<?php

namespace App\Http\Controllers;

use App\Enums\PaidEnum;
use App\Enums\StatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Http\Requests\SaleRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Sale;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    public function create()
    {
        $customers = Customer::orderBy('name')->get();

        $products = Product::where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'barcode',
                'selling_price',
                'stock_quantity',
            ]);

        $invoiceNumber = 'INV-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));

        return view('dashboard.sales.create', compact('customers','products','invoiceNumber'));
    }

    public function store(SaleRequest $request)
    {
        $data = $request->validated();

        $sale = DB::transaction(function () use ($data) {

            $subtotal = 0;
            $saleItemsData = [];

            /*
         * 1. جلب المنتجات وحساب إجمالي كل صنف.
         * نعيد جلب الأسعار من قاعدة البيانات ولا نعتمد على المتصفح.
         */
            foreach ($data['items'] as $item) {

                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];
                $price = (float) $product->selling_price;
                $itemDiscount = (float) ($item['discount'] ?? 0);

                $itemTotal = ($quantity * $price) - $itemDiscount;

                if ($itemDiscount > ($quantity * $price)) {
                    throw ValidationException::withMessages([
                        'items' => 'Item discount cannot exceed its total.',
                    ]);
                }

                $subtotal += $itemTotal;

                $saleItemsData[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'discount' => $itemDiscount,
                    'total' => $itemTotal,
                ];
            }

            /*
         * 2. حساب إجمالي الفاتورة والمبلغ المتبقي.
         */
            $discount = (float) ($data['discount'] ?? 0);
            $total = $subtotal - $discount;
            $paid = (float) ($data['paid'] ?? 0);

            if ($discount > $subtotal) {
                throw ValidationException::withMessages([
                    'discount' => 'Discount cannot exceed subtotal.',
                ]);
            }

            if ($paid > $total) {
                throw ValidationException::withMessages([
                    'paid' => 'Paid amount cannot exceed total.',
                ]);
            }

            $remainingAmount = $total - $paid;

            /*
         * 3. تحديد حالة الدفع.
         */
            $status = $paid <= 0
                ? PaidEnum::UNPAID->value
                : ($paid < $total
                    ? PaidEnum::PARTIALLY_PAID->value
                    : PaidEnum::PAID->value);

            /*
         * 4. إنشاء فاتورة البيع.
         */
            $sale = Sale::create([
                'invoice_number' => $data['invoice_number'],
                'customer_id' => $data['customer_id'] ?? null,
                'user_id' => auth()->id(),

                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,

                'paid' => $paid,
                'remaining_amount' => $remainingAmount,

                'payment_method' => $data['payment_method']
                    ?? PaymentMethodEnum::CASH->value,

                'status' => $status,
            ]);

            /*
         * 5. إنشاء تفاصيل الفاتورة وصرف المخزون باستخدام FEFO.
         */
            foreach ($saleItemsData as $itemData) {

                $product = $itemData['product'];
                $requiredQuantity = $itemData['quantity'];

                /*
             * جلب الدفعات النشطة وغير المنتهية.
             * الدفعات ذات تاريخ الانتهاء الأقرب أولاً.
             * الدفعات التي لا تملك تاريخ انتهاء تأتي أخيراً.
             */
                $batches = ProductBatch::where('product_id', $product->id)
                    ->where('status', StatusEnum::ACTIVE->value)
                    ->where('quantity', '>', 0)
                    ->where(function ($query) {
                        $query->whereNull('expiry_date')
                            ->orWhereDate('expiry_date', '>=', today());
                    })
                    ->orderByRaw('expiry_date IS NULL ASC')
                    ->orderBy('expiry_date', 'asc')
                    ->orderBy('id', 'asc')
                    ->lockForUpdate()
                    ->get();

                $availableQuantity = (int) $batches->sum('quantity');

                if ($availableQuantity < $requiredQuantity) {
                    throw ValidationException::withMessages([
                        'items' => "Insufficient stock for product: {$product->name}. Available: {$availableQuantity}, Requested: {$requiredQuantity}.",
                    ]);
                }

                /*
             * التأكد من أن إجمالي المخزون في المنتج
             * لا يتعارض مع الكمية المطلوب بيعها.
             */
                if ((int) $product->stock_quantity < $requiredQuantity) {
                    throw ValidationException::withMessages([
                        'items' => "The stock quantity of {$product->name} is inconsistent with its available batches. Please review the inventory.",
                    ]);
                }

                /*
             * إنشاء SaleItem.
             */
                $saleItem = $sale->saleItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $requiredQuantity,
                    'price' => $itemData['price'],
                    'discount' => $itemData['discount'],
                    'total' => $itemData['total'],
                ]);

                $remainingQuantity = $requiredQuantity;

                /*
             * توزيع الكمية على الدفعات حسب FEFO.
             */
                foreach ($batches as $batch) {

                    if ($remainingQuantity <= 0) {
                        break;
                    }

                    $deductQuantity = min(
                        $remainingQuantity,
                        (int) $batch->quantity
                    );

                    // حفظ الدفعة المستخدمة في عملية البيع.
                    $saleItem->saleItemBatches()->create([
                        'product_batch_id' => $batch->id,
                        'quantity' => $deductQuantity,
                    ]);

                    // خصم الكمية من الدفعة.
                    $batch->decrement('quantity', $deductQuantity);

                    // تسجيل حركة المخزون.
                    StockMovement::create([
                        'type' => 'sale_out',
                        'quantity' => -$deductQuantity,
                        'reference_id' => $sale->id,
                        'reference_type' => 'sale',
                        'notes' => 'Sale invoice: ' . $sale->invoice_number,
                        'product_id' => $product->id,
                        'product_batch_id' => $batch->id,
                    ]);

                    $remainingQuantity -= $deductQuantity;
                }

                // تحديث المخزون الإجمالي للمنتج.
                $product->decrement(
                    'stock_quantity',
                    $requiredQuantity
                );
            }

            return $sale;
        });

        return redirect()
            ->route('sale.show', $sale->id)
            ->with('success', 'Sale created successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load([
            'customer',
            'user',
            'saleItems.product',
            'saleItems.saleItemBatches.productBatch',
        ]);

        return view('dashboard.sales.show', compact('sale'));
    }

    public function searchProducts(Request $request)
    {
        $request->validate([
            'search' => ['required', 'string', 'max:255'],
        ]);

        $search = trim($request->search);

        // First: exact barcode match
        $product = Product::where('barcode', $search)
            ->where('stock_quantity', '>', 0)
            ->first();

        // If no barcode match, search by product name
        if ($product) {
            return response()->json([
                'products' => [$this->formatSaleProduct($product)],
            ]);
        }

        $products = Product::where('stock_quantity', '>', 0)
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json([
            'products' => $products->map(
                fn ($product) => $this->formatSaleProduct($product)
            ),
        ]);
    }

    private function formatSaleProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'barcode' => $product->barcode,
            'price' => (float) $product->selling_price,
            'stock' => (int) $product->stock_quantity,
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\PaidEnum;
use App\Enums\StatusEnum;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\ProductBatch;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->latest('purchase_date')->paginate(10);

        return view('dashboard.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();

        $products = Product::orderBy('name')->get();

        return view('dashboard.purchases.create', compact('suppliers','products'));
    }

    public function store(PurchaseRequest $request)
    {
        $validated = $request->validated();

        $items = collect($validated['items']);

        $subtotal = round(
            $items->sum(
                fn ($item) => (float) $item['quantity']
                    * (float) $item['cost']
            ),
            2
        );

        $discount = round((float) ($validated['discount'] ?? 0), 2);
        $total = round($subtotal - $discount, 2);
        $paid = round((float) ($validated['paid'] ?? 0), 2);
        $remainingAmount = round($total - $paid, 2);

        DB::transaction(function () use (
            $validated,
            $items,
            $subtotal,
            $discount,
            $total,
            $paid,
            $remainingAmount
        ) {
            $purchase = Purchase::create([
                'invoice_number' => $validated['invoice_number'],
                'supplier_id' => $validated['supplier_id'],
                'purchase_date' => $validated['purchase_date'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'paid' => $paid,
                'remaining_amount' => $remainingAmount,
                'status' => $remainingAmount <= 0
                    ? PaidEnum::PAID
                    : ($paid > 0 ? PaidEnum::PARTIALLY_PAID : PaidEnum::UNPAID),
            ]);

            foreach ($items as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];
                $cost = round((float) $item['cost'], 2);
                $itemTotal = round($quantity * $cost, 2);

                // 1. حفظ تفاصيل فاتورة الشراء.
                $purchaseItem = $purchase->purchaseItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'cost' => $cost,
                    'total' => $itemTotal,
                ]);

                // 2. إنشاء دفعة مرتبطة بتفصيل الفاتورة.
                $batch = $purchaseItem->productBatches()->create([
                    'product_id' => $product->id,
                    'purchase_item_id' => $purchaseItem->id,
                    'batch_number' => $item['batch_number'],
                    'expiry_date' => $item['expiry_date'] ?? null,
                    'quantity' => $quantity,
                    'purchase_price' => $cost,
                    'status' => StatusEnum::ACTIVE->value,
                ]);

                // 3. تحديث إجمالي المخزون للمنتج.
                $product->increment('stock_quantity', $quantity);

                // 4. تسجيل حركة دخول المخزون.
                StockMovement::create([
                    'type' => 'purchase_in',
                    'quantity' => $quantity,
                    'reference_id' => $purchase->id,
                    'reference_type' => 'purchase',
                    'notes' => 'Stock added from purchase '
                        . $purchase->invoice_number,
                    'product_id' => $product->id,
                    'product_batch_id' => $batch->id,
                ]);
            }
        });

        return redirect()
            ->route('purchase.index')
            ->with('success', 'Purchase created successfully.');
    }

    public function edit(Purchase $purchase)
    {
        $purchase->load(['supplier','purchaseItems.product','purchaseItems.productBatches']);

        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('dashboard.purchases.edit', compact('purchase','suppliers','products'));
    }

    public function update( PurchaseRequest $request, Purchase $purchase)
    {
        $data = $request->validated();

        $items = collect($data['items']);

        $subtotal = $items->sum(
            fn ($item) => (float) $item['quantity']
                * (float) $item['cost']
        );

        $discount = (float) ($data['discount'] ?? 0);
        $total = $subtotal - $discount;
        $paid = (float) ($data['paid'] ?? 0);

        if ($discount > $subtotal) {
            throw ValidationException::withMessages([
                'discount' => 'The discount cannot exceed the subtotal.',
            ]);
        }

        if ($paid > $total) {
            throw ValidationException::withMessages([
                'paid' => 'The paid amount cannot exceed the purchase total.',
            ]);
        }

        // السماح بأرقام الدفعات التابعة لهذه الفاتورة،
        // مع منع تكرار رقم دفعة يخص فاتورة أخرى.
        $currentBatchIds = $purchase->purchaseItems()
            ->with('productBatches:id,purchase_item_id')
            ->get()
            ->flatMap(fn ($item) => $item->productBatches->pluck('id'))
            ->all();

        DB::transaction(function () use (
            $purchase,
            $data,
            $items,
            $subtotal,
            $discount,
            $total,
            $paid
        ) {
            $purchase = Purchase::whereKey($purchase->id)
                ->lockForUpdate()
                ->firstOrFail();

            $purchase->load('purchaseItems.productBatches');

            // لا نعدّل المخزون إذا استُخدمت دفعات الفاتورة لاحقًا.
            $this->ensurePurchaseCanBeChanged($purchase);

            // تجميع الكميات القديمة حسب المنتج.
            $oldQuantities = $purchase->purchaseItems
                ->groupBy('product_id')
                ->map(fn ($productItems) =>
                    $productItems->sum('quantity')
                );

            // تأمين سجلات المنتجات قبل تحديث كمياتها.
            $productIds = collect($oldQuantities->keys())
                ->merge($items->pluck('product_id'))
                ->unique()
                ->values();

            $products = Product::whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // حذف الحركات القديمة قبل حذف الدفعات بسبب الـ foreign keys.
            $oldBatchIds = $purchase->purchaseItems
                ->flatMap(fn ($item) => $item->productBatches->pluck('id'))
                ->all();

            if (!empty($oldBatchIds)) {
                StockMovement::whereIn('product_batch_id', $oldBatchIds)
                    ->delete();

                ProductBatch::whereIn('id', $oldBatchIds)->delete();
            }

            // حذف تفاصيل الفاتورة القديمة.
            $purchase->purchaseItems()->delete();

            // عكس الكميات القديمة.
            foreach ($oldQuantities as $productId => $quantity) {
                $products->get($productId)->decrement(
                    'stock_quantity',
                    $quantity
                );
            }

            $status = $paid <= 0
                ? PaidEnum::UNPAID->value
                : ($paid < $total
                    ? PaidEnum::PARTIALLY_PAID->value
                    : PaidEnum::PAID->value);

            $purchase->update([
                'invoice_number' => $data['invoice_number'],
                'supplier_id' => $data['supplier_id'],
                'purchase_date' => $data['purchase_date'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'paid' => $paid,
                'remaining_amount' => $total - $paid,
                'status' => $status,
            ]);

            // إنشاء التفاصيل والدفعات وحركات المخزون الجديدة.
            foreach ($items as $item) {
                $product = $products->get($item['product_id']);

                $quantity = (int) $item['quantity'];
                $cost = (float) $item['cost'];
                $lineTotal = $quantity * $cost;

                $purchaseItem = $purchase->purchaseItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'cost' => $cost,
                    'total' => $lineTotal,
                ]);

                $batch = $purchaseItem->productBatches()->create([
                    'product_id' => $product->id,
                    'purchase_item_id' => $purchaseItem->id,
                    'batch_number' => $item['batch_number'],
                    'expiry_date' => $item['expiry_date'] ?? null,
                    'quantity' => $quantity,
                    'purchase_price' => $cost,
                    'status' => StatusEnum::ACTIVE->value,
                ]);

                $product->increment('stock_quantity', $quantity);

                StockMovement::create([
                    'type' => 'purchase_in',
                    'quantity' => $quantity,
                    'reference_id' => $purchase->id,
                    'reference_type' => 'purchase',
                    'notes' => 'Purchase updated: '
                        . $purchase->invoice_number,
                    'product_id' => $product->id,
                    'product_batch_id' => $batch->id,
                ]);
            }
        });

        return redirect()
            ->route('purchase.show', $purchase)
            ->with('success', 'Purchase updated successfully.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('supplier', 'purchaseItems.product');

        return view('dashboard.purchases.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            $purchase = Purchase::whereKey($purchase->id)
                ->lockForUpdate()
                ->firstOrFail();

            $purchase->load('purchaseItems.productBatches');

            // منع حذف فاتورة أثّرت دفعاتها في عمليات مخزون لاحقة.
            $this->ensurePurchaseCanBeChanged($purchase);

            $oldQuantities = $purchase->purchaseItems
                ->groupBy('product_id')
                ->map(fn ($productItems) =>
                    $productItems->sum('quantity')
                );

            $products = Product::whereIn(
                'id',
                $oldQuantities->keys()
            )
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $batchIds = $purchase->purchaseItems
                ->flatMap(fn ($item) => $item->productBatches->pluck('id'))
                ->all();

            // حذف الحركات أولًا لتجنب تعارض المفاتيح الأجنبية.
            if (!empty($batchIds)) {
                StockMovement::whereIn('product_batch_id', $batchIds)
                    ->delete();

                ProductBatch::whereIn('id', $batchIds)->delete();
            }

            $purchase->purchaseItems()->delete();

            // إزالة الكميات التي أضافتها الفاتورة من المخزون.
            foreach ($oldQuantities as $productId => $quantity) {
                $products->get($productId)->decrement(
                    'stock_quantity',
                    $quantity
                );
            }

            $purchase->delete();
        });

        return redirect()
            ->route('purchase.index')
            ->with('success', 'Purchase deleted successfully.');
    }

    private function ensurePurchaseCanBeChanged(Purchase $purchase): void 
    {
        foreach ($purchase->purchaseItems as $item) {
            $batches = $item->productBatches;

            if ($batches->isEmpty()) {
                throw ValidationException::withMessages([
                    'purchase' =>
                        'This purchase cannot be changed because a batch is missing.',
                ]);
            }

            // يجب أن تكون الكمية الحالية مطابقة للكمية المستلمة.
            if ((int) $batches->sum('quantity') !== (int) $item->quantity) {
                throw ValidationException::withMessages([
                    'purchase' =>
                        'This purchase cannot be changed because its stock has already changed.',
                ]);
            }

            foreach ($batches as $batch) {
                // أي حركة غير حركة الاستلام الأصلية تمنع التعديل والحذف.
                $hasOtherMovement = StockMovement::where(
                    'product_batch_id',
                    $batch->id
                )
                    ->where(function ($query) use ($purchase) {
                        $query->where('reference_type', '!=', 'purchase')
                            ->orWhere('reference_id', '!=', $purchase->id)
                            ->orWhere('type', '!=', 'purchase_in');
                    })
                    ->exists();

                if ($hasOtherMovement) {
                    throw ValidationException::withMessages([
                        'purchase' =>
                            'This purchase cannot be changed because one of its batches has subsequent stock movements.',
                    ]);
                }

                // التأكد من وجود حركة الاستلام الأصلية بالكمية الصحيحة.
                $receivedQuantity = StockMovement::where(
                    'product_batch_id',
                    $batch->id
                )
                    ->where('reference_type', 'purchase')
                    ->where('reference_id', $purchase->id)
                    ->where('type', 'purchase_in')
                    ->sum('quantity');

                if ((int) $receivedQuantity !== (int) $batch->quantity) {
                    throw ValidationException::withMessages([
                        'purchase' =>
                            'The original stock movement does not match the batch quantity.',
                    ]);
                }
            }
        }
    }
}

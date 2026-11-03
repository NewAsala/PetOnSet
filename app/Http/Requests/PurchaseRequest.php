<?php

namespace App\Http\Requests;

use App\Models\Purchase;
use App\Models\ProductBatch;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $purchase = $this->route('purchase');

        $purchaseId = $purchase instanceof Purchase
            ? $purchase->getKey()
            : $purchase;

        return [
            'supplier_id' => [
                'required',
                'integer',
                'exists:suppliers,id',
            ],

            'invoice_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('purchases', 'invoice_number')
                    ->ignore($purchaseId),
            ],

            'purchase_date' => [
                'required',
                'date',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'paid' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.cost' => [
                'required',
                'numeric',
                'min:0',
            ],

            'items.*.batch_number' => [
                'required',
                'string',
                'max:255',
                'distinct',
            ],

            'items.*.expiry_date' => [
                'nullable',
                'date',
                'after_or_equal:purchase_date',
            ],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $items = collect($this->input('items', []));

                // حساب الإجمالي قبل الخصم.
                $subtotal = $items->sum(function ($item) {
                    return (float) ($item['quantity'] ?? 0)
                        * (float) ($item['cost'] ?? 0);
                });

                $discount = (float) $this->input('discount', 0);
                $paid = (float) $this->input('paid', 0);

                $total = $subtotal - $discount;

                if ($discount > $subtotal) {
                    $validator->errors()->add(
                        'discount',
                        'The discount cannot exceed the subtotal.'
                    );
                }

                if ($paid > $total) {
                    $validator->errors()->add(
                        'paid',
                        'The paid amount cannot exceed the purchase total.'
                    );
                }

                // إذا كانت البيانات الأساسية غير صالحة،
                // لا نكمل فحص أرقام الدفعات.
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                // الحصول على أرقام الدفعات التابعة للشراء الحالي.
                $purchase = $this->route('purchase');

                $currentBatchIds = [];

                if ($purchase instanceof Purchase) {
                    $purchaseItemIds = $purchase->purchaseItems()
                        ->pluck('id');

                    $currentBatchIds = ProductBatch::whereIn(
                        'purchase_item_id',
                        $purchaseItemIds
                    )->pluck('id')->all();
                }

                // منع تكرار رقم دفعة موجود في شراء آخر.
                foreach ($items as $index => $item) {
                    $batchNumber = trim(
                        (string) ($item['batch_number'] ?? '')
                    );

                    if ($batchNumber === '') {
                        continue;
                    }

                    $query = ProductBatch::where(
                        'batch_number',
                        $batchNumber
                    );

                    if (!empty($currentBatchIds)) {
                        $query->whereNotIn('id', $currentBatchIds);
                    }

                    if ($query->exists()) {
                        $validator->errors()->add(
                            "items.$index.batch_number",
                            'This batch number already exists.'
                        );
                    }
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' =>
                'Please select a supplier.',

            'supplier_id.exists' =>
                'The selected supplier does not exist.',

            'invoice_number.required' =>
                'Invoice number is required.',

            'invoice_number.unique' =>
                'This invoice number already exists.',

            'purchase_date.required' =>
                'Purchase date is required.',

            'items.required' =>
                'Please add at least one product.',

            'items.min' =>
                'A purchase must contain at least one product.',

            'items.*.product_id.required' =>
                'Please select a product.',

            'items.*.quantity.min' =>
                'Quantity must be at least 1.',

            'items.*.cost.min' =>
                'Cost cannot be negative.',

            'items.*.batch_number.required' =>
                'Batch number is required.',

            'items.*.batch_number.distinct' =>
                'Batch numbers must be unique within this purchase.',

            'items.*.expiry_date.after_or_equal' =>
                'Expiry date cannot be before the purchase date.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethodEnum;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'invoice_number' => [
                'required',
                'string',
                'max:255',
                'unique:sales,invoice_number',
            ],

            'customer_id' => [
                'nullable',
                'exists:customers,id',
            ],

            'payment_method' => [
                'nullable',
                Rule::in(PaymentMethodEnum::values()),
            ],

            'paid' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            // الخصم العام على الفاتورة
            'discount' => [
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
                'distinct',
                'exists:products,id',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            // الخصم الخاص بكل صنف
            'items.*.discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);

            if (!is_array($items) || empty($items)) {
                return;
            }

            $productIds = collect($items)
                ->pluck('product_id')
                ->filter()
                ->unique();

            $products = Product::whereIn('id', $productIds)
                ->get()
                ->keyBy('id');

            $subtotal = 0;

            foreach ($items as $index => $item) {
                if (
                    empty($item['product_id']) ||
                    !isset($item['quantity']) ||
                    !$products->has($item['product_id'])
                ) {
                    continue;
                }

                $product = $products->get($item['product_id']);

                $price = (float) $product->selling_price;
                $quantity = (int) $item['quantity'];
                $itemDiscount = (float) ($item['discount'] ?? 0);

                $itemTotal = $price * $quantity;

                if ($itemDiscount > $itemTotal) {
                    $validator->errors()->add(
                        "items.$index.discount",
                        'The item discount cannot exceed its total.'
                    );

                    continue;
                }

                $subtotal += $itemTotal - $itemDiscount;
            }

            $discount = (float) $this->input('discount', 0);

            if ($discount > $subtotal) {
                $validator->errors()->add(
                    'discount',
                    'The invoice discount cannot exceed the subtotal after item discounts.'
                );
            }

            $total = max(0, $subtotal - $discount);
            $paid = (float) $this->input('paid', 0);

            if ($paid > $total) {
                $validator->errors()->add(
                    'paid',
                    'The paid amount cannot exceed the invoice total.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'invoice_number.unique' => 'This invoice number already exists.',
            'customer_id.exists' => 'The selected customer does not exist.',
            'items.required' => 'Please add at least one product.',
            'items.min' => 'The sale must contain at least one product.',
            'items.*.product_id.distinct' => 'You cannot add the same product more than once.',
            'items.*.quantity.min' => 'Product quantity must be at least 1.',
            'items.*.product_id.exists' => 'One of the selected products does not exist.',
        ];
    }
}

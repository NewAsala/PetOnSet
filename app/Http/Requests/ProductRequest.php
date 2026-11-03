<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        $product = $this->route('product');
        return [

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock_quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'min_stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'unit' => [
                'nullable',
                'string',
                'max:50',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                'in:' . implode(',', \App\Enums\StatusEnum::values()),
            ],

            'barcode' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'barcode') ->ignore($product?->id),
            ],

            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'sku') ->ignore($product?->id),
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'brand_id' => [
                'required',
                'exists:brands,id',
            ],

        ];
    }
}
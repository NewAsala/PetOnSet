<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Product([
            'name'            => $row['name'],
            'description'     => $row['description'] ?? null,
            'purchase_price'  => $row['purchase_price'],
            'selling_price'   => $row['selling_price'],
            'stock_quantity'  => $row['stock_quantity'],
            'min_stock'       => $row['min_stock'],
            'unit'            => $row['unit'] ?? null,
            'status'          => $row['status'],
            'barcode'         => $row['barcode'],
            'sku'             => $row['sku'],
            'category_id'     => $row['category_id'],
            'brand_id'        => $row['brand_id'],
        ]);
    }

    public function rules(): array
    {
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

            'status' => [
                'required',
                Rule::in(\App\Enums\StatusEnum::values()),
            ],

            'barcode' => [
                'required',
                'string',
                'max:255',
                'distinct',
                Rule::unique('products', 'barcode')->ignore(request()->route('product')?->id),
            ],

            'sku' => [
                'required',
                'string',
                'max:255',
                'distinct',
                Rule::unique('products', 'sku')->ignore(request()->route('product')?->id),
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

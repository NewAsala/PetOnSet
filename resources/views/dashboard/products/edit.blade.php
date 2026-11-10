@extends('layouts.app')
@section('content')
@php
    $breadcrumbItems = [
        [
            'label' => __('dashboard.products'),
            'url' => route('product.index'),
        ],
        [
            'label' => __('dashboard.edit_product'),
        ],
    ];
    $currentStatus = old('status', $product->status);
@endphp
<div class="py-5">
    <div class="row g-4 align-items-center">
        <div class="col">
            @include('components.breadcrumb', ['items' => $breadcrumbItems])
            <h1 class="h3 m-0">{{ __('dashboard.edit_product') }}</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('product.index') }}" class="btn btn-secondary me-3">{{ __('dashboard.cancel') }}</a>
            <button type="submit" form="product-form" class="btn btn-primary">{{ __('dashboard.save') }}</button>
        </div>
    </div>
</div>
<form id="product-form" method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="sa-entity-layout" data-sa-container-query="{&quot;920&quot;:&quot;sa-entity-layout--size--md&quot;,&quot;1100&quot;:&quot;sa-entity-layout--size--lg&quot;}">
        <div class="sa-entity-layout__body">
            <div class="sa-entity-layout__main">
                <div class="card mb-5"> 
                    <div class="card-body p-5">
                        <div class="mb-5">
                            <h2 class="mb-0 fs-exact-18">{{ __('dashboard.image') }}</h2>
                        </div>
                        <div class="text-center">
                            <x-image-upload
                                id="inputImage"
                                name="image"
                                preview-id="imagePreview"
                                :preview="$product->image ? Storage::url($product->image) : asset('images/default_product.png')"
                                accept=".jpg,.jpeg,.png,.webp"
                                help-text="{{ __('dashboard.image_upload_help') }}"
                            />
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-5">
                        <div class="mb-5">
                            <h2 class="mb-0 fs-exact-18">{{ __('dashboard.basic_information') }}</h2>
                        </div>
                        <div class="mb-4">
                            <label for="inputName" class="form-label">{{ __('dashboard.name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputName" value="{{ old('name', $product->name) }}" required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                       
                        <div>
                            <label for="inputDescription" class="form-label">{{ __('dashboard.description') }}</label>
                            <textarea id="inputDescription" class="sa-quill-control form-control @error('description') is-invalid @enderror" name="description" rows="8">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-body p-5">
                        <div class="mb-5">
                            <h2 class="mb-0 fs-exact-18">{{ __('dashboard.pricing') }}</h2>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="inputSellingPrice" class="form-label">{{ __('dashboard.selling_price') }}</label>
                                <input type="number" min="0" step="0.01" class="form-control @error('selling_price') is-invalid @enderror" name="selling_price" id="inputSellingPrice" value="{{ old('selling_price', $product->selling_price) }}" required />
                                @error('selling_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputPurchasePrice" class="form-label">{{ __('dashboard.purchase_price') }}</label>
                                <input type="number" min="0" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror" name="purchase_price" id="inputPurchasePrice" value="{{ old('purchase_price', $product->purchase_price) }}" required />
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-body p-5">
                        <div class="mb-5">
                            <h2 class="mb-0 fs-exact-18">{{ __('dashboard.inventory') }}</h2>
                        </div>
                        <div class="mb-4">
                            <label for="inputSku" class="form-label">{{ __('dashboard.sku') }}</label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" id="inputSku" value="{{ old('sku', $product->sku) }}" required />
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="inputBarcode" class="form-label">{{ __('dashboard.barcode') }}</label>
                            <input type="text" class="form-control @error('barcode') is-invalid @enderror" name="barcode" id="inputBarcode" value="{{ old('barcode', $product->barcode) }}" required />
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label for="inputStockQuantity" class="form-label">{{ __('dashboard.stock_quantity') }}</label>
                                <input type="number" min="0" step="1" class="form-control @error('stock_quantity') is-invalid @enderror" name="stock_quantity" id="inputStockQuantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required />
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputMinStock" class="form-label">{{ __('dashboard.minimum_stock') }}</label>
                                <input type="number" min="0" step="1" class="form-control @error('min_stock') is-invalid @enderror" name="min_stock" id="inputMinStock" value="{{ old('min_stock', $product->min_stock) }}" required />
                                @error('min_stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputUnit" class="form-label">{{ __('dashboard.unit') }}</label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" id="inputUnit" value="{{ old('unit', $product->unit) }}" maxlength="50" />
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sa-entity-layout__sidebar">
                <div class="card w-100">
                    <div class="card-body p-5">
                        <div class="mb-5">
                            <h2 class="mb-0 fs-exact-18">{{ __('dashboard.visibility') }}</h2>
                        </div>
                        <label for="inputStatus" class="form-label">{{ __('dashboard.status') }}</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="inputStatus" required>
                            <option value="{{ App\Enums\StatusEnum::ACTIVE->value }}" @selected(strcasecmp((string) $currentStatus, App\Enums\StatusEnum::ACTIVE->value) === 0)>{{ __('dashboard.active') }}</option>
                            <option value="{{ App\Enums\StatusEnum::INACTIVE->value }}" @selected(strcasecmp((string) $currentStatus, App\Enums\StatusEnum::INACTIVE->value) === 0)>{{ __('dashboard.inactive') }}</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card w-100 mt-5">
                    <div class="card-body p-5">
                        <div class="mb-5">
                            <h2 class="mb-0 fs-exact-18">{{ __('dashboard.classification') }}</h2>
                        </div>
                        <div class="mb-4">
                            <label for="inputCategory" class="form-label">{{ __('dashboard.category') }}</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="inputCategory" required>
                                <option value="">{{ __('dashboard.select_a_category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="inputBrand" class="form-label">{{ __('dashboard.brand') }}</label>
                            <select class="form-select @error('brand_id') is-invalid @enderror" name="brand_id" id="inputBrand" required>
                                <option value="">{{ __('dashboard.select_a_brand') }}</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

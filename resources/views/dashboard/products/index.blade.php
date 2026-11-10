@extends('layouts.app')

@section('content')
@php
	$breadcrumbItems = [
		[
			'label' => __('dashboard.products'),
		],
	];
@endphp

<div class="py-5">
    <div class="row g-4 align-items-center">
        <div class="col">
            @include('components.breadcrumb', ['items' => $breadcrumbItems])
			<h1 class="h3 m-0">{{ __('dashboard.products') }}</h1>
        </div>
        <div class="col-auto ">
            {{-- <a href="#" class="btn btn-secondary me-3">Import</a> --}}
            <button
                type="button"
                class="btn btn-secondary me-3"
                data-bs-toggle="modal"
                data-bs-target="#importProductsModal"
            >{{ __('dashboard.import') }}
            </button>
            <a href="{{ route('product.create') }}" class="btn btn-primary">{{ __('dashboard.new_product') }}</a></div>
    </div>
</div>

<div class="card">
    <form method="GET" action="{{ route('product.index') }}" class="sa-layout" id="productFilters">
        <div class="sa-layout__backdrop" data-sa-layout-sidebar-close=""></div>
        <div class="sa-layout__sidebar">
            <div class="sa-layout__sidebar-header">
                <div class="sa-layout__sidebar-title">{{ __('dashboard.filters') }}</div>
                <button type="button" class="sa-close sa-layout__sidebar-close" aria-label="{{ __('dashboard.close') }}"
                    data-sa-layout-sidebar-close=""></button>
            </div>
            <div class="sa-layout__sidebar-body sa-filters"
                style="min-height: 0; overflow-x: hidden; overflow-y: auto; flex: 1 1 auto;">
                <ul class="sa-filters__list">
                    <li class="sa-filters__item">
                        <div class="sa-filters__item-title">{{ __('dashboard.price') }}</div>
                        <div class="sa-filters__item-body">
                            <div class="sa-filter-range" data-min="{{ $availableMinPrice }}"
                                data-max="{{ $availableMaxPrice }}" data-from="{{ $minPrice }}"
                                data-to="{{ $maxPrice }}">
                                <div class="sa-filter-range__slider"></div>
                                <input type="hidden" name="price_min" value="{{ $minPrice }}"
                                    class="sa-filter-range__input-from" />
                                <input type="hidden" name="price_max" value="{{ $maxPrice }}"
                                    class="sa-filter-range__input-to" />
                            </div>
                        </div>
                    </li>
                    <li class="sa-filters__item">
                        <div class="sa-filters__item-title">{{ __('dashboard.categories') }}</div>
                        <div class="sa-filters__item-body">
                            <ul class="list-unstyled m-0 mt-n2">
                                @foreach ($categories as $category)
                                    <li>
                                        <label class="d-flex align-items-center pt-2">
                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                class="form-check-input m-0 me-3 fs-exact-16"
                                                @checked(in_array($category->id, $categoryIds, true)) />
                                            {{ $category->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li class="sa-filters__item">
                        <div class="sa-filters__item-title">{{ __('dashboard.stock') }}</div>
                        <div class="sa-filters__item-body">
                            <select name="stock_status" class="form-select">
                                <option value="">{{ __('dashboard.all_stock_levels') }}</option>
                                <option value="in_stock" @selected($stockStatus === 'in_stock')>{{ __('dashboard.in_stock') }}</option>
                                <option value="low_stock" @selected($stockStatus === 'low_stock')>{{ __('dashboard.low_stock') }}</option>
                                <option value="out_of_stock" @selected($stockStatus === 'out_of_stock')>{{ __('dashboard.out_of_stock') }}</option>
                            </select>
                        </div>
                    </li>
                    <li class="sa-filters__item">
                        <div class="sa-filters__item-title">{{ __('dashboard.status') }}</div>
                        <div class="sa-filters__item-body">
                            <select name="status" class="form-select">
                                <option value="">{{ __('dashboard.all_statuses') }}</option>
                                <option value="Active" @selected($status === 'Active')>{{ __('dashboard.active') }}</option>
                                <option value="Inactive" @selected($status === 'Inactive')>{{ __('dashboard.inactive') }}</option>
                            </select>
                        </div>
                    </li>
                    <li class="sa-filters__item">
                        <div class="sa-filters__item-title">{{ __('dashboard.brands') }}</div>
                        <div class="sa-filters__item-body">
                            <ul class="list-unstyled m-0 mt-n2">
                                @foreach ($brands as $brand)
                                    <li>
                                        <label class="d-flex align-items-center pt-2">
                                            <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                                                class="form-check-input m-0 me-3 fs-exact-16"
                                                @checked(in_array($brand->id, $brandIds, true)) />
                                            {{ $brand->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                </ul>
                <div class="d-grid gap-2 px-3 pb-3">
                    <button type="submit" class="btn btn-primary">{{ __('dashboard.apply_filters') }}</button>
                    <a href="{{ route('product.index') }}" class="btn btn-light border">{{ __('dashboard.clear_filters') }}</a>
                </div>
            </div>
        </div>
        <div class="sa-layout__content">
            <div class="card">
                <div class="p-4">
                    <div class="row g-4">
                        <div class="col-auto sa-layout__filters-button"><button
                                type="button" class="btn btn-sa-muted btn-sa-icon fs-exact-16"
                                data-sa-layout-sidebar-open=""><svg xmlns="http://www.w3.org/2000/svg"
                                    width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor">
                                    <path
                                        d="M7,14v-2h9v2H7z M14,7h2v2h-2V7z M12.5,6C12.8,6,13,6.2,13,6.5v3c0,0.3-0.2,0.5-0.5,0.5h-2 C10.2,10,10,9.8,10,9.5v-3C10,6.2,10.2,6,10.5,6H12.5z M7,2h9v2H7V2z M5.5,5h-2C3.2,5,3,4.8,3,4.5v-3C3,1.2,3.2,1,3.5,1h2 C5.8,1,6,1.2,6,1.5v3C6,4.8,5.8,5,5.5,5z M0,2h2v2H0V2z M9,9H0V7h9V9z M2,14H0v-2h2V14z M3.5,11h2C5.8,11,6,11.2,6,11.5v3 C6,14.8,5.8,15,5.5,15h-2C3.2,15,3,14.8,3,14.5v-3C3,11.2,3.2,11,3.5,11z">
                                    </path>
                                </svg></button></div>
                        <div class="col"><input type="text"
                                placeholder="{{ __('dashboard.search_products') }}"
                                class="form-control form-control--search mx-auto" id="table-search" />
                        </div>
                    </div>
                </div>
                <div class="sa-divider"></div>
                <table class="sa-datatables-init" data-order="[]"
                    data-sa-search-input="#table-search">
                    <thead>
                        <tr>
                            <th class="w-min" data-orderable="false"><input type="checkbox"
                                    class="form-check-input m-0 fs-exact-16 d-block" aria-label="{{ __('dashboard.select_all') }}" />
                            </th>
                            <th class="min-w-20x">{{ __('dashboard.product') }}</th>
                            <th>{{ __('dashboard.category') }}</th>
                            <th>{{ __('dashboard.stock') }}</th>
                            <th>{{ __('dashboard.selling_price') }}</th>
                            <th class="w-min" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="{{ __('dashboard.select_product') }}" />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                  <a href="{{ route('product.show', $product->id) }}" class="me-4">
                                        <div class="sa-symbol sa-symbol--shape--rounded sa-symbol--size--lg">
                                            <img
                                                src="{{ $product->image ? Storage::url($product->image) : asset('images/default_product.png') }}"
                                                width="40"
                                                height="40"
                                                alt="{{ $product->name }}"
                                            />
                                        </div>
                                    </a>
                                    <div>
                                        <a href="{{ route('product.show', $product->id) }}" class="text-reset">{{ $product->name }}</a>
                                        <div class="sa-meta mt-0">
                                            <ul class="sa-meta__list">
                                                <li class="sa-meta__item">{{ __('dashboard.identifier') }}
                                                    <span title="{{ __('dashboard.click_to_copy_product_id') }}" class="st-copy">{{ $product->id }}</span>
                                                </li>
                                                <li class="sa-meta__item">{{ __('dashboard.sku') }}:
                                                    <span title="{{ __('dashboard.click_to_copy_product_sku') }}" class="st-copy">{{ $product->sku }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>
                                <div class="badge badge-sa-success">{{ $product->stock_quantity }} {{ __('dashboard.in_stock_label') }}</div>
                            </td>
                            <td>
                                <div class="sa-price"><span class="sa-price__symbol">$</span>
                                    <span class="sa-price__integer">{{ $product->selling_price }}</span>
                                    {{-- <span class="sa-price__decimal"></span> --}}
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sa-muted btn-sm" type="button" id="product-context-menu-0" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('dashboard.more') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="3" height="13" fill="currentColor">
                                            <path
                                                d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z">
                                            </path>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="product-context-menu-0">
                                        <li><a class="dropdown-item" href="{{ route('product.edit', ['product' => $product->id]) }}">{{ __('dashboard.edit') }}</a></li>
                                        <li><a class="dropdown-item" href="{{ route('product.show', ['product' => $product->id]) }}">{{ __('dashboard.show') }}</a></li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li>
                                            <button
                                                type="button"
                                                class="dropdown-item text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-delete-url="{{ route('product.destroy', $product) }}"
                                                data-delete-name="{{ $product->name }}"
                                                data-delete-pets-count="{{ $product->pets_count }}"
                                            >
                                                {{ __('dashboard.delete') }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="importProductsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form
                action="{{ route('product.import') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('dashboard.import_products') }}
                    </h5>

                    <button
                        type="button"
                        class="btn-close m-0"
                        data-bs-dismiss="modal"
                    ></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="importFile" class="form-label">
                            {{ __('dashboard.excel_file') }}
                        </label>

                        <input
                            type="file"
                            name="file"
                            id="importFile"
                            class="form-control"
                            accept=".xlsx,.xls,.csv"
                            required
                        >

                        @error('file')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-text">
                        {{ __('dashboard.supported_import_formats') }}
                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        {{ __('dashboard.cancel') }}
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        {{ __('dashboard.import') }}
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection

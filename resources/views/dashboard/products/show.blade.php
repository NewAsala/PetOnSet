@extends('layouts.app')

@section('content')
@php
	$breadcrumbItems = [
		[
			'label' => __('dashboard.products'),
			'url' => route('product.index'),
		],
		[
			'label' => $product->name,
		],
	];
	$isActive = strtolower($product->status) === strtolower(App\Enums\StatusEnum::ACTIVE->value);
@endphp

<div class="py-5">
	<div class="row g-4 align-items-center">
		<div class="col">
			@include('components.breadcrumb', ['items' => $breadcrumbItems])
			<h1 class="h3 m-0">{{ $product->name }}</h1>
		</div>
		<div class="col-auto">
			<button
				type="button"
				class="btn btn-secondary me-3"
				data-bs-toggle="modal"
				data-bs-target="#deleteModal"
				data-delete-url="{{ route('product.destroy', $product) }}"
				data-delete-name="{{ $product->name }}"
			>
				{{ __('dashboard.delete') }}
			</button>
			<a href="{{ route('product.edit', ['product' => $product->id]) }}" class="btn btn-primary">{{ __('dashboard.edit') }}</a>
		</div>
	</div>
</div>

<div class="sa-entity-layout" data-sa-container-query="{&quot;920&quot;:&quot;sa-entity-layout--size--md&quot;,&quot;1100&quot;:&quot;sa-entity-layout--size--lg&quot;}">
	<div class="sa-entity-layout__body">
		<aside class="sa-entity-layout__sidebar">
			<div class="card w-100">
				<div class="card-body p-5">
					<img
						src="{{ $product->image ? Storage::url($product->image) : asset('images/default_product.png') }}"
						alt="{{ $product->name }}"
						class="img-fluid rounded d-block mx-auto mb-4"
						style="max-height: 240px; object-fit: contain;"
					/>
					<div class="text-center">
						<h2 class="fs-exact-16 fw-medium mb-2">{{ $product->name }}</h2>
						<span class="badge {{ $isActive ? 'bg-success' : 'bg-secondary' }}">{{ __('dashboard.' . strtolower($product->status)) }}</span>
					</div>
					<div class="sa-divider my-4"></div>
					<dl class="list-unstyled m-0">
						<dt class="fs-exact-14 fw-medium">{{ __('dashboard.sku') }}</dt>
						<dd class="fs-exact-13 text-muted mb-0 mt-1">{{ $product->sku }}</dd>
					</dl>
					<dl class="list-unstyled m-0 mt-4">
						<dt class="fs-exact-14 fw-medium">{{ __('dashboard.barcode') }}</dt>
						<dd class="fs-exact-13 text-muted mb-0 mt-1">{{ $product->barcode }}</dd>
					</dl>
					<dl class="list-unstyled m-0 mt-4">
						<dt class="fs-exact-14 fw-medium">{{ __('dashboard.category') }}</dt>
						<dd class="fs-exact-13 text-muted mb-0 mt-1">{{ $product->category->name }}</dd>
					</dl>
					<dl class="list-unstyled m-0 mt-4">
						<dt class="fs-exact-14 fw-medium">{{ __('dashboard.brand') }}</dt>
						<dd class="fs-exact-13 text-muted mb-0 mt-1">{{ $product->brand->name }}</dd>
					</dl>
				</div>
			</div>
		</aside>

		<main class="sa-entity-layout__main">
			<div class="card">
				<div class="card-body p-5">
					<div class="mb-4">
						<h2 class="mb-0 fs-exact-18">{{ __('dashboard.basic_information') }}</h2>
					</div>
					<dl class="row mb-0">
						<dt class="col-sm-3">{{ __('dashboard.name') }}</dt>
						<dd class="col-sm-9">{{ $product->name }}</dd>
						<dt class="col-sm-3">{{ __('dashboard.description') }}</dt>
						<dd class="col-sm-9 mb-0">
							@if ($product->description)
								{!! nl2br(e(strip_tags($product->description))) !!}
							@else
								<span class="text-muted">{{ __('dashboard.no_description_provided') }}</span>
							@endif
						</dd>
					</dl>
				</div>
			</div>

			<div class="card mt-5">
				<div class="card-body p-5">
					<div class="mb-4">
						<h2 class="mb-0 fs-exact-18">{{ __('dashboard.pricing') }}</h2>
					</div>
					<dl class="row mb-0">
						<dt class="col-sm-4">{{ __('dashboard.selling_price') }}</dt>
						<dd class="col-sm-8">{{ number_format($product->selling_price, 2) }}</dd>
						<dt class="col-sm-4">{{ __('dashboard.purchase_price') }}</dt>
						<dd class="col-sm-8 mb-0">{{ number_format($product->purchase_price, 2) }}</dd>
					</dl>
				</div>
			</div>

			<div class="card mt-5">
				<div class="card-body p-5">
					<div class="mb-4">
						<h2 class="mb-0 fs-exact-18">{{ __('dashboard.inventory') }}</h2>
					</div>
					<dl class="row mb-0">
						<dt class="col-sm-4">{{ __('dashboard.stock_quantity') }}</dt>
						<dd class="col-sm-8">{{ $product->stock_quantity }} {{ $product->unit }}</dd>
						<dt class="col-sm-4">{{ __('dashboard.minimum_stock') }}</dt>
						<dd class="col-sm-8 mb-0">{{ $product->min_stock }} {{ $product->unit }}</dd>
					</dl>
				</div>
			</div>

			<div class="card mt-5">
				<div class="card-body p-5">
					<div class="mb-4">
						<h2 class="mb-0 fs-exact-18">{{ __('dashboard.record_details') }}</h2>
					</div>
					<dl class="row mb-0">
						<dt class="col-sm-4">{{ __('dashboard.created') }}</dt>
						<dd class="col-sm-8">{{ $product->created_at->format('F j, Y g:i A') }}</dd>
						<dt class="col-sm-4">{{ __('dashboard.last_updated') }}</dt>
						<dd class="col-sm-8 mb-0">{{ $product->updated_at->format('F j, Y g:i A') }}</dd>
					</dl>
				</div>
			</div>
		</main>
	</div>
</div>
@endsection

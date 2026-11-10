@extends('layouts.app')

@section('content')
    @php
        $breadcrumbItems = [
            [
                'label' => __('dashboard.purchases'),
                'url' => route('purchase.index'),
            ],
            [
                'label' => __('dashboard.purchase_number', ['invoice' => $purchase->invoice_number]),
            ],
        ];
    @endphp

    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">
                @include('components.breadcrumb', ['items' => $breadcrumbItems])
                <h1 class="h3 m-0">{{ __('dashboard.purchase_number', ['invoice' => $purchase->invoice_number]) }}</h1>
            </div>
            <div class="col-auto d-flex">
                <button type="button" class="btn btn-secondary me-3" data-bs-toggle="modal" data-bs-target="#deleteModal"
                    data-delete-url="{{ route('purchase.destroy', $purchase) }}"
                    data-delete-name="{{ $purchase->invoice_number }}">
                    {{ __('dashboard.delete') }}
                </button>
                <a href="{{ route('purchase.edit', ['purchase' => $purchase->id]) }}" class="btn btn-primary">{{ __('dashboard.edit') }}</a>
            </div>
        </div>
    </div>

    @php
        $status = $purchase->status ?? 'Unknown';
        $statusLabel = match ($status) {
            'Paid' => __('dashboard.paid'),
            'Partially Paid' => __('dashboard.partially_paid'),
            'Unpaid' => __('dashboard.unpaid'),
            default => __('dashboard.unknown'),
        };
        $statusClass = match ($status) {
            'Paid' => 'badge-sa-success',
            'Partially Paid' => 'badge-sa-warning',
            default => 'badge-sa-danger',
        };
    @endphp

    <div class="sa-page-meta mb-5">
        <div class="sa-page-meta__body">
            <div class="sa-page-meta__list">
                <div class="sa-page-meta__item">{{ $purchase->purchase_date?->format('F j, Y') ?? __('dashboard.no_date') }}</div>
                <div class="sa-page-meta__item">{{ __('dashboard.items_count', ['count' => $purchase->purchaseItems->count()]) }}</div>
                <div class="sa-page-meta__item">{{ __('dashboard.total') }} ${{ number_format((float) $purchase->total, 2) }}</div>
                <div class="sa-page-meta__item d-flex align-items-center fs-6">
                    <span class="badge {{ $statusClass }} me-2">{{ $statusLabel }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="sa-entity-layout" data-sa-container-query="{&quot;920&quot;:&quot;sa-entity-layout--size--md&quot;}">
        <div class="sa-entity-layout__body">
            <div class="sa-entity-layout__main">
                <div class="card">
                    <div class="card-body px-5 py-4 border-bottom">
                        <h2 class="mb-0 fs-exact-18">{{ __('dashboard.items_label') }}</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="sa-table">
                            <thead>
                                <tr>
                                    <th>{{ __('dashboard.product') }}</th>
                                    <th class="text-end">{{ __('dashboard.cost') }}</th>
                                    <th class="text-end">{{ __('dashboard.quantity') }}</th>
                                    <th class="text-end">{{ __('dashboard.total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($purchase->purchaseItems as $item)
                                    <tr>
                                        <td class="min-w-20x">{{ $item->product?->name ?? __('dashboard.product_unavailable') }}</td>
                                        <td class="text-end">${{ number_format((float) $item->cost, 2) }}</td>
                                        <td class="text-end">{{ $item->quantity }}</td>
                                        <td class="text-end">${{ number_format((float) $item->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">{{ __('dashboard.no_purchase_items') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tbody class="sa-table__group">
                                <tr>
                                    <td colspan="3">{{ __('dashboard.subtotal') }}</td>
                                    <td class="text-end">${{ number_format((float) $purchase->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">{{ __('dashboard.discount') }}</td>
                                    <td class="text-end">-${{ number_format((float) $purchase->discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" colspan="3">{{ __('dashboard.total') }}</td>
                                    <td class="text-end fw-bold">${{ number_format((float) $purchase->total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-body px-5 py-4">
                        <h2 class="mb-0 fs-exact-18">{{ __('dashboard.payment_summary') }}</h2>
                    </div>
                    <table class="sa-table">
                        <tbody>
                            <tr>
                                <td>{{ __('dashboard.total') }}</td>
                                <td class="text-end">${{ number_format((float) $purchase->total, 2) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('dashboard.paid') }}</td>
                                <td class="text-end">${{ number_format((float) $purchase->paid, 2) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('dashboard.remaining_amount') }}</td>
                                <td class="text-end">${{ number_format((float) $purchase->remaining_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="sa-entity-layout__sidebar">
                <div class="card">
                    <div class="card-body pb-4 pt-4 border-bottom">
                        <h2 class="fs-exact-16 mb-0">{{ __('dashboard.supplier') }}</h2>
                    </div>
                    <div class="card-body pt-4 fs-exact-14">
                        @if ($purchase->supplier)
                            <div class="fw-medium">{{ $purchase->supplier->name }}</div>
                            @if ($purchase->supplier->email)
                                <div class="mt-2"><a href="mailto:{{ $purchase->supplier->email }}">{{ $purchase->supplier->email }}</a></div>
                            @endif
                            @if ($purchase->supplier->phone)
                                <div class="text-muted mt-1">{{ $purchase->supplier->phone }}</div>
                            @endif
                            @if ($purchase->supplier->address)
                                <div class="text-muted mt-2">{{ $purchase->supplier->address }}</div>
                            @endif
                            @if ($purchase->supplier->notes)
                                <div class="mt-3">{{ $purchase->supplier->notes }}</div>
                            @endif
                        @else
                            <div class="text-muted">{{ __('dashboard.supplier_information_unavailable') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    @php
        $breadcrumbItems = [
            ['label' => __('dashboard.sales')],
        ];
    @endphp

    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">
                @include('components.breadcrumb', ['items' => $breadcrumbItems])
                <h1 class="h3 m-0">{{ __('dashboard.sales') }}</h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('sale.create') }}" class="btn btn-primary">{{ __('dashboard.new_sale') }}</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="p-4">
            <input
                type="text"
                placeholder="{{ __('dashboard.search_sales') }}"
                class="form-control form-control--search mx-auto"
                id="table-search"
                aria-label="{{ __('dashboard.search_sales_label') }}"
            />
        </div>
        <div class="sa-divider"></div>
        <div class="table-responsive">
            <table
                class="sa-datatables-init text-nowrap"
                data-order="[[ 1, &quot;desc&quot; ]]"
                data-sa-search-input="#table-search"
            >
                <thead>
                    <tr>
                        <th>{{ __('dashboard.invoice') }}</th>
                        <th>{{ __('dashboard.date') }}</th>
                        <th>{{ __('dashboard.customer') }}</th>
                        <th>{{ __('dashboard.payment_method') }}</th>
                        <th>{{ __('dashboard.payment_status') }}</th>
                        <th>{{ __('dashboard.items') }}</th>
                        <th>{{ __('dashboard.total') }}</th>
                        <th>{{ __('dashboard.paid') }}</th>
                        <th>{{ __('dashboard.remaining') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        @php
                            $statusBadge = match ($sale->status) {
                                'Paid' => 'badge-sa-success',
                                'Partially Paid' => 'badge-sa-warning',
                                default => 'badge-sa-danger',
                            };
                            $statusLabel = match ($sale->status) {
                                'Paid' => __('dashboard.paid'),
                                'Partially Paid' => __('dashboard.partially_paid'),
                                'Unpaid' => __('dashboard.unpaid'),
                                default => $sale->status ?? __('dashboard.unknown'),
                            };
                            $paymentMethod = str_replace('_', ' ', $sale->payment_method);
                            $paymentMethodLabel = match ($paymentMethod) {
                                'Cash' => __('dashboard.cash'),
                                'By Whish' => __('dashboard.by_whish'),
                                default => $paymentMethod,
                            };
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('sale.show', $sale) }}" class="text-reset fw-semibold">
                                    #{{ $sale->invoice_number }}
                                </a>
                            </td>
                            <td>{{ $sale->created_at->format('M j, Y') }}<div class="text-muted small">{{ $sale->created_at->format('g:i A') }}</div></td>
                            <td>{{ $sale->customer?->name ?? __('dashboard.walk_in_customer') }}</td>
                            <td>{{ $paymentMethodLabel }}</td>
                            <td><span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span></td>
                            <td>{{ $sale->sale_items_count }}</td>
                            <td><span class="sa-price__symbol">$</span>{{ number_format((float) $sale->total, 2) }}</td>
                            <td><span class="sa-price__symbol">$</span>{{ number_format((float) $sale->paid, 2) }}</td>
                            <td><span class="sa-price__symbol">$</span>{{ number_format((float) $sale->remaining_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

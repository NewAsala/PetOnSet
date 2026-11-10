@extends('layouts.app')

@section('content')

@php
    $saleStatusLabel = match ($sale->status) {
        'Paid' => __('dashboard.paid'),
        'Partially Paid' => __('dashboard.partially_paid'),
        'Unpaid' => __('dashboard.unpaid'),
        'Pending' => __('dashboard.pending'),
        'Hold' => __('dashboard.sale_status_hold'),
        'Canceled' => __('dashboard.sale_status_canceled'),
        'Completed' => __('dashboard.completed'),
        default => $sale->status ?? __('dashboard.unknown'),
    };
    $paymentMethodLabel = match ($sale->payment_method) {
        'Cash' => __('dashboard.cash'),
        'By_Whish' => __('dashboard.by_whish'),
        default => $sale->payment_method,
    };
@endphp

<div class="container-fluid py-5">

    {{-- Actions: Hidden when printing --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">

        <div>
            <h4 class="mb-1">{{ __('dashboard.sales_invoice') }}</h4>
            <p class="text-muted mb-0">
                {{ __('dashboard.invoice_number') }} #{{ $sale->invoice_number }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('sale.create') }}"
               class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                {{ __('dashboard.new_sale') }}
            </a>

            <button type="button"
                    onclick="window.print()"
                    class="btn btn-primary">
                <i class="fas fa-print me-1"></i>
                {{ __('dashboard.print_invoice') }}
            </button>

            <a href="{{ route('sale.index') }}"
               class="btn btn-secondary">
                {{ __('dashboard.back_to_sales') }}
            </a>

        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success no-print">
            {{ session('success') }}
        </div>
    @endif

    {{-- Printable Receipt --}}
    <div class="receipt-wrapper">

        <div class="receipt" id="receipt">

            {{-- Store Header --}}
            <div class="text-center mb-3">

                <h3 class="fw-bold mb-1">PET ON SET</h3>

                <p class="mb-1">{{ __('dashboard.business_tagline') }}</p>

                <p class="mb-0 small">
                    {{ __('dashboard.thank_you_shopping') }}
                </p>

            </div>

            <hr>

            {{-- Invoice Details --}}
            <div class="invoice-details small">

                <div class="d-flex justify-content-between">
                    <span>{{ __('dashboard.invoice_label') }}</span>
                    <strong>{{ $sale->invoice_number }}</strong>
                </div>

                <div class="d-flex justify-content-between">
                    <span>{{ __('dashboard.date_label') }}</span>
                    <span>{{ $sale->created_at->format('d/m/Y') }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>{{ __('dashboard.time_label') }}</span>
                    <span>{{ $sale->created_at->format('h:i A') }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>{{ __('dashboard.customer_label') }}</span>
                    <span>
                        {{ $sale->customer?->name ?? __('dashboard.walk_in_customer') }}
                    </span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>{{ __('dashboard.cashier_label') }}</span>
                    <span>{{ $sale->user?->name ?? '-' }}</span>
                </div>

            </div>

            <hr>

            {{-- Products --}}
            <table class="table table-sm receipt-table">

                <thead>
                    <tr>
                        <th>{{ __('dashboard.item') }}</th>
                        <th class="text-center">{{ __('dashboard.qty') }}</th>
                        <th class="text-end">{{ __('dashboard.price') }}</th>
                        <th class="text-end">{{ __('dashboard.total') }}</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($sale->saleItems as $item)

                        <tr>
                            <td>
                                {{ $item->product?->name ?? __('dashboard.deleted_product') }}

                                @if($item->discount > 0)
                                    <small class="d-block">
                                        {{ __('dashboard.discount_label') }} {{ number_format($item->discount, 2) }}
                                    </small>
                                @endif
                            </td>

                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>

                            <td class="text-end">
                                {{ number_format($item->price, 2) }}
                            </td>

                            <td class="text-end">
                                {{ number_format($item->total, 2) }}
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

            <hr>

            {{-- Totals --}}
            <div class="receipt-totals">

                <div class="d-flex justify-content-between">
                    <span>{{ __('dashboard.subtotal') }}:</span>
                    <span>{{ number_format($sale->subtotal, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>{{ __('dashboard.discount_label') }}</span>
                    <span>{{ number_format($sale->discount, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                    <span>{{ __('dashboard.total') }}:</span>
                    <span>{{ number_format($sale->total, 2) }}</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <span>{{ __('dashboard.paid_label') }}</span>
                    <span>{{ number_format($sale->paid, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>{{ __('dashboard.remaining_label') }}</span>
                    <span>{{ number_format($sale->remaining_amount, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mt-2">
                    <span>{{ __('dashboard.payment_method_colon') }}</span>
                    <span>{{ $paymentMethodLabel }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>{{ __('dashboard.status_colon') }}</span>
                    <strong>{{ $saleStatusLabel }}</strong>
                </div>

            </div>

            <hr>

            {{-- Footer --}}
            <div class="text-center small mt-3">
                <p class="fw-bold mb-1">{{ __('dashboard.thank_you') }}</p>
                <p class="mb-0">{{ __('dashboard.hope_to_see_again') }}</p>
                <p class="mb-0">PET ON SET</p>
            </div>

        </div>

    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const saleId = @json($sale->id);
    const createSaleUrl = @json(route('sale.create'));

    const printKey = `sale_printed_${saleId}`;

    let automaticPrinting = false;

    // Prevent automatic printing again when refreshing the invoice.
    if (!sessionStorage.getItem(printKey)) {

        automaticPrinting = true;

        sessionStorage.setItem(printKey, '1');

        setTimeout(function () {
            window.print();
        }, 700);
    }

    // After closing the automatic print dialog, start a new sale.
    window.addEventListener('afterprint', function () {

        if (automaticPrinting) {
            window.location.href = createSaleUrl;
        }

    });

});
</script>
@endsection

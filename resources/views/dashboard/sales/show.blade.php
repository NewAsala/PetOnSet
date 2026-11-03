@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- Actions: Hidden when printing --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">

        <div>
            <h4 class="mb-1">Sale Invoice</h4>
            <p class="text-muted mb-0">
                Invoice #{{ $sale->invoice_number }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('sale.create') }}"
               class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                New Sale
            </a>

            <button type="button"
                    onclick="window.print()"
                    class="btn btn-primary">
                <i class="fas fa-print me-1"></i>
                Print Invoice
            </button>

            <a href="{{ route('sale.index') }}"
               class="btn btn-outline-secondary">
                Back to Sales
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

                <p class="mb-1">Grooming - Accessories - Food</p>

                <p class="mb-0 small">
                    Thank you for shopping with us!
                </p>

            </div>

            <hr>

            {{-- Invoice Details --}}
            <div class="invoice-details small">

                <div class="d-flex justify-content-between">
                    <span>Invoice:</span>
                    <strong>{{ $sale->invoice_number }}</strong>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Date:</span>
                    <span>{{ $sale->created_at->format('d/m/Y') }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Time:</span>
                    <span>{{ $sale->created_at->format('h:i A') }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Customer:</span>
                    <span>
                        {{ $sale->customer?->name ?? 'Walk-in Customer' }}
                    </span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Cashier:</span>
                    <span>{{ $sale->user?->name ?? '-' }}</span>
                </div>

            </div>

            <hr>

            {{-- Products --}}
            <table class="table table-sm receipt-table">

                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($sale->saleItems as $item)

                        <tr>
                            <td>
                                {{ $item->product?->name ?? 'Deleted Product' }}

                                @if($item->discount > 0)
                                    <small class="d-block">
                                        Discount: {{ number_format($item->discount, 2) }}
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
                    <span>Subtotal:</span>
                    <span>{{ number_format($sale->subtotal, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Discount:</span>
                    <span>{{ number_format($sale->discount, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                    <span>Total:</span>
                    <span>{{ number_format($sale->total, 2) }}</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <span>Paid:</span>
                    <span>{{ number_format($sale->paid, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Remaining:</span>
                    <span>{{ number_format($sale->remaining_amount, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mt-2">
                    <span>Payment Method:</span>
                    <span>{{ $sale->payment_method }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Status:</span>
                    <strong>{{ $sale->status }}</strong>
                </div>

            </div>

            <hr>

            {{-- Footer --}}
            <div class="text-center small mt-3">
                <p class="fw-bold mb-1">Thank You!</p>
                <p class="mb-0">We hope to see you again.</p>
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

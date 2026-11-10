@extends('layouts.app')

@section('content')
<style>
    #datepickers-container {
        position: fixed;
    }
</style>

@php
    $breadcrumbItems = [
        ['label' => __('dashboard.purchases'), 'url' => route('purchase.index')],
        ['label' => __('dashboard.edit_purchase'), 'url' => null],
    ];

    $oldItems = old('items');

    if ($oldItems === null) {
        $oldItems = $purchase->purchaseItems->values()->map(function ($item) {
            $batch = $item->productBatches->first();

            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'cost' => $item->cost,
                'batch_number' => $batch?->batch_number ?? '',
                'expiry_date' => $batch?->expiry_date?->format('Y-m-d') ?? '',
            ];
        })->all();
    }
@endphp

<div class="py-5">
    <div class="row g-4 align-items-center">
        <div class="col">
            @include('components.breadcrumb', ['items' => $breadcrumbItems])

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                <div>
                    <h1 class="h3 m-0">{{ __('dashboard.edit_purchase') }}</h1>
                    <p class="text-muted mb-0">{{ __('dashboard.update_invoice', ['invoice' => $purchase->invoice_number]) }}</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>{{ __('dashboard.correct_following_errors') }}</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('purchase.update', $purchase) }}" method="POST" id="purchaseForm">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">{{ __('dashboard.purchase_details') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="supplier_id" class="form-label">{{ __('dashboard.supplier') }} <span class="text-danger">*</span></label>
                                <select name="supplier_id" id="supplier_id"
                                        class="form-select @error('supplier_id') is-invalid @enderror" required>
                                    <option value="">{{ __('dashboard.select_supplier') }}</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            @selected(old('supplier_id', $purchase->supplier_id) == $supplier->id)>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="invoice_number" class="form-label">{{ __('dashboard.invoice_number') }} <span class="text-danger">*</span></label>
                                <input type="text" name="invoice_number" id="invoice_number"
                                       class="form-control @error('invoice_number') is-invalid @enderror"
                                       value="{{ old('invoice_number', $purchase->invoice_number) }}" required>
                                @error('invoice_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="purchase_date" class="form-label">{{ __('dashboard.purchase_date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="purchase_date" id="purchase_date"
                                       class="form-control datepicker-here @error('purchase_date') is-invalid @enderror"
                                       value="{{ old('purchase_date', $purchase->purchase_date?->format('Y-m-d')) }}"
                                       required data-language="{{ app()->getLocale() }}">
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('dashboard.currency') }}</label>
                                <input type="text" class="form-control" value="USD ($)" readonly>
                                <small class="text-muted">{{ __('dashboard.purchase_costs_usd') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="mb-0">{{ __('dashboard.purchase_items') }}</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addItemBtn">
                            <i class="fas fa-plus me-1"></i>
                            {{ __('dashboard.add_product') }}
                        </button>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0" id="purchaseItemsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="min-width: 210px;">{{ __('dashboard.product') }}</th>
                                        <th style="min-width: 100px;">{{ __('dashboard.quantity') }}</th>
                                        <th style="min-width: 140px;">{{ __('dashboard.unit_cost') }}</th>
                                        <th style="min-width: 150px;">{{ __('dashboard.batch_number') }}</th>
                                        <th style="min-width: 150px;">{{ __('dashboard.expiry_date') }}</th>
                                        <th style="min-width: 130px;">{{ __('dashboard.subtotal_dollars') }}</th>
                                        <th style="width: 60px;">{{ __('dashboard.remove') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="purchaseItemsBody">
                                    @foreach ($oldItems as $index => $oldItem)
                                        <tr class="purchase-item-row">
                                            <td>
                                                <select name="items[{{ $index }}][product_id]"
                                                        class="form-select product-select @error("items.$index.product_id") is-invalid @enderror" required>
                                                    <option value="">{{ __('dashboard.select_product') }}</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            @selected(($oldItem['product_id'] ?? '') == $product->id)>
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error("items.$index.product_id")
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][quantity]"
                                                       class="form-control item-quantity" value="{{ $oldItem['quantity'] ?? 1 }}"
                                                       min="1" step="1" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][cost]"
                                                       class="form-control item-cost" value="{{ $oldItem['cost'] ?? '' }}"
                                                       min="0" step="0.01" placeholder="0.00" required>
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][batch_number]"
                                                       class="form-control" value="{{ $oldItem['batch_number'] ?? '' }}"
                                                       maxlength="255" placeholder="{{ __('dashboard.unique_batch_placeholder') }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][expiry_date]"
                                                       class="form-control item-expiry datepicker-here"
                                                       value="{{ $oldItem['expiry_date'] ?? '' }}" data-language="{{ app()->getLocale() }}">
                                            </td>
                                            <td><span class="item-subtotal fw-semibold">$0.00</span></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item"
                                                        title="{{ __('dashboard.remove_product') }}" aria-label="{{ __('dashboard.remove_product') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">{{ __('dashboard.number_of_product_lines') }}</span>
                            <strong id="itemCount">0</strong>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end mb-4">
                    <div class="col-xl-5 col-lg-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">{{ __('dashboard.payment_summary') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <span>{{ __('dashboard.subtotal') }}</span>
                                    <strong id="subtotalDisplay">$0.00</strong>
                                </div>

                                <div class="mb-3">
                                    <label for="discount" class="form-label">{{ __('dashboard.discount_dollars') }}</label>
                                    <input type="number" name="discount" id="discount"
                                           class="form-control @error('discount') is-invalid @enderror"
                                           value="{{ old('discount', $purchase->discount ?? 0) }}" min="0" step="0.01">
                                    @error('discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span>{{ __('dashboard.total') }}</span>
                                    <strong id="totalDisplay" class="fs-5">$0.00</strong>
                                </div>

                                <div class="mb-3">
                                    <label for="paid" class="form-label">{{ __('dashboard.amount_paid_dollars') }}</label>
                                    <input type="number" name="paid" id="paid"
                                           class="form-control @error('paid') is-invalid @enderror"
                                           value="{{ old('paid', $purchase->paid ?? 0) }}" min="0" step="0.01">
                                    @error('paid')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span>{{ __('dashboard.remaining_amount') }}</span>
                                    <strong id="remainingDisplay">$0.00</strong>
                                </div>

                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ __('dashboard.payment_status') }}</span>
                                    <span id="paymentStatus" class="badge bg-secondary">{{ __('dashboard.unpaid') }}</span>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    {{ __('dashboard.payment_status_calculated') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mb-4">
                    <a href="{{ route('purchase.show', $purchase) }}" class="btn btn-light border">{{ __('dashboard.cancel') }}</a>
                    <button type="submit" class="btn btn-primary" id="submitPurchaseBtn">
                        <i class="fas fa-save me-1"></i>
                        {{ __('dashboard.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="purchaseItemTemplate">
    <tr class="purchase-item-row">
        <td>
            <select name="items[__INDEX__][product_id]" class="form-select product-select" required>
                <option value="">{{ __('dashboard.select_product') }}</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="items[__INDEX__][quantity]" class="form-control item-quantity"
                   value="1" min="1" step="1" required></td>
        <td><input type="number" name="items[__INDEX__][cost]" class="form-control item-cost"
                   min="0" step="0.01" placeholder="0.00" required></td>
        <td><input type="text" name="items[__INDEX__][batch_number]" class="form-control"
                   maxlength="255" placeholder="{{ __('dashboard.unique_batch_placeholder') }}" required></td>
        <td><input type="text" name="items[__INDEX__][expiry_date]"
                   class="form-control item-expiry datepicker-here" data-language="{{ app()->getLocale() }}"></td>
        <td><span class="item-subtotal fw-semibold">$0.00</span></td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger remove-item"
                    title="{{ __('dashboard.remove_product') }}" aria-label="{{ __('dashboard.remove_product') }}">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('purchaseForm');
    const itemsBody = document.getElementById('purchaseItemsBody');
    const itemTemplate = document.getElementById('purchaseItemTemplate');
    const discountInput = document.getElementById('discount');
    const paidInput = document.getElementById('paid');
    const purchaseDateInput = document.getElementById('purchase_date');
    const submitButton = document.getElementById('submitPurchaseBtn');

    let nextIndex = Math.max(
        -1,
        ...Array.from(itemsBody.querySelectorAll('[name]'))
            .map(input => {
                const match = input.name.match(/^items\[(\d+)\]/);
                return match ? Number(match[1]) : -1;
            })
    ) + 1;

        function getMinimumExpiryDate() {
            return purchaseDateInput.value
                ? new Date(`${purchaseDateInput.value}T00:00:00`)
                : null;
        }

        function initializeExpiryDatepicker(input) {
            const datepicker = $(input).datepicker({
                language: @json(app()->getLocale()),
                dateFormat: 'yyyy-mm-dd',
                minDate: getMinimumExpiryDate(),
                onShow: function (instance) {
                    const field = input.getBoundingClientRect();
                    const calendar = instance.$datepicker[0];
                    const left = Math.max(
                        8,
                        Math.min(field.left, window.innerWidth - calendar.offsetWidth - 8)
                    );

                    calendar.style.top = `${field.bottom}px`;
                    calendar.style.left = `${left}px`;
                },
            }).data('datepicker');

            if (input.value) {
                datepicker.selectDate(new Date(`${input.value}T00:00:00`));
            }
        }

        itemsBody.querySelectorAll('.item-expiry').forEach(initializeExpiryDatepicker);

    const money = value => '$' + Number(value || 0).toFixed(2);

    function calculateTotals() {
        let subtotal = 0;
        let itemCount = 0;

        itemsBody.querySelectorAll('.purchase-item-row').forEach(row => {
            const quantity = Math.max(0, Number(row.querySelector('.item-quantity').value) || 0);
            const cost = Math.max(0, Number(row.querySelector('.item-cost').value) || 0);
            row.querySelector('.item-subtotal').textContent = money(quantity * cost);
            subtotal += quantity * cost;

            if (row.querySelector('.product-select').value) {
                itemCount++;
            }
        });

        const discount = Math.max(0, Number(discountInput.value) || 0);
        const paid = Math.max(0, Number(paidInput.value) || 0);
        const total = Math.max(0, subtotal - discount);
        const remaining = Math.max(0, total - paid);

        document.getElementById('itemCount').textContent = itemCount;
        document.getElementById('subtotalDisplay').textContent = money(subtotal);
        document.getElementById('totalDisplay').textContent = money(total);
        document.getElementById('remainingDisplay').textContent = money(remaining);

        const statusBadge = document.getElementById('paymentStatus');
        if (total === 0 || paid === 0) {
            statusBadge.textContent = @json(__('dashboard.unpaid'));
            statusBadge.className = 'badge bg-danger';
        } else if (paid < total) {
            statusBadge.textContent = @json(__('dashboard.partially_paid'));
            statusBadge.className = 'badge bg-warning text-dark';
        } else {
            statusBadge.textContent = @json(__('dashboard.paid'));
            statusBadge.className = 'badge bg-success';
        }
    }

    function addItemRow() {
        const html = itemTemplate.innerHTML.replaceAll('__INDEX__', nextIndex++);
        itemsBody.insertAdjacentHTML('beforeend', html);

        const expiryInput = itemsBody.lastElementChild.querySelector('.item-expiry');
        initializeExpiryDatepicker(expiryInput);
        calculateTotals();
    }

    document.getElementById('addItemBtn').addEventListener('click', addItemRow);

    itemsBody.addEventListener('input', function (event) {
        if (event.target.matches('.item-quantity, .item-cost')) {
            calculateTotals();
        }
    });

    itemsBody.addEventListener('change', function (event) {
        if (event.target.matches('.product-select')) {
            calculateTotals();
        }
    });

    itemsBody.addEventListener('click', function (event) {
        const removeButton = event.target.closest('.remove-item');
        if (!removeButton) {
            return;
        }

        if (itemsBody.querySelectorAll('.purchase-item-row').length <= 1) {
            alert(@json(__('dashboard.purchase_must_have_product')));
            return;
        }

        removeButton.closest('.purchase-item-row').remove();
        calculateTotals();
    });

    discountInput.addEventListener('input', calculateTotals);
    paidInput.addEventListener('input', calculateTotals);

    purchaseDateInput.addEventListener('change', function () {
        const minDate = getMinimumExpiryDate();

        itemsBody.querySelectorAll('.item-expiry').forEach(input => {
            $(input).data('datepicker').update({ minDate });
        });
    });

    form.addEventListener('submit', function (event) {
        const rows = itemsBody.querySelectorAll('.purchase-item-row');
        if (rows.length === 0) {
            event.preventDefault();
            alert(@json(__('dashboard.please_add_product')));
            return;
        }

        const subtotal = Array.from(rows).reduce((sum, row) => {
            const quantity = Number(row.querySelector('.item-quantity').value) || 0;
            const cost = Number(row.querySelector('.item-cost').value) || 0;
            return sum + quantity * cost;
        }, 0);
        const discount = Number(discountInput.value) || 0;
        const paid = Number(paidInput.value) || 0;
        const total = subtotal - discount;

        if (discount < 0 || discount > subtotal) {
            event.preventDefault();
            alert(@json(__('dashboard.discount_between_zero_subtotal')));
            discountInput.focus();
            return;
        }

        if (paid < 0 || paid > total) {
            event.preventDefault();
            alert(@json(__('dashboard.paid_exceeds_purchase_total')));
            paidInput.focus();
            return;
        }

        submitButton.disabled = true;
        submitButton.innerHTML =
            '<span class="spinner-border spinner-border-sm me-1"></span> ' + @json(__('dashboard.saving'));
    });

    calculateTotals();
});
</script>
@endsection
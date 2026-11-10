@extends('layouts.app')

@section('content')

    @php
        $breadcrumbItems = [
            ['label' => __('dashboard.sales'), 'url' => route('sale.index')],
            ['label' => __('dashboard.create_sale'), 'url' => null],
        ];
    @endphp

    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">
                @include('components.breadcrumb', [
                    'items' => $breadcrumbItems,
                ])

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                    <div>
                        <h1 class="h3 m-0">{{ __('dashboard.point_of_sale') }}</h1>

                        <p class="text-muted mb-0">
                            {{ __('dashboard.create_sales_invoice') }}
                        </p>
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

            </div>
        </div>

        <form action="{{ route('sale.store') }}" method="POST" id="saleForm">
            @csrf

            <div class="row g-3">

                {{-- LEFT SIDE: PRODUCTS --}}
                <div class="col-lg-8">

                    {{-- Invoice Information --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('dashboard.invoice_number') }}</label>

                                    <input type="text" name="invoice_number"
                                        class="form-control @error('invoice_number') is-invalid @enderror"
                                        value="{{ old('invoice_number', $invoiceNumber) }}" required>

                                    @error('invoice_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('dashboard.customer') }}</label>

                                    <select name="customer_id" class="form-select">
                                        <option value="">{{ __('dashboard.walk_in_customer') }}</option>

                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('customer_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Product Search --}}
                    <div class="card mb-3">
                        <div class="card-body">

                            <label class="form-label fw-semibold">
                                {{ __('dashboard.scan_barcode_search_product') }}
                            </label>

                            <div class="input-group input-group-lg">
                                <span class="input-group-text">
                                    <i class="fas fa-barcode"></i>
                                </span>

                                <input type="text" id="productSearch" class="form-control"
                                    placeholder="{{ __('dashboard.scan_barcode_placeholder') }}" autocomplete="off" autofocus>

                                <button type="button" class="btn btn-primary" id="searchButton">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                            <div class="form-text">
                                {{ __('dashboard.scanner_help') }}
                            </div>

                            <div id="searchMessage" class="small mt-2"></div>

                            {{-- Search Results --}}
                            <div id="searchResults" class="list-group mt-2" style="display:none;">
                            </div>

                        </div>
                    </div>

                    {{-- Cart --}}
                    <div class="card">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ __('dashboard.current_sale') }}</h5>

                            <span class="badge bg-primary" id="itemsCount">
                                {{ __('dashboard.zero_items') }}
                            </span>
                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('dashboard.product') }}</th>
                                            <th width="120">{{ __('dashboard.price') }}</th>
                                            <th width="140">{{ __('dashboard.quantity') }}</th>
                                            <th width="120">{{ __('dashboard.discount') }}</th>
                                            <th width="120">{{ __('dashboard.total') }}</th>
                                            <th width="50"></th>
                                        </tr>
                                    </thead>

                                    <tbody id="cartItems">

                                        <tr id="emptyCart">
                                            <td colspan="6" class="text-center text-muted py-5">
                                                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                                <p class="mb-0">
                                                    {{ __('dashboard.no_products_added') }}
                                                </p>
                                                <small>
                                                    {{ __('dashboard.scan_or_search_product') }}
                                                </small>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- RIGHT SIDE: PAYMENT --}}
                <div class="col-lg-4">

                    <div class="card mb-3">

                        <div class="card-header">
                            <h5 class="mb-0">{{ __('dashboard.order_summary') }}</h5>
                        </div>

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">{{ __('dashboard.items') }}</span>
                                <strong id="summaryItems">0</strong>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">{{ __('dashboard.subtotal') }}</span>
                                <strong id="subtotal">0.00</strong>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('dashboard.invoice_discount') }}</label>

                                <input type="number" name="discount" id="invoiceDiscount" class="form-control"
                                    value="{{ old('discount', 0) }}" min="0" step="0.01">

                                @error('discount')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-semibold">{{ __('dashboard.total') }}</span>

                                <h3 class="mb-0 text-primary" id="total">
                                    0.00
                                </h3>
                            </div>

                        </div>
                    </div>

                    <div class="card mb-3">

                        <div class="card-header">
                            <h5 class="mb-0">{{ __('dashboard.payment') }}</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">{{ __('dashboard.paid_amount') }}</label>

                                <input type="number" name="paid" id="paid" class="form-control form-control-lg"
                                    value="{{ old('paid', 0) }}" min="0" step="0.01">

                                @error('paid')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">{{ __('dashboard.remaining_amount') }}</span>

                                <strong id="remaining" class="text-danger">
                                    0.00
                                </strong>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('dashboard.payment_method_label') }}</label>

                                <select name="payment_method" class="form-select">

                                    @foreach (\App\Enums\PaymentMethodEnum::cases() as $method)
                                        <option value="{{ $method->value }}"
                                            {{ old('payment_method', \App\Enums\PaymentMethodEnum::CASH->value) == $method->value ? 'selected' : '' }}>
                                            {{ __('dashboard.' . strtolower($method->value)) }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="alert alert-info py-2 mb-0">
                                <small>
                                    {{ __('dashboard.payment_status_auto') }}
                                </small>
                            </div>

                        </div>
                    </div>

                    {{-- Complete Sale --}}
                    <button type="submit" class="btn btn-success btn-lg w-100" id="completeSale">

                        <i class="fas fa-check-circle me-1"></i>
                        {{ __('dashboard.complete_sale') }}
                    </button>

                    <button type="button" class="btn btn-outline-danger w-100 mt-2" id="clearCart">

                        <i class="fas fa-trash me-1"></i>
                        {{ __('dashboard.clear_sale') }}
                    </button>

                </div>

            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('productSearch');
            const searchButton = document.getElementById('searchButton');
            const searchResults = document.getElementById('searchResults');
            const searchMessage = document.getElementById('searchMessage');
            const cartItems = document.getElementById('cartItems');

            const invoiceDiscountInput = document.getElementById('invoiceDiscount');
            const paidInput = document.getElementById('paid');

            let cart = {};
            let searchTimeout = null;
            let isSearching = false;

            const searchUrl = @json(route('sale.products.search'));
            const csrfToken = @json(csrf_token());

            // ------------------------------------
            // Search Products
            // ------------------------------------

            async function searchProducts(value) {

                value = value.trim();

                if (!value) {
                    searchResults.style.display = 'none';
                    searchMessage.textContent = '';
                    return;
                }

                if (isSearching) return;

                isSearching = true;

                searchMessage.textContent = @json(__('dashboard.searching'));

                try {

                    const response = await fetch(
                        `${searchUrl}?search=${encodeURIComponent(value)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        }
                    );

                    if (!response.ok) {
                        throw new Error('Search request failed.');
                    }

                    const data = await response.json();

                    displaySearchResults(data.products, value);

                } catch (error) {

                    searchMessage.textContent = @json(__('dashboard.search_products_error'));
                    searchResults.style.display = 'none';

                } finally {

                    isSearching = false;

                }
            }


            // ------------------------------------
            // Display Search Results
            // ------------------------------------

            function displaySearchResults(products, searchValue) {

                searchResults.innerHTML = '';

                if (!products.length) {

                    searchResults.style.display = 'none';
                    searchMessage.textContent = @json(__('dashboard.no_available_product_found'));

                    return;
                }

                searchMessage.textContent = '';

                products.forEach(product => {

                    const button = document.createElement('button');

                    button.type = 'button';
                    button.className =
                        'list-group-item list-group-item-action d-flex justify-content-between align-items-center';

                    const info = document.createElement('div');

                    const name = document.createElement('strong');
                    name.textContent = product.name;

                    const details = document.createElement('small');
                    details.className = 'd-block text-muted';
                    details.textContent =
                        `${@json(__('dashboard.barcode'))}: ${product.barcode || '-'} | ${@json(__('dashboard.stock'))}: ${product.stock}`;

                    info.appendChild(name);
                    info.appendChild(details);

                    const price = document.createElement('strong');
                    price.textContent = Number(product.price).toFixed(2);

                    button.appendChild(info);
                    button.appendChild(price);

                    button.addEventListener('click', function() {
                        addProduct(product);
                    });

                    searchResults.appendChild(button);

                });

                searchResults.style.display = 'block';

                // If exact barcode matched, add directly.
                if (
                    products.length === 1 &&
                    products[0].barcode &&
                    products[0].barcode.toLowerCase() === searchValue.toLowerCase()
                ) {
                    addProduct(products[0]);
                }
            }


            // ------------------------------------
            // Add Product to Cart
            // ------------------------------------

            function addProduct(product) {

                const productId = product.id;

                if (cart[productId]) {

                    const newQuantity = cart[productId].quantity + 1;

                    if (newQuantity > product.stock) {
                        alert(@json(__('dashboard.requested_quantity_exceeds_stock')));
                        return;
                    }

                    cart[productId].quantity = newQuantity;

                } else {

                    cart[productId] = {
                        id: product.id,
                        name: product.name,
                        barcode: product.barcode,
                        price: Number(product.price),
                        stock: Number(product.stock),
                        quantity: 1,
                        discount: 0
                    };

                }

                searchInput.value = '';
                searchResults.style.display = 'none';
                searchMessage.textContent = '';

                renderCart();

                // Keep focus on barcode input for the next scan.
                searchInput.focus();
            }


            // ------------------------------------
            // Render Cart
            // ------------------------------------

            function renderCart() {

                cartItems.innerHTML = '';

                const products = Object.values(cart);

                if (!products.length) {

                    cartItems.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                        <p class="mb-0">{{ __('dashboard.no_products_added') }}</p>
                        <small>{{ __('dashboard.scan_or_search_product') }}</small>
                    </td>
                </tr>
            `;

                    calculateTotals();

                    return;
                }

                products.forEach((product, index) => {

                    const row = document.createElement('tr');

                    const productCell = document.createElement('td');

                    const productName = document.createElement('strong');
                    productName.textContent = product.name;

                    const productBarcode = document.createElement('small');
                    productBarcode.className = 'd-block text-muted';
                    productBarcode.textContent = product.barcode || '';

                    productCell.appendChild(productName);
                    productCell.appendChild(productBarcode);


                    const priceCell = document.createElement('td');
                    priceCell.textContent = product.price.toFixed(2);


                    const quantityCell = document.createElement('td');

                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'number';
                    quantityInput.min = 1;
                    quantityInput.max = product.stock;
                    quantityInput.value = product.quantity;
                    quantityInput.className = 'form-control form-control-sm';

                    quantityInput.addEventListener('change', function() {

                        let quantity = parseInt(this.value) || 1;

                        if (quantity < 1) quantity = 1;

                        if (quantity > product.stock) {
                            alert(@json(__('dashboard.requested_quantity_exceeds_stock')));
                            quantity = product.stock;
                        }

                        cart[product.id].quantity = quantity;

                        renderCart();
                    });

                    quantityCell.appendChild(quantityInput);


                    const discountCell = document.createElement('td');

                    const discountInput = document.createElement('input');
                    discountInput.type = 'number';
                    discountInput.min = 0;
                    discountInput.step = '0.01';
                    discountInput.value = product.discount;
                    discountInput.className = 'form-control form-control-sm';

                    discountInput.addEventListener('change', function() {

                        let discount = Number(this.value) || 0;

                        const maxDiscount = product.price * product.quantity;

                        if (discount < 0) discount = 0;

                        if (discount > maxDiscount) {
                            alert(@json(__('dashboard.discount_exceeds_product_total')));
                            discount = maxDiscount;
                        }

                        cart[product.id].discount = discount;

                        renderCart();
                    });

                    discountCell.appendChild(discountInput);


                    const totalCell = document.createElement('td');

                    const lineTotal = Math.max(
                        0,
                        (product.price * product.quantity) - product.discount
                    );

                    totalCell.textContent = lineTotal.toFixed(2);


                    const actionCell = document.createElement('td');

                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'btn btn-sm btn-outline-danger';
                    removeButton.innerHTML = '<i class="fas fa-trash"></i>';

                    removeButton.addEventListener('click', function() {

                        delete cart[product.id];

                        renderCart();
                        searchInput.focus();
                    });

                    actionCell.appendChild(removeButton);


                    // Hidden inputs submitted to Laravel.
                    const hiddenProduct = document.createElement('input');
                    hiddenProduct.type = 'hidden';
                    hiddenProduct.name = `items[${index}][product_id]`;
                    hiddenProduct.value = product.id;

                    const hiddenQuantity = document.createElement('input');
                    hiddenQuantity.type = 'hidden';
                    hiddenQuantity.name = `items[${index}][quantity]`;
                    hiddenQuantity.value = product.quantity;

                    const hiddenDiscount = document.createElement('input');
                    hiddenDiscount.type = 'hidden';
                    hiddenDiscount.name = `items[${index}][discount]`;
                    hiddenDiscount.value = product.discount;

                    actionCell.appendChild(hiddenProduct);
                    actionCell.appendChild(hiddenQuantity);
                    actionCell.appendChild(hiddenDiscount);

                    row.appendChild(productCell);
                    row.appendChild(priceCell);
                    row.appendChild(quantityCell);
                    row.appendChild(discountCell);
                    row.appendChild(totalCell);
                    row.appendChild(actionCell);

                    cartItems.appendChild(row);

                });

                calculateTotals();
            }


            // ------------------------------------
            // Calculate Invoice Totals
            // ------------------------------------

            function calculateTotals() {

                const products = Object.values(cart);

                let subtotal = 0;
                let totalQuantity = 0;

                products.forEach(product => {

                    const itemTotal =
                        (product.price * product.quantity) - product.discount;

                    subtotal += itemTotal;
                    totalQuantity += product.quantity;

                });

                const invoiceDiscount = Math.max(
                    0,
                    Number(invoiceDiscountInput.value) || 0
                );

                const total = Math.max(0, subtotal - invoiceDiscount);

                const paid = Math.max(0, Number(paidInput.value) || 0);

                const remaining = Math.max(0, total - paid);

                document.getElementById('subtotal').textContent =
                    subtotal.toFixed(2);

                document.getElementById('total').textContent =
                    total.toFixed(2);

                document.getElementById('remaining').textContent =
                    remaining.toFixed(2);

                document.getElementById('itemsCount').textContent =
                    `${totalQuantity} ${@json(__('dashboard.items'))}`;

                document.getElementById('summaryItems').textContent =
                    totalQuantity;
            }


            // ------------------------------------
            // Search Input Events
            // ------------------------------------

            searchInput.addEventListener('input', function() {

                clearTimeout(searchTimeout);

                const value = this.value.trim();

                if (!value) {
                    searchResults.style.display = 'none';
                    searchMessage.textContent = '';
                    return;
                }

                searchTimeout = setTimeout(function() {
                    searchProducts(value);
                }, 300);

            });


            searchButton.addEventListener('click', function() {

                clearTimeout(searchTimeout);
                searchProducts(searchInput.value);

            });


            // USB Barcode Scanner usually sends Enter after scanning.
            searchInput.addEventListener('keydown', function(event) {

                if (event.key === 'Enter') {

                    event.preventDefault();

                    clearTimeout(searchTimeout);

                    searchProducts(this.value);

                }

            });


            invoiceDiscountInput.addEventListener('input', calculateTotals);
            paidInput.addEventListener('input', calculateTotals);


            // ------------------------------------
            // Clear Cart
            // ------------------------------------

            document.getElementById('clearCart').addEventListener('click', function() {

                if (!Object.keys(cart).length) return;

                if (!confirm(@json(__('dashboard.clear_sale_confirmation')))) {
                    return;
                }

                cart = {};

                invoiceDiscountInput.value = 0;
                paidInput.value = 0;

                renderCart();

                searchInput.value = '';
                searchInput.focus();

            });


            // ------------------------------------
            // Form Validation
            // ------------------------------------

            document.getElementById('saleForm').addEventListener('submit', function(event) {

                if (!Object.keys(cart).length) {

                    event.preventDefault();

                    alert(@json(__('dashboard.add_at_least_one_product')));
                    searchInput.focus();

                    return;
                }

                const subtotal = Object.values(cart).reduce((sum, product) => {
                    return sum + (product.price * product.quantity) - product.discount;
                }, 0);

                const invoiceDiscount = Number(invoiceDiscountInput.value) || 0;
                const paid = Number(paidInput.value) || 0;

                const total = Math.max(0, subtotal - invoiceDiscount);

                if (invoiceDiscount > subtotal) {

                    event.preventDefault();

                    alert(@json(__('dashboard.invoice_discount_exceeds_subtotal')));

                    return;
                }

                if (paid > total) {

                    event.preventDefault();

                    alert(@json(__('dashboard.paid_amount_exceeds_invoice_total')));

                    return;
                }

                document.getElementById('completeSale').disabled = true;

            });

            document.addEventListener('keydown', function(event) {

                if (event.key === 'F2') {
                    event.preventDefault();

                    searchInput.focus();
                    searchInput.select();
                }

            });

            // Initial state
            renderCart();

            searchInput.focus();

        });
    </script>

@endsection

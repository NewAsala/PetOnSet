@extends('layouts.app')

@section('content')
    @php
        $breadcrumbItems = [
            [
                'label' => 'Purchases',
            ],
        ];
    @endphp

    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">
                @include('components.breadcrumb', ['items' => $breadcrumbItems])
                <h1 class="h3 m-0">Purchases</h1>
            </div>
            <div class="col-auto d-flex">
                <a href="{{ route('purchase.create') }}" class="btn btn-primary">New purchase</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="p-4"><input type="text" placeholder="Start typing to search for purchases"
                class="form-control form-control--search mx-auto" id="table-search" /></div>
        <div class="sa-divider"></div>
        <table class="sa-datatables-init text-nowrap" data-order="[[ 1, &quot;desc&quot; ]]"
            data-sa-search-input="#table-search">
            <thead>
                <tr>
                    <th class="w-min" data-orderable="false">
                        <input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="..." />
                    </th>
                    <th>Invoice Number</th>
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Paid</th>
                    <th>Status</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th class="w-min" data-orderable="false"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                <tr>
                    <td><input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="..." /></td>
                    <td>#<a href="{{ route('purchase.show', ['purchase' => $purchase->id]) }}" class="text-reset">{{ $purchase->invoice_number }}</a></td>
                    <td>{{ $purchase->purchase_date?->format('F j, Y') }}</td>
                    <td><a href="app-customer.html" class="text-reset">{{ $purchase->supplier->name }}</a></td>
                    <td>
                        <div class="sa-price">
                            <span class="sa-price__symbol">$</span>
                            <span class="sa-price__integer">{{ $purchase->paid}}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex fs-6">
                            <div class="badge {{ $purchase->status ? 'badge-sa-success' : 'badge-sa-danger' }}">{{ $purchase->status ? 'Yes' : 'No' }}</div>
                        </div>
                    </td>
                    <td>{{ $purchase->purchaseItems->count() }} items</td>
                    <td>
                        <div class="sa-price">
                            <span class="sa-price__symbol">$</span>
                            <span class="sa-price__integer">{{ $purchase->total }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sa-muted btn-sm" type="button"
                                id="order-context-menu-0" data-bs-toggle="dropdown" aria-expanded="false"
                                aria-label="More">
                                <svg xmlns="http://www.w3.org/2000/svg" width="3" height="13"
                                    fill="currentColor">
                                    <path
                                        d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z">
                                    </path>
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="order-context-menu-0">
                                <li><a class="dropdown-item" href="{{ route('purchase.edit', ['purchase' => $purchase->id]) }}">Edit</a></li>
                                <li><a class="dropdown-item" href="{{ route('purchase.show', ['purchase' => $purchase->id]) }}">Show</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item text-danger" href="#">Purchase Return</a></li>
                                <li>
                                    <button type="button"
                                            class="dropdown-item text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deletePurchaseModal"
                                            data-delete-url="{{ route('purchase.destroy', $purchase) }}"
                                            data-delete-name="{{ $purchase->invoice_number }}">
                                        Delete
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
    <div class="modal fade" id="deletePurchaseModal" tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deletePurchaseForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h5 class="modal-title">Delete Purchase</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete invoice
                    <strong id="deletePurchaseName"></strong>?
                    This action cannot be undone.
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-danger">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('deletePurchaseModal')
    .addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('deletePurchaseForm').action =
            button.dataset.deleteUrl;

        document.getElementById('deletePurchaseName').textContent =
            button.dataset.deleteName;
    });
</script>
@endsection

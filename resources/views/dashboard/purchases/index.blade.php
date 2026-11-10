@extends('layouts.app')

@section('content')
    @php
        $breadcrumbItems = [
            [
                'label' => __('dashboard.purchases'),
            ],
        ];
    @endphp

    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">
                @include('components.breadcrumb', ['items' => $breadcrumbItems])
                <h1 class="h3 m-0">{{ __('dashboard.purchases') }}</h1>
            </div>
            <div class="col-auto d-flex">
                <a href="{{ route('purchase.create') }}" class="btn btn-primary">{{ __('dashboard.new_purchase') }}</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="p-4"><input type="text" placeholder="{{ __('dashboard.search_purchases') }}"
                class="form-control form-control--search mx-auto" id="table-search" /></div>
        <div class="sa-divider"></div>
        <table class="sa-datatables-init text-nowrap" data-order="[[ 1, &quot;desc&quot; ]]"
            data-sa-search-input="#table-search">
            <thead>
                <tr>
                    <th class="w-min" data-orderable="false">
                        <input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="{{ __('dashboard.select_all') }}" />
                    </th>
                    <th>{{ __('dashboard.invoice_number') }}</th>
                    <th>{{ __('dashboard.date') }}</th>
                    <th>{{ __('dashboard.supplier') }}</th>
                    <th>{{ __('dashboard.paid') }}</th>
                    <th>{{ __('dashboard.status') }}</th>
                    <th>{{ __('dashboard.items') }}</th>
                    <th>{{ __('dashboard.total') }}</th>
                    <th class="w-min" data-orderable="false"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                <tr>
                    <td><input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="{{ __('dashboard.select_purchase') }}" /></td>
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
                            <div class="badge {{ $purchase->status ? 'badge-sa-success' : 'badge-sa-danger' }}">{{ $purchase->status ? __('dashboard.yes') : __('dashboard.no') }}</div>
                        </div>
                    </td>
                    <td>{{ __('dashboard.items_count', ['count' => $purchase->purchaseItems->count()]) }}</td>
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
                                aria-label="{{ __('dashboard.more') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="3" height="13"
                                    fill="currentColor">
                                    <path
                                        d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z">
                                    </path>
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="order-context-menu-0">
                                <li><a class="dropdown-item" href="{{ route('purchase.edit', ['purchase' => $purchase->id]) }}">{{ __('dashboard.edit') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('purchase.show', ['purchase' => $purchase->id]) }}">{{ __('dashboard.show') }}</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item text-danger" href="#">{{ __('dashboard.purchase_return') }}</a></li>
                                <li>
                                    <button type="button"
                                            class="dropdown-item text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deletePurchaseModal"
                                            data-delete-url="{{ route('purchase.destroy', $purchase) }}"
                                            data-delete-name="{{ $purchase->invoice_number }}">
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
    <div class="modal fade" id="deletePurchaseModal" tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deletePurchaseForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('dashboard.delete_purchase') }}</h5>
                    <button type="button" class="btn-close m-0"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{ __('dashboard.delete_invoice_confirmation') }}
                    <strong id="deletePurchaseName"></strong>?
                    {{ __('dashboard.action_cannot_be_undone') }}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">
                        {{ __('dashboard.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-danger">
                        {{ __('dashboard.delete') }}
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

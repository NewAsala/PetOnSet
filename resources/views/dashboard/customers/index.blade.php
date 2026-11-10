@extends('layouts.app')
@section('content')
@php
    $breadcrumbItems = [
        [
            'label' => __('dashboard.customers'),
        ],
    ];
@endphp
<div class="py-5">
    <div class="row g-4 align-items-center">
        <div class="col">
            @include('components.breadcrumb', ['items' => $breadcrumbItems])
            <h1 class="h3 m-0">{{ __('dashboard.customers') }}</h1>
        </div>
        <div class="col-auto d-flex">
            <a href="{{ route('customer.create') }}" class="btn btn-primary">{{ __('dashboard.new_customer') }}</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="p-4">
        <input type="text" placeholder="{{ __('dashboard.search_customers') }}" class="form-control form-control--search mx-auto" id="table-search" />
    </div>
    <div class="sa-divider"></div>
    <table class="sa-datatables-init" data-order="[[ 1, &quot;asc&quot; ]]" data-sa-search-input="#table-search">
        <thead>
            <tr>
                <th class="w-min" data-orderable="false">
                    <input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="{{ __('dashboard.select_all') }}" />
                </th>
                <th class="min-w-20x">{{ __('dashboard.name') }}</th>
                <th>{{ __('dashboard.phone') }}</th>
                <th>{{ __('dashboard.registered') }}</th>
                <th class="w-min" data-orderable="false"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="{{ __('dashboard.select_customer') }}" />
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            {{-- <a href="app-customer.html" class="me-4">
                                <div class="sa-symbol sa-symbol--shape--rounded sa-symbol--size--lg">
                                    <img src="images/customers/customer-1-40x40.jpg" width="40" height="40" alt="" />
                                </div>
                            </a> --}}
                            <div>
                                <a href="{{ route('customer.show',['customer' => $customer->id]) }}" class="text-reset">{{$customer->name}}</a>
                                <div class="text-muted mt-n1">{{$customer->email}}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $customer->phone }}</td>
                    <td class="text-nowrap">{{ $customer->created_at->format('F j, Y') }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sa-muted btn-sm" type="button" id="customer-context-menu-0" 
                                data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('dashboard.more') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="3"
                                    height="13" fill="currentColor">
                                    <path
                                        d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z">
                                    </path>
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="customer-context-menu-0">
                                <li><a class="dropdown-item" href="{{ route('customer.edit', ['customer' => $customer->id]) }}">{{ __('dashboard.edit') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.show', ['customer' => $customer->id]) }}">{{ __('dashboard.show') }}</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <button
                                        type="button"
                                        class="dropdown-item text-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-delete-url="{{ route('customer.destroy', $customer) }}"
                                        data-delete-name="{{ $customer->name }}"
                                        data-delete-pets-count="{{ $customer->pets_count }}"
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

@endsection

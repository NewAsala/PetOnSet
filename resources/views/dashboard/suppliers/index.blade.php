@extends('layouts.app')
@section('content')
@php
    $breadcrumbItems = [
        [
            'label' => 'Suppliers',
        ],
    ];
@endphp
<div class="py-5">
    <div class="row g-4 align-items-center">
        <div class="col">
            @include('components.breadcrumb', ['items' => $breadcrumbItems])
            <h1 class="h3 m-0">Suppliers</h1>
        </div>
        <div class="col-auto d-flex">
            <a href="{{ route('supplier.create') }}" class="btn btn-primary">New supplier</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="p-4">
        <input type="text" placeholder="Start typing to search for suppliers" class="form-control form-control--search mx-auto" id="table-search" />
    </div>
    <div class="sa-divider"></div>
    <table class="sa-datatables-init" data-order="[[ 1, &quot;asc&quot; ]]" data-sa-search-input="#table-search">
        <thead>
            <tr>
                <th class="w-min" data-orderable="false">
                    <input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="..." />
                </th>
                <th class="min-w-20x">Name</th>
                <th>Phone</th>
                <th>Registered</th>
                <th class="w-min" data-orderable="false"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="..." />
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            {{-- <a href="app-supplier.html" class="me-4">
                                <div class="sa-symbol sa-symbol--shape--rounded sa-symbol--size--lg">
                                    <img src="images/suppliers/supplier-1-40x40.jpg" width="40" height="40" alt="" />
                                </div>
                            </a> --}}
                            <div>
                                <a href="{{ route('supplier.show',['supplier' => $supplier->id]) }}" class="text-reset">{{$supplier->name}}</a>
                                <div class="text-muted mt-n1">{{$supplier->email}}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $supplier->phone }}</td>
                    <td class="text-nowrap">{{ $supplier->created_at->format('F j, Y') }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sa-muted btn-sm" type="button" id="supplier-context-menu-0" 
                                data-bs-toggle="dropdown" aria-expanded="false" aria-label="More">
                                <svg xmlns="http://www.w3.org/2000/svg" width="3"
                                    height="13" fill="currentColor">
                                    <path
                                        d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z">
                                    </path>
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="supplier-context-menu-0">
                                <li><a class="dropdown-item" href="{{ route('supplier.edit', ['supplier' => $supplier->id]) }}">Edit</a></li>
                                <li><a class="dropdown-item" href="{{ route('supplier.show', ['supplier' => $supplier->id]) }}">Show</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <button
                                        type="button"
                                        class="dropdown-item text-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-delete-url="{{ route('supplier.destroy', $supplier) }}"
                                        data-delete-name="{{ $supplier->name }}"
                                    >
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

@endsection

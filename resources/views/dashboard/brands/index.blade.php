@extends('layouts.app')

@section('content')

@php
    $breadcrumbItems = [
        [
            'label' => 'Brands',
        ],
    ];
@endphp

{{-- Page Header --}}
<div class="py-5">
    <div class="row g-4 align-items-center">

        <div class="col">

            @include('components.breadcrumb', [
                'items' => $breadcrumbItems
            ])

            <h1 class="h3 m-0">Brands</h1>

        </div>

        <div class="col-auto d-flex">

            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#createBrandModal"
            >
                New brand
            </button>

        </div>

    </div>
</div>


{{-- Brands Table --}}
<div class="card">

    {{-- Search --}}
    <div class="p-4">

        <input
            type="text"
            placeholder="Start typing to search for brands"
            class="form-control form-control--search mx-auto"
            id="table-search"
        />

    </div>

    <div class="sa-divider"></div>


    {{-- Table --}}
    <table
        class="sa-datatables-init"
        data-order="[[ 1, &quot;asc&quot; ]]"
        data-sa-search-input="#table-search"
    >

        <thead>

            <tr>

                <th
                    class="w-min"
                    data-orderable="false"
                >
                    <input
                        type="checkbox"
                        class="form-check-input m-0 fs-exact-16 d-block"
                        aria-label="Select all"
                    />
                </th>

                <th class="min-w-20x">
                    Brand Name
                </th>

                <th>
                    Created
                </th>

                <th
                    class="w-min"
                    data-orderable="false"
                ></th>

            </tr>

        </thead>


        <tbody>

            @forelse ($brands as $brand)

                <tr>

                    {{-- Checkbox --}}
                    <td>

                        <input
                            type="checkbox"
                            class="form-check-input m-0 fs-exact-16 d-block"
                            aria-label="Select brand"
                        />

                    </td>


                    {{-- Brand Name --}}
                    <td>

                        <div class="d-flex align-items-center">

                            <div>

                                <span class="text-reset">
                                    {{ $brand->name }}
                                </span>

                            </div>

                        </div>

                    </td>


                    {{-- Created --}}
                    <td class="text-nowrap">

                        {{ $brand->created_at->format('F j, Y') }}

                    </td>


                    {{-- Actions --}}
                    <td>

                        <div class="dropdown">

                            <button
                                class="btn btn-sa-muted btn-sm"
                                type="button"
                                id="brand-context-menu-{{ $brand->id }}"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                aria-label="More"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="3"
                                    height="13"
                                    fill="currentColor"
                                >

                                    <path
                                        d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C0.7,10,0,10.7,0,11.5S0.7,13,1.5,13S3,12.3,3,11.5S2.3,10,1.5,10z"
                                    />

                                </svg>

                            </button>


                            <ul
                                class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="brand-context-menu-{{ $brand->id }}"
                            >

                                {{-- Edit --}}
                                <li>

                                    <button
                                        type="button"
                                        class="dropdown-item"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editBrandModal"
                                        data-brand-id="{{ $brand->id }}"
                                        data-brand-name="{{ $brand->name }}"
                                        data-update-url="{{ route('brand.update', $brand) }}"
                                    >
                                        Edit
                                    </button>

                                </li>


                                <li>
                                    <hr class="dropdown-divider" />
                                </li>


                                {{-- Delete --}}
                                <li>

                                    <button
                                        type="button"
                                        class="dropdown-item text-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-delete-url="{{ route('brand.destroy', $brand) }}"
                                        data-delete-name="{{ $brand->name }}"
                                    >
                                        Delete
                                    </button>

                                </li>

                            </ul>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="4"
                        class="text-center py-5"
                    >
                        <div class="text-muted">
                            No brands found.
                        </div>
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- Pagination --}}
    @if ($brands->hasPages())

        <div class="p-4">

            {{ $brands->links() }}

        </div>

    @endif

</div>


{{-- ========================================================= --}}
{{-- CREATE BRAND MODAL --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="createBrandModal"
    tabindex="-1"
    aria-labelledby="createBrandModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="createBrandModalLabel"
                >
                    Create Brand
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form
                method="POST"
                action="{{ route('brand.store') }}"
            >

                @csrf

                <div class="modal-body">

                    <div>

                        <label
                            for="createBrandName"
                            class="form-label"
                        >
                            Brand name
                        </label>

                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="createBrandName"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter brand name"
                            required
                        >

                        @error('name')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Save
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- EDIT BRAND MODAL --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="editBrandModal"
    tabindex="-1"
    aria-labelledby="editBrandModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="editBrandModalLabel"
                >
                    Edit Brand
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form
                method="POST"
                id="editBrandForm"
            >

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div>

                        <label
                            for="editBrandName"
                            class="form-label"
                        >
                            Brand name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="editBrandName"
                            name="name"
                            required
                        >

                        <div
                            class="invalid-feedback"
                            id="editBrandNameError"
                        ></div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- EDIT MODAL SCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const editModal = document.getElementById('editBrandModal');

    if (!editModal) {
        return;
    }

    editModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const brandName = button.getAttribute('data-brand-name');
        const updateUrl = button.getAttribute('data-update-url');

        const form = document.getElementById('editBrandForm');
        const nameInput = document.getElementById('editBrandName');

        form.setAttribute('action', updateUrl);

        nameInput.value = brandName;

        nameInput.classList.remove('is-invalid');

    });

});

</script>


{{-- ========================================================= --}}
{{-- OPEN CREATE MODAL AFTER VALIDATION ERROR --}}
{{-- ========================================================= --}}

@if ($errors->any())

<script>

document.addEventListener('DOMContentLoaded', function () {

    const createModalElement =
        document.getElementById('createBrandModal');

    const createModal =
        new bootstrap.Modal(createModalElement);

    createModal.show();

});

</script>

@endif

@endsection
@extends('layouts.app')

@section('content')

@php
    $breadcrumbItems = [
        [
            'label' => 'Categories',
        ],
    ];
@endphp


{{-- ========================================================= --}}
{{-- PAGE HEADER --}}
{{-- ========================================================= --}}

<div class="py-5">

    <div class="row g-4 align-items-center">

        <div class="col">

            @include('components.breadcrumb', [
                'items' => $breadcrumbItems
            ])

            <h1 class="h3 m-0">
                Categories
            </h1>

        </div>

        <div class="col-auto">

            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#categoryModal"
            >
                New category
            </button>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- CATEGORIES TABLE --}}
{{-- ========================================================= --}}

<div class="card">

    <div class="p-4">

        <input
            type="text"
            placeholder="Start typing to search for categories"
            class="form-control form-control--search mx-auto"
            id="table-search"
        />

    </div>

    <div class="sa-divider"></div>


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
                    Name
                </th>

                <th>
                    Description
                </th>

                <th>
                    Created
                </th>

                <th
                    class="w-min"
                    data-orderable="false"
                >
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse ($categories as $category)

                <tr>

                    {{-- Checkbox --}}
                    <td>

                        <input
                            type="checkbox"
                            class="form-check-input m-0 fs-exact-16 d-block"
                            aria-label="Select category"
                        />

                    </td>


                    {{-- Name --}}
                    <td>

                        <span class="fw-medium">
                            {{ $category->name }}
                        </span>

                    </td>


                    {{-- Description --}}
                    <td>

                        <span class="text-muted">

                            {{ $category->description ?: '—' }}

                        </span>

                    </td>


                    {{-- Created --}}
                    <td class="text-nowrap">

                        {{ $category->created_at->format('F j, Y') }}

                    </td>


                    {{-- Actions --}}
                    <td>

                        <div class="dropdown">

                            <button
                                class="btn btn-sa-muted btn-sm"
                                type="button"
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
                                        d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z"
                                    />
                                </svg>

                            </button>


                            <ul class="dropdown-menu dropdown-menu-end">

                                {{-- Edit --}}
                                <li>

                                    <button
                                        type="button"
                                        class="dropdown-item"
                                        data-bs-toggle="modal"
                                        data-bs-target="#categoryModal"

                                        data-mode="edit"

                                        data-category-name="{{ $category->name }}"

                                        data-category-description="{{ $category->description }}"

                                        data-category-update-url="{{ route('category.update', $category) }}"
                                    >
                                        Edit
                                    </button>

                                </li>


                                <li>
                                    <hr class="dropdown-divider">
                                </li>


                                {{-- Delete --}}
                                <li>

                                    <button
                                        type="button"
                                        class="dropdown-item text-danger"

                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"

                                        data-delete-url="{{ route('category.destroy', $category) }}"

                                        data-delete-name="{{ $category->name }}"
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
                        colspan="5"
                        class="text-center py-5 text-muted"
                    >
                        No categories found.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


{{-- ========================================================= --}}
{{-- PAGINATION --}}
{{-- ========================================================= --}}

@if ($categories->hasPages())

    <div class="mt-4">

        {{ $categories->links() }}

    </div>

@endif



{{-- ========================================================= --}}
{{-- CREATE / EDIT CATEGORY MODAL --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="categoryModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog">

        <div class="modal-content">


            {{-- Header --}}
            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="categoryModalTitle"
                >
                    Create Category
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- Form --}}
            <form
                method="POST"
                id="categoryForm"
                action="{{ route('category.store') }}"
            >

                @csrf

                <div id="categoryMethod"></div>


                <div class="modal-body">


                    {{-- Name --}}
                    <div class="mb-3">

                        <label
                            for="categoryName"
                            class="form-label"
                        >
                            Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="categoryName"

                            class="form-control @error('name') is-invalid @enderror"

                            value="{{ old('name') }}"

                            placeholder="Category name"
                        >

                        @error('name')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Description --}}
                    <div class="mb-3">

                        <label
                            for="categoryDescription"
                            class="form-label"
                        >
                            Description
                        </label>

                        <textarea
                            name="description"
                            id="categoryDescription"

                            class="form-control @error('description') is-invalid @enderror"

                            rows="4"

                            placeholder="Category description"
                        >{{ old('description') }}</textarea>

                        @error('description')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- Footer --}}
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
                        id="categorySubmitButton"
                    >
                        Save
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAL JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const categoryModal =
        document.getElementById('categoryModal');

    const categoryForm =
        document.getElementById('categoryForm');

    const categoryModalTitle =
        document.getElementById('categoryModalTitle');

    const categorySubmitButton =
        document.getElementById('categorySubmitButton');

    const categoryName =
        document.getElementById('categoryName');

    const categoryDescription =
        document.getElementById('categoryDescription');

    const categoryMethod =
        document.getElementById('categoryMethod');


    if (!categoryModal) {
        return;
    }


    categoryModal.addEventListener(
        'show.bs.modal',
        function (event) {

            const button = event.relatedTarget;


            /*
            |--------------------------------------------------------------------------
            | CREATE
            |--------------------------------------------------------------------------
            */

            if (
                !button ||
                button.getAttribute('data-mode') !== 'edit'
            ) {

                categoryModalTitle.textContent =
                    'Create Category';

                categorySubmitButton.textContent =
                    'Save';

                categoryForm.action =
                    "{{ route('category.store') }}";


                categoryMethod.innerHTML = '';


                categoryName.value = '';

                categoryDescription.value = '';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | EDIT
            |--------------------------------------------------------------------------
            */

            const name =
                button.getAttribute('data-category-name');

            const description =
                button.getAttribute(
                    'data-category-description'
                );

            const updateUrl =
                button.getAttribute(
                    'data-category-update-url'
                );


            categoryModalTitle.textContent =
                'Edit Category';

            categorySubmitButton.textContent =
                'Save changes';


            categoryForm.action =
                updateUrl;


            categoryMethod.innerHTML =
                '@method("PUT")';


            categoryName.value =
                name ?? '';

            categoryDescription.value =
                description ?? '';

        }
    );


    /*
    |--------------------------------------------------------------------------
    | OPEN CREATE MODAL AFTER VALIDATION ERROR
    |--------------------------------------------------------------------------
    */

    @if ($errors->any())

        const modal =
            new bootstrap.Modal(categoryModal);

        modal.show();

    @endif

});

</script>


@endsection
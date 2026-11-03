@extends('layouts.app')

@section('content')

@php
    use App\Enums\PetTypeEnum;
    use App\Enums\GenderEnum;

    $breadcrumbItems = [
        [
            'label' => 'Pets',
        ],
    ];
@endphp


<div class="py-5">

    <div class="row g-4 align-items-center">

        <div class="col">

            @include('components.breadcrumb', [
                'items' => $breadcrumbItems
            ])

            <h1 class="h3 m-0">Pets</h1>

        </div>

        <div class="col-auto d-flex">

            <a href="{{ route('pet.create') }}" class="btn btn-primary">
                New pet
            </a>

        </div>

    </div>

</div>


<div class="card">

    <div class="p-4">

        <input
            type="text"
            placeholder="Start typing to search for pets"
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

                <th class="w-min" data-orderable="false">
                    <input
                        type="checkbox"
                        class="form-check-input m-0 fs-exact-16 d-block"
                        aria-label="Select all"
                    />
                </th>

                <th class="min-w-15x">
                    Pet Name
                </th>

                <th>
                    Type
                </th>

                <th>
                    Gender
                </th>

                <th>
                    Age
                </th>

                <th>
                    Weight
                </th>

                <th>
                    Customer
                </th>

                <th>
                    Created
                </th>

                <th class="w-min" data-orderable="false"></th>

            </tr>

        </thead>


        <tbody>

            @forelse ($pets as $pet)

                <tr>

                    {{-- Checkbox --}}

                    <td>

                        <input
                            type="checkbox"
                            class="form-check-input m-0 fs-exact-16 d-block"
                            aria-label="Select pet"
                        />

                    </td>


                    {{-- Pet Name --}}

                    <td>

                        <div>

                            <a href="{{ route('pet.edit', $pet) }}" class="text-reset">{{$pet->name}}</a>

                            @if ($pet->notes)

                                <div class="text-muted mt-n1">

                                    {{ Str::limit($pet->notes, 50) }}

                                </div>

                            @endif

                        </div>

                    </td>


                    {{-- Type --}}

                    <td>

                        @if ($pet->type)

                            {{ $pet->type->value }}

                        @else

                            —

                        @endif

                    </td>


                    {{-- Gender --}}

                    <td>

                        @if ($pet->gender)

                            {{ $pet->gender->value }}

                        @else

                            —

                        @endif

                    </td>


                    {{-- Age --}}

                    <td>

                        @if ($pet->age !== null)

                            {{ $pet->age }}
                            {{ $pet->age == 1 ? 'year' : 'years' }}

                        @else

                            —

                        @endif

                    </td>


                    {{-- Weight --}}

                    <td>

                        @if ($pet->weight !== null)

                            {{ number_format($pet->weight, 2) }} kg

                        @else

                            —

                        @endif

                    </td>


                    {{-- Customer --}}

                    <td>

                        @if ($pet->customer)

                            <a
                                href="{{ route('customer.show', $pet->customer) }}"
                                class="text-reset"
                            >
                                {{ $pet->customer->name }}
                            </a>

                        @else

                            —

                        @endif

                    </td>


                    {{-- Created --}}

                    <td class="text-nowrap">

                        {{ $pet->created_at->format('F j, Y') }}

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
                                        d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5z M1.5,10C0.7,10,0,10.7,0,11.5S0.7,13,1.5,13S3,12.3,3,11.5S2.3,10,1.5,10z"
                                    />

                                </svg>

                            </button>


                            <ul class="dropdown-menu dropdown-menu-end">

                                {{-- Edit --}}

                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('pet.edit', $pet) }}"
                                    >
                                        Edit
                                    </a>

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
                                        data-delete-url="{{ route('pet.destroy', $pet) }}"
                                        data-delete-name="{{ $pet->name }}"
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
                        colspan="9"
                        class="text-center py-5 text-muted"
                    >
                        No pets found.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


{{-- Pagination --}}

@if ($pets->hasPages())

    <div class="mt-4">

        {{ $pets->links() }}

    </div>

@endif

@endsection
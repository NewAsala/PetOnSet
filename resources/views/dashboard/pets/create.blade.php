@extends('layouts.app')

@section('content')

@php
    use App\Enums\PetTypeEnum;
    use App\Enums\GenderEnum;

    $breadcrumbItems = [
        [
            'label' => 'Pets',
            'url' => route('pet.index'),
        ],
        [
            'label' => 'Create Pet',
        ],
    ];
@endphp


<div class="py-5">

    <div class="row g-4 align-items-center">

        <div class="col">

            @include('components.breadcrumb', [
                'items' => $breadcrumbItems
            ])

            <h1 class="h3 m-0">
                Create new Pet
            </h1>

        </div>

    </div>

</div>


<div class="card">

    <div class="card-body p-5">

        <form
            class="row g-4"
            method="POST"
            action="{{ route('pet.store') }}"
        >

            @csrf


            {{-- Name --}}

            <div class="col-md-6">

                <label for="inputName" class="form-label">
                    Name
                </label>

                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    id="inputName"
                    value="{{ old('name') }}"
                >

                @error('name')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- Customer --}}

            <div class="col-md-6">

                <label for="customer_id" class="form-label">
                    Customer
                </label>

                <select
                    name="customer_id"
                    id="customer_id"
                    class="form-select @error('customer_id') is-invalid @enderror"
                >

                    <option value="">
                        Select customer
                    </option>

                    @foreach ($customers as $customer)

                        <option
                            value="{{ $customer->id }}"
                            @selected(old('customer_id') == $customer->id)
                        >
                            {{ $customer->name }}
                        </option>

                    @endforeach

                </select>

                @error('customer_id')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- Type --}}

            <div class="col-md-6">

                <label for="type" class="form-label">
                    Type
                </label>

                <select
                    name="type"
                    id="type"
                    class="form-select @error('type') is-invalid @enderror"
                >

                    <option value="">
                        Select type
                    </option>

                    @foreach (PetTypeEnum::cases() as $type)

                        <option
                            value="{{ $type->value }}"
                            @selected(old('type') === $type->value)
                        >
                            {{ $type->value }}
                        </option>

                    @endforeach

                </select>

                @error('type')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- Gender --}}

            <div class="col-md-6">

                <label for="gender" class="form-label">
                    Gender
                </label>

                <select
                    name="gender"
                    id="gender"
                    class="form-select @error('gender') is-invalid @enderror"
                >

                    <option value="">
                        Select gender
                    </option>

                    @foreach (GenderEnum::cases() as $gender)

                        <option
                            value="{{ $gender->value }}"
                            @selected(old('gender') === $gender->value)
                        >
                            {{ $gender->value }}
                        </option>

                    @endforeach

                </select>

                @error('gender')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- Age --}}

            <div class="col-md-6">

                <label for="age" class="form-label">
                    Age
                </label>

                <input
                    type="number"
                    min="0"
                    class="form-control @error('age') is-invalid @enderror"
                    name="age"
                    id="age"
                    value="{{ old('age') }}"
                >

                @error('age')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- Weight --}}

            <div class="col-md-6">

                <label for="weight" class="form-label">
                    Weight (kg)
                </label>

                <input
                    type="number"
                    step="0.01"
                    min="0"
                    class="form-control @error('weight') is-invalid @enderror"
                    name="weight"
                    id="weight"
                    value="{{ old('weight') }}"
                >

                @error('weight')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- Notes --}}

            <div class="col-12">

                <label for="notes" class="form-label">
                    Notes
                </label>

                <textarea
                    name="notes"
                    id="notes"
                    rows="4"
                    class="form-control @error('notes') is-invalid @enderror"
                    placeholder="Additional notes..."
                >{{ old('notes') }}</textarea>

                @error('notes')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- Buttons --}}

            <div class="col-12">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Save
                </button>

                <a
                    href="{{ route('pet.index') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
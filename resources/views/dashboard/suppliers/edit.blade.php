@extends('layouts.app')

@section('content')
    @php
        $breadcrumbItems = [
            [
                'label' => 'Suppliers',
                'url' => route('supplier.index'),
            ],
            [
                'label' => 'Edit Supplier',
            ],
        ];
    @endphp

    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">

                @include('components.breadcrumb', [
                    'items' => $breadcrumbItems,
                ])

                <h1 class="h3 m-0">Edit Supplier</h1>

            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-body p-5">

            <form class="row g-4" method="POST" action="{{ route('supplier.update', $supplier) }}">

                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="col-md-6">

                    <label for="inputName" class="form-label">
                        Name
                    </label>

                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="inputName" value="{{ old('name', $supplier->name) }}">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Email --}}
                <div class="col-md-6">

                    <label for="inputEmail" class="form-label">
                        Email
                    </label>

                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        id="inputEmail" value="{{ old('email', $supplier->email) }}">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Phone --}}
                <div class="col-md-6">

                    <label for="inputPhone" class="form-label">
                        Phone
                    </label>

                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        id="inputPhone" value="{{ old('phone', $supplier->phone) }}">

                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Address --}}
                <div class="col-md-6">

                    <label for="inputAddress" class="form-label">
                        Address
                    </label>

                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                        id="inputAddress" value="{{ old('address', $supplier->address) }}" placeholder="1234 Main St">

                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-12">

                    <label for="inputNotes" class="form-label">
                        Notes
                    </label>

                    <textarea class="form-control @error('notes') is-invalid @enderror" name="notes"
                        id="inputNotes" placeholder="Additional information about the supplier">{{ old('notes', $supplier->notes) }}</textarea>

                    @error('notes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Buttons --}}
                <div class="col-12">

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('supplier.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>
@endsection

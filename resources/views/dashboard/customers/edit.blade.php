@extends('layouts.app')

@section('content')
    @php
        $breadcrumbItems = [
            [
                'label' => 'Customers',
                'url' => route('customer.index'),
            ],
            [
                'label' => 'Edit Customer',
            ],
        ];
    @endphp

    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">

                @include('components.breadcrumb', [
                    'items' => $breadcrumbItems,
                ])

                <h1 class="h3 m-0">Edit Customer</h1>

            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-body p-5">

            <form class="row g-4" method="POST" action="{{ route('customer.update', $customer) }}">

                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="col-md-6">

                    <label for="inputName" class="form-label">
                        Name
                    </label>

                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="inputName" value="{{ old('name', $customer->name) }}">

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
                        id="inputEmail" value="{{ old('email', $customer->email) }}">

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
                        id="inputPhone" value="{{ old('phone', $customer->phone) }}">

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
                        id="inputAddress" value="{{ old('address', $customer->address) }}" placeholder="1234 Main St">

                    @error('address')
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

                    <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>
@endsection

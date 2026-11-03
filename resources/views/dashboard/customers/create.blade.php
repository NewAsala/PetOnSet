@extends('layouts.app')
@section('content')
@php
    $breadcrumbItems = [
        [
            'label' => 'Customers',
            'url' => route('customer.index'),
        ],
        [
            'label' => 'Create Customer',
        ],
    ];
@endphp
<div class="py-5">
    <div class="row g-4 align-items-center">
        <div class="col">
            @include('components.breadcrumb', ['items' => $breadcrumbItems ])

            <h1 class="h3 m-0">Create new Customer</h1>
        </div>
        {{-- <div class="col-auto d-flex">
            <a href="{{ route('customer.create') }}" class="btn btn-primary">New customer</a>
        </div> --}}
    </div>
</div>
<div class="card">
    <div class="card-body p-5">
        <form class="row g-4" method="POST" action="{{ route('customer.store') }}">
            @csrf
            <div class="col-md-6">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputName" value="{{ old('name') }}" />
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail" value="{{ old('email') }}" />
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="inputPhone" value="{{ old('phone') }}" />
                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Address</label>
                <input
                    type="text"
                    class="form-control @error('address') is-invalid @enderror"
                    name="address"
                    id="inputAddress"
                    value="{{ old('address') }}"
                    placeholder="1234 Main St"
                />
                @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">

                <button type="submit" class="btn btn-primary">
                    Save
                </button>

                <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

            </div>
        </form>
    </div>
</div>
@endsection

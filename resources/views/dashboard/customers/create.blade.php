@extends('layouts.app')
@section('content')
@php
    $breadcrumbItems = [
        [
            'label' => __('dashboard.customers'),
            'url' => route('customer.index'),
        ],
        [
            'label' => __('dashboard.create_customer'),
        ],
    ];
@endphp
<div class="py-5">
    <div class="row g-4 align-items-center">
        <div class="col">
            @include('components.breadcrumb', ['items' => $breadcrumbItems ])

            <h1 class="h3 m-0">{{ __('dashboard.create_new_customer') }}</h1>
        </div>
        {{-- <div class="col-auto d-flex">
            <a href="{{ route('customer.create') }}" class="btn btn-primary">{{ __('dashboard.new_customer') }}</a>
        </div> --}}
    </div>
</div>
<div class="card">
    <div class="card-body p-5">
        <form class="row g-4" method="POST" action="{{ route('customer.store') }}">
            @csrf
            <div class="col-md-6">
                <label for="inputName" class="form-label">{{ __('dashboard.name') }}</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputName" value="{{ old('name') }}" />
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">{{ __('dashboard.email') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail" value="{{ old('email') }}" />
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">{{ __('dashboard.phone') }}</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="inputPhone" value="{{ old('phone') }}" />
                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="inputAddress" class="form-label">{{ __('dashboard.address') }}</label>
                <input
                    type="text"
                    class="form-control @error('address') is-invalid @enderror"
                    name="address"
                    id="inputAddress"
                    value="{{ old('address') }}"
                    placeholder="{{ __('dashboard.main_street_placeholder') }}"
                />
                @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">

                <button type="submit" class="btn btn-primary">
                    {{ __('dashboard.save') }}
                </button>

                <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                    {{ __('dashboard.cancel') }}
                </a>

            </div>
        </form>
    </div>
</div>
@endsection

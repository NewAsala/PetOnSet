@extends('layouts.app')

@section('content')

@php
    $breadcrumbItems = [
        [
            'label' => __('dashboard.users'),
            'url' => route('user.index'),
        ],
        [
            'label' => __('dashboard.create_user'),
        ],
    ];
@endphp

<div class="py-5">
    <div class="row g-4 align-items-center">
        <div class="col">

            @include('components.breadcrumb', [
                'items' => $breadcrumbItems
            ])

            <h1 class="h3 m-0">{{ __('dashboard.create_new_user') }}</h1>

        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-5">

        <form class="row g-4"
              method="POST"
              action="{{ route('user.store') }}">

            @csrf

            {{-- Name --}}
            <div class="col-md-6">

                <label for="inputName" class="form-label">
                    {{ __('dashboard.name') }}
                </label>

                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    id="inputName"
                    value="{{ old('name') }}"
                    autofocus
                />

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- Email --}}
            <div class="col-md-6">

                <label for="inputEmail" class="form-label">
                    {{ __('dashboard.email') }}
                </label>

                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    id="inputEmail"
                    value="{{ old('email') }}"
                />

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- Phone --}}
            <div class="col-md-6">

                <label for="inputPhone" class="form-label">
                    {{ __('dashboard.phone') }}
                </label>

                <input
                    type="text"
                    class="form-control @error('phone') is-invalid @enderror"
                    name="phone"
                    id="inputPhone"
                    value="{{ old('phone') }}"
                />

                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- Role --}}
            <div class="col-md-6">

                <label for="inputRole" class="form-label">
                    {{ __('dashboard.role') }}
                </label>

                <select
                    name="role"
                    id="inputRole"
                    class="form-select @error('role') is-invalid @enderror"
                >

                    <option value="">
                        {{ __('dashboard.select_role') }}
                    </option>

                    @foreach ($roles as $role)

                        <option
                            value="{{ $role->name }}"
                            {{ old('role') == $role->name ? 'selected' : '' }}
                        >
                            {{ $role->name }}
                        </option>

                    @endforeach

                </select>

                @error('role')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- Password --}}
            <div class="col-md-6">

                <label for="inputPassword" class="form-label">
                    {{ __('dashboard.password') }}
                </label>

                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    id="inputPassword"
                    autocomplete="new-password"
                />

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- Confirm Password --}}
            <div class="col-md-6">

                <label for="inputPasswordConfirmation" class="form-label">
                    {{ __('dashboard.confirm_password') }}
                </label>

                <input
                    type="password"
                    class="form-control"
                    name="password_confirmation"
                    id="inputPasswordConfirmation"
                    autocomplete="new-password"
                />

            </div>

            {{-- Buttons --}}
            <div class="col-12">

                <button type="submit" class="btn btn-primary">
                    {{ __('dashboard.save') }}
                </button>

                <a
                    href="{{ route('user.index') }}"
                    class="btn btn-secondary"
                >
                    {{ __('dashboard.cancel') }}
                </a>

            </div>

        </form>

    </div>
</div>

@endsection
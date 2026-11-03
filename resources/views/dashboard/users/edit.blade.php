@extends('layouts.app')

@section('content')

@php
    $breadcrumbItems = [
        [
            'label' => 'Users',
            'url' => route('user.index'),
        ],
        [
            'label' => 'Edit User',
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
                Update User: <span class="fst-italic">{{ $user->name }}</span> 
            </h1>

        </div>

    </div>
</div>

<div class="card">
    <div class="card-body p-5">

        <form
            class="row g-4"
            method="POST"
            action="{{ route('user.update', $user) }}"
        >

            @csrf
            @method('PUT')

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
                    value="{{ old('name', $user->name) }}"
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
                    Email
                </label>

                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    id="inputEmail"
                    value="{{ old('email', $user->email) }}"
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
                    Phone
                </label>

                <input
                    type="text"
                    class="form-control @error('phone') is-invalid @enderror"
                    name="phone"
                    id="inputPhone"
                    value="{{ old('phone', $user->phone) }}"
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
                    Role
                </label>

                @php
                    $currentRole = $user->roles->first()?->name;
                @endphp

                <select
                    name="role"
                    id="inputRole"
                    class="form-select @error('role') is-invalid @enderror"
                >

                    <option value="">
                        Select Role
                    </option>

                    @foreach ($roles as $role)
                        <option
                            value="{{ $role->name }}"
                            {{ old('role', $currentRole) == $role->name ? 'selected' : '' }}
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

            {{-- New Password --}}
            <div class="col-md-6">

                <label for="inputPassword" class="form-label">
                    New Password
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

            {{-- Confirm New Password --}}
            <div class="col-md-6">

                <label for="inputPasswordConfirmation" class="form-label">
                    Confirm New Password
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
                    Save
                </button>

                <a
                    href="{{ route('user.index') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>
</div>

@endsection
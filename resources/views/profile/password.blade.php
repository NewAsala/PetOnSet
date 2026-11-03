@extends('layouts.app')
@section('content')
    @php
        $breadcrumbItems = [
            [
                'label' => 'Edit Password',
            ],
        ];
    @endphp
    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">
                @include('components.breadcrumb', ['items' => $breadcrumbItems])

                <h1 class="h3 m-0">Update Password</h1>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-5">
                @include('profile.partials.update-password-form')
        </div>

    </div>
@endsection

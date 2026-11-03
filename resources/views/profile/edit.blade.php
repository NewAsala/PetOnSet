@extends('layouts.app')
@section('content')
    @php
        $breadcrumbItems = [
            [
                'label' => 'Edit Profile',
            ],
        ];
    @endphp
    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">
                @include('components.breadcrumb', ['items' => $breadcrumbItems])
                <h1 class="h3 m-0">Update Profile: <span class="fst-italic fw-normal">{{Auth::user()->name}}</span></h1>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-5">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
    @endsection
@extends('layouts.auth')

@section('auth-css')
<link href="{{ asset('frontend/css/pages/choosecompany.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('frontend/css/pages/membership.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend/assets/vendor/libs/bs-stepper/bs-stepper.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')


<div class="lopgBox">
    <a href="{{ route('login') }}">
        <img src="{{ asset('assets/img/rehda-logo.svg') }}" alt="">
    </a>
</div>
<div class="container mb-4">
    <div class="card mt-1 mb-5">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h3 class="card-title mb-3">Rehda Member Portal</h3>
            <a href="{{ route('login') }}">BACK TO HOME PAGE <i class="ti ti-arrow-right"></i></a>
        </div>

        <div class="card-body text-center pt-4">
              <h4>Your registration has been submitted!</h4>

              <h5>Please check your email now for the invoice and payment link. Thank you.</h5>
        </div>
    </div>
</div>
@endsection
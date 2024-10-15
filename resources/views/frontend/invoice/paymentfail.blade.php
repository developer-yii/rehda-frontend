@extends('layouts.auth')

@section('title', 'Payment Fail')

@section('auth-css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
<link href="{{ asset('frontend/css/pages/membership.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="lopgBox">
    <a href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/img/rehda-logo.svg') }}" alt="">
    </a>
</div>
<div class="container mb-4">
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h3 class="card-title mb-3">Rehda Member Portal</h3>
        </div>

        <div class="card-body pt-3">
            <div class="payment-message">
                <h3 class="fail">Payment Fail!</h3>
                <p>Ops, payment not successful! Please try again later.</p>
            </div>
        </div>
    </div>
</div>
@endsection
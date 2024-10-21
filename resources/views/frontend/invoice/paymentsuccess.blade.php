@extends('layouts.auth')

@section('title', 'Payment Success')

@section('auth-css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
<link href="{{ asset('frontend/css/pages/membership.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="lopgBox">
    <a href="{{ route('bulletin.index') }}">
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
                <h3 class="success">Payment Successful!</h3>
                <p>Thank you for the payment! Please check your receipt from your REHDA Members Portal.</p>
            </div>
        </div>
    </div>
</div>
@endsection
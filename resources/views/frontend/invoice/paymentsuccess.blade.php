@extends('layouts.app')

@section('title', 'Invoice/Receipt/Payment')

@section('css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">{{ __('translation.label_dashboard') }}</a>
                </li>

                <li class="breadcrumb-item active">Invoice/Receipt/Payment</li>

            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Invoice/Receipt/Payment</h5>
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
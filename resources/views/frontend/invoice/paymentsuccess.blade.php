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
            <h3 class="card-title mb-3">REHDA Member Portal</h3>
        </div>

        <div class="card-body pt-3">
            <div class="payment-message">
                <h3 class="success">Payment Successful!</h3>
                <p>Thank you for the payment! Please check your receipt from your REHDA Members Portal.</p>
            </div>

            <div class="d-flex justify-content-center mt-4 mb-3">
                <a href="{{ route('invoice.index') }}" name="membership-submit" id="membership-submit" class="btn btn-primary d-grid w-25 waves-effect waves-light">Back to Invoice</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('auth-js')
<script type="text/javascript">
$(document).ready(function(){
    setTimeout(function(){
        window.location.href = "{{ route('invoice.index') }}";
    }, 5000);
});
</script>
@endsection
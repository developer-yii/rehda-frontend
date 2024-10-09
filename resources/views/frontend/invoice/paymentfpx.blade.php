@extends('layouts.auth')

@section('title', 'Invoice/Receipt/Payment')

@section('css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">

            @php

            $totalprice = $order->order_grandtotal;
            $amounthash = $totalprice*100;

            $hashcode = hash('sha256', 'GXk0rFMnVv'.'M38849'.$order->order_no.$amounthash.'MYR');
            @endphp
            <form method="POST" name="paymentfpx" id="paymentfpx" action="https://payment.ipay88.com.my/epayment/entry.asp">
                <input type="hidden" name="MerchantCode" value="M38849">
                <input type="hidden" name="PaymentId" value="16">
                <input type="hidden" name="RefNo" value="{{ $order->order_no }}">
                <input type="hidden" name="Amount" value="{{ number_format($order->order_grandtotal,2) }}">
                <input type="hidden" name="Currency" value="MYR">
                <input type="hidden" name="ProdDesc" value="REHDA MEMBERSHIP">
                <input type="hidden" name="UserName" value="{{ $memberDetails['fullname'] }}">
                <input type="hidden" name="UserEmail" value="{{ $memberDetails['email'] }}">
                <input type="hidden" name="UserContact" value="{{ $memberDetails['hp'] }}">
                <input type="hidden" name="Lang" value="UTF-8">
                <input type="hidden" name="SignatureType" value="SHA256">
				<input type="hidden" name="Signature" value="{{ $hashcode }}">
				<input type="hidden" name="ResponseURL" value="{{ route('invoice.paymentreturn') }}">
				<input type="hidden" name="BackendURL" value="{{ route('invoice.paymentreturncallback') }}">
				<input type="submit" id="startrunning" value="Proceed with Payment" name="Submit" style="display:none;">
            </form>
        </div>
</div>
@endsection

@section('auth-js')
<script type="text/javascript">
    function submitForm() {
        document.getElementById("paymentfpx").submit(); // Automatically submit the form
    }
    window.onload = submitForm; // Call the function on page load
</script>
@endsection
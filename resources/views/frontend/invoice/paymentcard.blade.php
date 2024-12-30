@extends('layouts.auth')

@section('title', 'Invoice/Receipt/Payment')

@section('css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">

            @php

            $totalprice = $order->order_grandtotal + $order->order_paycc;
            $amounthash = $totalprice*100;
            $merchant_key = config('constant.MERCHANT_KEY');
            $merchant_code = config('constant.MERCHANT_CODE');

            $hashcode = hash('sha256', $merchant_key.$merchant_code.config('constant.ORDERID_SET').$order->order_no.$amounthash.'MYR');
            @endphp
            <form method="POST" name="paymentcard" id="paymentcard" action="https://payment.ipay88.com.my/epayment/entry.asp">
                <input type="hidden" name="MerchantCode" value="{{ $merchant_code }}">
                <input type="hidden" name="PaymentId" value="2">
                <input type="hidden" name="RefNo" value="{{ config('constant.ORDERID_SET').$order->order_no }}">
                <!-- <input type="hidden" name="Amount" value="{{ number_format(($order->order_grandtotal + $order->order_paycc),2) }}"> -->
                <input type="hidden" name="Amount" value="{{ number_format(1,2) }}">
                <input type="hidden" name="Currency" value="MYR">
                <input type="hidden" name="ProdDesc" value="REHDA MEMBERSHIP">
                <input type="hidden" name="UserName" value="{{ $memberDetails['fullname'] }}">
                <input type="hidden" name="UserEmail" value="{{ $memberDetails['email'] }}">
                <input type="hidden" name="UserContact" value="{{ substr($memberDetails['hp'], 0, 19) }}">
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
        document.getElementById("paymentcard").submit(); // Automatically submit the form
    }
    window.onload = submitForm; // Call the function on page load
</script>
@endsection
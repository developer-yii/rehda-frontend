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

            @php

            $totalprice = $order->order_grandtotal + $order->order_paycc;
            $amounthash = $totalprice*100;

            $hashcode = hash('sha256', 'GXk0rFMnVv'.'M38849'.$order->order_no.$amounthash.'MYR');
            @endphp
            <!-- <form method="POST" name="paymentcard" id="paymentcard" action="https://payment.ipay88.com.my/epayment/entry.asp"> -->
            <form method="POST" name="paymentcard" id="paymentcard" action="{{ route('invoice.paymentsubmit') }}">
                @csrf
                <input type="hidden" name="MerchantCode" value="M38849">
                <input type="hidden" name="PaymentId" value="2">
                <input type="hidden" name="RefNo" value="{{ $order->order_no }}">
                <input type="hidden" name="Amount" value="{{ number_format(($order->order_grandtotal + $order->order_paycc),2) }}">
                <input type="hidden" name="Currency" value="MYR">
                <input type="hidden" name="ProdDesc" value="REHDA MEMBERSHIP">
                <input type="hidden" name="UserName" value="{{ $memberDetails['fullname'] }}">
                <input type="hidden" name="UserEmail" value="{{ $memberDetails['email'] }}">
                <input type="hidden" name="UserContact" value="{{ $memberDetails['hp'] }}">
                <input type="hidden" name="Lang" value="UTF-8">
                <input type="hidden" name="SignatureType" value="SHA256">
				<input type="hidden" name="Signature" value="<?=$hashcode;?>">
				<input type="hidden" name="ResponseURL" value="pymt_returnpymt.php">
				<input type="hidden" name="BackendURL" value="pymt_returncallback.php">
				<input type="submit" id="startrunning" value="Proceed with Payment" name="Submit" style="display:none;">
            </form>

        </div>
</div>
@endsection

@section('page-js')
<script>
    $(window).on("load", function() {
        $("#paymentcard").submit();
    });
</script>
@endsection
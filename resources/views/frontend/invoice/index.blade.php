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
                        <a href="{{ route('choosecompant.index') }}">Other Accounts</a>
                    </li>

                    <li class="breadcrumb-item active">Invoice/Receipt/Payment</li>

                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header border-bottom d-flex">
                <h5 class="card-title mt-2 mb-3">Invoice/Receipt/Payment</h5>
                <select class="form-control w-25 ms-3" name="status_filter" id="status_filter">
                    <option value="">Select / Clear Status</option>
                    <option value="2">Paid</option>
                    <option value="99">Cancel</option>
                </select>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="invoiceTable">
                    <thead class="border-top">
                        <tr>
                            <th>Date</th>
                            <th>Membership No</th>
                            <th>Company Name</th>
                            <th>Member Type</th>
                            <th>Invoice No.</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

</div>

@endsection

@section('page-js')
<script>
        var getInvoice = "{{ route('invoice.indexget') }}";
</script>
<script src="{{ asset('frontend/js/pages/invoice.js') }}"></script>
@endsection
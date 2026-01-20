@extends('layouts.frontend.app')

@section('title', 'New Registrations | List')

@section('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/pages/member-users.css') }}" />
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Users List Table -->
        <div class="card">
            <h5 class="card-header">Invoices for {{ $companyName }}</h5>
            <div class="card-datatable table-responsive">
              <table class="dt-responsive table" width="100%">
                <thead>
                  <tr>
                    <th></th>
                    <th>Invoice Date</th>
                    <th>Invoice No.</th>
                    <th>Company Name</th>
                    <th>Total ({{ config('currency.base_currency') }})</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th style="min-width: 400px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)

                    <tr>
                        <td></td>
                        <td>
                            {{ $invoice->order_created_at }}
                        </td>
                        <td>
                            {{ $invoice->order_no }}
                        </td>
                        <td>
                            {{ $invoice->memberComp->d_compname }} {{ ($invoice->memberComp->d_compssmno) }}
                        </td>
                        <td>
                            {{ number_format($invoice->order_grandtotal) }}
                        </td>
                        <td>
                            {{ $invoice->order_remarks }}
                        </td>
                        <td>
                            <span class="badge bg-label-{{$invoice->orderStatus->label}}">{{$invoice->orderStatus->status}}</span>
                        </td>
                        <td>
                            <a href="{{route('mm-userlists.invoice-view',['bid' => $invoice->oid])}}" target="_new" class="btn btn-info btn-xs"><i class="fa fa-eye me-1"></i> View</a> <br>
                            @if($invoice->order_status == 1)
                                <a href="javascript:void(0)" data-id={{$invoice->oid}} class="btn btn-warning btn-xs sendInvoice"><li class="fa fa-envelope me-1"></li> Invoice Email</a><br>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
    </div>
    <!-- / Content -->
@endsection

@section('page-js')
    <script>
        var sendInvoiceUrl = "{{ route('mm-userlists.invoice-send')}}";
    </script>
    <script src="{{ addPageJsLink('member-invoices.js?v=' . assetVersion() . time()) }}"></script>
@endsection

@extends('layouts.app')

@section('title', 'Branch Annual Report')

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

                    <li class="breadcrumb-item active">Branch Annual Report</li>

                </ol>
            </nav>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">List of Branch Annual Report</h5>
            </div>

            <div class="row pt-4">
                @foreach($annualreports as $report)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body card-body-box box-annualreport">
                                <center>
                                <img class="img-fluid d-flex mb-3 rounded annualreportimage" src="{{ config('app.backendurl').'storage/'.str_replace('../','',$report->img_cover) }}">

                                <h5>{{ strtoupper($report->name) }}</h5>
                                <h4 class="fw-bolder">{{ $report->yr }}</h4>

                                <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$report->file_path) }}" target="_blank" class="btn btn-outline-primary waves-effect">View</a>
                                <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$report->file_path) }}" download class="btn btn-outline-primary waves-effect">Download</a>
                                </center>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection

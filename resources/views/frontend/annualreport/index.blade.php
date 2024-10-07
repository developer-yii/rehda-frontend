@extends('layouts.app')

@section('title', 'Annual Report')

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

                    <li class="breadcrumb-item active">Annual Report</li>

                </ol>
            </nav>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">List of Annual Report</h5>
            </div>

            <div class="row pt-4">
                @foreach($annualreports as $report)
                    <div class="col-md-6 col-lg-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <center>
                                <img class="img-fluid d-flex mb-4 rounded annualreportimage" src="{{ config('app.backendurl').'storage/'.str_replace('../','',$report->ar_img_cover) }}">

                                <h5>{{ strtoupper($report->ar_name) }}</h5>
                                <h4>{{ $report->ar_yr }}</h4>

                                <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$report->ar_file_path) }}" target="_blank" class="btn btn-outline-primary waves-effect">View</a>
                                <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$report->ar_file_path) }}" download class="btn btn-outline-primary waves-effect">Download</a>
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

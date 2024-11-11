@extends('layouts.app')

@section('title', 'Bulletin')

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

                    <li class="breadcrumb-item active">Bulletin</li>

                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">List of Bulletin</h5>
            </div>
            <div class="card-body pt-4">
            <div class="accordion accordion-flush accordion-arrow-left" id="accordionYearParent">
            @php
            $years = $bulletins->groupBy('bu_yr')->sortByDesc(function ($group, $key) {
                return $key;
            });
            $count = 0;
            @endphp

            @foreach($years as $key => $year)
                @php
                $firstKey = $year->keys()->first();
                $count++;

                @endphp
                <!-- <div class="accordion accordion-flush accordion-arrow-left" id="year"> -->
                    <div class="accordion-item border-bottom {{ $count < 2 ? 'active' : '' }}">
                        <div class="accordion-header d-flex justify-content-between align-items-center flex-wrap flex-sm-nowrap" id="yearid{{$year[$firstKey]->bu_yr}}">
                            <a class="accordion-button accordion-button-removearrow {{ $count < 2 ? 'collapsed' : '' }}" data-bs-toggle="collapse" data-bs-target="#target{{$year[$firstKey]->bu_yr}}" aria-expanded="false" aria-controls="yearid{{$year[$firstKey]->bu_yr}}" role="button">
                                <span>
                                    <span class="d-flex gap-2 align-items-baseline ms-3">
                                        <span class="h4 mb-1 text-white">{{ $year[$firstKey]->bu_yr }}</span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div id="target{{$year[$firstKey]->bu_yr}}" class="accordion-collapse collapse {{ $count < 2 ? 'show' : '' }}" data-bs-parent="#accordionYearParent">

                            <div class="row pt-2">
                                <h4 class="fw-bolder">BULLETIN {{$year[$firstKey]->bu_yr }}</h4>
                                @foreach($year as $yeardata)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body card-body-box">
                                            <center>
                                            <img class="img-fluid d-flex mb-3 rounded bulletinimage" src="{{ config('app.backendurl').'storage/'.str_replace('../','',$yeardata->bu_img_cover) }}">

                                            <h5>{{ strtoupper($yeardata->bu_name) }}</h5>
                                            <h4 class="fw-bolder">{{ $yeardata->bu_yr }}</h4>

                                            <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$yeardata->bu_file_path) }}" target="_blank" class="btn btn-outline-primary waves-effect">View</a>
                                            <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$yeardata->bu_file_path) }}" target="_blank" download class="btn btn-outline-primary waves-effect">Download</a>
                                            </center>
                                        </div>
                                    </div>

                                    <!-- <div class="card h-100">
                                        <img class="card-img-top" src="{{ $yeardata->bu_img_cover }}">
                                        <div class="card-body">
                                            <a href="{{ $yeardata->bu_file_path }}" target="_blank" class="btn btn-outline-primary waves-effect">View</a>
                                        </div>
                                    </div> -->
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                <!-- </div> -->
            @endforeach
            </div>
            </div>
        </div>
    </div>
</div>

@endsection

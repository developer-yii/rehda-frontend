@extends('layouts.app')

@section('title', 'Branch Newsletter')

@section('css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('choosecompant.index') }}">Back</a>
                </li>

                <li class="breadcrumb-item active">Branch Newsletter</li>

            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Branch Newsletter</h5>
        </div>

        <div class="card-body pt-4">
            @if(count($newsletters) == 0)
            <p class="mt-3 mb-0">Stay tune for more content...</p>
            @else
            <div class="accordion accordion-flush accordion-arrow-left" id="accordionYearParent">
                @php
                $years = $newsletters->groupBy('bu_yr')->sortByDesc(function ($group, $key) {
                    return $key;
                });
                $count = 0;

                $datacount = 0;
                @endphp

                @foreach($years as $key => $year)
                    @php
                    $firstKey = $year->keys()->first();
                    $count++;

                    //$year[$firstKey]->bu_yr = str_replace('/','-',$year[$firstKey]->bu_yr);
                    $ctype = 'newsletter';

                    $memberComp = App\Models\MemberComp::with('member')->where('did', session('compid'))->first();
                    $member = $memberComp->member;

                    $newslettersData = App\Models\Newsletter::where('bu_status', 2)
                    ->where('bu_yr', $year[$firstKey]->bu_yr)
                    ->orderBy('bu_sorting', 'asc')
                    ->get();

                    $year[$firstKey]->bu_yr = str_replace('/','-',$year[$firstKey]->bu_yr);
                    @endphp

                    @if(count($newslettersData) != 0)

                    @php $datacount++; @endphp

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

                            <div class="row pt-4">

                                <h2>Newsletter {{$year[$firstKey]->bu_yr}}</h2>
                                @if(count($newslettersData) == 0)
                                <p>Stay tune for more content...</p>
                                @else
                                @foreach($newslettersData as $data)

                                    <div class="col-md-6 col-lg-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body card-body-box">
                                                <center>
                                                <img class="img-fluid d-flex mb-3 rounded bulletinimage" src="{{ config('app.backendurl').'storage/'.str_replace('../','',$data->bu_img_cover) }}">

                                                <h5>{{ strtoupper($data->bu_name) }}</h5>
                                                <h4 class="fw-bolder">{{ $data->bu_yr }}</h4>

                                                <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$data->bu_file_path) }}" target="_blank" class="btn btn-outline-primary waves-effect">View</a>
                                                <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$data->bu_file_path) }}" target="_blank" download class="btn btn-outline-primary waves-effect">Download</a>
                                                </center>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                @endif
                            </div>


                        </div>

                    </div>

                    @endif

                @endforeach

                @if($datacount == 0)
                    <p>Stay tune for more content...</p>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
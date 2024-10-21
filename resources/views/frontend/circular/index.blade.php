@extends('layouts.app')

@section('title', 'Circular')

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

                <li class="breadcrumb-item active">Circular</li>

            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Circular</h5>
        </div>
        <div class="card-body">
            @if(count($circulers) == 0)
            <p class="mt-3 mb-0">Stay tune for more content...</p>
            @else
            <div class="accordion accordion-flush accordion-arrow-left mt-4" id="accordionYearParent">

                @php

                $circulers->map(function($circuler) {
                    $circuler->year = \Carbon\Carbon::parse($circuler->ar_date)->year;
                    return $circuler;
                });

                $years = $circulers->groupBy('year')->sortByDesc(function ($group, $key) {
                    return $key;
                });


                $count = 0;
                @endphp

                @foreach($years as $key => $year)

                    @php
                    $firstKey = $year->keys()->first();
                    $count++;
                    @endphp

                    <div class="accordion-item border-bottom {{ $count < 2 ? 'active' : '' }}">
                        <div class="accordion-header d-flex justify-content-between align-items-center flex-wrap flex-sm-nowrap" id="yearid{{$year[$firstKey]->ar_id}}">
                            <a class="accordion-button accordion-button-removearrow {{ $count < 2 ? 'collapsed' : '' }}" data-bs-toggle="collapse" data-bs-target="#target{{$year[$firstKey]->ar_id}}" aria-expanded="false" aria-controls="yearid{{$year[$firstKey]->ar_id}}" role="button">
                                <span>
                                    <span class="d-flex gap-2 align-items-baseline ms-3">
                                        <span class="h4 mb-1 text-white">{{ date('Y', strtotime($year[$firstKey]->ar_date)) }}</span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div id="target{{$year[$firstKey]->ar_id}}" class="p-3 accordion-collapse collapse {{ $count < 2 ? 'show' : '' }}" data-bs-parent="#accordionYearParent">

                            <!-- <div class="row pt-4"> -->
                                <table class="mt-3 table dataTable border">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($year as $key => $data)
                                    <tr>
                                        <td width="80%">
                                            <div>
                                                <h3>({{ date('d F Y', strtotime($data->ar_date)) }}) {{ $data->ar_name }}</h3>
                                                <p>{{ $data->ar_yr }}</p>
                                            </div>
                                        </td>
                                        <td width="20%" class="displaytext-vertical">
                                            <div>
                                                <ul class="ps-0">
                                                    <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$data->ar_file_path) }}" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1"><li class="list-unstyled">View</li></a>
                                                    <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$data->ar_file_path) }}" target="_blank" download class="btn btn-outline-primary waves-effect me-2 mb-1"><li class="list-unstyled">Download</li></a>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            <!-- </div> -->
                        </div>

                    </div>

                @endforeach

            </div>
            @endif
        </div>
    </div>

</div>
@endsection
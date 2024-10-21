@extends('layouts.app')

@section('title', 'Others')

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

                <li class="breadcrumb-item active">Others</li>

            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Others</h5>
        </div>

        <div class="card-body pt-4">
            @if(count($papers) == 0)
                <p class="mb-0">Stay tune for more content...</p>
            @else
                @foreach($papers as $paper)
                    <div class="col-md-6 col-lg-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body card-body-box box-others">
                                <center>
                                <img class="img-fluid d-flex mb-3 rounded othersimage" src="{{ config('app.backendurl').'storage/'.str_replace('../','',$paper->ar_img_cover) }}">

                                <h5>{{ strtoupper($paper->ar_name) }}</h5>
                                <h4 class="fw-bolder">{{ $paper->ar_yr }}</h4>

                                <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$paper->ar_file_path) }}" target="_blank" class="btn btn-outline-primary waves-effect">View</a>
                                <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$paper->ar_file_path) }}" target="_blank" download class="btn btn-outline-primary waves-effect">Download</a>
                                </center>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
</div>
@endsection
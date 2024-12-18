@extends('layouts.app')

@section('title', 'Branch Contact Details')

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

                <li class="breadcrumb-item active">Branch Contact Details</li>

            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Branch Contact Details</h5>
        </div>

        <div class="card-body pt-4" id="branch-contact-details-card">

            @if($branches->count() > 0)

            <h4>Branches</h4>

            <div class="accordion accordion-flush accordion-arrow-left mt-4" id="accordionYearParent">
                @foreach($branches as $key => $branch)
                    <div class="accordion-item border-bottom">
                        <div class="accordion-header d-flex justify-content-between align-items-center flex-wrap flex-sm-nowrap" id="branchid{{$branch->bid}}">
                            <a class="accordion-button accordion-button-removearrow" data-bs-toggle="collapse" data-bs-target="#target{{$branch->bid}}" aria-expanded="false" aria-controls="branchid{{$branch->bid}}" role="button">
                                <span>
                                    <span class="d-flex gap-2 align-items-baseline ms-3">
                                        <span class="h5 mb-0 text-white">{{ $branch->new_name }}</span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div id="target{{$branch->bid}}" class="p-3 accordion-collapse collapse" data-bs-parent="#accordionYearParent">
                            <p>{!! $branch->address !!}</p>
                            @if($branch->telefon_no)
                            <p>T : {{ $branch->telefon_no }}</p>
                            @endif
                            @if($branch->fax_no)
                            <p>F : {{ $branch->fax_no }}</p>
                            @endif
                            @if($branch->email)
                            <p>E : {{ $branch->email }}</p>
                            @endif
                            @if($branch->site_url)
                            <p>W : <a href="{{ $branch->site_url }}" target="_blank">{{ $branch->site_url }}</a></p>
                            @endif
                            <p>
                                <i>
                                    Operating Hours :
                                    <br>
                                    @if($branch->opening_time && $branch->closing_time)
                                        {{ date('h:i A', strtotime($branch->opening_time)) }} - {{ date('h:i A', strtotime($branch->closing_time)) }}
                                    @endif
                                    @if($branch->days)
                                        ({{ $branch->days }})
                                    @endif
                                </i>
                            </p>

                        </div>

                    </div>
                @endforeach
            </div>

            @endif

        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('title', 'Circulars | List')

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

                    <li class="breadcrumb-item active">Membership Certificate</li>

                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">List of Membership Certificate</h5>
            </div>
            <div class="card-body pt-4">

            </div>
        </div>

</div>

@endsection
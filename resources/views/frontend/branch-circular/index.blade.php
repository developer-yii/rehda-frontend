@extends('layouts.app')

@section('title', 'Branch Circular')

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

                <li class="breadcrumb-item active">Branch Circular</li>

            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Branch Circular</h5>
        </div>

        @if(count($notices) == 0)
            <div class="card-body pt-4">
                <p class="mb-0">Stay tune for more content...</p>
            </div>
        @else

            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="branchCircularTable">
                    <thead class="border-top">
                        <tr>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        @endif
    </div>
</div>
@endsection

@section('page-js')
<script>
        var getBranchCircular = "{{ route('branch-circular.index') }}";
</script>
<script src="{{ asset('frontend/js/pages/branch-circular.js') }}"></script>
@endsection
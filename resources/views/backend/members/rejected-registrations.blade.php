@extends('layouts.app')

@section('title', 'New Registrations | List')

@section('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/pages/new-registrations.css') }}" />
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Members</a>
                    </li>
                    <li class="breadcrumb-item active">Rejected Registrations</li>
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">Rejected Registrations</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="registrations">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th>Reg Date</th>
                            <th>Member Type</th>
                            <th>Company Name</th>
                            <th>Parent Company Membership No.</th>
                            <th>Date Formation</th>
                            <th>Details</th>
                            <th>Paid-Up Capital ({{ config('currency.base_currency') }})</th>
                            <th>Supporting Docs</th>
                            <th>Remarks (For office use)</th>
                            <th width="3%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('page-js')
    <script>
        var getRejectedRegistrations = "{{ route('mm-registration-reject.index') }}";
        var approveBranchUrl = "{{  route('members.branch.approve')}}";
        var getMemberBranch = "{{ route('members.branch.getSingle') }}";
        var memberReject = "{{ route('members.reject') }}";

        var getSingleUser = "{{ route('user.getSingleUser') }}/";
        var createUser = "{{ route('user.createUser') }}";
        var deleteUser = "{{ route('user.deleteUser') }}";
        var basepath = "{{ asset('storage/user_image') }}/";
        var defaultimg = "{{ asset('backend/assets/img/default-image.png') }}/";
    </script>

    <script src="{{ addPageJsLink('member-rejectedRegistrations.js?v=' . assetVersion() . time()) }}"></script>
@endsection

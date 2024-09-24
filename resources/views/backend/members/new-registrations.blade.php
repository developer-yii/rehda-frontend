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
                    <li class="breadcrumb-item active">New Registrations</li>
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">New Registrations</h5>
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

    <!-- Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Approve</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" name="approveForm" id="approveForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="oid" name="oid" value="" required="" readonly="">
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label">Preferred Branch</label>
                            <div class="col-sm-10">
                                <input id="branch" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="branchid">Branch</label>
                            <div class="col-sm-10">
                                <select id="branchid" name="branchid" class="form-control">
                                    <option value="" selected>Select Branch</option>
                                    @foreach ($branches as $branchId => $branchName)
                                        <option value="{{ $branchId }}">
                                            {{ $branchName }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script>
        var getNewRegistrations = "{{ route('members.newRegistration') }}";
        var approveBranchUrl = "{{  route('members.branch.approve')}}";
        var getMemberBranch = "{{ route('members.branch.getSingle') }}";
        var memberReject = "{{ route('members.reject') }}";

        var getSingleUser = "{{ route('user.getSingleUser') }}/";
        var createUser = "{{ route('user.createUser') }}";
        var deleteUser = "{{ route('user.deleteUser') }}";
        var basepath = "{{ asset('storage/user_image') }}/";
        var defaultimg = "{{ asset('backend/assets/img/default-image.png') }}/";
    </script>

    <script src="{{ addPageJsLink('member-newRegistrations.js?v=' . assetVersion() . time()) }}"></script>
@endsection

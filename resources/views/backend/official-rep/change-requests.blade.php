@extends('layouts.app')

@section('title', 'Affiliate Users | List')

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('backend/assets/css/pages/offrep-change-req.css') }}" /> --}}
    @endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Request Change of Official Representative</a>
                    </li>
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">List of Requests</h5>
            </div>
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-12">
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="registrations">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th>Requested Date</th>
                            <th>Company Name</th>
                            <th>Membership No.</th>
                            <th>Membership Type</th>
                            <th>New Name</th>
                            <th>New MyKad No.</th>
                            <th>Current Name</th>
                            <th>Current MyKad No.</th>
                            <th>Status</th>
                            <th width="3%">Action</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Modal -->
    <div class="modal fade" id="passwordChangeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordChangeModalLabel">Change Password Member User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" name="passwordChangeForm" id="passwordChangeForm">
                        @csrf
                        <input type="hidden" id="mid" name="mid" value="" readonly="">
                        <div class="row g-3">
                            <div class="mb-3">
                                <label class="form-label" for="username">Username<span class="required">*</span></label>
                                <input type="text" id="username" name="username" required="required" class="form-control" readonly>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3">
                                <label class="form-label" for="password">Password<span class="required">*</span></label>
                                <input type="password" id="password" name="password" required="required" class="form-control" placeholder="Min. 6 chars with upper & lower case & number">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Re-type Password<span class="required">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required="required" class="form-control" placeholder="Min. 6 chars with upper & lower case & number">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Change Password</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script>
        var getChangeRequest = "{{route('official-rep.change.requests')}}";
        var approveChangeRequest = "{{route('official-rep.change.approve')}}";
        var rejectChangeRequest = "{{route('official-rep.change.reject')}}";

    </script>

    <script src="{{ addPageJsLink('change-offrep-requests.js?v=' . assetVersion() . time()) }}"></script>
@endsection
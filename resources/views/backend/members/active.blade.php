@extends('layouts.app')

@section('title', 'New Registrations | List')

@section('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/pages/active-members.css') }}" />
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
                    <li class="breadcrumb-item active">Active Members</li>
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">Active Members</h5>
            </div>
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-lg-4">
                                <label class="form-label">Branch:</label>
                                <select class="form-select dt-input" data-column="1" data-column-index="0"
                                    id="branch-filter">
                                    <option value="">All</option>
                                    @foreach ($branches as $branchId => $branchName)
                                        <option value="{{ $branchName }}">
                                            {{ $branchName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4">
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4">
                                {{-- <label class="form-label">Search:</label>
                                <input type="text" class="form-control dt-input" data-column="3" placeholder="Search"
                                    data-column-index="2" id="searchFilter"/> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="registrations">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th>Approved Date</th>
                            <th>Member Type</th>
                            <th>Company Name</th>
                            <th>Branch</th>
                            <th>Membership No.</th>
                            <th>Parent Membership No.</th>
                            <th>Details</th>
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
    <div class="modal fade" id="uploadCertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadCertModalLabel1">Membership Certificates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 pb-3">
                        <div class="col-sm-12">
                            <small class="text-light fw-medium">Membership Certificates</small>
                            <div class="demo-inline-spacing mt-3">
                                <ul class="list-group" id="certificates">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <form method="post" name="uploadCertForm" id="uploadCertForm">
                        @csrf
                        <input type="hidden" id="pid" name="pid" value="" required="" readonly="">
                        <div class="row g-3">
                            <div class="mb-3">
                                <label class="form-label">Membership Certificate (PDF)<span class="required">*</span></label>
                                <input type="file" id="fileimg" name="fileimg" required="required" class="form-control" accept=".pdf">
                                <div class="form-text text-danger">Max file size: {{config('constant.MAX_PDF_FILESIZE_MB')}}MB per file.</div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3">
                                <label class="form-label" for="certyr">Select Year<span class="required">*</span></label>
                                <select id="certyr" name="certyr" class="form-control">
                                    @for ($i = 2017; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}"
                                            @if ($i == date('Y')) selected @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-upload me-1"></i>Upload Cert</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Statement Modal -->
    <div class="modal fade" id="statementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statementModalLabel1">Statement of Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body-content">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="changeMembershipModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeMembershipModalLabel1">Change Membership No.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" name="changeMembershipForm" id="changeMembershipForm">
                        @csrf
                        <input type="hidden" id="memberId" name="member_id" value="" readonly="">
                        <div class="row g-3">
                            <div class="mb-3">
                                <label class="form-label">Current Membership No.</label>
                                <input type="text" id="curr" name="curr" required="required" class="form-control" disabled>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <label class="form-label">New Membership No.<span class="required">*</span></label>
                        </div>
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-sm-1">
                                <span>{{ config('constant.MNP1')}}</span>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="m_no_p2" id="m_no_p2" class="form-control" placeholder="Part 2" maxlength="4" required>
                            </div>
                            <div class="col-sm-2 text-center">
                                <span id="m_no_p3"></span>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="m_no_p4" id="m_no_p4" class="form-control" placeholder="Part 4" maxlength="6" required>
                            </div>
                            <div class="col-sm-1 text-center">
                                <span>{{ config('constant.MNP2')}}</span>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" name="m_no_p5" id="m_no_p5" class="form-control" placeholder="Part 5" maxlength="4" required>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save me-1"></i>Save</button>
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
        var getActiveMembers = "{{ route('active-members.index') }}";
        var getMemberCertificates = "{{ route('active-members.uploadcert.show') }}";
        var deleteCert = "{{ route('active-members.uploadcert.delete')}}";
        var uploadCertificate = "{{ route('active-members.uploadcert.update')}}";
        var getStatementOfAccUrl =  "{{ route('active-members.getStatementOfAccount')}}";
        var getMemberShipDetails = "{{ route('active-members.getMembershipNoDetail')}}";
        var updateMemberShipNoUrl = "{{ route('active-members.updateMembershipNo')}}";
    </script>

    <script src="{{ addPageJsLink('active-members.js?v=' . assetVersion() . time()) }}"></script>
@endsection

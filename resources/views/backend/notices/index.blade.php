@extends('layouts.app')

@section('title', 'Branch Circulars | List')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @can('dashboard-view')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">{{ __('translation.label_dashboard') }}</a>
                        </li>
                    @endcan
                    @can('circulars-view')
                        <li class="breadcrumb-item active">Branch Circulars</li>
                    @endcan
                </ol>
            </nav>
        </div>
        <!-- Circulars List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">Branch Circulars</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="noticeTable">
                    <thead class="border-top">
                        <tr>
                            <th>Branch Circular Date</th>
                            <th>Branch Circular Title</th>
                            <th>Level</th>
                            <th>Branch</th>
                            <th>Status</th>
                            @canany(['circulars-edit', 'circulars-delete'])
                                <th>{{ __('translation.label_actions') }}</th>
                            @else
                                <th></th>
                            @endcan
                        </tr>
                    </thead>
                </table>
            </div>


        </div>
    </div>
    <!-- / Content -->

    {{-- Modal --}}
    <div class="modal fade" id="noticeMembershipPermissionModal" tabindex="-1" aira-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Membership Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="notice-membership-permission-body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveNoticeMembershipPermission" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

     {{-- Modal --}}
     <div class="modal fade" id="noticeBranchPermissionModal" tabindex="-1" aira-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Branch Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="notice-branch-permission-body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="savenoticeBranchPermission" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script>
        var getNotice = "{{ route('notices.index') }}";
        var deleteNotice = "{{ route('notices.delete') }}";
        var membership = "{{ route('notices.membership') }}";
        var membershipPermissionDelete = "{{ route('notices.membership.permision.delete') }}";
        var membershipPermissionStore = "{{ route('notices.membership.permision.store') }}";
        var branch = "{{ route('notices.branch') }}";
        var branchPermissionDelete = "{{ route('notices.branch.permision.delete') }}";
        var branchPermissionStore = "{{ route('notices.branch.permision.store') }}";
    </script>

    <script src="{{ addPageJsLink('notice-list.js?v=' . assetVersion() . time()) }}"></script>
@endsection

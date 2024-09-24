@extends('layouts.app')

@section('title', 'Circulars | List')

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
                        <li class="breadcrumb-item active">Circulars</li>
                    @endcan
                </ol>
            </nav>
        </div>
        <!-- Circulars List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">List of Circulars</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="circularTable">
                    <thead class="border-top">
                        <tr>
                            <th>Circular Date</th>
                            <th>Circular Title</th>
                            <th>Description</th>
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
    <div class="modal fade" id="circularMembershipPermissionModal" tabindex="-1" aira-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Membership Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="circular-membership-permission-body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveCircularMembershipPermission" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="circularBranchPermissionModal" tabindex="-1" aira-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Branch Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="circular-branch-permission-body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveBranchPermission" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        var getCircular = "{{ route('circulars.index') }}";
        var deleteCircular = "{{ route('circulars.delete') }}";
        var membership = "{{ route('circulars.membership') }}";
        var membershipPermissionDelete = "{{ route('circulars.membership.permision.delete') }}";
        var membershipPermissionStore = "{{ route('circulars.membership.permision.store') }}";
        var branch = "{{ route('circulars.branch') }}";
        var branchPermissionDelete = "{{ route('circulars.branch.permision.delete') }}";
        var branchPermissionStore = "{{ route('circulars.branch.permision.store') }}";
    </script>

    <script src="{{ addPageJsLink('circular-list.js?v=' . assetVersion() . time()) }}"></script>
@endsection

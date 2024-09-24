@extends('layouts.app')

@section('title', 'Branch Newsletter | List')

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
                    @can('newsletter-view')
                        <li class="breadcrumb-item active">Branch Newsletters</li>
                    @endcan
                </ol>
            </nav>
        </div>
        <!-- Newsletter List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">Branch Newsletters</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="newsletters">
                    <thead class="border-top">
                        <tr>
                            <th>Newsletter</th>
                            <th>Level</th>
                            <th>Branch</th>
                            <th>Status</th>
                            {{-- <th>Permission</th> --}}
                            @canany(['newsletter-edit', 'newsletter-delete'])
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
    <div class="modal fade" id="membershipPermissionModal" tabindex="-1" aira-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Membership Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="membership-permission-body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveMembershipPermission" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>


      {{-- Modal --}}
      <div class="modal fade" id="newsletterBranchPermissionModal" tabindex="-1" aira-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Branch Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="newsletter-branch-permission-body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="savenewsletterBranchPermission" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script>
        var getNewSletters = "{{ route('newsletters.index') }}";
        var deleteNewSletter = "{{ route('newsletters.delete') }}";
        var membership = "{{ route('newsletters.membership') }}";
        var membershipPermissionDelete = "{{ route('newsletters.membership.permision.delete') }}";
        var membershipPermissionStore = "{{ route('newsletters.membership.permision.store') }}";
        var branch = "{{ route('newsletters.branch') }}";
        var branchPermissionDelete = "{{ route('newsletters.branch.permision.delete') }}";
        var branchPermissionStore = "{{ route('newsletters.branch.permision.store') }}";
    </script>

    <script src="{{ addPageJsLink('newsletter-list.js?v=' . assetVersion() . time()) }}"></script>
@endsection

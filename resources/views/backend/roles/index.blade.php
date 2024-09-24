@extends('layouts.app')

@section('title', 'Role | List')

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
                    @can('role-view')
                        <li class="breadcrumb-item active">{{ __('translation.label_roles') }}</li>
                    @endcan
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">{{ __('translation.label_roles') }}</h5>
                <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                    <div class="col-md-4 user_role"></div>
                    <div class="col-md-4 user_plan"></div>
                    <div class="col-md-4 user_status"></div>
                </div>
                @can('role-create')
                    <div class="btn-add-user add-customer">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">{{ __('translation.label_add_new_role') }}</a>
                    </div>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="roles">
                    <thead class="border-top">
                        <tr>
                            <th>{{ __('translation.label_name') }}</th>
                            {{-- <th>Permission</th> --}}
                            @canany(['role-update', 'role-delete'])
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

@endsection

@section('page-js')
    <script>
        var getRoles = "{{ route('roles.index') }}";
        var deleteRole = "{{ route('roles.delete') }}";
    </script>

    <script src="{{ addPageJsLink('roles.js?v=' . assetVersion() . time()) }}"></script>
@endsection

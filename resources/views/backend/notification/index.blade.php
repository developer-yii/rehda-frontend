@extends('layouts.app')

@section('title', 'All | Notification')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">{{ __('translation.label_view_notification') }}</h5>
                <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                    <div class="col-md-4 user_role"></div>
                    <div class="col-md-4 user_plan"></div>
                    <div class="col-md-4 user_status"></div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="notification">
                    <thead class="border-top">
                        <tr>
                            <th>{{ __('translation.label_body') }}</th>
                            <th>{{ __('translation.label_created_at') }}</th>
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
        var getNotifications = "{{ route('notification.index') }}";
    </script>

    <script src="{{ addPageJsLink('notification.js?v=' . assetVersion() . time()) }}"></script>
@endsection

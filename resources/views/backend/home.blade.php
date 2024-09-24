@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
    </div>
@endsection
@section('page-js')
    <script>
        flatpickr("#start_date", {
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                flatpickr("#end_date", {
                    minDate: dateStr,
                    dateFormat: "Y-m-d",
                });
            }
        });

        flatpickr("#end_date", {
            dateFormat: "Y-m-d",
        });
        var csrf_token = "{{ csrf_token() }}";
        var label_request_status = "{{ __('translation.label_request_status') }}";
        var label_filter_error = "{{ __('translation.label_filter_error') }}";
        var url_for_total = "{{ url('/') }}" + "/dashboard/new_order_total/";
        var url_for_update_total = "{{ url('/') }}" + "/dashboard/read_record/";
        var label_new = "{{ __('translation.label_new') }}";
        var label_select_therapist = "{{ __('translation.label_select_therapist') }}";
    </script>

    <script src="{{ addPageJsLink('dashboard.js?v=' . assetVersion() . time()) }}"></script>

@endsection

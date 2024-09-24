
<!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js?v='.assetVersion().time()) }}"></script>
    
    <script src="{{ asset('assets/vendor/js/menu.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js?v='.assetVersion().time()) }}"></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js?v='.assetVersion().time()) }}"></script>
    <!-- Main JS -->
    {{-- <script src="{{ asset('assets/js/front-main.js?v='.assetVersion().time()) }}"></script> --}}
    <script src="{{ asset('assets/js/custom.js?v='.assetVersion().time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js?v='.assetVersion().time()) }}"></script>
    @if (Session::has('status'))
    <script type="text/javascript">
        showToastMessage("success", "{{ Session::get('status') }}");
    </script>
    @php Session::forget('status') @endphp
    @endif
    @if (Session::has('success'))
        <script type="text/javascript">
            showToastMessage("success", "{{ Session::get('success') }}");
        </script>
        @php Session::forget('success') @endphp
    @endif
    @if (Session::has('error'))
        <script type="text/javascript">
            showToastMessage("error", "{{ Session::get('error') }}");
        </script>
        @php Session::forget('error') @endphp
    @endif
    @if (Session::has('warning'))
        <script type="text/javascript">
            showToastMessage("warning", "{{ Session::get('warning') }}");
        </script>
        @php Session::forget('warning') @endphp
    @endif
    
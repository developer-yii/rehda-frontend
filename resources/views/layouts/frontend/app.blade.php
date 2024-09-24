<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-wide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}/" data-template="front-pages">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title')</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ getFavicon() }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css?v=' . assetVersion() . time()) }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css?v=' . assetVersion() . time()) }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css?v=' . assetVersion() . time()) }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page.css?v=' . assetVersion() . time()) }}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/node-waves/node-waves.css?v=' . assetVersion() . time()) }}" />

    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/nouislider/nouislider.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css?v=' . assetVersion() . time()) }}" />

    <!-- Page CSS -->

    <link rel="stylesheet"
        href="{{ asset('assets/vendor/css/pages/front-page-help-center.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/fontawesome.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js?v=' . assetVersion() . time()) }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js?v=' . assetVersion() . time()) }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/front-config.js?v=' . assetVersion() . time()) }}"></script>
    <link href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css?v=' . assetVersion() . time()) }}" />
    @yield('css')
</head>

<body>
    <script src="{{ asset('assets/vendor/js/dropdown-hover.js?v=' . assetVersion() . time()) }}"></script>
    <script src="{{ asset('assets/vendor/js/mega-dropdown.js?v=' . assetVersion() . time()) }}"></script>

    {{-- @include('layouts.frontend.header') --}}

    <!-- Sections:Start -->

    @yield('content')
    <!-- / Sections:End -->

    @include('layouts.frontend.scriptJs')
    @yield('js')
    @yield('page-js')
</body>

</html>

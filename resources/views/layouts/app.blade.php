<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('backend/assets') }}/"
    data-template="vertical-menu-template-starter">

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

    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/fontawesome.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/rtl/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/node-waves/node-waves.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/typeahead-js/typeahead.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/fullcalendar/fullcalendar.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/pages/app-calendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/select2/select2.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/@form-validation/umd/styles/index.min.css?v=' . assetVersion() . time()) }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/sweetalert2/sweetalert2.css?v=' . assetVersion() . time()) }}" />
    <link href="{{ asset('backend/assets/vendor/libs/toastr/toastr.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/vendor/libs/colorpicker/colorpicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/custom.css?v=' . assetVersion()) }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>
    @yield('css')
    <!-- Helpers -->
    <script src="{{ asset('backend/assets/vendor/js/helpers.js?v=' . assetVersion() . time()) }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('backend/assets/vendor/js/template-customizer.js?v=' . assetVersion() . time()) }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('backend/assets/js/config.js?v=' . assetVersion() . time()) }}"></script>
    <script src="{{ asset('assets/vendor/libs/sortablejs/sortable.js') }}"></script>
</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.sidemenu')
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="ti ti-menu-2 ti-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="ti ti-md"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-start dropdown-styles">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                            <span class="align-middle"><i
                                                    class="ti ti-sun me-2"></i>{{ __('translation.label_light') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                            <span class="align-middle"><i
                                                    class="ti ti-moon me-2"></i>{{ __('translation.label_dark') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                            <span class="align-middle"><i
                                                    class="ti ti-device-desktop me-2"></i>{{ __('translation.label_system') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex-grow-1 ms-5">
                            <span class="fw-medium d-block">{{ Auth::user()->memberUserProfile->up_fullname }}</span>
                            <small class="text-muted">{{ Auth::user()->ml_priv }}</small>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <span class="fw-medium d-block">{{ getMembershipNobyMID(Auth::user()->memberUserProfile->up_mid) }}</span>
                            <small class="text-muted">Membership No.</small>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <span class="fw-medium d-block">{{ getMemberBranch(getMemberBid(getMemberDid(Auth::user()->memberUserProfile->up_mid))) }}</span>
                            <small class="text-muted">Branch</small>
                        </div>

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-language rounded-circle ti-md"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item @if (App::getLocale() == 'en') active @endif"
                                            href="{{ url('/lang/en') }}" data-text-direction="ltr">
                                            <span class="align-middle">{{ __('translation.label_english') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item @if (App::getLocale() == 'id') active @endif"
                                            href="{{ url('/lang/id') }}" data-text-direction="ltr">
                                            <span class="align-middle">{{ __('translation.label_indonesia') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @can('order-view')
                                <!-- Notification -->
                                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1" id="app-notification">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                        <i class="ti ti-bell ti-md"></i>
                                        <span class="badge bg-danger rounded-pill badge-notifications notification-count">0</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end py-0">
                                        <li class="dropdown-menu-header border-bottom">
                                            <div class="dropdown-header d-flex align-items-center py-3">
                                                <h5 class="text-body mb-0 me-auto">{{ __('translation.label_notification') }}</h5>
                                                <a href="javascript:void(0)" class="dropdown-notifications-all text-body mark-all-read"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('translation.label_mark_all_read') }}"><i class="ti ti-mail-opened fs-4"></i></a>
                                            </div>
                                        </li>
                                        <li class="dropdown-notifications-list scrollable-container notification-listing">

                                        </li>
                                        <li class="dropdown-menu-footer border-top">
                                            <a href="{{ route('notification.index') }}"
                                                class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                                                {{ __('translation.label_view_all_notification') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!--/ Notification -->
                            @endcan
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ Auth::user()->getImageUrl() }}" alt
                                            class="h-auto rounded-circle avatar-rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ Auth::user()->getImageUrl() }}" alt
                                                            class="h-auto rounded-circle avatar-rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-medium d-block">{{ Auth::user()->memberUserProfile->up_fullname }}</span>
                                                    <small
                                                        class="text-muted">{{ Auth::user()->ml_priv }}</small>

                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li> -->
                                        <!-- <a class="dropdown-item" href="{{ route('profile.editprofile', Auth::id()) }}"> -->
                                        <!-- <a class="dropdown-item" href="">
                                            <i class="ti ti-user-check me-2 ti-sm"></i>
                                            <span class="align-middle">{{ __('profile')['my profile'] }}</span>
                                        </a>
                                    </li> -->
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.logout') }}">
                                            <i class="ti ti-logout me-2 ti-sm"></i>
                                            <span class="align-middle">{{ __('translation.label_logout') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    @yield('content')
                    @include('layouts.footer')

                    <div class="content-backdrop fade"></div>
                    <audio id="audio" src="{{ asset('backend/assets/audio/notification-sound.mp3') }}"></audio>
                    <input type="hidden" id="audioTrigger" value="0">
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    @include('layouts.vendor-scriptJs')
    <script>
        var url = window.location;
        var getNotificationUrl = "{{ route('notification.getNotification') }}";
        $('ul.menu-sub a').filter(function() {
            if (this.href) {
                return this.href == url || url.href.indexOf(this.href) == 0;
            }
        }).parentsUntil(".menu-inner > .menu-sub").addClass('open').prev('a').addClass('active');
    </script>
    @yield('js')
    @yield('page-js')
</body>

</html>

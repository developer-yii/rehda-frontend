@extends('layouts.app')

@section('title', 'Setting | List')

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
                    @can('setting-view')
                        <li class="breadcrumb-item active">{{ __('translation.label_setting_configuration') }}</li>
                    @endcan
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ __('translation.label_setting') }}</h5>
            </div>
            <div class="card-body">
                <form method="post" id="updatesetting" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label required_label"
                            for="basic-default-name">{{ __('translation.label_app_name') }}:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control app_name" id="app_name" name="app_name"
                                value="{{ $settings['app_name'] }}"
                                placeholder="{{ __('translation.placeholder_enter_app_name') }}">
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label required_label"
                            for="basic-default-company">{{ __('translation.label_app_description') }}:</label>
                        <div class="col-sm-10">
                            <textarea type="text" rows="6" class="form-control app_description" name="app_description"
                                id="app_description" placeholder="{{ __('translation.placeholder_enter_app_description') }}">{{ $settings['app_description'] }}</textarea>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label required_label"
                            for="basic-default-email">{{ __('translation.label_smtp_host') }}:</label>
                        <div class="col-sm-10">
                            <input type="text" id="smtp_host" class="form-control smtp_host"
                                placeholder="{{ __('translation.placeholder_enter_smtp_host') }}" name="smtp_host"
                                value="{{ $settings['smtp_host'] }}" aria-describedby="basic-default-email2">
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label required_label"
                            for="basic-default-phone">{{ __('translation.label_smtp_port') }}:</label>
                        <div class="col-sm-10">
                            <input type="text" id="smtp_port" name="smtp_port" value="{{ $settings['smtp_port'] }}"
                                class="form-control smtp_port" placeholder="658 799 8941"
                                aria-describedby="basic-default-phone">
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label required_label"
                            for="basic-default-message">{{ __('translation.label_smtp_user') }}:</label>
                        <div class="col-sm-10">
                            <input id="smtp_user" type="text" class="form-control smtp_user" name="smtp_user"
                                value="{{ $settings['smtp_user'] }}"
                                placeholder="{{ __('translation.placeholder_enter_user_detail') }}"
                                aria-describedby="basic-icon-default-message2" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label required_label"
                            for="basic-default-message">{{ __('translation.label_smtp_password') }}:</label>
                        <div class="col-sm-10">
                            <input id="smtp_password" type="password" class="form-control smtp_user" name="smtp_password"
                                placeholder="{{ __('translation.enter_smtp_password') }}"
                                value="{{ $settings['smtp_password'] }}" aria-describedby="basic-icon-default-message2" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label required_label"
                            for="basic-default-message">{{ __('translation.label_login_page_title') }}:</label>
                        <div class="col-sm-10">
                            <input id="login_page_title" type="text" class="form-control login_page_title"
                                name="login_page_title" value="{{ @$settings['login_page_title'] }}"
                                placeholder="{{ __('translation.placeholder_enter_login_page_title') }}"
                                aria-describedby="basic-icon-default-message2" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"
                            for="basic-default-message">{{ __('translation.label_login_cover_image') }}:</label>

                        <div class="button-wrapper col-sm-10">
                                <img src="{{ (@$settings['login_cover_image']) ? asset('storage/backend/assets/img/login-cover-image/' . @$settings['login_cover_image']) : asset('backend/assets/img/default-image.webp') }}"
                                    alt="cover-image" class="d-block rounded mb-2" width="105" id="uploadedCoverImage"/>
                            <label for="login_cover_image" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span
                                    class="d-none d-sm-block">{{ __('translation.label_upload_new_cover_image') }}</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" id="login_cover_image" class="login-cover-image-input" hidden
                                    name="login_cover_image" accept=".jpg, .jpeg, .png, .gif"/>
                            </label>
                            <span class="error"></span>
                            <div class="text-muted">{{ __('translation.txt_allowed_dimension_of_cover_image') }}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"
                            for="basic-default-message">{{ __('translation.label_background_type') }}:</label>
                        <div class="col-sm-10">
                            <div class="col mt-2">
                                <div class="form-check form-check-inline">
                                    <input name="background_type" class="form-check-input background_type" type="radio"
                                        value="0" id="background_type_color" {{ @$settings['background_type'] == 0 ? "checked" : ''}} />
                                    <label class="form-check-label"
                                        for="background_type_color">{{ __('translation.label_color') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="background_type" class="form-check-input background_type" type="radio"
                                        value="1" id="background_type_image" {{ @$settings['background_type'] == 1 ? "checked" : ''}}/>
                                    <label class="form-check-label" for="background_type_image">
                                        {{ __('translation.label_image') }}
                                    </label>
                                </div>
                            </div>
                            <div class="row background-image @if(@$settings['background_type'] == 0 || !isset($settings['background_type'])) d-none @endif mt-4">
                                <div class="col">
                                        <img src="{{ (@$settings['login_background_image']) ? asset('storage/backend/assets/img/login-background-image/' . @$settings['login_background_image']) : asset('backend/assets/img/default-image.webp') }}"
                                            alt="background-image" class="d-block rounded mb-2" width="105"
                                            id="uploadedBackgroundImage" />
                                    <label for="login_background_image" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span
                                            class="d-none d-sm-block">{{ __('translation.label_upload_new_background_image') }}</span>
                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                        <input type="file" id="login_background_image" class="login-background-image-input"
                                            hidden name="login_background_image" accept=".jpg, .jpeg, .png, .gif"/>
                                    </label>
                                    <span class="error"></span>
                                    <div class="text-muted">{{ __('translation.txt_allowed_dimension_of_background_image') }}</div>
                                </div>
                            </div>
                            <div class="row background-color @if(@$settings['background_type'] == 1) d-none @endif mt-4">
                                <div class="col">
                                    <input id="background_color" type="text" class="form-control background_color w-25"
                                        name="background_color" value="{{ @$settings['background_color'] }}"
                                        placeholder="{{ __('translation.placeholder_enter_background_color') }}"
                                        aria-describedby="basic-icon-default-message2" />
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-message">{{ __('translation.label_logo') }}:</label>

                        <div class="button-wrapper col-sm-10">
                            @php
                                $logoPath = 'storage/backend/assets/img/logo/' . $settings['logo'];
                            @endphp

                            @if(file_exists(public_path($logoPath)))
                                <img src="{{ asset($logoPath) }}" alt="app-logo" class="d-block rounded mb-2" width="105px" id="uploadedImage" />
                            @endif

                            <label for="logo" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">{{ __('translation.label_upload_new_logo') }}</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" id="logo" class="account-file-input" hidden name="logo" accept=".jpg, .jpeg, .png, .gif"/>
                            </label>
                            <span class="error"></span>

                            <div class="text-muted">{{ __('translation.txt_allowed_jpg_webp_or_png') }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-message">{{ __('translation.label_favicon') }}:</label>

                        <div class="button-wrapper col-sm-10">
                            @php
                                $faviconPath = 'storage/backend/assets/img/favicon/' . $settings['favicon'];
                            @endphp

                            @if(file_exists(public_path($faviconPath)))
                                <img src="{{ asset($faviconPath) }}" alt="app-favicon" class="d-block w-px-50 h-px-50 rounded mb-2" id="faviconUpload" />
                            @endif

                            <label for="favicon" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">{{ __('translation.label_upload_new_favicon') }}</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" id="favicon" class="account-file-input1" hidden name="favicon" />
                            </label>
                            <span class="error"></span>

                            <div class="text-muted">{{ __('translation.txt_allowed_ico_png_and_jpeg') }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"
                            for="basic-default-message">{{ __('translation.label_email_notification') }}:</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" value="1" id="active"
                                    @if ($settings['email_notification']) checked @endif>
                                <input type="hidden" name="email_notification" class="email_notification"
                                    value="{{ $settings['email_notification'] }}" />
                            </div>
                        </div>
                    </div>
                    @can('setting-update')
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit"
                                    class="btn btn-primary waves-effect waves-light">{{ __('translation.label_updated') }}</button>
                            </div>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
    <!-- / Content -->

@endsection

@section('page-js')
    <script>
        var updateSetting = "{{ route('setting.update') }}";
        var defaultImage = "{{ asset('backend/assets/img/default-image.webp') }}";
    </script>

    <script src="{{ addPageJsLink('setting.js?v=' . assetVersion() . time()) }}"></script>
@endsection

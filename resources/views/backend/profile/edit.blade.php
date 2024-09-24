@extends('layouts.app')
@section('title', 'Edit | Profile')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">{{ __('translation.label_account_settings') }}</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('translation.label_profile_details') }}</h5>
                    <form id="accountUpdate" method="POST" >
                    @csrf
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ $get_user->getImageUrl() }}" alt="user-avatar"
                                    class="d-block w-px-100 h-px-100 rounded" id="uploadedImage" />
                                <div class="button-wrapper col-md-6">
                                    <label for="user_image" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span class="d-none d-sm-block">{{ __('translation.label_upload_new_photo') }}</span>
                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                        <input type="file" id="user_image" class="account-file-input" hidden
                                            accept="image/png, image/jpeg" name="user_image" />
                                    </label>
                                    <span class="error"></span>
                                    <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">{{ __('translation.label_reset') }}</span>
                                    </button>

                                    <div class="text-muted">{{ __('translation.txt_allowed_jpg_webp_or_png') }}</div>
                                </div>
                                <input type="hidden" name="hidden_image" id="hidden_image" value="{{ $get_user->profile_image }}">
                                <input type="hidden" name="remove_image" id="remove_image" value="0">
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label required_label">{{ __('translation.label_first_name') }}</label>
                                        <input class="form-control first_name" type="text" id="first_name" name="first_name"
                                            autofocus value="{{ $get_user->first_name }}"/>
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="lastName" class="form-label required_label">{{ __('translation.label_last_name') }}</label>
                                        <input class="form-control" type="text" name="last_name" value="{{ $get_user->last_name }}" id="last_name"/>
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label required_label">{{ __('translation.label_email') }}</label>
                                        <input class="form-control email" type="text" id="email" name="email"
                                            value="{{ $get_user->email }}"/>
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">{{ __('translation.label_phone_number') }}</label>
                                        <input class="form-control" type="text" id="phone_number" name="phone_number"
                                        value="{{ $get_user->phone_number }}"/>
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">{{ __('translation.label_password') }}</label>
                                        <input class="form-control" type="password" id="password" name="password"/>
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">{{ __('translation.label_is_active') }}</label>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="active" @if($get_user->is_active == 1) checked @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">{{ __('translation.label_save_changes') }}s</button>
                                </div>

                        </div>
                        <!-- /Account -->
                </form>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('page-js')
    <script>
        var updateprofile = "{{ route('profile.update') }}";
        var default_image = "{{ asset('backend/assets/img/avatars/avatar.png') }}";
    </script>
    <script src="{{ addPageJsLink('edit-profile.js?v=' . assetVersion() . time()) }}"></script>
@endsection

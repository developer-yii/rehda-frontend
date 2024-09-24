<?php
    $getBackgroundStyle = getBackgroundStyle();
?>
@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="authentication-wrapper authentication-cover" style="{{ $getBackgroundStyle }}">
<div class="authentication-inner row">
    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-7 p-0">
        <img src="{{ getCoverImagePath() }}" alt="auth-login-cover" class="auth-cover-bg auauth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
    </div>
    <!-- /Left Text -->

    <!-- Login -->
    <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
            <!-- Logo -->
            <div class="app-brand mb-4">
                <a href="{{ route('login') }}" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo w-auto h-auto">
                        <img src="{{ getLogoPath() }}" width="350" height="80" />
                    </span>
                </a>
            </div>
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <!-- /Logo -->
            <h3 class="mb-1"> {{ getSetting('app_name') }}</h3>
            <p class="mb-4">{{ getSetting('login_page_title') }}</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label required_label">{{ __('translation.label_username') }}</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" id="username" name="username"
                        placeholder="{{ __('translation.placeholder_enter_your_username') }}" autofocus />

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label required_label" for="password">{{ __('translation.label_password') }}</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                <small>{{ __('translation.label_forgot_password') }}</small>
                            </a>
                        @endif
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-me" />
                        <label class="form-check-label" for="remember-me">{{ __('translation.label_remember_me') }}</label>
                    </div>
                </div>
                <button class="btn btn-primary d-grid w-100">{{ __('translation.label_sign_in') }}</button>
            </form>

        </div>
    </div>
    <!-- /Login -->
    </div>
</div>
@endsection

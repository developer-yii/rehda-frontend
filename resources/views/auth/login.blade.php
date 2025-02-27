<?php
    $getBackgroundStyle = getBackgroundStyle();
?>
@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="authentication-wrapper authentication-cover" style="{{ $getBackgroundStyle }}">
    <div class="authentication-inner row">

        <div class="d-flex d-lg-flex col-lg-12 p-0">

            <div class="home-banner">
                <video autoplay loop muted src="{{ asset('frontend/video/rehda-video-1080.mp4') }}" type="video/mp4" class="video-cover"></video>
                <div class="animate_text">
                    <h2>
                        Real Estate & Housing Developers'
                        <br>
                        Association (REHDA) Malaysia
                        <br>
                        Members' Portal
                    </h2>
                </div>
            </div>

        </div>

        <div class="d-flex d-lg-flex col-lg-12 pt-5">
            <div class="container">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="text-center mb-3">
                        <h2>Login</h2>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-sm-12 mb-5">

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form name="membership-no-login" action="{{ route('login') }}" method="POST" onsubmit="disableSubmitButton(this)">
                        @csrf
                        <input type="hidden" name="form_type" id="form_type" value="membership">
                        <div class="mb-3">
                            <label for="username" class="form-label required_label" id="label-username">Membership No. / MyKad No.</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror " name="username" id="username" value="{{ old('username') }}">
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
                                    <a href="javascript:void(0);" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#basicModal">
                                        <small>Forgot Password?</small>
                                    </a>
                                @endif
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror " name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer passwordspan"><i class="ti ti-eye-off"></i></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="submit form-text mb-2">
                            <button type="submit" name="membership-submit" id="membership-submit" class="btn btn-primary d-grid w-100">Login</button>
                        </div>

                    </form>

                </div>
                <hr>
                <div class="col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                    <h4>How to Become a REHDA Member?</h4>

                    <p class="mb-2">Applicants may fill in the REHDA Membership Application form.</p>

                    <p class="mb-2">Upon receipt of the application form from applicants, an administration personnel will verify all the information submitted before sending it to the Branch for vetting and recommendation. On approval by the Branch Committee, the application will be tabled for the National Council’s approval.</p>

                    <p class="mb-2">The applicants will be informed once their applications have been approved. A Membership Certificate and an Approval Letter signed by the President will be issued to the successful applicants.</p>

                    <div class="col-lg-12 col-md-12 col-sm-12 text-center mt-3 mb-5 d-flex justify-content-center">
                        <a href="{{ route('register') }}" class="btn btn-outline-primary d-grid w-50">New Member Registration</a>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>

<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Reset Password?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" name="reset-password-companyadmin" id="reset-password-companyadmin" method="post">
            @csrf
            <input type="hidden" name="form_type_reset" value="membership">
            <div class="modal-body">
                <p>Please follow the step below.</p>
                <div class="row">
                    <div class="col mb-3">
                        <label for="membershipno" class="form-label" id="label-username-forgotpass">Membership Number / MyKad No.</label>
                        <input type="text" name="membershipno" id="membershipno" class="form-control" placeholder="Enter Number" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email1" class="form-control" placeholder="Enter email" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary" id="btn-resetpass">Reset</button>
            </div>
            <div id="forgotpwdmmno-msg" style="padding-top:10px;"></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="basicModal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Reset Password?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" name="reset-password-representative" id="reset-password-representative" method="post">
            @csrf
            <input type="hidden" name="form_type_reset" value="representative">
            <div class="modal-body">
                <p>Please follow the step below.</p>
                <div class="row">
                    <div class="col mb-3">
                        <label for="mykadno" class="form-label">MyKad No.: <small>(Official Representative)</small></label>
                        <input type="text" name="mykadno" id="mykadno" class="form-control" placeholder="Enter MyKad No." />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email2" class="form-control" placeholder="Enter email" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">Reset</button>
            </div>
            <div id="forgotpwdmykad-msg" style="padding-top:10px;"></div>
            </form>
        </div>
    </div>
</div>

@include('layouts.footer')

<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">


@endsection
@section('auth-js')
<script>
    var forgotpwdUrl = "{{ route('forgot.pwd') }}";
</script>
<script src="{{ asset('assets/js/pages/login.js') }}"></script>
@endsection
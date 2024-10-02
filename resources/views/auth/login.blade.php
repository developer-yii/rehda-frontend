<?php
    $getBackgroundStyle = getBackgroundStyle();
?>
@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="login-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                <div class="title">
                    <h2>Login</h2>
                </div>
            </div>

            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12">
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ session('form') == 'membership' || !session('form') ? 'active' : '' }}" id="membership-tab" data-bs-toggle="tab" href="#membership" role="tab" aria-controls="membership" aria-selected="true">Member's Admin Login</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ session('form') == 'representative' ? 'active' : '' }}" id="representative-tab" data-bs-toggle="tab" href="#representative" role="tab" aria-controls="representative" aria-selected="false">Representative Login</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade {{ session('form') == 'membership' || !session('form') ? 'show active' : '' }}" id="membership" role="tabpanel" aria-labelledby="membership-tab">
                        <div id="login-msg-m" class="clearfix"></div>
                        <form name="membership-no-login" action="{{ route('login') }}" method="POST">
                            @csrf
                            <input type="hidden" name="form_type" value="membership">
                            <div class="mb-3">
                                <label for="membership" class="form-label required_label">Membership No.</label>
                                <input type="text" class="form-control {{ $errors->has('username') && session('form') == 'membership' ? 'is-invalid' : '' }}" name="username" id="username" value="{{ session('form') == 'membership' ? old('username') : '' }}">
                                @if ($errors->has('username') && session('form') == 'membership')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="memberLogin" class="form-label required_label">Password</label>
                                <input type="password" class="form-control {{ $errors->has('password') && session('form') == 'membership' ? 'is-invalid' : '' }}" name="password" id="password">
                                @if ($errors->has('password') && session('form') == 'membership')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="submit form-text">
                                <button type="submit" name="membership-submit" id="membership-submit" class="btn btn-primary">Login</button>
                            </div>

                            <!-- JOYCE HERE IS THE LOADING -->
                            <!-- <div class="load-form-submit">
                            <div class="form-loading-bg"></div>
                            <span></span>
                            <p class="white">Logging In!</p>
                            </div> -->
                        </form>

                        <a style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#resetmodalcompanyadmin">
                            <small>Forgot Password?</small>
                        </a>
                    </div>
                    <div class="tab-pane fade {{ session('form') == 'representative' ? 'show active' : '' }}" id="representative" role="tabpanel" aria-labelledby="representative-tab">
                        <div id="login-msg" class="clearfix"></div>
                        <form name="mykad-login" method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="form_type" value="representative">
                            <div class="mb-3">
                                <label for="mykad" class="form-label required_label">MyKad No.</label>
                                <input type="text" class="form-control {{ $errors->has('username') && session('form') == 'representative' ? 'is-invalid' : '' }}" name="username" id="mykadUn" value="{{ session('form') == 'representative' ? old('username') : '' }}">
                                @if ($errors->has('username') && session('form') == 'representative')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mykadLogin" class="form-label required_label">Password</label>
                                <input type="password" class="form-control {{ $errors->has('password') && session('form') == 'representative' ? 'is-invalid' : '' }}" name="password" id="mykadLogin">
                                @if ($errors->has('password') && session('form') == 'representative')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="submit form-text">
                                <button type="submit" name="mykad-submit" id="mykad-submit" class="btn btn-primary">Login</button>
                            </div>

                            <!-- JOYCE HERE IS THE LOADING -->
                            <!-- <div class="load-form-submit">
                            <div class="form-loading-bg"></div>
                            <span></span>
                            <p class="white">Logging In!</p>
                            </div> -->
                        </form>

                        <a style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#resetmodalrepresentative">
                            <small>Forgot Password?</small>
                        </a>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>

<div class="rehda-modal modal fade reset-password" id="resetmodalcompanyadmin" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('assets/img/question.png') }}">
                <h5 class="modal-title reset-title" id="staticBackdropLabel">
                    Reset Password?
                </h5>

                <p>Please follow the step below.</p>

                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" name="reset-password-companyadmin" id="reset-password-companyadmin" method="post">
                    @csrf
                    <input type="hidden" name="form_type_reset" value="membership">
                    <div class="form-text">
                        <label for="reset-email">
                            <p>Membership Number: <small>(Company Admin)</small></p>
                            <input type="text" name="membershipno" id="membershipno">
                        </label>
                    </div>
                    <div class="form-text">
                        <label for="reset-email">
                            <p>Email: </p>
                            <input type="email" name="email" id="email" pattern="^[^ ]+@[^ ]+\.[a-zA-Z]{2,10}$">
                        </label>
                    </div>

                    <div class="submit">
                        <input type="submit" name="reset-submit" id="reset-submit" value="Reset">
                    </div>

                    <div id="forgotpwdmmno-msg" style="padding-top:10px;"></div>

                </form>

                <hr>

                <div class="contact">
                    <!--<p>Facing issue while during resetting? <br>Please contact our <a href="#" target="_blank" style="color:#075E54;font-weight:800;">Whatsapp</a> or our <a href="#" target="_blank" style="color:#003264;font-weight:800;">Office number</a>.</p>-->
                </div>
            </div>

        </div>
    </div>
</div>

<div class="rehda-modal modal fade reset-password" id="resetmodalrepresentative" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('assets/img/question.png') }}">
                <h5 class="modal-title reset-title" id="staticBackdropLabel">
                    Reset Password?
                </h5>

                <p>Please follow the step below.</p>

                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form name="reset-password-representative" id="reset-password-representative" method="post">
                    <input type="hidden" name="form_type_reset" value="representative">
                    <div class="form-text">
                        <label for="mykadno">
                            <p>MyKad No.: <small>(Official Representative)</small></p>
                            <input type="text" name="mykadno" id="mykadno" minlength="12" maxlength="12">
                        </label>
                    </div>
                    <div class="form-text">
                        <label for="email">
                            <p>Email: </p>
                            <input type="email" name="email" id="email" pattern="^[^ ]+@[^ ]+\.[a-zA-Z]{2,10}$">
                        </label>
                    </div>

                    <div class="submit">
                        <input type="submit" name="reset-mykad-submit" id="reset-mykad-submit" value="Reset">
                    </div>

                    <div id="forgotpwdmykad-msg" style="padding-top:10px;"></div>

                </form>

                <hr>

                <div class="contact">
                    <!--<p>Facing issue while during resetting? <br>Please contact our <a href="#" target="_blank" style="color:#075E54;font-weight:800;">Whatsapp</a> or our <a href="#" target="_blank" style="color:#003264;font-weight:800;">Office number</a>.</p>-->
                </div>
            </div>

        </div>
    </div>
</div>


@endsection
@section('auth-js')
<script>
    // var forgotpwdUrl = "{{ route('password.email') }}";
    var forgotpwdUrl = "{{ route('forgot.pwd') }}";
</script>
<script src="{{ asset('assets/js/pages/login.js') }}"></script>
@endsection

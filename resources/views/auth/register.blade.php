@extends('layouts.auth')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

<style>
    .leftside{
        /* padding: 3rem 8px; */
        padding: 20px 40px;
        border-right: 1px solid black;
    }
    .leftside ul{
        list-style: none;
        padding-left: 0;
    }
    .leftside ul button{
        text-align: left !important;
    }
</style>

<div class="container">
    <div class="card mt-5">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Rehda Member Portal</h5>
        </div>

        <div class="choose-company-section section-padding mb-5">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                    <div class="title mt-2">
                        <h3>New Member Registration</h3>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 leftside">
                    <h3>Type of Membership Applying for</h3>

                    <ul>
                        <li>
                            <h2>
                                <button class="btn w-100 btn-lg btn-primary">Ordinary</button>
                            </h2>
                        </li>
                        <li>
                            <h2>
                                <button class="btn w-100 btn-lg">Subsidiary / Related</button>
                            </h2>
                        </li>
                        <li>
                            <h2>
                                <button class="btn w-100 btn-lg">Affiliate</button>
                            </h2>
                        </li>
                        <li>
                            <h2>
                                <button class="btn w-100 btn-lg">Associate</button>
                            </h2>
                        </li>
                        <li>
                            <h2>
                                <button class="btn w-100 btn-lg">Rehda Youth</button>
                            </h2>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

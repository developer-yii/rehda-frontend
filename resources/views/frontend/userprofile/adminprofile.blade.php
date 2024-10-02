@extends('layouts.app')

@section('title', 'User Profile')

@section('css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">{{ __('translation.label_dashboard') }}</a>
                </li>

                <li class="breadcrumb-item active">User Profile</li>

            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">User Profile</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('userprofile.updateadmin') }}">
                @csrf
                <!-- <div class="row mt-3">
                    <div class="mb-3 col-md-12">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div>{{$error}}</div>
                        @endforeach
                    @endif
                    </div>
                </div> -->
                <div class="row mt-3">
                    <div class="mb-3 col-md-12">
                        <label for="name_of_admin" class="form-label form-label-lg required_label">Name of Admin:</label>
                        <input class="form-control form-control-lg" type="text" id="name_of_admin" name="name_of_admin" value="{{ $profile->up_fullname }}" />
                        @if ($errors->has('name_of_admin'))
                        <span class="error">{{ $errors->first('name_of_admin') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="title" class="form-label form-label-lg required_label">Title:</label>
                        <select id="title" name="title" class="form-select form-select-lg">
                            @foreach($titles as $title)
                                <option value="{{ $title->sid }}" {{ ($title->sid == $profile->up_title) ? 'selected' : '' }}>{{ $title->sname }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('title'))
                        <span class="error">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="designation" class="form-label form-label-lg required_label">Designation:</label>
                        <input class="form-control form-control-lg" type="text" id="designation" name="designation" value="{{ $profile->up_designation }}" />
                        @if ($errors->has('designation'))
                        <span class="error">{{ $errors->first('designation') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="email" class="form-label form-label-lg required_label">Email:</label>
                        <input class="form-control form-control-lg" type="email" id="email" name="email" value="{{ $profile->up_emailadd }}" />
                        @if ($errors->has('email'))
                        <span class="error">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="contact_no" class="form-label form-label-lg required_label">Contact No:</label>
                        <input class="form-control form-control-lg" type="number" id="contact_no" name="contact_no" value="{{ $profile->up_contactno }}" />
                        @if ($errors->has('contact_no'))
                        <span class="error">{{ $errors->first('contact_no') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="update-password">
                        <label for="changePass">
                            <h4 class="d-inline me-2">Update Your Password</h4>
                            <input type="checkbox" name="changePass" id="changePass" class="form-check-input align-baseline" onclick="changePassCheck()" {{ old('changePass') != null ? 'checked' : '' }} >
                        </label>
                    </div>
                </div>
                @php
                if(old('new_password') != null || old('retype_password') != null) {
                    $style = 'display:block;';
                } else {
                    $style = 'display:none;';
                }
                @endphp
                <div class="row mt-3" id="passInput" style="{{ $style }}">
                    <hr>
                    <div class="mb-3 col-md-12">
                        <div class="mb-3 col-md-12">
                            <label for="new_password" class="form-label form-label-lg">New Password:</label>
                            <input class="form-control form-control-lg createpw" type="password" id="new_password" name="new_password" value="{{ old('new_password') }}" />
                            @if ($errors->has('new_password'))
                            <span class="error">{{ $errors->first('new_password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="retype_password" class="form-label form-label-lg">Re-Type Password:</label>
                        <input class="form-control form-control-lg" type="password" id="retype_password" name="retype_password" value="{{ old('retype_password') }}" />
                        @if ($errors->has('retype_password'))
                        <span class="error">{{ $errors->first('retype_password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="btn btn-lg btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
    function changePassCheck() {
        var changePassLabel = document.getElementById("changePass");
        var passInput = document.getElementById("passInput");

        if (changePassLabel.checked == true){
            passInput.style.display = "block";
        } else {
            passInput.style.display = "none";
        }
    }
</script>
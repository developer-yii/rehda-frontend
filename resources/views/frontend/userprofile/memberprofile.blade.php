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
            <form method="POST" action="{{ route('userprofile.updatemember') }}">
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
                        <label for="name_of_official_representative" class="form-label form-label-lg required_label">Name of Official Representative:</label>
                        <input class="form-control form-control-lg" type="text" id="name_of_official_representative" name="name_of_official_representative" value="{{ $profile->up_fullname }}" disabled />
                        @if ($errors->has('name_of_official_representative'))
                        <span class="error">{{ $errors->first('name_of_official_representative') }}</span>
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
                        <label for="mykad_no" class="form-label form-label-lg required_label">MyKad No.:</label>
                        <input class="form-control form-control-lg" type="text" id="mykad_no" name="mykad_no" value="{{ $profile->up_mykad }}" disabled />
                        @if ($errors->has('mykad_no'))
                        <span class="error">{{ $errors->first('mykad_no') }}</span>
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
                        <label for="gender" class="form-label form-label-lg required_label">Gender:</label>
                        <br>
                        @foreach($genders as $gender)
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == $profile->up_gender ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $gender->gid }}">{{ $gender->gname }}</label>
                        </div>
                        @endforeach
                        @if ($errors->has('gender'))
                        <span class="error">{{ $errors->first('gender') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="professional_qualification" class="form-label form-label-lg">Professional Qualification (If Any):</label>
                        <input class="form-control form-control-lg" type="text" id="professional_qualification" name="professional_qualification" value="{{ $profile->up_profq }}" />
                        @if ($errors->has('professional_qualification'))
                        <span class="error">{{ $errors->first('professional_qualification') }}</span>
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
                    <div class="mb-3 col-md-12">
                        <label for="correspondence_address" class="form-label form-label-lg required_label">Correspondence Address:</label>
                        <input class="form-control form-control-lg" type="text" id="correspondence_address" name="correspondence_address" value="{{ $profile->up_address }}" />
                        @if ($errors->has('correspondence_address'))
                        <span class="error">{{ $errors->first('correspondence_address') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="city" class="form-label form-label-lg required_label">City:</label>
                        <input class="form-control form-control-lg" type="text" id="city" name="city" value="{{ $profile->up_city }}" />
                        @if ($errors->has('city'))
                        <span class="error">{{ $errors->first('city') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="state" class="form-label form-label-lg required_label">State:</label>
                        <select id="state" name="state" class="form-select form-select-lg">
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->state_id }}" {{ ($state->state_id == $profile->up_state) ? 'selected' : '' }}>{{ $state->state_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('state'))
                        <span class="error">{{ $errors->first('state') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="postcode" class="form-label form-label-lg required_label">Postcode:</label>
                        <input class="form-control form-control-lg" type="text" id="postcode" name="postcode" value="{{ $profile->up_postcode }}" />
                        @if ($errors->has('postcode'))
                        <span class="error">{{ $errors->first('postcode') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="country" class="form-label form-label-lg required_label">Country:</label>
                        <select id="country" name="country" class="form-select form-select-lg">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->country_id }}" {{ ($country->country_id == $profile->up_country) ? 'selected' : '' }}>{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('country'))
                        <span class="error">{{ $errors->first('country') }}</span>
                        @endif
                    </div>
                    <hr>
                    <div class="mb-3 col-md-12">
                        <label for="secretary_name" class="form-label form-label-lg">Secretary Name:</label>
                        <input class="form-control form-control-lg" type="text" id="secretary_name" name="secretary_name" value="{{ $profile->up_sec_name }}" />
                        @if ($errors->has('secretary_name'))
                        <span class="error">{{ $errors->first('secretary_name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="secretary_title" class="form-label form-label-lg">Secretary Title:</label>
                        <select id="secretary_title" name="secretary_title" class="form-select form-select-lg">
                            <option value="" selected disabled>Select Title</option>
                            @foreach($titles as $title)
                                <option value="{{ $title->sid }}" {{ ($title->sid == $profile->up_sec_title) ? 'selected' : '' }}>{{ $title->sname }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('secretary_title'))
                        <span class="error">{{ $errors->first('secretary_title') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="secretary_email" class="form-label form-label-lg">Secretary Email:</label>
                        <input class="form-control form-control-lg" type="text" id="secretary_email" name="secretary_email" value="{{ $profile->up_sec_email }}" />
                        @if ($errors->has('secretary_email'))
                        <span class="error">{{ $errors->first('secretary_email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="secretary_contact_no" class="form-label form-label-lg">Secretary Contact No:</label>
                        <input class="form-control form-control-lg" type="text" id="secretary_contact_no" name="secretary_contact_no" value="{{ $profile->up_sec_mobile }}" />
                        @if ($errors->has('secretary_contact_no'))
                        <span class="error">{{ $errors->first('secretary_contact_no') }}</span>
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
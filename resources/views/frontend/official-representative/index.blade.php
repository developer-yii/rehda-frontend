@extends('layouts.app')

@section('title', 'Official Representative')

@section('css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('choosecompant.index') }}">Back</a>
                </li>

                <li class="breadcrumb-item active">Official Representative</li>

            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Official Representative</h5>
        </div>

        <div class="card-body pt-4">
            <div class="accordion accordion-flush accordion-arrow-left" id="accordionYearParent">
                <form method="POST" action="{{ route('official-representative.update') }}" onsubmit="disableSubmitButton(this)">

                    <div class="row">
                        <div class="mb-3 col-md-12">

                        <div class="nav-align-top">
                            <ul class="nav nav-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link @if( (!$errors->has('official2designation') && !$errors->has('official2email') && !$errors->has('official2contact_no') && !$errors->has('official2address') && !$errors->has('official2city') && !$errors->has('official2state') && !$errors->has('official2postcode') && !$errors->has('official2country')) && !isset($alternate) ) active @endif"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-info"
                                        aria-controls="navs-info"
                                        aria-selected="@if( (!$errors->has('official2designation') && !$errors->has('official2email') && !$errors->has('official2contact_no') && !$errors->has('official2address') && !$errors->has('official2city') && !$errors->has('official2state') && !$errors->has('official2postcode') && !$errors->has('official2country')) && !isset($alternate) ) true @else false @endif">
                                        Official Representative
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link @if($errors->has('official2designation') || $errors->has('official2email') || $errors->has('official2contact_no') || $errors->has('official2address') || $errors->has('official2city') || $errors->has('official2state') || $errors->has('official2postcode') || $errors->has('official2country') || isset($alternate)) active @endif"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-password"
                                        aria-controls="navs-password"
                                        aria-selected="@if($errors->has('official2designation') || $errors->has('official2email') || $errors->has('official2contact_no') || $errors->has('official2address') || $errors->has('official2city') || $errors->has('official2state') || $errors->has('official2postcode') || $errors->has('official2country') || isset($alternate)) true @else false @endif">
                                        Alternate Representative
                                    </button>
                                </li>
                            </ul>

                    @csrf
                    @php
                    $i = 1;
                    $count = 1;

                    if( $errors->has('official1designation') || $errors->has('official1gender') || $errors->has('official1email') || $errors->has('official1contact_no') || $errors->has('official1address') || $errors->has('official1city') || $errors->has('official1state') || $errors->has('official1postcode') || $errors->has('official1country') ) {
                        $errorcheck = 1;
                    } else if( $errors->has('official2designation') || $errors->has('official2gender') || $errors->has('official2email') || $errors->has('official2contact_no') || $errors->has('official2address') || $errors->has('official2city') || $errors->has('official2state') || $errors->has('official2postcode') || $errors->has('official2country') ) {
                        $errorcheck = 2;
                    } else {
                        $errorcheck = 0;
                    }

                    @endphp

                    @foreach($userProfiles as $profile)

                        @if($i==1)

                        <div class="tab-content ps-0 pe-0 pb-0">
                            <div class="tab-pane fade @if( (!$errors->has('official2designation') && !$errors->has('official2email') && !$errors->has('official2contact_no') & !$errors->has('official2address') && !$errors->has('official2city') && !$errors->has('official2state') && !$errors->has('official2postcode') && !$errors->has('official2country')) && !isset($alternate) ) show active @endif" id="navs-info" role="tabpanel">

                        <input type="hidden" name="official1" id="official1" value="{{ $profile->up_id }}">

                        <!-- <div class="accordion-item border-bottom {{ ($count < 2 && $errorcheck != 2) ? 'active' : '' }}">
                            <div class="accordion-header d-flex justify-content-between align-items-center flex-wrap flex-sm-nowrap" id="{{$profile->up_id}}">
                                <a class="accordion-button accordion-button-removearrow {{ $count < 2 ? 'collapsed' : '' }}" data-bs-toggle="collapse" data-bs-target="#official-representative-1" aria-expanded="false" aria-controls="official-representative-1" role="button">
                                    <span>
                                        <span class="d-flex gap-2 align-items-baseline ms-3">
                                            <span class="h5 mb-1 text-white">Official Representative <span class="badge bg-danger ms-2">Required</span></span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div id="official-representative-1" class="accordion-collapse collapse {{ ($count < 2 && $errorcheck != 2) ? 'show' : '' }}" data-bs-parent="#accordionYearParent"> -->
                                <!-- <div class="card-body"> -->
                                    <a class="edit-name-of-offcial-representative text-danger" id="nor1" data-toggle="modal" data-target="#resetNor1" style="cursor: pointer;">
                                        <i class="menu-icon ti ti-edit"></i>Click here to change Official Representative
                                    </a>
                                    @php $id1 = $profile->up_id; @endphp

                                    <div class="row mt-3">
                                        <div class="mb-3 col-md-12">
                                            <label for="official1nop" class="form-label form-label-lg required_label">Name of Official Representative:</label>
                                            <input class="form-control form-control-lg" type="text" id="official1nop" name="official1nop" value="{{ $profile->up_fullname }}" disabled />
                                            @if ($errors->has('official1nop'))
                                            <span class="error">{{ $errors->first('official1nop') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1title" class="form-label form-label-lg required_label">Title:</label>
                                            <select id="official1title" name="official1title" class="form-select form-select-lg">
                                                <option value="0" {{ ($profile->up_title == 0) ? 'selected' : '' }}>-</option>
                                                @foreach($titles as $title)
                                                    <option value="{{ $title->sid }}" {{ ($title->sid == $profile->up_title) ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('official1title'))
                                            <span class="error">{{ $errors->first('official1title') }}</span>
                                            @endif
                                        </div>
                                        @if($profile->up_mykad)
                                        <div class="mb-3 col-md-12">
                                            <label for="official1mykad" class="form-label form-label-lg required_label">MyKad No.:</label>
                                            <input class="form-control form-control-lg" type="text" id="official1mykad" name="official1mykad" value="{{ $profile->up_mykad }}" disabled />
                                            @if ($errors->has('official1mykad'))
                                            <span class="error">{{ $errors->first('official1mykad') }}</span>
                                            @endif
                                        </div>
                                        @endif
                                        @if($profile->passportno)
                                        <div class="mb-3 col-md-12">
                                            <label for="passportno1" class="form-label form-label-lg required_label">MyKad No.:</label>
                                            <input class="form-control form-control-lg" type="text" id="passportno1" name="passportno1" value="{{ $profile->passportno }}" disabled />
                                            @if ($errors->has('passportno1'))
                                            <span class="error">{{ $errors->first('passportno1') }}</span>
                                            @endif
                                        </div>
                                        @endif
                                        <div class="mb-3 col-md-12">
                                            <label for="official1designation" class="form-label form-label-lg required_label">Designation:</label>
                                            <input class="form-control form-control-lg" type="text" id="official1designation" name="official1designation" value="{{ old('official1designation', $profile->up_designation ?? '') }}" />
                                            @if ($errors->has('official1designation'))
                                            <span class="error">{{ $errors->first('official1designation') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1gender" class="form-label form-label-lg required_label">Gender:</label>
                                            <br>
                                            @foreach($genders as $gender)
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="radio" name="official1gender" id="{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('official1gender', $profile->up_gender) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $gender->gid }}">{{ $gender->gname }}</label>
                                            </div>
                                            @endforeach
                                            @if ($errors->has('official1gender'))
                                            <br>
                                            <span class="error">{{ $errors->first('official1gender') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1pro_qualification" class="form-label form-label-lg">Professional Qualification (If Any):</label>
                                            <input class="form-control form-control-lg" type="text" id="official1pro_qualification" name="official1pro_qualification" value="{{ old('official1pro_qualification', $profile->up_profq ?? '') }}" />
                                            @if ($errors->has('official1pro_qualification'))
                                            <span class="error">{{ $errors->first('official1pro_qualification') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1email" class="form-label form-label-lg required_label">Email:</label>
                                            <input class="form-control form-control-lg" type="email" id="official1email" name="official1email" value="{{ old('official1email', $profile->up_emailadd ?? '') }}" />
                                            @if ($errors->has('official1email'))
                                            <span class="error">{{ $errors->first('official1email') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1contact_no" class="form-label form-label-lg required_label">Contact No:</label>
                                            <input class="form-control form-control-lg" type="number" id="official1contact_no" name="official1contact_no" value="{{ old('official1contact_no', $profile->up_contactno ?? '') }}" />
                                            @if ($errors->has('official1contact_no'))
                                            <span class="error">{{ $errors->first('official1contact_no') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1address" class="form-label form-label-lg required_label">Correspondence Address:</label>
                                            <input class="form-control form-control-lg" type="text" id="official1address" name="official1address" value="{{ old('official1address', $profile->up_address ?? '') }}" />
                                            @if ($errors->has('official1address'))
                                            <span class="error">{{ $errors->first('official1address') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1city" class="form-label form-label-lg required_label">City:</label>
                                            <input class="form-control form-control-lg" type="text" id="official1city" name="official1city" value="{{ old('official1city', $profile->up_city ?? '') }}" />
                                            @if ($errors->has('official1city'))
                                            <span class="error">{{ $errors->first('official1city') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1state" class="form-label form-label-lg required_label">State:</label>
                                            <select id="official1state" name="official1state" class="form-select form-select-lg">
                                                <option value="">Select State</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->state_id }}" {{ $state->state_id == old('official1state', $profile->up_state) ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('official1state'))
                                            <span class="error">{{ $errors->first('official1state') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1postcode" class="form-label form-label-lg required_label">Postcode:</label>
                                            <input class="form-control form-control-lg" type="text" id="official1postcode" name="official1postcode" value="{{ old('official1postcode', $profile->up_postcode ?? '') }}" />
                                            @if ($errors->has('official1postcode'))
                                            <span class="error">{{ $errors->first('official1postcode') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1country" class="form-label form-label-lg required_label">Country:</label>
                                            <select id="official1country" name="official1country" class="form-select form-select-lg">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->country_id }}" {{ $country->country_id == old('official1country', $profile->up_country) ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('official1country'))
                                            <span class="error">{{ $errors->first('official1country') }}</span>
                                            @endif
                                        </div>
                                        <hr>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1secretary_name" class="form-label form-label-lg">Secretary Name:</label>
                                            <input class="form-control form-control-lg" type="text" id="official1secretary_name" name="official1secretary_name" value="{{ old('official1secretary_name', $profile->up_sec_name ?? '') }}" />
                                            @if ($errors->has('official1secretary_name'))
                                            <span class="error">{{ $errors->first('official1secretary_name') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1secretary_title" class="form-label form-label-lg">Secretary Title:</label>
                                            <select id="official1secretary_title" name="official1secretary_title" class="form-select form-select-lg">
                                                <option value="" selected disabled>Select Title</option>
                                                <option value="0" {{ ($profile->up_sec_title == 0) ? 'selected' : '' }}>-</option>
                                                @foreach($titles as $title)
                                                    <option value="{{ $title->sid }}" {{ $title->sid == old('official1secretary_title', $profile->up_sec_title) ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('official1secretary_title'))
                                            <span class="error">{{ $errors->first('official1secretary_title') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1secretary_email" class="form-label form-label-lg">Secretary Email:</label>
                                            <input class="form-control form-control-lg" type="text" id="official1secretary_email" name="official1secretary_email" value="{{ old('official1secretary_email', $profile->up_sec_email ?? '') }}" />
                                            @if ($errors->has('official1secretary_email'))
                                            <span class="error">{{ $errors->first('official1secretary_email') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official1secretary_contact_no" class="form-label form-label-lg">Secretary Contact No:</label>
                                            <input class="form-control form-control-lg" type="number" id="official1secretary_contact_no" name="official1secretary_contact_no" value="{{ old('official1secretary_contact_no', $profile->up_sec_mobile ?? '') }}" />
                                            @if ($errors->has('official1secretary_contact_no'))
                                            <span class="error">{{ $errors->first('official1secretary_contact_no') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                <!-- </div> -->
                            <!-- </div>
                        </div> -->

                            </div>


                        @elseif($i==2)

                            <div class="tab-pane fade @if($errors->has('official2designation') || $errors->has('official2email') || $errors->has('official2contact_no') || $errors->has('official2address') || $errors->has('official2city') || $errors->has('official2state') || $errors->has('official2postcode') || $errors->has('official2country') || isset($alternate)) show active @endif" id="navs-password" role="tabpanel">

                        <input type="hidden" name="official2" id="official2" value="{{ $profile->up_id }}">

                        <!-- <div class="accordion-item border-bottom {{ ($count < 2 || $errorcheck == 2)  ? 'active' : '' }}">
                            <div class="accordion-header d-flex justify-content-between align-items-center flex-wrap flex-sm-nowrap" id="{{$profile->up_id}}">
                                <a class="accordion-button accordion-button-removearrow {{ $count < 2 ? 'collapsed' : '' }}" data-bs-toggle="collapse" data-bs-target="#official-representative-2" aria-expanded="false" aria-controls="official-representative-2" role="button">
                                    <span>
                                        <span class="d-flex gap-2 align-items-baseline ms-3">
                                            <span class="h5 mb-1 text-white">Alternate Representative <span class="badge bg-danger ms-2">Required</span></span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div id="official-representative-2" class="accordion-collapse collapse {{ ($count < 2 || $errorcheck == 2) ? 'show' : '' }}" data-bs-parent="#accordionYearParent"> -->
                                <!-- <div class="card-body"> -->
                                    <a class="edit-name-of-offcial-representative text-danger" id="nor2" data-toggle="modal" data-target="#resetNor1" style="cursor: pointer;">
                                        <i class="menu-icon ti ti-edit"></i>Click here to change Alternate Representative
                                    </a>
                                    @php $id2 = $profile->up_id; @endphp

                                    <div class="row mt-3">
                                        <div class="mb-3 col-md-12">
                                            <label for="official2nop" class="form-label form-label-lg required_label">Name of Alternate Representative:</label>
                                            <input class="form-control form-control-lg" type="text" id="official2nop" name="official2nop" value="{{ $profile->up_fullname }}" disabled />
                                            @if ($errors->has('official2nop'))
                                            <span class="error">{{ $errors->first('official2nop') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2title" class="form-label form-label-lg required_label">Title:</label>
                                            <select id="official2title" name="official2title" class="form-select form-select-lg">
                                                <option value="0" {{ ($profile->up_title == 0) ? 'selected' : '' }}>-</option>
                                                @foreach($titles as $title)
                                                    <option value="{{ $title->sid }}" {{ ($title->sid == $profile->up_title) ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('official2title'))
                                            <span class="error">{{ $errors->first('official2title') }}</span>
                                            @endif
                                        </div>
                                        @if($profile->up_mykad)
                                        <div class="mb-3 col-md-12">
                                            <label for="official2mykad" class="form-label form-label-lg required_label">MyKad No.:</label>
                                            <input class="form-control form-control-lg" type="text" id="official2mykad" name="official2mykad" value="{{ $profile->up_mykad }}" disabled />
                                            @if ($errors->has('official2mykad'))
                                            <span class="error">{{ $errors->first('official2mykad') }}</span>
                                            @endif
                                        </div>
                                        @endif
                                        @if($profile->passportno)
                                        <div class="mb-3 col-md-12">
                                            <label for="passportno2" class="form-label form-label-lg required_label">MyKad No.:</label>
                                            <input class="form-control form-control-lg" type="text" id="passportno2" name="passportno2" value="{{ $profile->passportno }}" disabled />
                                            @if ($errors->has('passportno2'))
                                            <span class="error">{{ $errors->first('passportno2') }}</span>
                                            @endif
                                        </div>
                                        @endif

                                        <div class="mb-3 col-md-12">
                                            <label for="official2designation" class="form-label form-label-lg required_label">Designation:</label>
                                            <input class="form-control form-control-lg" type="text" id="official2designation" name="official2designation" value="{{ old('official2designation', $profile->up_designation ?? '') }}" />
                                            @if ($errors->has('official2designation'))
                                            <span class="error">{{ $errors->first('official2designation') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2gender" class="form-label form-label-lg required_label">Gender:</label>
                                            <br>
                                            @foreach($genders as $gender)
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="radio" name="official2gender" id="{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('official2gender', $profile->up_gender) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $gender->gid }}">{{ $gender->gname }}</label>
                                            </div>
                                            @endforeach
                                            @if ($errors->has('official2gender'))
                                            <br>
                                            <span class="error">{{ $errors->first('official2gender') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2pro_qualification" class="form-label form-label-lg">Professional Qualification (If Any):</label>
                                            <input class="form-control form-control-lg" type="text" id="official2pro_qualification" name="official2pro_qualification" value="{{ old('official2pro_qualification', $profile->up_profq ?? '') }}" />
                                            @if ($errors->has('official2pro_qualification'))
                                            <span class="error">{{ $errors->first('official2pro_qualification') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2email" class="form-label form-label-lg required_label">Email:</label>
                                            <input class="form-control form-control-lg" type="email" id="official2email" name="official2email" value="{{ old('official2email', $profile->up_emailadd ?? '') }}" />
                                            @if ($errors->has('official2email'))
                                            <span class="error">{{ $errors->first('official2email') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2contact_no" class="form-label form-label-lg required_label">Contact No:</label>
                                            <input class="form-control form-control-lg" type="number" id="official2contact_no" name="official2contact_no" value="{{ old('official2contact_no', $profile->up_contactno ?? '') }}" />
                                            @if ($errors->has('official2contact_no'))
                                            <span class="error">{{ $errors->first('official2contact_no') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2address" class="form-label form-label-lg required_label">Correspondence Address:</label>
                                            <input class="form-control form-control-lg" type="text" id="official2address" name="official2address" value="{{ old('official2address', $profile->up_address ?? '') }}" />
                                            @if ($errors->has('official2address'))
                                            <span class="error">{{ $errors->first('official2address') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2city" class="form-label form-label-lg required_label">City:</label>
                                            <input class="form-control form-control-lg" type="text" id="official2city" name="official2city" value="{{ old('official2city', $profile->up_city ?? '') }}" />
                                            @if ($errors->has('official2city'))
                                            <span class="error">{{ $errors->first('official2city') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2state" class="form-label form-label-lg required_label">State:</label>
                                            <select id="official2state" name="official2state" class="form-select form-select-lg">
                                                <option value="">Select State</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->state_id }}" {{ $state->state_id == old('official2state', $profile->up_state) ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('official2state'))
                                            <span class="error">{{ $errors->first('official2state') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2postcode" class="form-label form-label-lg required_label">Postcode:</label>
                                            <input class="form-control form-control-lg" type="text" id="official2postcode" name="official2postcode" value="{{ old('official2postcode', $profile->up_postcode ?? '') }}" />
                                            @if ($errors->has('official2postcode'))
                                            <span class="error">{{ $errors->first('official2postcode') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2country" class="form-label form-label-lg required_label">Country:</label>
                                            <select id="official2country" name="official2country" class="form-select form-select-lg">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->country_id }}" {{ $country->country_id == old('official2country', $profile->up_country) ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('official2country'))
                                            <span class="error">{{ $errors->first('official2country') }}</span>
                                            @endif
                                        </div>
                                        <hr>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2secretary_name" class="form-label form-label-lg">Secretary Name:</label>
                                            <input class="form-control form-control-lg" type="text" id="official2secretary_name" name="official2secretary_name" value="{{ old('official2secretary_name', $profile->up_sec_name ?? '') }}" />
                                            @if ($errors->has('official2secretary_name'))
                                            <span class="error">{{ $errors->first('official2secretary_name') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2secretary_title" class="form-label form-label-lg">Secretary Title:</label>
                                            <select id="official2secretary_title" name="official2secretary_title" class="form-select form-select-lg">
                                                <option value="" selected disabled>Select Title</option>
                                                <option value="0" {{ ($profile->up_sec_title == 0) ? 'selected' : '' }}>-</option>
                                                @foreach($titles as $title)
                                                    <option value="{{ $title->sid }}" {{ $title->sid == old('official2secretary_title', $profile->up_sec_title) ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('official2secretary_title'))
                                            <span class="error">{{ $errors->first('official2secretary_title') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2secretary_email" class="form-label form-label-lg">Secretary Email:</label>
                                            <input class="form-control form-control-lg" type="email" id="official2secretary_email" name="official2secretary_email" value="{{ old('official2secretary_email', $profile->up_sec_email ?? '') }}" />
                                            @if ($errors->has('official2secretary_email'))
                                            <span class="error">{{ $errors->first('official2secretary_email') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="official2secretary_contact_no" class="form-label form-label-lg">Secretary Contact No:</label>
                                            <input class="form-control form-control-lg" type="text" id="official2secretary_contact_no" name="official2secretary_contact_no" value="{{ old('official2secretary_contact_no', $profile->up_sec_mobile ?? '') }}" />
                                            @if ($errors->has('official2secretary_contact_no'))
                                            <span class="error">{{ $errors->first('official2secretary_contact_no') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                <!-- </div> -->
                            <!-- </div>
                        </div> -->

                            </div>
                        </div>

                        @endif

                        @php
                        $i++;
                        $count++;
                        @endphp

                    @endforeach

                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-lg btn-primary me-sm-3 me-1 waves-effect waves-light" id="submitBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="resetNor1" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-simple modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Official Representative</h3>
                    <p>
                        <small>**Please ensure the email address belongs to the new Representative. <br>
                        First-time login password will be sent to the email address.**</small>
                    </p>
                </div>
                <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" name="reset-nor1" novalidate="novalidate">
                    @csrf
                    <input type="hidden" id="resetNor1Id" name="resetNor1Id" value="<?=$id1?>" readonly required>
                    <div class="col-12 fv-plugins-icon-container">
                        <label class="form-label form-label-lg" for="resetNor1Name">Name of Representative:</label>
                        <input class="form-control form-control-lg" type="text" id="resetNor1Name" name="resetNor1Name" value="" />
                    </div>
                    <div class="col-12 fv-plugins-icon-container">
                        <label class="form-label form-label-lg" for="resetNor1MyKadSelect">MyKad No.:</label>
                        <select name="resetNor1MyKadSelect" id="resetNor1MyKadSelect" class="form-select form-select-lg mykadSelect">
                            <option value="1">MyKad No.</option>
                            <option value="2">Passport No.</option>
                        </select>
                    </div>
                    <div class="col-12 fv-plugins-icon-container mykadDiv">
                        <label class="form-label form-label-lg" for="resetNor1MyKad">MyKad No.:</label>
                        <input class="form-control form-control-lg mykad" type="text" id="resetNor1MyKad" name="resetNor1MyKad" value="" />
                    </div>
                    <div class="col-12 fv-plugins-icon-container passportDiv">
                        <label class="form-label form-label-lg" for="resetNor1Passportno">Passport No.:</label>
                        <input class="form-control form-control-lg passport" type="text" id="resetNor1Passportno" name="resetNor1Passportno" value="" />
                    </div>
                    <div class="col-12 fv-plugins-icon-container">
                        <label class="form-label form-label-lg" for="resetNor1contact">Contact No.:</label>
                        <input class="form-control form-control-lg" type="number" id="resetNor1contact" name="resetNor1contact" value="" />
                    </div>
                    <div class="col-12 fv-plugins-icon-container">
                        <label class="form-label form-label-lg" for="resetNor1email">Email Address:</label>
                        <input class="form-control form-control-lg" type="text" id="resetNor1email" name="resetNor1email" value="" />
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="submit1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                    <div id="chgreq1-msg" style="padding-top:10px;"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="resetNor2" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-simple modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Alternate Representative</h3>
                    <p>
                        <small>**Please ensure the email address belongs to the new Representative. <br>
                        First-time login password will be sent to the email address.**</small>
                    </p>
                </div>
                <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" name="reset-nor2"  novalidate="novalidate">
                    @csrf
                    <input type="hidden" id="resetNor2Id" name="resetNor2Id" value="<?=$id2?>" readonly required>
                    <div class="col-12 fv-plugins-icon-container">
                        <label class="form-label form-label-lg" for="resetNor2Name">Name of Representative:</label>
                        <input class="form-control form-control-lg" type="text" id="resetNor2Name" name="resetNor2Name" value="" />
                    </div>
                    <div class="col-12 fv-plugins-icon-container">
                        <label class="form-label form-label-lg" for="resetNor2MyKadSelect">MyKad No.:</label>
                        <select name="resetNor2MyKadSelect" id="resetNor2MyKadSelect" class="form-select form-select-lg mykadSelect">
                            <option value="1">MyKad No.</option>
                            <option value="2">Passport No.</option>
                        </select>
                    </div>
                    <div class="col-12 fv-plugins-icon-container mykadDiv">
                        <label class="form-label form-label-lg" for="resetNor2MyKad">MyKad No.:</label>
                        <input class="form-control form-control-lg mykad" type="text" id="resetNor2MyKad" name="resetNor2MyKad" value="" />
                    </div>
                    <div class="col-12 fv-plugins-icon-container passportDiv">
                        <label class="form-label form-label-lg" for="resetNor2resetNor1Passportno">Passport No.:</label>
                        <input class="form-control form-control-lg passport" type="text" id="resetNor2resetNor1Passportno" name="resetNor2resetNor1Passportno" value="" />
                    </div>
                    <div class="col-12 fv-plugins-icon-container">
                        <label class="form-label form-label-lg" for="resetNor2contact">Contact No.:</label>
                        <input class="form-control form-control-lg" type="number" id="resetNor2contact" name="resetNor2contact" value="" />
                    </div>
                    <div class="col-12 fv-plugins-icon-container">
                        <label class="form-label form-label-lg" for="resetNor2email">Email Address:</label>
                        <input class="form-control form-control-lg" type="text" id="resetNor2email" name="resetNor2email" value="" />
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="submit2">Submit</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                    <div id="chgreq2-msg" style="padding-top:10px;"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="{{ asset('frontend/js/pages/official-representative.js') }}"></script>
<script>
    nor1url = "{{ route('official-representative.new1') }}";
</script>
@endsection
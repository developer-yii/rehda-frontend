@extends('layouts.auth')

@section('auth-css')
<link href="{{ asset('frontend/css/pages/choosecompany.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('frontend/css/pages/membership.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')


<div class="lopgBox">
    <a href="">
        <img src="{{ asset('assets/img/rehda-logo.svg') }}" alt="">
    </a>
</div>
<div class="container mb-4">
    <div class="card mt-1 mb-5">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h3 class="card-title mb-3">New Member Registration</h3>
            <a href="{{ route('login') }}">BACK TO HOME PAGE <i class="ti ti-arrow-right"></i></a>
        </div>

        <div class="choose-company-section section-padding mb-5">

            <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
            <div class="row mt-4 p-2">
                <!-- Navigation -->
                <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3 register-box">
                    <h4>Type of Membership Applying for</h4>
                    <div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
                        <ul class="nav nav-align-left nav-pills flex-column">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#ordinary">
                                    <span class="align-middle fw-medium">Ordinary</span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#subsidiary">
                                    <span class="align-middle fw-medium">Subsidiary / Related</span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#affiliate">
                                    <span class="align-middle fw-medium">Affiliate</span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#associate">
                                    <span class="align-middle fw-medium">Associate</span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rehdayouth">
                                    <span class="align-middle fw-medium">Rehda Youth</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /Navigation -->

                <!-- FAQ's -->
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="tab-content py-0">

                        <div class="tab-pane fade show active" id="ordinary" role="tabpanel">
                            <div id="accordionOrdinary" class="accordion">

                                <form method="POST" action="{{ route('ordinary.register') }}" name="ordinary-membership-form" enctype="multipart/form-data">
                                    @csrf

                                    <div class="card accordion-item active">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                aria-expanded="true"
                                                data-bs-target="#ordinary-general-information"
                                                aria-controls="ordinary-general-information">
                                                General Information
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>

                                        <div id="ordinary-general-information" class="accordion-collapse collapse show" data-bs-parent="#accordionOrdinary">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCompanyPreferBranch" class="form-label form-label-lg required_label">Preferred Branch</label>
                                                        <select class="form-select form-select-lg" id="ordinaryCompanyPreferBranch" name="ordinaryCompanyPreferBranch">
                                                            <option value="" selected disabled>Select Preferred Branch</option>
                                                            @foreach($branches as $branch)
                                                            <option value="{{ $branch->bid }}" {{ $branch->bid == old('ordinaryCompanyPreferBranch') ? 'selected' : '' }}>{{ $branch->bname }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryCompanyPreferBranch'))
                                                        <span class="error">{{ $errors->first('ordinaryCompanyPreferBranch') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCompanyName" class="form-label form-label-lg required_label">Company Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryCompanyName" name="ordinaryCompanyName" value="{{ old('ordinaryCompanyName') }}" />
                                                        @if ($errors->has('ordinaryCompanyName'))
                                                        <span class="error">{{ $errors->first('ordinaryCompanyName') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCompanyAddress" class="form-label form-label-lg required_label">Address:</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryCompanyAddress" name="ordinaryCompanyAddress" value="{{ old('ordinaryCompanyAddress') }}" />
                                                        @if ($errors->has('ordinaryCompanyAddress'))
                                                        <span class="error">{{ $errors->first('ordinaryCompanyAddress') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCompanyAddressCity" class="form-label form-label-lg required_label">City:</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryCompanyAddressCity" name="ordinaryCompanyAddressCity" value="{{ old('ordinaryCompanyAddressCity') }}" />
                                                        @if ($errors->has('ordinaryCompanyAddressCity'))
                                                        <span class="error">{{ $errors->first('ordinaryCompanyAddressCity') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCompanyAddressState" class="form-label form-label-lg required_label">State:</label>
                                                        <select id="ordinaryCompanyAddressState" name="ordinaryCompanyAddressState" class="form-select form-select-lg">
                                                            <option value="">Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('ordinaryCompanyAddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryCompanyAddressState'))
                                                        <span class="error">{{ $errors->first('ordinaryCompanyAddressState') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCompanyAddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryCompanyAddressPc" name="ordinaryCompanyAddressPc" value="{{ old('ordinaryCompanyAddressPc') }}" />
                                                        @if ($errors->has('ordinaryCompanyAddressPc'))
                                                        <span class="error">{{ $errors->first('ordinaryCompanyAddressPc') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCompanyAddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="ordinaryCompanyAddressCountry" name="ordinaryCompanyAddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('ordinaryCompanyAddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryCompanyAddressCountry'))
                                                        <span class="error">{{ $errors->first('ordinaryCompanyAddressCountry') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficialWebsite" class="form-label form-label-lg required_label">Official Website</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficialWebsite" name="ordinaryOfficialWebsite" value="{{ old('ordinaryOfficialWebsite') }}" />
                                                        @if ($errors->has('ordinaryOfficialWebsite'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficialWebsite') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficialNumber" class="form-label form-label-lg required_label">Office No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="ordinaryOfficialNumber" name="ordinaryOfficialNumber" value="{{ old('ordinaryOfficialNumber') }}" />
                                                        @if ($errors->has('ordinaryOfficialNumber'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficialNumber') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryFaxNumber" class="form-label form-label-lg">Fax No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="ordinaryFaxNumber" name="ordinaryFaxNumber" value="{{ old('ordinaryFaxNumber') }}" />
                                                        @if ($errors->has('ordinaryFaxNumber'))
                                                        <span class="error">{{ $errors->first('ordinaryFaxNumber') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinarySSMRegNumber" class="form-label form-label-lg required_label">SSM Registration No.</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinarySSMRegNumber" name="ordinarySSMRegNumber" value="{{ old('ordinarySSMRegNumber') }}" />
                                                        @if ($errors->has('ordinarySSMRegNumber'))
                                                        <span class="error">{{ $errors->first('ordinarySSMRegNumber') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryDateOfCompanyFormation" class="form-label form-label-lg required_label">Date of Company Formation</label>
                                                        <input class="form-control form-control-lg" type="date" id="ordinaryDateOfCompanyFormation" name="ordinaryDateOfCompanyFormation" value="{{ old('ordinaryDateOfCompanyFormation') }}" />
                                                        @if ($errors->has('ordinaryDateOfCompanyFormation'))
                                                        <span class="error">{{ $errors->first('ordinaryDateOfCompanyFormation') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryLatestPaidUpCapital" class="form-label form-label-lg required_label">Latest Paid-Up Capital</label>
                                                        <select id="ordinaryLatestPaidUpCapital" name="ordinaryLatestPaidUpCapital" class="form-select form-select-lg">
                                                            @foreach($paidups as $paidup)
                                                            <option value="{{ $paidup->pt_id }}" {{ $paidup->pt_id == old('ordinaryLatestPaidUpCapital') ? 'selected' : '' }}>{{ $paidup->pt_desc }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryLatestPaidUpCapital'))
                                                        <span class="error">{{ $errors->first('ordinaryLatestPaidUpCapital') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCopySSMCert" class="form-label form-label-lg required_label">Attachment: Copy of SSM Certification</label>
                                                        <input class="form-control form-control-lg" type="file" id="ordinaryCopySSMCert" name="ordinaryCopySSMCert" value="" accept="application/pdf" />
                                                        @if ($errors->has('ordinaryCopySSMCert'))
                                                        <span class="error">{{ $errors->first('ordinaryCopySSMCert') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCopyForm24" class="form-label form-label-lg">Attachment: Copy of Form 24</label>
                                                        <input class="form-control form-control-lg" type="file" id="ordinaryCopyForm24" name="ordinaryCopyForm24" value="" accept="application/pdf" />
                                                        @if ($errors->has('ordinaryCopyForm24'))
                                                        <span class="error">{{ $errors->first('ordinaryCopyForm24') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCopyForm49" class="form-label form-label-lg">Attachment: Copy of Form 49</label>
                                                        <input class="form-control form-control-lg" type="file" id="ordinaryCopyForm49" name="ordinaryCopyForm49" value="" accept="application/pdf" />
                                                        @if ($errors->has('ordinaryCopyForm49'))
                                                        <span class="error">{{ $errors->first('ordinaryCopyForm49') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCopyOfAnnualReturn" class="form-label form-label-lg required_label">Attachment: Copy of Annual Return</label>
                                                        <input class="form-control form-control-lg" type="file" id="ordinaryCopyOfAnnualReturn" name="ordinaryCopyOfAnnualReturn" value="" accept="application/pdf" />
                                                        @if ($errors->has('ordinaryCopyOfAnnualReturn'))
                                                        <span class="error">{{ $errors->first('ordinaryCopyOfAnnualReturn') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryHouseDevelopingLicense" class="form-label form-label-lg required_label">Housing Developer's Licence No.</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryHouseDevelopingLicense" name="ordinaryHouseDevelopingLicense" value="{{ old('ordinaryHouseDevelopingLicense') }}" />
                                                        @if ($errors->has('ordinaryHouseDevelopingLicense'))
                                                        <span class="error">{{ $errors->first('ordinaryHouseDevelopingLicense') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryCopyOfHousingDeveloperLicense" class="form-label form-label-lg required_label">Attachment: Copy of Housing Developer's Licence No.</label>
                                                        <input class="form-control form-control-lg" type="file" id="ordinaryCopyOfHousingDeveloperLicense" name="ordinaryCopyOfHousingDeveloperLicense" value="" accept="application/pdf" />
                                                        @if ($errors->has('ordinaryCopyOfHousingDeveloperLicense'))
                                                        <span class="error">{{ $errors->first('ordinaryCopyOfHousingDeveloperLicense') }}</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#ordinary-company-admin"
                                                aria-controls="ordinary-company-admin">
                                                Company Admin
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>
                                        <div id="ordinary-company-admin" class="accordion-collapse collapse" data-bs-parent="#accordionOrdinary">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryAdminTitle" class="form-label form-label-lg">Title</label>
                                                        <select id="ordinaryAdminTitle" name="ordinaryAdminTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('ordinaryAdminTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryAdminTitle'))
                                                        <span class="error">{{ $errors->first('ordinaryAdminTitle') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryNameOfAdmin" class="form-label form-label-lg required_label">Admin Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryNameOfAdmin" name="ordinaryNameOfAdmin" value="{{ old('ordinaryNameOfAdmin') }}" />
                                                        @if ($errors->has('ordinaryNameOfAdmin'))
                                                        <span class="error">{{ $errors->first('ordinaryNameOfAdmin') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryAdminDesignation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryAdminDesignation" name="ordinaryAdminDesignation" value="{{ old('ordinaryAdminDesignation') }}" />
                                                        @if ($errors->has('ordinaryAdminDesignation'))
                                                        <span class="error">{{ $errors->first('ordinaryAdminDesignation') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryAdminEmail" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="ordinaryAdminEmail" name="ordinaryAdminEmail" value="{{ old('ordinaryAdminEmail') }}" />
                                                        @if ($errors->has('ordinaryAdminEmail'))
                                                        <span class="error">{{ $errors->first('ordinaryAdminEmail') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryAdminContactNumber" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="ordinaryAdminContactNumber" name="ordinaryAdminContactNumber" value="{{ old('ordinaryAdminContactNumber') }}" />
                                                        @if ($errors->has('ordinaryAdminContactNumber'))
                                                        <span class="error">{{ $errors->first('ordinaryAdminContactNumber') }}</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#ordinary-official-representative-1"
                                                aria-controls="ordinary-official-representative-1">
                                                Official Representative 1
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>
                                        <div id="ordinary-official-representative-1" class="accordion-collapse collapse" data-bs-parent="#accordionOrdinary">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1Title" class="form-label form-label-lg required_label">Title</label>
                                                        <select id="ordinaryOfficial1Title" name="ordinaryOfficial1Title" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('ordinaryOfficial1Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryOfficial1Title'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1Title') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1Nop" class="form-label form-label-lg required_label">Official Representative 1 Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1Nop" name="ordinaryOfficial1Nop" value="{{ old('ordinaryOfficial1Nop') }}" />
                                                        @if ($errors->has('ordinaryOfficial1Nop'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1Nop') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryMyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="ordinaryMyKad" name="ordinaryMyKad" value="{{ old('ordinaryMyKad') }}" />
                                                        @if ($errors->has('ordinaryMyKad'))
                                                        <span class="error">{{ $errors->first('ordinaryMyKad') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1Designation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1Designation" name="ordinaryOfficial1Designation" value="{{ old('ordinaryOfficial1Designation') }}" />
                                                        @if ($errors->has('ordinaryOfficial1Designation'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1Designation') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryGender" class="form-label form-label-lg required_label">Gender:</label>
                                                        <br>
                                                        @foreach($genders as $gender)
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="radio" name="ordinaryGender" id="{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('ordinaryGender') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="{{ $gender->gid }}">{{ $gender->gname }}</label>
                                                        </div>
                                                        @endforeach
                                                        @if ($errors->has('ordinaryGender'))
                                                        <br>
                                                        <span class="error">{{ $errors->first('ordinaryGender') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1ProQualification" name="ordinaryOfficial1ProQualification" value="{{ old('ordinaryOfficial1ProQualification') }}" />
                                                        @if ($errors->has('ordinaryOfficial1ProQualification'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1ProQualification') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1Email" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="ordinaryOfficial1Email" name="ordinaryOfficial1Email" value="{{ old('ordinaryOfficial1Email') }}" />
                                                        @if ($errors->has('ordinaryOfficial1Email'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1Email') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1Contact" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="ordinaryOfficial1Contact" name="ordinaryOfficial1Contact" value="{{ old('ordinaryOfficial1Contact') }}" />
                                                        @if ($errors->has('ordinaryOfficial1Contact'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1Contact') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1Address" class="form-label form-label-lg required_label">Correspondence Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1Address" name="ordinaryOfficial1Address" value="{{ old('ordinaryOfficial1Address') }}" />
                                                        @if ($errors->has('ordinaryOfficial1Address'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1Address') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1AddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1AddressCity" name="ordinaryOfficial1AddressCity" value="{{ old('ordinaryOfficial1AddressCity') }}" />
                                                        @if ($errors->has('ordinaryOfficial1AddressCity'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1AddressCity') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1AddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="ordinaryOfficial1AddressState" name="ordinaryOfficial1AddressState" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('ordinaryOfficial1AddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryOfficial1AddressState'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1AddressState') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1AddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1AddressPc" name="ordinaryOfficial1AddressPc" value="{{ old('ordinaryOfficial1AddressPc') }}" />
                                                        @if ($errors->has('ordinaryOfficial1AddressPc'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1AddressPc') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1AddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="ordinaryOfficial1AddressCountry" name="ordinaryOfficial1AddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('ordinaryOfficial1AddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryOfficial1AddressCountry'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1AddressCountry') }}</span>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1SecretartTitle" class="form-label form-label-lg">Secretary Title</label>
                                                        <select id="ordinaryOfficial1SecretartTitle" name="ordinaryOfficial1SecretartTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('ordinaryOfficial1SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryOfficial1SecretartTitle'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1SecretartTitle') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1SecretarName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1SecretarName" name="ordinaryOfficial1SecretarName" value="{{ old('ordinaryOfficial1SecretarName') }}" />
                                                        @if ($errors->has('ordinaryOfficial1SecretarName'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1SecretarName') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="ordinaryOfficial1SecretartEmail" name="ordinaryOfficial1SecretartEmail" value="{{ old('ordinaryOfficial1SecretartEmail') }}" />
                                                        @if ($errors->has('ordinaryOfficial1SecretartEmail'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1SecretartEmail') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial1SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="ordinaryOfficial1SecretartContact" name="ordinaryOfficial1SecretartContact" value="{{ old('ordinaryOfficial1SecretartContact') }}" />
                                                        @if ($errors->has('ordinaryOfficial1SecretartContact'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial1SecretartContact') }}</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#ordinary-official-representative-2"
                                                aria-controls="ordinary-official-representative-2">
                                                Official Representative 2
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>
                                        <div id="ordinary-official-representative-2" class="accordion-collapse collapse" data-bs-parent="#accordionOrdinary">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2Title" class="form-label form-label-lg required_label">Title</label>
                                                        <select id="ordinaryOfficial2Title" name="ordinaryOfficial2Title" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('ordinaryOfficial2Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryOfficial2Title'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2Title') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2Nop" class="form-label form-label-lg required_label">Official Representative 2 Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2Nop" name="ordinaryOfficial2Nop" value="{{ old('ordinaryOfficial2Nop') }}" />
                                                        @if ($errors->has('ordinaryOfficial2Nop'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2Nop') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryMyKad2" class="form-label form-label-lg required_label">MyKad No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="ordinaryMyKad2" name="ordinaryMyKad2" value="{{ old('ordinaryMyKad2') }}" />
                                                        @if ($errors->has('ordinaryMyKad2'))
                                                        <span class="error">{{ $errors->first('ordinaryMyKad2') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2Designation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2Designation" name="ordinaryOfficial2Designation" value="{{ old('ordinaryOfficial2Designation') }}" />
                                                        @if ($errors->has('ordinaryOfficial2Designation'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2Designation') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2Gender" class="form-label form-label-lg required_label">Gender:</label>
                                                        <br>
                                                        @foreach($genders as $gender)
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="radio" name="ordinaryOfficial2Gender" id="ordinaryOfficial2Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('ordinaryOfficial2Gender') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="ordinaryOfficial2Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                                        </div>
                                                        @endforeach
                                                        @if ($errors->has('ordinaryOfficial2Gender'))
                                                        <br>
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2Gender') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2ProQualification" name="ordinaryOfficial2ProQualification" value="{{ old('ordinaryOfficial2ProQualification') }}" />
                                                        @if ($errors->has('ordinaryOfficial2ProQualification'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2ProQualification') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2Email" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="ordinaryOfficial2Email" name="ordinaryOfficial2Email" value="{{ old('ordinaryOfficial2Email') }}" />
                                                        @if ($errors->has('ordinaryOfficial2Email'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2Email') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2Contact" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="ordinaryOfficial2Contact" name="ordinaryOfficial2Contact" value="{{ old('ordinaryOfficial2Contact') }}" />
                                                        @if ($errors->has('ordinaryOfficial2Contact'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2Contact') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2Address" class="form-label form-label-lg required_label">Correspondence Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2Address" name="ordinaryOfficial2Address" value="{{ old('ordinaryOfficial2Address') }}" />
                                                        @if ($errors->has('ordinaryOfficial2Address'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2Address') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2AddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2AddressCity" name="ordinaryOfficial2AddressCity" value="{{ old('ordinaryOfficial2AddressCity') }}" />
                                                        @if ($errors->has('ordinaryOfficial2AddressCity'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2AddressCity') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2AddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="ordinaryOfficial2AddressState" name="ordinaryOfficial2AddressState" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('ordinaryOfficial2AddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryOfficial2AddressState'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2AddressState') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2AddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2AddressPc" name="ordinaryOfficial2AddressPc" value="{{ old('ordinaryOfficial2AddressPc') }}" />
                                                        @if ($errors->has('ordinaryOfficial2AddressPc'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2AddressPc') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2AddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="ordinaryOfficial2AddressCountry" name="ordinaryOfficial2AddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('ordinaryOfficial2AddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryOfficial2AddressCountry'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2AddressCountry') }}</span>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2SecretartTitle" class="form-label form-label-lg">Secretary Title</label>
                                                        <select id="ordinaryOfficial2SecretartTitle" name="ordinaryOfficial2SecretartTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('ordinaryOfficial2SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('ordinaryOfficial2SecretartTitle'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2SecretartTitle') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2SecretartName" name="ordinaryOfficial2SecretartName" value="{{ old('ordinaryOfficial2SecretartName') }}" />
                                                        @if ($errors->has('ordinaryOfficial2SecretartName'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2SecretartName') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="ordinaryOfficial2SecretartEmail" name="ordinaryOfficial2SecretartEmail" value="{{ old('ordinaryOfficial2SecretartEmail') }}" />
                                                        @if ($errors->has('ordinaryOfficial2SecretartEmail'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2SecretartEmail') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="ordinaryOfficial2SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="ordinaryOfficial2SecretartContact" name="ordinaryOfficial2SecretartContact" value="{{ old('ordinaryOfficial2SecretartContact') }}" />
                                                        @if ($errors->has('ordinaryOfficial2SecretartContact'))
                                                        <span class="error">{{ $errors->first('ordinaryOfficial2SecretartContact') }}</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-4">
                                        <button type="submit" class="btn btn-lg btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                                    </div>

                                </form>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="subsidiary" role="tabpanel">
                            <div id="accordionSubsidiary" class="accordion">

                                <form method="POST" action="{{ route('subsidiary.register') }}" name="subsidiary-membership-form" enctype="multipart/form-data">
                                    @csrf

                                    <div class="card accordion-item active">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                aria-expanded="true"
                                                data-bs-target="#subsidiary-general-information"
                                                aria-controls="subsidiary-general-information">
                                                General Information
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>

                                        <div id="subsidiary-general-information" class="accordion-collapse collapse show" data-bs-parent="#accordionSubsidiary">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCompanyPreferBranch" class="form-label form-label-lg required_label">Preferred Branch</label>
                                                        <select class="form-select form-select-lg" id="subsidiaryCompanyPreferBranch" name="subsidiaryCompanyPreferBranch">
                                                            <option value="" selected disabled>Select Preferred Branch</option>
                                                            @foreach($branches as $branch)
                                                            <option value="{{ $branch->bid }}" {{ $branch->bid == old('subsidiaryCompanyPreferBranch') ? 'selected' : '' }}>{{ $branch->bname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOrdinaryMembershipNumber" class="form-label form-label-lg required_label">REHDA Ordinary Membership No.</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryOrdinaryMembershipNumber" name="subsidiaryOrdinaryMembershipNumber" value="{{ old('subsidiaryOrdinaryMembershipNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCompanyName" class="form-label form-label-lg required_label">Company Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryCompanyName" name="subsidiaryCompanyName" value="{{ old('subsidiaryCompanyName') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCompanyAddress" class="form-label form-label-lg required_label">Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryCompanyAddress" name="subsidiaryCompanyAddress" value="{{ old('subsidiaryCompanyAddress') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCompanyAddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryCompanyAddressCity" name="subsidiaryCompanyAddressCity" value="{{ old('subsidiaryCompanyAddressCity') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCompanyAddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="subsidiaryCompanyAddressState" name="subsidiaryCompanyAddressState" class="form-select form-select-lg">
                                                            <option value="">Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('subsidiaryCompanyAddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCompanyAddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryCompanyAddressPc" name="subsidiaryCompanyAddressPc" value="{{ old('subsidiaryCompanyAddressPc') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCompanyAddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="subsidiaryCompanyAddressCountry" name="subsidiaryCompanyAddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('subsidiaryCompanyAddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficialWebsite" class="form-label form-label-lg required_label">Official Website</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryOfficialWebsite" name="subsidiaryOfficialWebsite" value="{{ old('subsidiaryOfficialWebsite') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficialNumber" class="form-label form-label-lg required_label">Office No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="subsidiaryOfficialNumber" name="subsidiaryOfficialNumber" value="{{ old('subsidiaryOfficialNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryFaxNumber" class="form-label form-label-lg">Fax No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="subsidiaryFaxNumber" name="subsidiaryFaxNumber" value="{{ old('subsidiaryFaxNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiarySSMRegNumber" class="form-label form-label-lg required_label">SSM Registration No.</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiarySSMRegNumber" name="subsidiarySSMRegNumber" value="{{ old('subsidiarySSMRegNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryDateOfCompanyFormation" class="form-label form-label-lg required_label">Date of Company Formation</label>
                                                        <input class="form-control form-control-lg" type="date" id="subsidiaryDateOfCompanyFormation" name="subsidiaryDateOfCompanyFormation" value="{{ old('subsidiaryDateOfCompanyFormation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryLatestPaidUpCapital" class="form-label form-label-lg required_label">Latest Paid-Up Capital</label>
                                                        <select id="subsidiaryLatestPaidUpCapital" name="subsidiaryLatestPaidUpCapital" class="form-select form-select-lg">
                                                            @foreach($paidups as $paidup)
                                                            <option value="{{ $paidup->pt_id }}" {{ $paidup->pt_id == old('subsidiaryLatestPaidUpCapital') ? 'selected' : '' }}>{{ $paidup->pt_desc }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCopySSMCert" class="form-label form-label-lg required_label">Attachment: Copy of SSM Certification</label>
                                                        <input class="form-control form-control-lg" type="file" id="subsidiaryCopySSMCert" name="subsidiaryCopySSMCert" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCopyForm24" class="form-label form-label-lg">Attachment: Copy of Form 24</label>
                                                        <input class="form-control form-control-lg" type="file" id="subsidiaryCopyForm24" name="subsidiaryCopyForm24" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCopyForm49" class="form-label form-label-lg">Attachment: Copy of Form 49</label>
                                                        <input class="form-control form-control-lg" type="file" id="subsidiaryCopyForm49" name="subsidiaryCopyForm49" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCopyOfAnnualReturn" class="form-label form-label-lg required_label">Attachment: Copy of Annual Return</label>
                                                        <input class="form-control form-control-lg" type="file" id="subsidiaryCopyOfAnnualReturn" name="subsidiaryCopyOfAnnualReturn" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryHouseDevelopingLicense" class="form-label form-label-lg required_label">Housing Developer's Licence No.</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryHouseDevelopingLicense" name="subsidiaryHouseDevelopingLicense" value="{{ old('subsidiaryHouseDevelopingLicense') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryCopyOfHousingDeveloperLicense" class="form-label form-label-lg required_label">Attachment: Copy of Housing Developer's Licence No.</label>
                                                        <input class="form-control form-control-lg" type="file" id="subsidiaryCopyOfHousingDeveloperLicense" name="subsidiaryCopyOfHousingDeveloperLicense" value="" accept="application/pdf" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#subsidiary-company-admin"
                                                aria-controls="subsidiary-company-admin">
                                                Company Admin
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>
                                        <div id="subsidiary-company-admin" class="accordion-collapse collapse" data-bs-parent="#accordionSubsidiary">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryAdminTitle" class="form-label form-label-lg">Title</label>
                                                        <select id="subsidiaryAdminTitle" name="subsidiaryAdminTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('subsidiaryAdminTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryNameOfAdmin" class="form-label form-label-lg required_label">Admin Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryNameOfAdmin" name="subsidiaryNameOfAdmin" value="{{ old('subsidiaryNameOfAdmin') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryAdminDesignation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryAdminDesignation" name="subsidiaryAdminDesignation" value="{{ old('subsidiaryAdminDesignation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryAdminEmail" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="subsidiaryAdminEmail" name="subsidiaryAdminEmail" value="{{ old('subsidiaryAdminEmail') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryAdminContactNumber" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="subsidiaryAdminContactNumber" name="subsidiaryAdminContactNumber" value="{{ old('subsidiaryAdminContactNumber') }}" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#subsidiary-official-representative-1"
                                                aria-controls="subsidiary-official-representative-1">
                                                Official Representative 1
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>
                                        <div id="subsidiary-official-representative-1" class="accordion-collapse collapse" data-bs-parent="#accordionSubsidiary">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1Title" class="form-label form-label-lg required_label">Title</label>
                                                        <select id="subsidiaryOfficial1Title" name="subsidiaryOfficial1Title" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('subsidiaryOfficial1Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1Nop" class="form-label form-label-lg required_label">Official Representative 1 Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1Nop" name="subsidiaryOfficial1Nop" value="{{ old('subsidiaryOfficial1Nop') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryMyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="subsidiaryMyKad" name="subsidiaryMyKad" value="{{ old('subsidiaryMyKad') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1Designation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1Designation" name="subsidiaryOfficial1Designation" value="{{ old('subsidiaryOfficial1Designation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1Gender" class="form-label form-label-lg required_label">Gender:</label>
                                                        <br>
                                                        @foreach($genders as $gender)
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="radio" name="subsidiaryOfficial1Gender" id="subsidiaryOfficial1Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('subsidiaryOfficial1Gender') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="subsidiaryOfficial1Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1ProQualification" name="subsidiaryOfficial1ProQualification" value="{{ old('subsidiaryOfficial1ProQualification') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1Email" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="subsidiaryOfficial1Email" name="subsidiaryOfficial1Email" value="{{ old('subsidiaryOfficial1Email') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1Contact" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="subsidiaryOfficial1Contact" name="subsidiaryOfficial1Contact" value="{{ old('subsidiaryOfficial1Contact') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1Address" class="form-label form-label-lg required_label">Correspondence Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1Address" name="subsidiaryOfficial1Address" value="{{ old('subsidiaryOfficial1Address') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1AddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1AddressCity" name="subsidiaryOfficial1AddressCity" value="{{ old('subsidiaryOfficial1AddressCity') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1AddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="subsidiaryOfficial1AddressState" name="subsidiaryOfficial1AddressState" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('subsidiaryOfficial1AddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1AddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1AddressPc" name="subsidiaryOfficial1AddressPc" value="{{ old('subsidiaryOfficial1AddressPc') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1AddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="subsidiaryOfficial1AddressCountry" name="subsidiaryOfficial1AddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('subsidiaryOfficial1AddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1SecretartTitle" class="form-label form-label-lg">Title</label>
                                                        <select id="subsidiaryOfficial1SecretartTitle" name="subsidiaryOfficial1SecretartTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('subsidiaryOfficial1SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1SecretartName" name="subsidiaryOfficial1SecretartName" value="{{ old('subsidiaryOfficial1SecretartName') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="subsidiaryOfficial1SecretartEmail" name="subsidiaryOfficial1SecretartEmail" value="{{ old('subsidiaryOfficial1SecretartEmail') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="subsidiaryOfficial1SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="subsidiaryOfficial1SecretartContact" name="subsidiaryOfficial1SecretartContact" value="{{ old('subsidiaryOfficial1SecretartContact') }}" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-4">
                                        <button type="submit" class="btn btn-lg btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="affiliate" role="tabpanel">
                            <div id="accordionAffiliate" class="accordion">

                                <form method="POST" action="{{ route('affiliate.register') }}" name="affiliate-membership-form" enctype="multipart/form-data">
                                    @csrf

                                    <div class="card accordion-item active">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                aria-expanded="true"
                                                data-bs-target="#affiliate-general-information"
                                                aria-controls="affiliate-general-information">
                                                General Information
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>

                                        <div id="affiliate-general-information" class="accordion-collapse collapse show" data-bs-parent="#accordionAffiliate">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCompanyPreferBranch" class="form-label form-label-lg required_label">Preferred Branch</label>
                                                        <select class="form-select form-select-lg" id="affiliateCompanyPreferBranch" name="affiliateCompanyPreferBranch">
                                                            <option value="" selected disabled>Select Preferred Branch</option>
                                                            @foreach($branches as $branch)
                                                            <option value="{{ $branch->bid }}" {{ $branch->bid == old('affiliateCompanyPreferBranch') ? 'selected' : '' }}>{{ $branch->bname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOrdinaryMembershipNumber" class="form-label form-label-lg required_label">REHDA Ordinary Membership No.</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOrdinaryMembershipNumber" name="affiliateOrdinaryMembershipNumber" value="{{ old('affiliateOrdinaryMembershipNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCompanyName" class="form-label form-label-lg required_label">Company Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateCompanyName" name="affiliateCompanyName" value="{{ old('affiliateCompanyName') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCompanyAddress" class="form-label form-label-lg required_label">Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateCompanyAddress" name="affiliateCompanyAddress" value="{{ old('affiliateCompanyAddress') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCompanyAddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateCompanyAddressCity" name="affiliateCompanyAddressCity" value="{{ old('affiliateCompanyAddressCity') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCompanyAddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="affiliateCompanyAddressState" name="affiliateCompanyAddressState" class="form-select form-select-lg">
                                                            <option value="">Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('affiliateCompanyAddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCompanyAddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateCompanyAddressPc" name="affiliateCompanyAddressPc" value="{{ old('affiliateCompanyAddressPc') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCompanyAddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="affiliateCompanyAddressCountry" name="affiliateCompanyAddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('affiliateCompanyAddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficialWebsite" class="form-label form-label-lg required_label">Official Website</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficialWebsite" name="affiliateOfficialWebsite" value="{{ old('affiliateOfficialWebsite') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficialNumber" class="form-label form-label-lg required_label">Office No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="affiliateOfficialNumber" name="affiliateOfficialNumber" value="{{ old('affiliateOfficialNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateFaxNumber" class="form-label form-label-lg">Fax No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="affiliateFaxNumber" name="affiliateFaxNumber" value="{{ old('affiliateFaxNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateSSMRegNumber" class="form-label form-label-lg required_label">SSM Registration No.</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateSSMRegNumber" name="affiliateSSMRegNumber" value="{{ old('affiliateSSMRegNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateDateOfCompanyFormation" class="form-label form-label-lg required_label">Date of Company Formation</label>
                                                        <input class="form-control form-control-lg" type="date" id="affiliateDateOfCompanyFormation" name="affiliateDateOfCompanyFormation" value="{{ old('affiliateDateOfCompanyFormation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateLatestPaidUpCapital" class="form-label form-label-lg required_label">Latest Paid-Up Capital</label>
                                                        <select id="affiliateLatestPaidUpCapital" name="affiliateLatestPaidUpCapital" class="form-select form-select-lg">
                                                            @foreach($paidups as $paidup)
                                                            <option value="{{ $paidup->pt_id }}" {{ $paidup->pt_id == old('affiliateLatestPaidUpCapital') ? 'selected' : '' }}>{{ $paidup->pt_desc }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCopySSMCert" class="form-label form-label-lg required_label">Attachment: Copy of SSM Certification</label>
                                                        <input class="form-control form-control-lg" type="file" id="affiliateCopySSMCert" name="affiliateCopySSMCert" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCopyForm24" class="form-label form-label-lg">Attachment: Copy of Form 24</label>
                                                        <input class="form-control form-control-lg" type="file" id="affiliateCopyForm24" name="affiliateCopyForm24" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCopyForm49" class="form-label form-label-lg">Attachment: Copy of Form 49</label>
                                                        <input class="form-control form-control-lg" type="file" id="affiliateCopyForm49" name="affiliateCopyForm49" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCopyOfAnnualReturn" class="form-label form-label-lg required_label">Attachment: Copy of Annual Return</label>
                                                        <input class="form-control form-control-lg" type="file" id="affiliateCopyOfAnnualReturn" name="affiliateCopyOfAnnualReturn" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateHouseDevelopingLicense" class="form-label form-label-lg required_label">Housing Developer's Licence No.</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateHouseDevelopingLicense" name="affiliateHouseDevelopingLicense" value="{{ old('affiliateHouseDevelopingLicense') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateCopyOfHousingDeveloperLicense" class="form-label form-label-lg required_label">Attachment: Copy of Housing Developer's Licence No.</label>
                                                        <input class="form-control form-control-lg" type="file" id="affiliateCopyOfHousingDeveloperLicense" name="affiliateCopyOfHousingDeveloperLicense" value="" accept="application/pdf" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#affiliate-company-admin"
                                                aria-controls="affiliate-company-admin">
                                                Company Admin
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>
                                        <div id="affiliate-company-admin" class="accordion-collapse collapse" data-bs-parent="#accordionAffiliate">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateAdminTitle" class="form-label form-label-lg">Title</label>
                                                        <select id="affiliateAdminTitle" name="affiliateAdminTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('affiliateAdminTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateNameOfAdmin" class="form-label form-label-lg required_label">Admin Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateNameOfAdmin" name="affiliateNameOfAdmin" value="{{ old('affiliateNameOfAdmin') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateAdminDesignation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateAdminDesignation" name="affiliateAdminDesignation" value="{{ old('affiliateAdminDesignation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateAdminEmail" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="affiliateAdminEmail" name="affiliateAdminEmail" value="{{ old('affiliateAdminEmail') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateAdminContactNumber" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="affiliateAdminContactNumber" name="affiliateAdminContactNumber" value="{{ old('affiliateAdminContactNumber') }}" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                aria-controls="affiliate-official-representative-1"
                                                data-bs-target="#affiliate-official-representative-1">
                                                Official Representative 1
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>
                                        <div id="affiliate-official-representative-1" class="accordion-collapse collapse" data-bs-parent="#accordionAffiliate">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1Title" class="form-label form-label-lg required_label">Title</label>
                                                        <select id="affiliateOfficial1Title" name="affiliateOfficial1Title" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('affiliateOfficial1Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1Nop" class="form-label form-label-lg required_label">Official Representative 1 Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial1Nop" name="affiliateOfficial1Nop" value="{{ old('affiliateOfficial1Nop') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateMyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="affiliateMyKad" name="affiliateMyKad" value="{{ old('affiliateMyKad') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1Designation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial1Designation" name="affiliateOfficial1Designation" value="{{ old('affiliateOfficial1Designation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1Gender" class="form-label form-label-lg required_label">Gender:</label>
                                                        <br>
                                                        @foreach($genders as $gender)
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="radio" name="affiliateOfficial1Gender" id="affiliateOfficial1Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('affiliateOfficial1Gender') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="affiliateOfficial1Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial1ProQualification" name="affiliateOfficial1ProQualification" value="{{ old('affiliateOfficial1ProQualification') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1Email" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="affiliateOfficial1Email" name="affiliateOfficial1Email" value="{{ old('affiliateOfficial1Email') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1Contact" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="affiliateOfficial1Contact" name="affiliateOfficial1Contact" value="{{ old('affiliateOfficial1Contact') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1Address" class="form-label form-label-lg required_label">Correspondence Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial1Address" name="affiliateOfficial1Address" value="{{ old('affiliateOfficial1Address') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1AddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial1AddressCity" name="affiliateOfficial1AddressCity" value="{{ old('affiliateOfficial1AddressCity') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1AddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="affiliateOfficial1AddressState" name="affiliateOfficial1AddressState" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('affiliateOfficial1AddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1AddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial1AddressPc" name="affiliateOfficial1AddressPc" value="{{ old('affiliateOfficial1AddressPc') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1AddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="affiliateOfficial1AddressCountry" name="affiliateOfficial1AddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('affiliateOfficial1AddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1SecretartTitle" class="form-label form-label-lg">Title</label>
                                                        <select id="affiliateOfficial1SecretartTitle" name="affiliateOfficial1SecretartTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('affiliateOfficial1SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial1SecretartName" name="affiliateOfficial1SecretartName" value="{{ old('affiliateOfficial1SecretartName') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="affiliateOfficial1SecretartEmail" name="affiliateOfficial1SecretartEmail" value="{{ old('affiliateOfficial1SecretartEmail') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial1SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="affiliateOfficial1SecretartContact" name="affiliateOfficial1SecretartContact" value="{{ old('affiliateOfficial1SecretartContact') }}" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                aria-controls="affiliate-official-representative-2"
                                                data-bs-target="#affiliate-official-representative-2">
                                                Official Representative 2
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>
                                        <div id="affiliate-official-representative-2" class="accordion-collapse collapse" data-bs-parent="#accordionAffiliate">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2Title" class="form-label form-label-lg required_label">Title</label>
                                                        <select id="affiliateOfficial2Title" name="affiliateOfficial2Title" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('affiliateOfficial2Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2Nop" class="form-label form-label-lg required_label">Official Representative 2 Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial2Nop" name="affiliateOfficial2Nop" value="{{ old('affiliateOfficial2Nop') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateMyKad2" class="form-label form-label-lg required_label">MyKad No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="affiliateMyKad2" name="affiliateMyKad2" value="{{ old('affiliateMyKad2') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2Designation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial2Designation" name="affiliateOfficial2Designation" value="{{ old('affiliateOfficial2Designation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2Gender" class="form-label form-label-lg required_label">Gender:</label>
                                                        <br>
                                                        @foreach($genders as $gender)
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="radio" name="affiliateOfficial2Gender" id="affiliateOfficial2Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('affiliateOfficial2Gender') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="affiliateOfficial2Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial2ProQualification" name="affiliateOfficial2ProQualification" value="{{ old('affiliateOfficial2ProQualification') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2Email" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="affiliateOfficial2Email" name="affiliateOfficial2Email" value="{{ old('affiliateOfficial2Email') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2Contact" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="affiliateOfficial2Contact" name="affiliateOfficial2Contact" value="{{ old('affiliateOfficial2Contact') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2Address" class="form-label form-label-lg required_label">Correspondence Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial2Address" name="affiliateOfficial2Address" value="{{ old('affiliateOfficial2Address') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2AddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial2AddressCity" name="affiliateOfficial2AddressCity" value="{{ old('affiliateOfficial2AddressCity') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2AddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="affiliateOfficial2AddressState" name="affiliateOfficial2AddressState" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('affiliateOfficial2AddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2AddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial2AddressPc" name="affiliateOfficial2AddressPc" value="{{ old('affiliateOfficial2AddressPc') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2AddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="affiliateOfficial2AddressCountry" name="affiliateOfficial2AddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('affiliateOfficial2AddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2SecretartTitle" class="form-label form-label-lg">Title</label>
                                                        <select id="affiliateOfficial2SecretartTitle" name="affiliateOfficial2SecretartTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('affiliateOfficial2SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="affiliateOfficial2SecretartName" name="affiliateOfficial2SecretartName" value="{{ old('affiliateOfficial2SecretartName') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="affiliateOfficial2SecretartEmail" name="affiliateOfficial2SecretartEmail" value="{{ old('affiliateOfficial2SecretartEmail') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="affiliateOfficial2SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="affiliateOfficial2SecretartContact" name="affiliateOfficial2SecretartContact" value="{{ old('affiliateOfficial2SecretartContact') }}" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-4">
                                        <button type="submit" class="btn btn-lg btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="associate" role="tabpanel">
                            <div id="accordionAssociate" class="accordion">

                                <form method="POST" action="{{ route('associate.register') }}" name="associate-membership-form" enctype="multipart/form-data">
                                    @csrf

                                    <div class="card accordion-item active">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                aria-expanded="true"
                                                data-bs-target="#associate-general-information"
                                                aria-controls="associate-general-information">
                                                General Information
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>

                                        <div id="associate-general-information" class="accordion-collapse collapse show" data-bs-parent="#accordionAssociate">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCompanyPreferBranch" class="form-label form-label-lg required_label">Preferred Branch</label>
                                                        <select class="form-select form-select-lg" id="associateCompanyPreferBranch" name="associateCompanyPreferBranch">
                                                            <option value="" selected disabled>Select Preferred Branch</option>
                                                            @foreach($branches as $branch)
                                                            <option value="{{ $branch->bid }}" {{ $branch->bid == old('associateCompanyPreferBranch') ? 'selected' : '' }}>{{ $branch->bname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateAccType" class="form-label form-label-lg required_label">Account Type:</label>
                                                        <br>
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="radio" name="associateAccType" id="associateAccType1" value="1" checked>
                                                            <label class="form-check-label" for="associateAccType1">Company</label>
                                                        </div>
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="radio" name="associateAccType" id="associateAccType2" value="2">
                                                            <label class="form-check-label" for="associateAccType2">Company</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCompanyName" class="form-label form-label-lg required_label">Company Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateCompanyName" name="associateCompanyName" value="{{ old('associateCompanyName') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCompanyAddress" class="form-label form-label-lg required_label">Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateCompanyAddress" name="associateCompanyAddress" value="{{ old('associateCompanyAddress') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCompanyAddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateCompanyAddressCity" name="associateCompanyAddressCity" value="{{ old('associateCompanyAddressCity') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCompanyAddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="associateCompanyAddressState" name="associateCompanyAddressState" class="form-select form-select-lg">
                                                            <option value="">Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('associateCompanyAddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCompanyAddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateCompanyAddressPc" name="associateCompanyAddressPc" value="{{ old('associateCompanyAddressPc') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCompanyAddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="associateCompanyAddressCountry" name="associateCompanyAddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('associateCompanyAddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficialWebsite" class="form-label form-label-lg required_label">Official Website</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficialWebsite" name="associateOfficialWebsite" value="{{ old('associateOfficialWebsite') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficialNumber" class="form-label form-label-lg required_label">Office No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="associateOfficialNumber" name="associateOfficialNumber" value="{{ old('associateOfficialNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateFaxNumber" class="form-label form-label-lg">Fax No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="associateFaxNumber" name="associateFaxNumber" value="{{ old('associateFaxNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateSSMRegNumber" class="form-label form-label-lg required_label">SSM Registration No.</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateSSMRegNumber" name="associateSSMRegNumber" value="{{ old('associateSSMRegNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateDateOfCompanyFormation" class="form-label form-label-lg required_label">Date of Company Formation</label>
                                                        <input class="form-control form-control-lg" type="date" id="associateDateOfCompanyFormation" name="associateDateOfCompanyFormation" value="{{ old('associateDateOfCompanyFormation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateLatestPaidUpCapital" class="form-label form-label-lg required_label">Latest Paid-Up Capital</label>
                                                        <select id="associateLatestPaidUpCapital" name="associateLatestPaidUpCapital" class="form-select form-select-lg">
                                                            @foreach($paidups as $paidup)
                                                            <option value="{{ $paidup->pt_id }}" {{ $paidup->pt_id == old('associateLatestPaidUpCapital') ? 'selected' : '' }}>{{ $paidup->pt_desc }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCopySSMCertLabel" class="form-label form-label-lg required_label">Attachment: Copy of SSM Certification</label>
                                                        <input class="form-control form-control-lg" type="file" id="associateCopySSMCert" name="associateCopySSMCert" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCopyForm24" class="form-label form-label-lg">Attachment: Copy of Form 24</label>
                                                        <input class="form-control form-control-lg" type="file" id="associateCopyForm24" name="associateCopyForm24" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCopyForm49" class="form-label form-label-lg">Attachment: Copy of Form 49</label>
                                                        <input class="form-control form-control-lg" type="file" id="associateCopyForm49" name="associateCopyForm49" value="" accept="application/pdf" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateCopyOfAnnualReturn" class="form-label form-label-lg required_label">Attachment: Copy of Annual Return</label>
                                                        <input class="form-control form-control-lg" type="file" id="associateCopyOfAnnualReturn" name="associateCopyOfAnnualReturn" value="" accept="application/pdf" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#associate-company-admin"
                                                aria-controls="associate-company-admin">
                                                Company Admin
                                                <div class="requiredtitle">
                                                    <span class="badge bg-danger ms-2">Required</span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="associate-company-admin" class="accordion-collapse collapse" data-bs-parent="#accordionAssociate">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateAdminTitle" class="form-label form-label-lg">Title</label>
                                                        <select id="associateAdminTitle" name="associateAdminTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('associateAdminTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateNameOfAdmin" class="form-label form-label-lg required_label">Admin Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateNameOfAdmin" name="associateNameOfAdmin" value="{{ old('associateNameOfAdmin') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateAdminDesignation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateAdminDesignation" name="associateAdminDesignation" value="{{ old('associateAdminDesignation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateAdminEmail" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="associateAdminEmail" name="associateAdminEmail" value="{{ old('associateAdminEmail') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateAdminContactNumber" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="associateAdminContactNumber" name="associateAdminContactNumber" value="{{ old('associateAdminContactNumber') }}" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#associate-official-representative-1"
                                                aria-controls="associate-official-representative-1">
                                                Official Representative 1
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>
                                        <div id="associate-official-representative-1" class="accordion-collapse collapse" data-bs-parent="#accordionAssociate">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1Title" class="form-label form-label-lg required_label">Title</label>
                                                        <select id="associateOfficial1Title" name="associateOfficial1Title" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('associateOfficial1Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1Nop" class="form-label form-label-lg required_label">Official Representative 1 Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial1Nop" name="associateOfficial1Nop" value="{{ old('associateOfficial1Nop') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1MyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="associateOfficial1MyKad" name="associateOfficial1MyKad" value="{{ old('associateOfficial1MyKad') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1Designation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial1Designation" name="associateOfficial1Designation" value="{{ old('associateOfficial1Designation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1Gender" class="form-label form-label-lg required_label">Gender:</label>
                                                        <br>
                                                        @foreach($genders as $gender)
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="radio" name="associateOfficial1Gender" id="associateOfficial1Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('associateOfficial1Gender') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="associateOfficial1Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial1ProQualification" name="associateOfficial1ProQualification" value="{{ old('associateOfficial1ProQualification') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1Email" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="associateOfficial1Email" name="associateOfficial1Email" value="{{ old('associateOfficial1Email') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1Contact" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="associateOfficial1Contact" name="associateOfficial1Contact" value="{{ old('associateOfficial1Contact') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1Address" class="form-label form-label-lg required_label">Correspondence Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial1Address" name="associateOfficial1Address" value="{{ old('associateOfficial1Address') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1AddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial1AddressCity" name="associateOfficial1AddressCity" value="{{ old('associateOfficial1AddressCity') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1AddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="associateOfficial1AddressState" name="associateOfficial1AddressState" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('associateOfficial1AddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1AddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial1AddressPc" name="associateOfficial1AddressPc" value="{{ old('associateOfficial1AddressPc') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1Country" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="associateOfficial1Country" name="associateOfficial1Country" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('associateOfficial1Country') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1SecretartTitle" class="form-label form-label-lg">Title</label>
                                                        <select id="associateOfficial1SecretartTitle" name="associateOfficial1SecretartTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('associateOfficial1SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial1SecretartName" name="associateOfficial1SecretartName" value="{{ old('associateOfficial1SecretartName') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="associateOfficial1SecretartEmail" name="associateOfficial1SecretartEmail" value="{{ old('associateOfficial1SecretartEmail') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial1SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="associateOfficial1SecretartContact" name="associateOfficial1SecretartContact" value="{{ old('associateOfficial1SecretartContact') }}" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#associate-official-representative-2"
                                                aria-controls="associate-official-representative-2">
                                                Official Representative 2
                                                <div class="requiredtitle">
                                                    <span class="badge bg-danger ms-2">Required</span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="associate-official-representative-2" class="accordion-collapse collapse" data-bs-parent="#accordionAssociate">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2Title" class="form-label form-label-lg required_label">Title</label>
                                                        <select id="associateOfficial2Title" name="associateOfficial2Title" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('associateOfficial2Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2Nop" class="form-label form-label-lg required_label">Official Representative 2 Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial2Nop" name="associateOfficial2Nop" value="{{ old('associateOfficial2Nop') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2MyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="associateOfficial2MyKad" name="associateOfficial2MyKad" value="{{ old('associateOfficial2MyKad') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2Designation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial2Designation" name="associateOfficial2Designation" value="{{ old('associateOfficial2Designation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2Gender" class="form-label form-label-lg required_label">Gender:</label>
                                                        <br>
                                                        @foreach($genders as $gender)
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="radio" name="associateOfficial2Gender" id="associateOfficial2Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('associateOfficial2Gender') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="associateOfficial2Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial2ProQualification" name="associateOfficial2ProQualification" value="{{ old('associateOfficial2ProQualification') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2Email" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="associateOfficial2Email" name="associateOfficial2Email" value="{{ old('associateOfficial2Email') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2Contact" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="associateOfficial2Contact" name="associateOfficial2Contact" value="{{ old('associateOfficial2Contact') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2Address" class="form-label form-label-lg required_label">Correspondence Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial2Address" name="associateOfficial2Address" value="{{ old('associateOfficial2Address') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2AddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial2AddressCity" name="associateOfficial2AddressCity" value="{{ old('associateOfficial2AddressCity') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2AddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="associateOfficial2AddressState" name="associateOfficial2AddressState" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('associateOfficial2AddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2AddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial2AddressPc" name="associateOfficial2AddressPc" value="{{ old('associateOfficial2AddressPc') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2AddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="associateOfficial2AddressCountry" name="associateOfficial2AddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('associateOfficial2AddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2SecretartTitle" class="form-label form-label-lg">Title</label>
                                                        <select id="associateOfficial2SecretartTitle" name="associateOfficial2SecretartTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('associateOfficial2SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="associateOfficial2SecretartName" name="associateOfficial2SecretartName" value="{{ old('associateOfficial2SecretartName') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="associateOfficial2SecretartEmail" name="associateOfficial2SecretartEmail" value="{{ old('associateOfficial2SecretartEmail') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="associateOfficial2SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="associateOfficial2SecretartContact" name="associateOfficial2SecretartContact" value="{{ old('associateOfficial2SecretartContact') }}" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-4">
                                        <button type="submit" class="btn btn-lg btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="rehdayouth" role="tabpanel">
                            <div id="accordionRehdayouth" class="accordion">

                                <form method="POST" action="{{ route('rehdayouth.register') }}" name="rehdayouth-membership-form" enctype="multipart/form-data">
                                    @csrf

                                    <div class="card accordion-item active">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                aria-expanded="true"
                                                data-bs-target="#accordionProduct-1"
                                                aria-controls="accordionProduct-1">
                                                General Information
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>

                                        <div id="accordionProduct-1" class="accordion-collapse collapse show" data-bs-parent="#accordionRehdayouth">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOrdinaryMembershipNumber" class="form-label form-label-lg required_label">REHDA Ordinary Membership No.</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthOrdinaryMembershipNumber" name="rehdaYouthOrdinaryMembershipNumber" value="{{ old('rehdaYouthOrdinaryMembershipNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthCompanyName" class="form-label form-label-lg required_label">Company Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthCompanyName" name="rehdaYouthCompanyName" value="{{ old('rehdaYouthCompanyName') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthCompanyAddress" class="form-label form-label-lg required_label">Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthCompanyAddress" name="rehdaYouthCompanyAddress" value="{{ old('rehdaYouthCompanyAddress') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthCompanyAddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthCompanyAddressCity" name="rehdaYouthCompanyAddressCity" value="{{ old('rehdaYouthCompanyAddressCity') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthCompanyAddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="rehdaYouthCompanyAddressState" name="rehdaYouthCompanyAddressState" class="form-select form-select-lg">
                                                            <option value="">Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('rehdaYouthCompanyAddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthCompanyAddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthCompanyAddressPc" name="rehdaYouthCompanyAddressPc" value="{{ old('rehdaYouthCompanyAddressPc') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthCompanyAddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="rehdaYouthCompanyAddressCountry" name="rehdaYouthCompanyAddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('rehdaYouthCompanyAddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficialWebsite" class="form-label form-label-lg required_label">Official Website</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficialWebsite" name="rehdaYouthOfficialWebsite" value="{{ old('rehdaYouthOfficialWebsite') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficialNumber" class="form-label form-label-lg required_label">Office No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="rehdaYouthOfficialNumber" name="rehdaYouthOfficialNumber" value="{{ old('rehdaYouthOfficialNumber') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthFaxNumber" class="form-label form-label-lg">Fax No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="rehdaYouthFaxNumber" name="rehdaYouthFaxNumber" value="{{ old('rehdaYouthFaxNumber') }}" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#accordionProduct-2"
                                                aria-controls="accordionProduct-2">
                                                Official Representative 1
                                                <span class="badge bg-danger ms-2">Required</span>
                                            </button>
                                        </h2>
                                        <div id="accordionProduct-2" class="accordion-collapse collapse" data-bs-parent="#accordionRehdayouth">
                                            <div class="card-body">
                                                <div class="row mt-3">
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1Title" class="form-label form-label-lg required_label">Title</label>
                                                        <select id="rehdaYouthOfficial1Title" name="rehdaYouthOfficial1Title" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('rehdaYouthOfficial1Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1Nop" class="form-label form-label-lg required_label">Official Representative 1 Name</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1Nop" name="rehdaYouthOfficial1Nop" value="{{ old('rehdaYouthOfficial1Nop') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1MyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="rehdaYouthOfficial1MyKad" name="rehdaYouthOfficial1MyKad" value="{{ old('rehdaYouthOfficial1MyKad') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1Designation" class="form-label form-label-lg required_label">Designation</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1Designation" name="rehdaYouthOfficial1Designation" value="{{ old('rehdaYouthOfficial1Designation') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1Gender" class="form-label form-label-lg required_label">Gender:</label>
                                                        <br>
                                                        @foreach($genders as $gender)
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="radio" name="rehdaYouthOfficial1Gender" id="rehdaYouthOfficial1Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('rehdaYouthOfficial1Gender') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="rehdaYouthOfficial1Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1ProQualification" name="rehdaYouthOfficial1ProQualification" value="{{ old('rehdaYouthOfficial1ProQualification') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1Email" class="form-label form-label-lg required_label">Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="rehdaYouthOfficial1Email" name="rehdaYouthOfficial1Email" value="{{ old('rehdaYouthOfficial1Email') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1Contact" class="form-label form-label-lg required_label">Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="rehdaYouthOfficial1Contact" name="rehdaYouthOfficial1Contact" value="{{ old('rehdaYouthOfficial1Contact') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1Address" class="form-label form-label-lg required_label">Correspondence Address</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1Address" name="rehdaYouthOfficial1Address" value="{{ old('rehdaYouthOfficial1Address') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1AddressCity" class="form-label form-label-lg required_label">City</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1AddressCity" name="rehdaYouthOfficial1AddressCity" value="{{ old('rehdaYouthOfficial1AddressCity') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1AddressState" class="form-label form-label-lg required_label">State</label>
                                                        <select id="rehdaYouthOfficial1AddressState" name="rehdaYouthOfficial1AddressState" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select State</option>
                                                            @foreach($states as $state)
                                                            <option value="{{ $state->state_id }}" {{ $state->state_id == old('rehdaYouthOfficial1AddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1AddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1AddressPc" name="rehdaYouthOfficial1AddressPc" value="{{ old('rehdaYouthOfficial1AddressPc') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1AddressCountry" class="form-label form-label-lg required_label">Country</label>
                                                        <select id="rehdaYouthOfficial1AddressCountry" name="rehdaYouthOfficial1AddressCountry" class="form-select form-select-lg">
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->country_id }}" {{ $country->country_id == old('rehdaYouthOfficial1AddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1SecretartTitle" class="form-label form-label-lg">Title</label>
                                                        <select id="rehdaYouthOfficial1SecretartTitle" name="rehdaYouthOfficial1SecretartTitle" class="form-select form-select-lg">
                                                            <option value="" selected disabled>Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{ $title->sid }}" {{ $title->sid == old('rehdaYouthOfficial1SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                                        <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1SecretartName" name="rehdaYouthOfficial1SecretartName" value="{{ old('rehdaYouthOfficial1SecretartName') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdaYouthOfficial1SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                                        <input class="form-control form-control-lg" type="email" id="rehdaYouthOfficial1SecretartEmail" name="rehdaYouthOfficial1SecretartEmail" value="{{ old('rehdaYouthOfficial1SecretartEmail') }}" />
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label for="rehdarehdaYouthouthOfficial1SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                                        <input class="form-control form-control-lg" type="number" id="rehdarehdaYouthouthOfficial1SecretartContact" name="rehdarehdaYouthouthOfficial1SecretartContact" value="{{ old('rehdarehdaYouthouthOfficial1SecretartContact') }}" />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-4">
                                        <button type="submit" class="btn btn-lg btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /FAQ's -->
            </div>

        </div>
    </div>
</div>

@include('layouts.footer')

@endsection

@section('auth-js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="csrf-token"]').val()
            }
        });

        $("form[name='ordinary-membership-form']").validate({
            ignore: [],
            rules: {
                ordinaryCompanyPreferBranch: "required",
                ordinaryCompanyName: "required",
                ordinaryCompanyAddress: "required",
                ordinaryCompanyAddressCity: "required",
                ordinaryCompanyAddressState: "required",
                ordinaryCompanyAddressPc: "required",
                ordinaryCompanyAddressCountry: "required",
                ordinaryOfficialWebsite: "required",
                ordinaryOfficialNumber: "required",
                ordinarySSMRegNumber: "required",
                ordinaryDateOfCompanyFormation: "required",
                ordinaryLatestPaidUpCapital: "required",
                ordinaryCopySSMCert: "required",
                ordinaryCopyOfAnnualReturn: "required",
                ordinaryHouseDevelopingLicense: "required",
                ordinaryCopyOfHousingDeveloperLicense: "required",
                ordinaryNameOfAdmin: "required",
                ordinaryAdminTitle: "required",
                ordinaryAdminDesignation: "required",
                ordinaryAdminEmail: "required",
                ordinaryAdminContactNumber: "required",
                ordinaryOfficial1Nop: "required",
                ordinaryOfficial1Title: "required",
                ordinaryMyKad: "required",
                ordinaryOfficial1Designation: "required",
                ordinaryGender: "required",
                ordinaryOfficial1Email: {
                    required: true,
                    email: true
                },
                ordinaryOfficial1Contact: "required",
                ordinaryOfficial1Address: "required",
                ordinaryOfficial1AddressCity: "required",
                ordinaryOfficial1AddressState: "required",
                ordinaryOfficial1AddressPc: "required",
                ordinaryOfficial1AddressCountry: "required",
                ordinaryOfficial2Nop: "required",
                ordinaryOfficial2Title: "required",
                ordinaryMyKad2: "required",
                ordinaryOfficial2Designation: "required",
                ordinaryOfficial2Gender: "required",
                ordinaryOfficial2Email: {
                    required: true,
                    email: true
                },
                ordinaryOfficial2Contact: "required",
                ordinaryOfficial2Address: "required",
                ordinaryOfficial2AddressCity: "required",
                ordinaryOfficial2AddressState: "required",
                ordinaryOfficial2AddressPc: "required",
                ordinaryOfficial2AddressCountry: "required",
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });

                    // Remove 'active' class from all accordion items
                    $(".accordion-item").removeClass("active");

                    // Find the first error label, then find the closest card (accordion item)
                    $("form[name='ordinary-membership-form']").find('label.error:first').closest('div.accordion-item').children('div.accordion-collapse').collapse('show'); // Expand it

                    // Make the corresponding accordion button active
                    $("form[name='ordinary-membership-form']").find('label.error:first').closest('div.accordion-item').find('h2.accordion-header').find('button.accordion-button').removeClass('collapsed').addClass('active'); // Add the active class
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('type') == 'radio' || element.attr('type') == 'checkbox') {
                    error.insertAfter(element.parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {

                var formData = new FormData(form);

                $('.error-message').remove();
                // Clear any existing error messages
                $('.error-message').remove();
                $('.accordion-item').removeClass('active');
                $('.accordion-collapse').removeClass('show');

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    // data:$(form).serialize(),
                    data: formData,
                    processData: false, // Don't process the data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {

                        if (response.status == 1) {
                            //form[0].reset();
                            $("form[name='ordinary-membership-form']")[0].reset();
                            $('input[type="radio"]').prop('checked', false);
                            $('select').prop('selectedIndex', 0);
                            toastr.success(response.message, 'Success');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;

                        // Flag to track if an accordion item has been opened
                        var hasOpenedAccordion = false;

                        // Iterate through the errors
                        $.each(errors, function(field, message) {
                            if (!hasOpenedAccordion) {
                                var inputField = $("#" + field);

                                // Activate the accordion item related to the field with an error
                                var accordionItem = inputField.closest('.accordion-item');
                                accordionItem.addClass('active');
                                accordionItem.find('.accordion-collapse').addClass('show');

                                // Show the error message
                                var errorElement = $('<div class="error-message" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                                inputField.focus();

                                // Set the flag to true to prevent opening other accordion items
                                hasOpenedAccordion = true;
                            } else {
                                // If already opened, just show the error message without opening another accordion
                                var inputField = $("#" + field);
                                var errorElement = $('<div class="error-message" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                            }
                        });
                    }
                });
            }
        });

        $("form[name='subsidiary-membership-form']").validate({
            ignore: [],
            rules: {
                subsidiaryCompanyPreferBranch: "required",
                subsidiaryOrdinaryMembershipNumber: {
                    required: true,
                    minlength: 15
                },
                subsidiaryCompanyName: "required",
                subsidiaryCompanyAddress: "required",
                subsidiaryCompanyAddressCity: "required",
                subsidiaryCompanyAddressState: "required",
                subsidiaryCompanyAddressPc: "required",
                subsidiaryCompanyAddressCountry: "required",
                subsidiaryOfficialWebsite: "required",
                subsidiaryOfficialNumber: "required",
                subsidiarySSMRegNumber: "required",
                subsidiaryDateOfCompanyFormation: "required",
                subsidiaryLatestPaidUpCapital: "required",
                subsidiaryCopySSMCert: "required",
                subsidiaryCopyOfAnnualReturn: "required",
                subsidiaryHouseDevelopingLicense: "required",
                subsidiaryCopyOfHousingDeveloperLicense: "required",
                subsidiaryNameOfAdmin: "required",
                subsidiaryAdminTitle: "required",
                subsidiaryAdminDesignation: "required",
                subsidiaryAdminEmail: "required",
                subsidiaryAdminContactNumber: "required",
                subsidiaryOfficial1Nop: "required",
                subsidiaryOfficial1Title: "required",
                subsidiaryMyKad: "required",
                subsidiaryOfficial1Designation: "required",
                subsidiaryOfficial1Gender: "required",
                subsidiaryOfficial1Email: {
                    required: true,
                    email: true
                },
                subsidiaryOfficial1Contact: "required",
                subsidiaryOfficial1Address: "required",
                subsidiaryOfficial1AddressCity: "required",
                subsidiaryOfficial1AddressState: "required",
                subsidiaryOfficial1AddressPc: "required",
                subsidiaryOfficial1AddressCountry: "required"
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });

                    // Remove 'active' class from all accordion items
                    $(".accordion-item").removeClass("active");

                    // Find the first error label, then find the closest card (accordion item)
                    $("form[name='subsidiary-membership-form']").find('label.error:first').closest('div.accordion-item').children('div.accordion-collapse').collapse('show'); // Expand it

                    // Make the corresponding accordion button active
                    $("form[name='subsidiary-membership-form']").find('label.error:first').closest('div.accordion-item').find('h2.accordion-header').find('button.accordion-button').removeClass('collapsed').addClass('active'); // Add the active class
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('type') == 'radio' || element.attr('type') == 'checkbox') {
                    error.insertAfter(element.parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {

                var formData = new FormData(form);

                $('.error-message').remove();
                // Clear any existing error messages
                $('.error-message').remove();
                $('.accordion-item').removeClass('active');
                $('.accordion-collapse').removeClass('show');

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false, // Don't process the data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {

                        if (response.status == 1) {
                            $("form[name='subsidiary-membership-form']")[0].reset();
                            $('input[type="radio"]').prop('checked', false);
                            $('select').prop('selectedIndex', 0);
                            toastr.success(response.message, 'Success');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function(xhr) {

                        var errors = xhr.responseJSON.errors;

                        // Flag to track if an accordion item has been opened
                        var hasOpenedAccordion = false;

                        // Iterate through the errors
                        $.each(errors, function(field, message) {
                            if (!hasOpenedAccordion) {
                                var inputField = $("#" + field);

                                // Activate the accordion item related to the field with an error
                                var accordionItem = inputField.closest('.accordion-item');
                                accordionItem.addClass('active');
                                accordionItem.find('.accordion-collapse').addClass('show');

                                // Show the error message
                                var errorElement = $('<div class="error-message" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                                inputField.focus();

                                // Set the flag to true to prevent opening other accordion items
                                hasOpenedAccordion = true;
                            } else {
                                // If already opened, just show the error message without opening another accordion
                                var inputField = $("#" + field);
                                var errorElement = $('<div class="error-message" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                            }
                        });
                    }
                });
            }

        });

        $("form[name='affiliate-membership-form']").validate({
            ignore: [],
            rules: {
                affiliateCompanyPreferBranch: "required",
                affiliateOrdinaryMembershipNumber: {
                    required: true,
                    minlength: 15
                },
                affiliateCompanyName: "required",
                affiliateCompanyAddress: "required",
                affiliateCompanyAddressCity: "required",
                affiliateCompanyAddressState: "required",
                affiliateCompanyAddressPc: "required",
                affiliateCompanyAddressCountry: "required",
                affiliateOfficialWebsite: "required",
                affiliateOfficialNumber: "required",
                affiliateSSMRegNumber: "required",
                affiliateDateOfCompanyFormation: "required",
                affiliateLatestPaidUpCapital: "required",
                affiliateCopySSMCert: "required",
                affiliateCopyOfAnnualReturn: "required",
                affiliateHouseDevelopingLicense: "required",
                affiliateCopyOfHousingDeveloperLicense: "required",
                affiliateNameOfAdmin: "required",
                affiliateAdminTitle: "required",
                affiliateAdminDesignation: "required",
                affiliateAdminEmail: "required",
                affiliateAdminContactNumber: "required",
                affiliateOfficial1Nop: "required",
                affiliateOfficial1Title: "required",
                affiliateMyKad: "required",
                affiliateOfficial1Designation: "required",
                affiliateOfficial1Gender: "required",
                affiliateOfficial1Email: {
                    required: true,
                    email: true
                },
                affiliateOfficial1Contact: "required",
                affiliateOfficial1Address: "required",
                affiliateOfficial1AddressCity: "required",
                affiliateOfficial1AddressState: "required",
                affiliateOfficial1AddressPc: "required",
                affiliateOfficial1AddressCountry: "required",
                affiliateOfficial2Nop: "required",
                affiliateOfficial2Title: "required",
                affiliateMyKad2: "required",
                affiliateOfficial2Designation: "required",
                affiliateOfficial2Gender: "required",
                affiliateOfficial2Email: {
                    required: true,
                    email: true
                },
                affiliateOfficial2Contact: "required",
                affiliateOfficial2Address: "required",
                affiliateOfficial2AddressCity: "required",
                affiliateOfficial2AddressState: "required",
                affiliateOfficial2AddressPc: "required",
                affiliateOfficial2AddressCountry: "required"
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });

                    // Remove 'active' class from all accordion items
                    $(".accordion-item").removeClass("active");

                    // Find the first error label, then find the closest card (accordion item)
                    $("form[name='affiliate-membership-form']").find('label.error:first').closest('div.accordion-item').children('div.accordion-collapse').collapse('show'); // Expand it

                    // Make the corresponding accordion button active
                    $("form[name='affiliate-membership-form']").find('label.error:first').closest('div.accordion-item').find('h2.accordion-header').find('button.accordion-button').removeClass('collapsed').addClass('active'); // Add the active class
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('type') == 'radio' || element.attr('type') == 'checkbox') {
                    error.insertAfter(element.parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {

                var formData = new FormData(form);

                $('.error-message').remove();
                // Clear any existing error messages
                $('.error-message').remove();
                $('.accordion-item').removeClass('active');
                $('.accordion-collapse').removeClass('show');

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false, // Don't process the data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {

                        if (response.status == 1) {
                            $("form[name='affiliate-membership-form']")[0].reset();
                            $('input[type="radio"]').prop('checked', false);
                            $('select').prop('selectedIndex', 0);
                            toastr.success(response.message, 'Success');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function(xhr) {

                        var errors = xhr.responseJSON.errors;

                        // Flag to track if an accordion item has been opened
                        var hasOpenedAccordion = false;

                        // Iterate through the errors
                        $.each(errors, function(field, message) {
                            if (!hasOpenedAccordion) {
                                var inputField = $("#" + field);

                                // Activate the accordion item related to the field with an error
                                var accordionItem = inputField.closest('.accordion-item');
                                accordionItem.addClass('active');
                                accordionItem.find('.accordion-collapse').addClass('show');

                                // Show the error message
                                var errorElement = $('<div class="error-message" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                                inputField.focus();

                                // Set the flag to true to prevent opening other accordion items
                                hasOpenedAccordion = true;
                            } else {
                                // If already opened, just show the error message without opening another accordion
                                var inputField = $("#" + field);
                                var errorElement = $('<div class="error-message" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                            }
                        });
                    }
                });
            }

        });

        $("input:radio[name='associateAccType']").on('change', function(e) {
            if ($(this).is(':checked') && $(this).val() == 1) {
                $('#associateSSMRegNumber').prop("disabled", false);
                $('#associateDateOfCompanyFormation').prop("disabled", false);
                $('#associateLatestPaidUpCapital').prop("disabled", false);
                $('#associateCopyForm24').prop("disabled", false);
                $('#associateCopyForm49').prop("disabled", false);
                $('#associateCopyOfAnnualReturn').prop("disabled", false);
                $('#associateCopySSMCert').prop("required", true);
                $('#associateCopySSMCertLabel').html('Attachment: Copy of SSM Certification <span>*</span>');
                $('#associateOffRep2Button').html('Official Representative 2 <span>Required</span>');
                $('#associateCompayAdminButton').html('Company Admin <span>Required</span>');
                $("#associate-official-representative-2 :input").attr("disabled", false);
                $("#associate-company-admin :input").attr("disabled", false);
                $(".requiredtitle").html('<span class="badge bg-danger ms-2">Required</span>');
            } else if ($(this).is(':checked') && $(this).val() == 2) {
                $('#associateSSMRegNumber').prop("disabled", true);
                $('#associateDateOfCompanyFormation').prop("disabled", true);
                $('#associateLatestPaidUpCapital').prop("disabled", true);
                $('#associateCopyForm24').prop("disabled", true);
                $('#associateCopyForm49').prop("disabled", true);
                $('#associateCopyOfAnnualReturn').prop("disabled", true);
                $('#associateCopySSMCert').prop("required", false);
                $('#associateCopySSMCertLabel').html('Attachment: Company Ownership Supporting Document');
                $('#associateOffRep2Button').html('Official Representative 2 <span style="background-color:darkgrey;">Not Applicable</span>');
                $('#associateCompayAdminButton').html('Company Admin <span style="background-color:darkgrey;">Not Applicable</span>');
                $("#associate-official-representative-2 :input").attr("disabled", true);
                $("#associate-company-admin :input").attr("disabled", true);
                $(".requiredtitle").html('<span class="badge bg-secondary ms-2">Not Applicable</span>');
            }
        });

        $("form[name='associate-membership-form']").validate({
            ignore: [],
            rules: {
                associateCompanyPreferBranch: "required",
                associateCompanyName: "required",
                associateCompanyAddress: "required",
                associateCompanyAddressCity: "required",
                associateCompanyAddressState: "required",
                associateCompanyAddressPc: "required",
                associateCompanyAddressCountry: "required",
                associateOfficialWebsite: "required",
                associateOfficialNumber: "required",
                associateSSMRegNumber: {
                    required: function(element) {
                        return $('input[name="associateAccType"]:checked').val() == "1";
                    }
                },
                associateDateOfCompanyFormation: {
                    required: function(element) {
                        return $('input[name="associateAccType"]:checked').val() == "1";
                    }
                },
                associateCopySSMCert: {
                    required: function(element) {
                        return $('input[name="associateAccType"]:checked').val() == "1";
                    }
                },
                associateCopyForm24: {
                    required: function(element) {
                        return $('input[name="associateAccType"]:checked').val() == "1";
                    }
                },
                associateCopyForm49: {
                    required: function(element) {
                        return $('input[name="associateAccType"]:checked').val() == "1";
                    }
                },
                associateCopyOfAnnualReturn: {
                    required: function(element) {
                        return $('input[name="associateAccType"]:checked').val() == "1";
                    }
                },

                associateNameOfAdmin: "required",
                associateAdminTitle: "required",
                associateAdminDesignation: "required",
                associateAdminEmail: {
                    required: true,
                    email: true
                },
                associateAdminContactNumber: "required",

                associateOfficial1Nop: "required",
                associateOfficial1Title: "required",
                associateOfficial1MyKad: "required",
                associateOfficial1Designation: "required",
                associateOfficial1Gender: "required",
                associateOfficial1Email: {
                    required: true,
                    email: true
                },
                associateOfficial1Contact: "required",
                associateOfficial1Address: "required",
                associateOfficial1AddressCity: "required",
                associateOfficial1AddressState: "required",
                associateOfficial1AddressPc: "required",
                associateOfficial1Country: "required",

                associateOfficial2Nop: "required",
                associateOfficial2Title: "required",
                associateOfficial2MyKad: "required",
                associateOfficial2Designation: "required",
                associateOfficial2Gender: "required",
                associateOfficial2Email: {
                    required: true,
                    email: true
                },
                associateOfficial2Contact: "required",
                associateOfficial2Address: "required",
                associateOfficial2AddressCity: "required",
                associateOfficial2AddressState: "required",
                associateOfficial2AddressPc: "required",
                associateOfficial2Country: "required",
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });

                    // Remove 'active' class from all accordion items
                    $(".accordion-item").removeClass("active");

                    // Find the first error label, then find the closest card (accordion item)
                    $("form[name='associate-membership-form']").find('label.error:first').closest('div.accordion-item').children('div.accordion-collapse').collapse('show'); // Expand it

                    // Make the corresponding accordion button active
                    $("form[name='associate-membership-form']").find('label.error:first').closest('div.accordion-item').find('h2.accordion-header').find('button.accordion-button').removeClass('collapsed').addClass('active'); // Add the active class
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('type') == 'radio' || element.attr('type') == 'checkbox') {
                    error.insertAfter(element.parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {

                var formData = new FormData(form);

                $('.error-message').remove();
                // Clear any existing error messages
                $('.error-message').remove();
                $('.accordion-item').removeClass('active');
                $('.accordion-collapse').removeClass('show');

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false, // Don't process the data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {

                        if (response.status == 1) {
                            $("form[name='associate-membership-form']")[0].reset();
                            $('input[type="radio"]').prop('checked', false);
                            $('select').prop('selectedIndex', 0);
                            toastr.success(response.message, 'Success');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function(xhr) {

                        var errors = xhr.responseJSON.errors;

                        // Flag to track if an accordion item has been opened
                        var hasOpenedAccordion = false;

                        // Iterate through the errors
                        $.each(errors, function(field, message) {
                            if (!hasOpenedAccordion) {
                                var inputField = $("#" + field);

                                // Activate the accordion item related to the field with an error
                                var accordionItem = inputField.closest('.accordion-item');
                                accordionItem.addClass('active');
                                accordionItem.find('.accordion-collapse').addClass('show');

                                // Show the error message
                                var errorElement = $('<div class="error-message" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                                inputField.focus();

                                // Set the flag to true to prevent opening other accordion items
                                hasOpenedAccordion = true;
                            } else {
                                // If already opened, just show the error message without opening another accordion
                                var inputField = $("#" + field);
                                var errorElement = $('<div class="error-message" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                            }
                        });
                    }
                });
            }

        });

        $("form[name='rehdayouth-membership-form']").validate({
            ignore: [],
            rules: {
                rehdaYouthOrdinaryMembershipNumber: {
                    required: true,
                    minlength: 15
                },
                rehdaYouthCompanyName: "required",
                rehdaYouthCompanyAddress: "required",
                rehdaYouthCompanyAddressCity: "required",
                rehdaYouthCompanyAddressState: "required",
                rehdaYouthCompanyAddressPc: "required",
                rehdaYouthCompanyAddressCountry: "required",
                rehdaYouthOfficialWebsite: "required",
                rehdaYouthOfficialNumber: "required",
                rehdaYouthOfficial1Nop: "required",
                rehdaYouthOfficial1Title: "required",
                rehdaYouthOfficial1MyKad: "required",
                rehdaYouthOfficial1Designation: "required",
                rehdaYouthOfficial1Gender: "required",
                rehdaYouthOfficial1Email: {
                    required: true,
                    email: true
                },
                rehdaYouthOfficial1Contact: "required",
                rehdaYouthOfficial1Address: "required",
                rehdaYouthOfficial1AddressCity: "required",
                rehdaYouthOfficial1AddressState: "required",
                rehdaYouthOfficial1AddressPc: "required",
                rehdaYouthOfficial1AddressCountry: "required"
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });

                    // Remove 'active' class from all accordion items
                    $(".accordion-item").removeClass("active");

                    // Find the first error label, then find the closest card (accordion item)
                    $("form[name='rehdayouth-membership-form']").find('label.error:first').closest('div.accordion-item').children('div.accordion-collapse').collapse('show'); // Expand it

                    // Make the corresponding accordion button active
                    $("form[name='rehdayouth-membership-form']").find('label.error:first').closest('div.accordion-item').find('h2.accordion-header').find('button.accordion-button').removeClass('collapsed').addClass('active'); // Add the active class
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('type') == 'radio' || element.attr('type') == 'checkbox') {
                    error.insertAfter(element.parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {

                var formData = new FormData(form);

                $('.error-message').remove();
                // Clear any existing error messages
                $('.error-message').remove();
                $('.accordion-item').removeClass('active');
                $('.accordion-collapse').removeClass('show');

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false, // Don't process the data
                    contentType: false, // Prevent jQuery from setting content type
                    success: function(response) {

                        if (response.status == 1) {
                            $("form[name='rehdayouth-membership-form']")[0].reset();
                            $('input[type="radio"]').prop('checked', false);
                            $('select').prop('selectedIndex', 0);
                            toastr.success(response.message, 'Success');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function(xhr) {

                        var errors = xhr.responseJSON.errors;

                        // Flag to track if an accordion item has been opened
                        var hasOpenedAccordion = false;

                        // Iterate through the errors
                        $.each(errors, function(field, message) {
                            if (!hasOpenedAccordion) {
                                var inputField = $("#" + field);

                                // Activate the accordion item related to the field with an error
                                var accordionItem = inputField.closest('.accordion-item');
                                accordionItem.addClass('active');
                                accordionItem.find('.accordion-collapse').addClass('show');

                                // Show the error message
                                var errorElement = $('<div class="error-message" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                                inputField.focus();

                                // Set the flag to true to prevent opening other accordion items
                                hasOpenedAccordion = true;
                            } else {
                                // If already opened, just show the error message without opening another accordion
                                var inputField = $("#" + field);
                                var errorElement = $('<div class="error-message" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                            }
                        });
                    }
                });
            }

        });

    });
</script>

@endsection
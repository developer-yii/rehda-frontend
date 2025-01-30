@extends('layouts.auth')

@section('auth-css')
<link href="{{ asset('frontend/css/pages/choosecompany.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('frontend/css/pages/membership.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend/assets/vendor/libs/bs-stepper/bs-stepper.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')


<div class="lopgBox">
    <a href="{{ route('login') }}">
        <img src="{{ asset('assets/img/rehda-logo.svg') }}" alt="">
    </a>
</div>
<div class="container mb-4">
    <div class="card mt-1 mb-5">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h3 class="card-title mb-3">New Member Registration</h3>
            <a href="{{ route('login') }}">BACK TO HOME PAGE <i class="ti ti-arrow-right"></i></a>
        </div>

        <div class="bs-stepper wizard-numbered">
            <div class="bs-stepper-header overflow-auto">
                <div class="step" data-target="#account-details">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Type of Membership</span>
                            <span class="bs-stepper-subtitle">Select Membership Type</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase ms-1">Required</span>
                </div>

                <div class="line ordinary-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step ordinary-head" data-target="#ordinary-general-information">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">General Information</span>
                            <span class="bs-stepper-subtitle">Add General Information</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line ordinary-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step ordinary-head" data-target="#ordinary-company-admin">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Company Admin</span>
                            <span class="bs-stepper-subtitle">Add Company Admin</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line ordinary-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step ordinary-head" data-target="#ordinary-official-representative-1">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">4</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Official Representative</span>
                            <span class="bs-stepper-subtitle">Add Official Representative</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line ordinary-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step ordinary-head" data-target="#ordinary-official-representative-2">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">5</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Alternate Representative</span>
                            <span class="bs-stepper-subtitle">Add Alternate Representative</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>


                <div class="line subsidiary-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step subsidiary-head" data-target="#subsidiary-general-information">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">General Information</span>
                            <span class="bs-stepper-subtitle">Add General Information</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line subsidiary-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step subsidiary-head" data-target="#subsidiary-company-admin">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Company Admin</span>
                            <span class="bs-stepper-subtitle">Add Company Admin</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line subsidiary-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step subsidiary-head" data-target="#subsidiary-official-representative-1">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">4</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Official Representative</span>
                            <span class="bs-stepper-subtitle">Add Official Representative</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>


                <div class="line affiliate-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step affiliate-head" data-target="#affiliate-general-information">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">General Information</span>
                            <span class="bs-stepper-subtitle">Add General Information</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line affiliate-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step affiliate-head" data-target="#affiliate-company-admin">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Company Admin</span>
                            <span class="bs-stepper-subtitle">Add Company Admin</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line affiliate-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step affiliate-head" data-target="#affiliate-official-representative-1">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">4</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Official Representative</span>
                            <span class="bs-stepper-subtitle">Add Official Representative</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line affiliate-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step affiliate-head" data-target="#affiliate-official-representative-2">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">5</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Alternate Representative</span>
                            <span class="bs-stepper-subtitle">Add Alternate Representative</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>


                <div class="line associate-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step associate-head" data-target="#associate-general-information">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">General Information</span>
                            <span class="bs-stepper-subtitle">Add General Information</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line associate-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step associate-head" data-target="#associate-company-admin">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Company Admin</span>
                            <span class="bs-stepper-subtitle">Add Company Admin</span>
                        </span>
                    </button>
                    <div class="requiredtitle">
                        <span class="badge bg-danger text-uppercase required-badge">Required</span>
                    </div>
                </div>
                <div class="line associate-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step associate-head" data-target="#associate-official-representative-1">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">4</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Official Representative</span>
                            <span class="bs-stepper-subtitle">Add Official Representative</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line associate-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step associate-head" data-target="#associate-official-representative-2">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">5</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Alternate Representative</span>
                            <span class="bs-stepper-subtitle">Add Alternate Representative</span>
                        </span>
                    </button>
                    <div class="requiredtitle">
                        <span class="badge bg-danger text-uppercase required-badge">Required</span>
                    </div>
                </div>


                <div class="line rehdayouth-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step rehdayouth-head" data-target="#rehdayouth-general-information">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">General Information</span>
                            <span class="bs-stepper-subtitle">Add General Information</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>
                <div class="line rehdayouth-head">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step rehdayouth-head" data-target="#rehdayouth-official-representative-1">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Official Representative</span>
                            <span class="bs-stepper-subtitle">Add Official Representative</span>
                        </span>
                    </button>
                    <span class="badge bg-danger text-uppercase required-badge">Required</span>
                </div>

            </div>
            <div class="bs-stepper-content">
                <div id="account-details" class="content">
                    <form method="POST" action="" name="membertype-form">
                        @csrf
                        <div class="row g-3">
                            <div class="mb-3 col-md-12">
                                <label for="membertype" class="form-label form-label-lg required_label">Type of Membership</label>
                                <!-- <select class="form-select form-select-lg" id="membertype" name="membertype">
                                    <option value="">Select Member Type</option>
                                    <option value="ordinary">Ordinary</option>
                                    <option value="subsidiary">Subsidiary / Related</option>
                                    <option value="affiliate">Affiliate</option>
                                    <option value="associate">Associate</option>
                                    <option value="rehdayouth">Rehda Youth</option>
                                </select> -->

                                <br><br>
                                <div class="form-check-inline">
                                    <input class="form-check-input membertype" type="radio" name="membertype" id="membertype-ordinary" value="ordinary">
                                    <label class="form-check-label form-label-lg ms-1" for="membertype-ordinary"><b>Ordinary Member</b></label>
                                    <p class="ms-4">Any person, company, firm or corporation who carries on the business of housing and property development and undertakes such development within 5 years of membership entry. A member shall belong to the branch of the Association in which it has principal housing project.</p>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input membertype" type="radio" name="membertype" id="membertype-subsidiary" value="subsidiary">
                                    <label class="form-check-label form-label-lg ms-1" for="membertype-subsidiary"><b>Subsidiary/Related Member</b></label>
                                    <p class="ms-4">An ordinary member who is a company, firm, or corporation who has subsidiaries or related companies, wishing to join the Association as subsidiary or related members. A subsidiary or related member shall not be entitled to vote or hold office.</p>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input membertype" type="radio" name="membertype" id="membertype-affiliate" value="affiliate">
                                    <label class="form-check-label form-label-lg ms-1" for="membertype-affiliate"><b>Affiliate Member</b></label>
                                    <p class="ms-4">An ordinary member with a branch office in another state may apply to be an Affiliate Member of the branch.</p>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input membertype" type="radio" name="membertype" id="membertype-associate" value="associate">
                                    <label class="form-check-label form-label-lg ms-1" for="membertype-associate"><b>Associate Member</b></label>
                                    <p class="ms-4">Any person, company, firm or corporation who carries on the business which is related to the business of housing and property development.</p>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input membertype" type="radio" name="membertype" id="membertype-rehdayouth" value="rehdayouth">
                                    <label class="form-check-label form-label-lg ms-1" for="membertype-rehdayouth"><b>REHDA Youth Member</b></label>
                                    <p class="ms-4">An executive employee of ordinary members, under the age of forty years, is eligible for REHDA Youth membership.
                                    <br>
                                    The REHDA Youth membership is limited to a maximum of two eligible employees for each ordinary member.</p>
                                </div>
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between mt-4">
                                <button class="btn btn-label-secondary btn-prev" disabled>
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1 membertype-next ">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <form method="POST" action="{{ route('ordinary.register') }}" name="ordinary-membership-form" enctype="multipart/form-data">
                @csrf
                    <div id="ordinary-general-information" class="content ordinary-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">General Information</h5>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCompanyPreferBranch" class="form-label form-label-lg required_label">Select Branch</label>
                                <select class="form-select form-select-lg" id="ordinaryCompanyPreferBranch" name="ordinaryCompanyPreferBranch">
                                    <option value="" selected disabled>Select Branch</option>
                                    @foreach($branches as $branch)
                                    <option value="{{ $branch->bid }}" {{ $branch->bid == old('ordinaryCompanyPreferBranch') ? 'selected' : '' }}>{{ $branch->bname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCompanyName" class="form-label form-label-lg required_label">Company Name</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryCompanyName" name="ordinaryCompanyName" value="{{ old('ordinaryCompanyName') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCompanyAddress" class="form-label form-label-lg required_label">Address Line 1</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryCompanyAddress" name="ordinaryCompanyAddress" value="{{ old('ordinaryCompanyAddress') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCompanyAddressCity" class="form-label form-label-lg required_label">Address Line 2</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryCompanyAddressCity" name="ordinaryCompanyAddressCity" value="{{ old('ordinaryCompanyAddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCompanyAddress3" class="form-label form-label-lg">Address Line 3</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryCompanyAddress3" name="ordinaryCompanyAddress3" value="{{ old('ordinaryCompanyAddress3') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCompanyAddressState" class="form-label form-label-lg required_label">State</label>
                                <select id="ordinaryCompanyAddressState" name="ordinaryCompanyAddressState" class="form-select form-select-lg">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->state_id }}" {{ $state->state_id == old('ordinaryCompanyAddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCompanyAddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryCompanyAddressPc" name="ordinaryCompanyAddressPc" value="{{ old('ordinaryCompanyAddressPc') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCompanyAddressCountry" class="form-label form-label-lg required_label">Country</label>
                                <select id="ordinaryCompanyAddressCountry" name="ordinaryCompanyAddressCountry" class="form-select form-select-lg">
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_id }}" {{ $country->country_id == old('ordinaryCompanyAddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficialWebsite" class="form-label form-label-lg">Official Website</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficialWebsite" name="ordinaryOfficialWebsite" value="{{ old('ordinaryOfficialWebsite') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficialNumber" class="form-label form-label-lg required_label">Office No.</label>
                                <input class="form-control form-control-lg" type="number" id="ordinaryOfficialNumber" name="ordinaryOfficialNumber" value="{{ old('ordinaryOfficialNumber') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryFaxNumber" class="form-label form-label-lg">Fax No.</label>
                                <input class="form-control form-control-lg" type="number" id="ordinaryFaxNumber" name="ordinaryFaxNumber" value="{{ old('ordinaryFaxNumber') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinarySSMRegNumber" class="form-label form-label-lg required_label">SSM Registration No.</label>
                                <input class="form-control form-control-lg" type="text" id="ordinarySSMRegNumber" name="ordinarySSMRegNumber" value="{{ old('ordinarySSMRegNumber') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryDateOfCompanyFormation" class="form-label form-label-lg required_label">Date of Company Formation</label>
                                <input class="form-control form-control-lg" type="date" id="ordinaryDateOfCompanyFormation" name="ordinaryDateOfCompanyFormation" value="{{ old('ordinaryDateOfCompanyFormation') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryLatestPaidUpCapital" class="form-label form-label-lg required_label">Latest Paid-Up Capital</label>
                                <select id="ordinaryLatestPaidUpCapital" name="ordinaryLatestPaidUpCapital" class="form-select form-select-lg">
                                    @foreach($paidups as $paidup)
                                    <option value="{{ $paidup->pt_id }}" {{ $paidup->pt_id == old('ordinaryLatestPaidUpCapital') ? 'selected' : '' }}>{{ $paidup->pt_desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCopySSMCert" class="form-label form-label-lg required_label">Attachment: Copy of SSM Certification</label>
                                <input class="form-control form-control-lg" type="file" id="ordinaryCopySSMCert" name="ordinaryCopySSMCert" value="" accept="application/pdf" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCopyForm24" class="form-label form-label-lg">Attachment: Copy of Form 24</label>
                                <input class="form-control form-control-lg" type="file" id="ordinaryCopyForm24" name="ordinaryCopyForm24" value="" accept="application/pdf" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCopyForm49" class="form-label form-label-lg">Attachment: Copy of Form 49</label>
                                <input class="form-control form-control-lg" type="file" id="ordinaryCopyForm49" name="ordinaryCopyForm49" value="" accept="application/pdf" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCopyOfAnnualReturn" class="form-label form-label-lg required_label">Attachment: Copy of Annual Return</label>
                                <input class="form-control form-control-lg" type="file" id="ordinaryCopyOfAnnualReturn" name="ordinaryCopyOfAnnualReturn" value="" accept="application/pdf" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryNominationForm" class="form-label form-label-lg required_label">Attachment: Nomination Form</label>
                                <input class="form-control form-control-lg" type="file" id="ordinaryNominationForm" name="ordinaryNominationForm" value="" accept="application/pdf" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryHouseDevelopingLicense" class="form-label form-label-lg required_label">Housing Developer's Licence No.</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryHouseDevelopingLicense" name="ordinaryHouseDevelopingLicense" value="{{ old('ordinaryHouseDevelopingLicense') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryCopyOfHousingDeveloperLicense" class="form-label form-label-lg required_label">Attachment: Copy of Housing Developer's Licence No.</label>
                                <input class="form-control form-control-lg" type="file" id="ordinaryCopyOfHousingDeveloperLicense" name="ordinaryCopyOfHousingDeveloperLicense" value="" accept="application/pdf" />
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next ordinary-general-information-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="ordinary-company-admin" class="content ordinary-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Company Admin</h5>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryAdminTitle" class="form-label form-label-lg required_label">Title</label>
                                <select id="ordinaryAdminTitle" name="ordinaryAdminTitle" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('ordinaryAdminTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryNameOfAdmin" class="form-label form-label-lg required_label">Admin Name</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryNameOfAdmin" name="ordinaryNameOfAdmin" value="{{ old('ordinaryNameOfAdmin') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryAdminDesignation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryAdminDesignation" name="ordinaryAdminDesignation" value="{{ old('ordinaryAdminDesignation') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryAdminEmail" class="form-label form-label-lg required_label">Email</label>
                                <input class="form-control form-control-lg" type="email" id="ordinaryAdminEmail" name="ordinaryAdminEmail" value="{{ old('ordinaryAdminEmail') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryAdminContactNumber" class="form-label form-label-lg required_label">Contact No.</label>
                                <input class="form-control form-control-lg" type="number" id="ordinaryAdminContactNumber" name="ordinaryAdminContactNumber" value="{{ old('ordinaryAdminContactNumber') }}" />
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next ordinary-company-admin-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="ordinary-official-representative-1" class="content ordinary-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Official Representative</h5>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1Title" class="form-label form-label-lg required_label">Title</label>
                                <select id="ordinaryOfficial1Title" name="ordinaryOfficial1Title" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('ordinaryOfficial1Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1Nop" class="form-label form-label-lg required_label">Official Representative Name</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1Nop" name="ordinaryOfficial1Nop" value="{{ old('ordinaryOfficial1Nop') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryMyKadSelect" class="form-label
                                form-label-lg required_label">Type of Identity</label>
                                <select id="ordinaryMyKadSelect" name="ordinaryMyKadSelect" class="form-select form-select-lg mykadSelect1">
                                    <option value="1">MyKad No.</option>
                                    <option value="2">Passport No.</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12 mykadDiv1">
                                <label for="ordinaryMyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                <input class="form-control form-control-lg mykad1" type="number" id="ordinaryMyKad" name="ordinaryMyKad" value="{{ old('ordinaryMyKad') }}" />
                            </div>
                            <div class="mb-3 col-md-12 passportDiv1">
                                <label for="ordinaryPassportno" class="form-label form-label-lg required_label">Passport No.</label>
                                <input class="form-control form-control-lg passport1" type="text" id="ordinaryPassportno" name="ordinaryPassportno" value="{{ old('ordinaryPassportno') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1Designation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1Designation" name="ordinaryOfficial1Designation" value="{{ old('ordinaryOfficial1Designation') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryGender" class="form-label form-label-lg required_label">Gender:</label>
                                <br>
                                @foreach($genders as $gender)
                                <div class="form-check-inline">
                                    <input class="form-check-input ordinaryGender" type="radio" name="ordinaryGender" id="{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('ordinaryGender') ? 'checked' : '' }}>
                                    <label class="form-check-label form-label-lg" for="{{ $gender->gid }}">{{ $gender->gname }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1ProQualification" name="ordinaryOfficial1ProQualification" value="{{ old('ordinaryOfficial1ProQualification') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1Email" class="form-label form-label-lg required_label">Email</label>
                                <input class="form-control form-control-lg" type="email" id="ordinaryOfficial1Email" name="ordinaryOfficial1Email" value="{{ old('ordinaryOfficial1Email') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1Contact" class="form-label form-label-lg required_label">Contact No.</label>
                                <input class="form-control form-control-lg" type="number" id="ordinaryOfficial1Contact" name="ordinaryOfficial1Contact" value="{{ old('ordinaryOfficial1Contact') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1Address" class="form-label form-label-lg required_label">Correspondence Address</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1Address" name="ordinaryOfficial1Address" value="{{ old('ordinaryOfficial1Address') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1AddressCity" class="form-label form-label-lg required_label">City</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1AddressCity" name="ordinaryOfficial1AddressCity" value="{{ old('ordinaryOfficial1AddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1AddressState" class="form-label form-label-lg required_label">State</label>
                                <select id="ordinaryOfficial1AddressState" name="ordinaryOfficial1AddressState" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select State</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->state_id }}" {{ $state->state_id == old('ordinaryOfficial1AddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1AddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1AddressPc" name="ordinaryOfficial1AddressPc" value="{{ old('ordinaryOfficial1AddressPc') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1AddressCountry" class="form-label form-label-lg required_label">Country</label>
                                <select id="ordinaryOfficial1AddressCountry" name="ordinaryOfficial1AddressCountry" class="form-select form-select-lg">
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_id }}" {{ $country->country_id == old('ordinaryOfficial1AddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1SecretartTitle" class="form-label form-label-lg">Secretary Title</label>
                                <select id="ordinaryOfficial1SecretartTitle" name="ordinaryOfficial1SecretartTitle" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('ordinaryOfficial1SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1SecretarName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial1SecretarName" name="ordinaryOfficial1SecretarName" value="{{ old('ordinaryOfficial1SecretarName') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                <input class="form-control form-control-lg" type="email" id="ordinaryOfficial1SecretartEmail" name="ordinaryOfficial1SecretartEmail" value="{{ old('ordinaryOfficial1SecretartEmail') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                <input class="form-control form-control-lg" type="number" id="ordinaryOfficial1SecretartContact" name="ordinaryOfficial1SecretartContact" value="{{ old('ordinaryOfficial1SecretartContact') }}" />
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next ordinary-official-representative-1-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="ordinary-official-representative-2" class="content ordinary-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Alternate Representative</h5>
                        </div>
                        <div class="row g3">
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2Title" class="form-label form-label-lg required_label">Title</label>
                                <select id="ordinaryOfficial2Title" name="ordinaryOfficial2Title" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('ordinaryOfficial2Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2Nop" class="form-label form-label-lg required_label">Alternate Representative Name</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2Nop" name="ordinaryOfficial2Nop" value="{{ old('ordinaryOfficial2Nop') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryMyKad2Select" class="form-label
                                form-label-lg required_label">Type of Identity</label>
                                <select id="ordinaryMyKad2Select" name="ordinaryMyKad2Select" class="form-select form-select-lg mykadSelect2">
                                    <option value="1">MyKad No.</option>
                                    <option value="2">Passport No.</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12 mykadDiv2">
                                <label for="ordinaryMyKad2" class="form-label form-label-lg required_label">MyKad No.</label>
                                <input class="form-control form-control-lg mykad2" type="number" id="ordinaryMyKad2" name="ordinaryMyKad2" value="{{ old('ordinaryMyKad2') }}" />
                            </div>
                            <div class="mb-3 col-md-12 passportDiv2">
                                <label for="ordinary2Passportno" class="form-label form-label-lg required_label">Passport No.</label>
                                <input class="form-control form-control-lg passport2" type="text" id="ordinary2Passportno" name="ordinary2Passportno" value="{{ old('ordinary2Passportno') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2Designation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2Designation" name="ordinaryOfficial2Designation" value="{{ old('ordinaryOfficial2Designation') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2Gender" class="form-label form-label-lg required_label">Gender:</label>
                                <br>
                                @foreach($genders as $gender)
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="ordinaryOfficial2Gender" id="ordinaryOfficial2Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('ordinaryOfficial2Gender') ? 'checked' : '' }}>
                                    <label class="form-check-label form-label-lg" for="ordinaryOfficial2Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2ProQualification" name="ordinaryOfficial2ProQualification" value="{{ old('ordinaryOfficial2ProQualification') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2Email" class="form-label form-label-lg required_label">Email</label>
                                <input class="form-control form-control-lg" type="email" id="ordinaryOfficial2Email" name="ordinaryOfficial2Email" value="{{ old('ordinaryOfficial2Email') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2Contact" class="form-label form-label-lg required_label">Contact No.</label>
                                <input class="form-control form-control-lg" type="number" id="ordinaryOfficial2Contact" name="ordinaryOfficial2Contact" value="{{ old('ordinaryOfficial2Contact') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2Address" class="form-label form-label-lg required_label">Correspondence Address</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2Address" name="ordinaryOfficial2Address" value="{{ old('ordinaryOfficial2Address') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2AddressCity" class="form-label form-label-lg required_label">City</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2AddressCity" name="ordinaryOfficial2AddressCity" value="{{ old('ordinaryOfficial2AddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2AddressState" class="form-label form-label-lg required_label">State</label>
                                <select id="ordinaryOfficial2AddressState" name="ordinaryOfficial2AddressState" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select State</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->state_id }}" {{ $state->state_id == old('ordinaryOfficial2AddressState') ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2AddressPc" class="form-label form-label-lg required_label">Postcode</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2AddressPc" name="ordinaryOfficial2AddressPc" value="{{ old('ordinaryOfficial2AddressPc') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2AddressCountry" class="form-label form-label-lg required_label">Country</label>
                                <select id="ordinaryOfficial2AddressCountry" name="ordinaryOfficial2AddressCountry" class="form-select form-select-lg">
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_id }}" {{ $country->country_id == old('ordinaryOfficial2AddressCountry') ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2SecretartTitle" class="form-label form-label-lg">Secretary Title</label>
                                <select id="ordinaryOfficial2SecretartTitle" name="ordinaryOfficial2SecretartTitle" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('ordinaryOfficial2SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                <input class="form-control form-control-lg" type="text" id="ordinaryOfficial2SecretartName" name="ordinaryOfficial2SecretartName" value="{{ old('ordinaryOfficial2SecretartName') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                <input class="form-control form-control-lg" type="email" id="ordinaryOfficial2SecretartEmail" name="ordinaryOfficial2SecretartEmail" value="{{ old('ordinaryOfficial2SecretartEmail') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial2SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                <input class="form-control form-control-lg" type="number" id="ordinaryOfficial2SecretartContact" name="ordinaryOfficial2SecretartContact" value="{{ old('ordinaryOfficial2SecretartContact') }}" />
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="submit" class="btn btn-success btn-next btn-submit" id="ordinary-btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <form method="POST" action="{{ route('subsidiary.register') }}" name="subsidiary-membership-form" enctype="multipart/form-data">
                @csrf
                    <div id="subsidiary-general-information" class="content subsidiary-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">General Information</h5>
                        </div>
                        <div class="row g3">
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryCompanyPreferBranch" class="form-label form-label-lg required_label">Select Branch</label>
                                <select class="form-select form-select-lg" id="subsidiaryCompanyPreferBranch" name="subsidiaryCompanyPreferBranch">
                                    <option value="" selected disabled>Select Branch</option>
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
                                <input class="form-control form-control-lg" type="text" id="subsidiaryCompanyName" name="subsidiaryCompanyName" value="{{ old('subsidiaryCompanyName') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryCompanyAddress" class="form-label form-label-lg required_label">Address Line 1</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryCompanyAddress" name="subsidiaryCompanyAddress" value="{{ old('subsidiaryCompanyAddress') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryCompanyAddressCity" class="form-label form-label-lg required_label">Address Line 2</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryCompanyAddressCity" name="subsidiaryCompanyAddressCity" value="{{ old('subsidiaryCompanyAddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryCompanyAddress3" class="form-label form-label-lg">Address Line 3</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryCompanyAddress3" name="subsidiaryCompanyAddress3" value="{{ old('subsidiaryCompanyAddress3') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                <label for="subsidiaryOfficialWebsite" class="form-label form-label-lg">Official Website</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryOfficialWebsite" name="subsidiaryOfficialWebsite" value="{{ old('subsidiaryOfficialWebsite') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryOfficialNumber" class="form-label form-label-lg required_label">Office No.</label>
                                <input class="form-control form-control-lg" type="number" id="subsidiaryOfficialNumber" name="subsidiaryOfficialNumber" value="{{ old('subsidiaryOfficialNumber') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryFaxNumber" class="form-label form-label-lg">Fax No.</label>
                                <input class="form-control form-control-lg" type="number" id="subsidiaryFaxNumber" name="subsidiaryFaxNumber" value="{{ old('subsidiaryFaxNumber') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiarySSMRegNumber" class="form-label form-label-lg required_label">SSM Registration No.</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiarySSMRegNumber" name="subsidiarySSMRegNumber" value="{{ old('subsidiarySSMRegNumber') }}" oninput="this.value = this.value.toUpperCase();" />
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
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next subsidiary-general-information-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="subsidiary-company-admin" class="content subsidiary-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Company Admin</h5>
                        </div>
                        <div class="row g3">
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryAdminTitle" class="form-label form-label-lg">Title</label>
                                <select id="subsidiaryAdminTitle" name="subsidiaryAdminTitle" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('subsidiaryAdminTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryNameOfAdmin" class="form-label form-label-lg required_label">Admin Name</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryNameOfAdmin" name="subsidiaryNameOfAdmin" value="{{ old('subsidiaryNameOfAdmin') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryAdminDesignation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryAdminDesignation" name="subsidiaryAdminDesignation" value="{{ old('subsidiaryAdminDesignation') }}" oninput="this.value = this.value.toUpperCase();" />
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
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next subsidiary-company-admin-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="subsidiary-official-representative-1" class="content subsidiary-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Official Representative</h5>
                        </div>
                        <div class="row g3">
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryOfficial1Title" class="form-label form-label-lg required_label">Title</label>
                                <select id="subsidiaryOfficial1Title" name="subsidiaryOfficial1Title" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('subsidiaryOfficial1Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryOfficial1Nop" class="form-label form-label-lg required_label">Official Representative Name</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1Nop" name="subsidiaryOfficial1Nop" value="{{ old('subsidiaryOfficial1Nop') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryMyKadSelect" class="form-label
                                form-label-lg required_label">Type of Identity</label>
                                <select id="subsidiaryMyKadSelect" name="subsidiaryMyKadSelect" class="form-select form-select-lg mykadSelect1">
                                    <option value="1">MyKad No.</option>
                                    <option value="2">Passport No.</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12 mykadDiv1">
                                <label for="subsidiaryMyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                <input class="form-control form-control-lg mykad1" type="number" id="subsidiaryMyKad" name="subsidiaryMyKad" value="{{ old('subsidiaryMyKad') }}" />
                            </div>
                            <div class="mb-3 col-md-12 passportDiv1">
                                <label for="subsidiaryPassportno" class="form-label form-label-lg required_label">Passport No.</label>
                                <input class="form-control form-control-lg passport1" type="text" id="subsidiaryPassportno" name="subsidiaryPassportno" value="{{ old('subsidiaryPassportno') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryOfficial1Designation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1Designation" name="subsidiaryOfficial1Designation" value="{{ old('subsidiaryOfficial1Designation') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryOfficial1Gender" class="form-label form-label-lg required_label">Gender:</label>
                                <br>
                                @foreach($genders as $gender)
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="subsidiaryOfficial1Gender" id="subsidiaryOfficial1Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('subsidiaryOfficial1Gender') ? 'checked' : '' }}>
                                    <label class="form-check-label form-label-lg" for="subsidiaryOfficial1Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryOfficial1ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1ProQualification" name="subsidiaryOfficial1ProQualification" value="{{ old('subsidiaryOfficial1ProQualification') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1Address" name="subsidiaryOfficial1Address" value="{{ old('subsidiaryOfficial1Address') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryOfficial1AddressCity" class="form-label form-label-lg required_label">City</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1AddressCity" name="subsidiaryOfficial1AddressCity" value="{{ old('subsidiaryOfficial1AddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('subsidiaryOfficial1SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="subsidiaryOfficial1SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                <input class="form-control form-control-lg" type="text" id="subsidiaryOfficial1SecretartName" name="subsidiaryOfficial1SecretartName" value="{{ old('subsidiaryOfficial1SecretartName') }}" oninput="this.value = this.value.toUpperCase();" />
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
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="submit" class="btn btn-success btn-next btn-submit" id="subsidiary-btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <form method="POST" action="{{ route('affiliate.register') }}" name="affiliate-membership-form" enctype="multipart/form-data">
                @csrf
                    <div id="affiliate-general-information" class="content affiliate-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">General Information</h5>
                        </div>
                        <div class="row g3">
                            <div class="mb-3 col-md-12">
                                <label for="affiliateCompanyPreferBranch" class="form-label form-label-lg required_label">Select Branch</label>
                                <select class="form-select form-select-lg" id="affiliateCompanyPreferBranch" name="affiliateCompanyPreferBranch">
                                    <option value="" selected disabled>Select Branch</option>
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
                                <input class="form-control form-control-lg" type="text" id="affiliateCompanyName" name="affiliateCompanyName" value="{{ old('affiliateCompanyName') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateCompanyAddress" class="form-label form-label-lg required_label">Address Line 1</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateCompanyAddress" name="affiliateCompanyAddress" value="{{ old('affiliateCompanyAddress') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateCompanyAddressCity" class="form-label form-label-lg required_label">Address Line 2</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateCompanyAddressCity" name="affiliateCompanyAddressCity" value="{{ old('affiliateCompanyAddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateCompanyAddress3" class="form-label form-label-lg">Address Line 3</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateCompanyAddress3" name="affiliateCompanyAddress3" value="{{ old('affiliateCompanyAddress3') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                <label for="affiliateOfficialWebsite" class="form-label form-label-lg">Official Website</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficialWebsite" name="affiliateOfficialWebsite" value="{{ old('affiliateOfficialWebsite') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficialNumber" class="form-label form-label-lg required_label">Office No.</label>
                                <input class="form-control form-control-lg" type="number" id="affiliateOfficialNumber" name="affiliateOfficialNumber" value="{{ old('affiliateOfficialNumber') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateFaxNumber" class="form-label form-label-lg">Fax No.</label>
                                <input class="form-control form-control-lg" type="number" id="affiliateFaxNumber" name="affiliateFaxNumber" value="{{ old('affiliateFaxNumber') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateSSMRegNumber" class="form-label form-label-lg required_label">SSM Registration No.</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateSSMRegNumber" name="affiliateSSMRegNumber" value="{{ old('affiliateSSMRegNumber') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                <input class="form-control form-control-lg" type="text" id="affiliateHouseDevelopingLicense" name="affiliateHouseDevelopingLicense" value="{{ old('affiliateHouseDevelopingLicense') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateCopyOfHousingDeveloperLicense" class="form-label form-label-lg required_label">Attachment: Copy of Housing Developer's Licence No.</label>
                                <input class="form-control form-control-lg" type="file" id="affiliateCopyOfHousingDeveloperLicense" name="affiliateCopyOfHousingDeveloperLicense" value="" accept="application/pdf" />
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next affiliate-general-information-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="affiliate-company-admin" class="content affiliate-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Company Admin</h5>
                        </div>
                        <div class="row mt-3">
                            <div class="mb-3 col-md-12">
                                <label for="affiliateAdminTitle" class="form-label form-label-lg">Title</label>
                                <select id="affiliateAdminTitle" name="affiliateAdminTitle" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('affiliateAdminTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateNameOfAdmin" class="form-label form-label-lg required_label">Admin Name</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateNameOfAdmin" name="affiliateNameOfAdmin" value="{{ old('affiliateNameOfAdmin') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateAdminDesignation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateAdminDesignation" name="affiliateAdminDesignation" value="{{ old('affiliateAdminDesignation') }}" oninput="this.value = this.value.toUpperCase();" />
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
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next affiliate-company-admin-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="affiliate-official-representative-1" class="content affiliate-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Official Representative</h5>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial1Title" class="form-label form-label-lg required_label">Title</label>
                                <select id="affiliateOfficial1Title" name="affiliateOfficial1Title" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('affiliateOfficial1Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial1Nop" class="form-label form-label-lg required_label">Official Representative Name</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial1Nop" name="affiliateOfficial1Nop" value="{{ old('affiliateOfficial1Nop') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateMyKadSelect" class="form-label
                                form-label-lg required_label">Type of Identity</label>
                                <select id="affiliateMyKadSelect" name="affiliateMyKadSelect" class="form-select form-select-lg mykadSelect1">
                                    <option value="1">MyKad No.</option>
                                    <option value="2">Passport No.</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12 mykadDiv1">
                                <label for="affiliateMyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                <input class="form-control form-control-lg mykad1" type="number" id="affiliateMyKad" name="affiliateMyKad" value="{{ old('affiliateMyKad') }}" />
                            </div>
                            <div class="mb-3 col-md-12 passportDiv1">
                                <label for="affiliatePassportno" class="form-label form-label-lg required_label">Passport No.</label>
                                <input class="form-control form-control-lg passport1" type="text" id="affiliatePassportno" name="affiliatePassportno" value="{{ old('affiliatePassportno') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial1Designation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial1Designation" name="affiliateOfficial1Designation" value="{{ old('affiliateOfficial1Designation') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial1Gender" class="form-label form-label-lg required_label">Gender:</label>
                                <br>
                                @foreach($genders as $gender)
                                <div class="form-check-inline">
                                    <input class="form-check-input affiliateOfficial1Gender" type="radio" name="affiliateOfficial1Gender" id="{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('affiliateOfficial1Gender') ? 'checked' : '' }}>
                                    <label class="form-check-label form-label-lg" for="{{ $gender->gid }}">{{ $gender->gname }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial1ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial1ProQualification" name="affiliateOfficial1ProQualification" value="{{ old('affiliateOfficial1ProQualification') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial1Address" name="affiliateOfficial1Address" value="{{ old('affiliateOfficial1Address') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial1AddressCity" class="form-label form-label-lg required_label">City</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial1AddressCity" name="affiliateOfficial1AddressCity" value="{{ old('affiliateOfficial1AddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                <label for="affiliateOfficial1SecretartTitle" class="form-label form-label-lg">Secretary Title</label>
                                <select id="affiliateOfficial1SecretartTitle" name="affiliateOfficial1SecretartTitle" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('affiliateOfficial1SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial1SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial1SecretartName" name="affiliateOfficial1SecretartName" value="{{ old('affiliateOfficial1SecretartName') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial1SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                <input class="form-control form-control-lg" type="email" id="affiliateOfficial1SecretartEmail" name="affiliateOfficial1SecretartEmail" value="{{ old('affiliateOfficial1SecretartEmail') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="ordinaryOfficial1SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                <input class="form-control form-control-lg" type="number" id="ordinaryOfficial1SecretartContact" name="ordinaryOfficial1SecretartContact" value="{{ old('ordinaryOfficial1SecretartContact') }}" />
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next affiliate-official-representative-1-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="affiliate-official-representative-2" class="content affiliate-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Alternate Representative</h5>
                        </div>
                        <div class="row g3">
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial2Title" class="form-label form-label-lg required_label">Title</label>
                                <select id="affiliateOfficial2Title" name="affiliateOfficial2Title" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('affiliateOfficial2Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial2Nop" class="form-label form-label-lg required_label">Alternate Representative Name</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial2Nop" name="affiliateOfficial2Nop" value="{{ old('affiliateOfficial2Nop') }}"  oninput="this.value = this.value.toUpperCase();"/>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateMyKad2Select" class="form-label
                                form-label-lg required_label">Type of Identity</label>
                                <select id="affiliateMyKad2Select" name="affiliateMyKad2Select" class="form-select form-select-lg mykadSelect2">
                                    <option value="1">MyKad No.</option>
                                    <option value="2">Passport No.</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12 mykadDiv2">
                                <label for="affiliateMyKad2" class="form-label form-label-lg required_label">MyKad No.</label>
                                <input class="form-control form-control-lg mykad2" type="number" id="affiliateMyKad2" name="affiliateMyKad2" value="{{ old('affiliateMyKad2') }}" />
                            </div>
                            <div class="mb-3 col-md-12 passportDiv2">
                                <label for="affiliate2Passportno" class="form-label form-label-lg required_label">Passport No.</label>
                                <input class="form-control form-control-lg passport2" type="text" id="affiliate2Passportno" name="affiliate2Passportno" value="{{ old('affiliate2Passportno') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial2Designation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial2Designation" name="affiliateOfficial2Designation" value="{{ old('affiliateOfficial2Designation') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial2Gender" class="form-label form-label-lg required_label">Gender:</label>
                                <br>
                                @foreach($genders as $gender)
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="affiliateOfficial2Gender" id="affiliateOfficial2Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('affiliateOfficial2Gender') ? 'checked' : '' }}>
                                    <label class="form-check-label form-label-lg" for="affiliateOfficial2Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial2ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial2ProQualification" name="affiliateOfficial2ProQualification" value="{{ old('affiliateOfficial2ProQualification') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial2Address" name="affiliateOfficial2Address" value="{{ old('affiliateOfficial2Address') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial2AddressCity" class="form-label form-label-lg required_label">City</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial2AddressCity" name="affiliateOfficial2AddressCity" value="{{ old('affiliateOfficial2AddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('affiliateOfficial2SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="affiliateOfficial2SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                <input class="form-control form-control-lg" type="text" id="affiliateOfficial2SecretartName" name="affiliateOfficial2SecretartName" value="{{ old('affiliateOfficial2SecretartName') }}" oninput="this.value = this.value.toUpperCase();" />
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
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="submit" class="btn btn-success btn-next btn-submit" id="affiliate-btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <form method="POST" action="{{ route('associate.register') }}" name="associate-membership-form" enctype="multipart/form-data">
                @csrf
                    <div id="associate-general-information" class="content associate-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">General Information</h5>
                        </div>
                        <div class="row g3">
                            <div class="mb-3 col-md-12">
                                <label for="associateCompanyPreferBranch" class="form-label form-label-lg required_label">Select Branch</label>
                                <select class="form-select form-select-lg" id="associateCompanyPreferBranch" name="associateCompanyPreferBranch">
                                    <option value="" selected disabled>Select Branch</option>
                                    @foreach($branches as $branch)
                                    <option value="{{ $branch->bid }}" {{ $branch->bid == old('associateCompanyPreferBranch') ? 'selected' : '' }}>{{ $branch->bname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateAccType" class="form-label form-label-lg required_label">Account Type:</label>
                                <br>
                                <div class="form-check-inline">
                                    <input class="form-check-input associateAccType" type="radio" name="associateAccType" id="associateAccType1" value="1" checked>
                                    <label class="form-check-label form-label-lg" for="associateAccType1">Company</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input associateAccType" type="radio" name="associateAccType" id="associateAccType2" value="2">
                                    <label class="form-check-label form-label-lg" for="associateAccType2">Individual</label>
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateCompanyName" class="form-label form-label-lg required_label">Company Name</label>
                                <input class="form-control form-control-lg" type="text" id="associateCompanyName" name="associateCompanyName" value="{{ old('associateCompanyName') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateCompanyAddress" class="form-label form-label-lg required_label">Address Line 1</label>
                                <input class="form-control form-control-lg" type="text" id="associateCompanyAddress" name="associateCompanyAddress" value="{{ old('associateCompanyAddress') }}"  oninput="this.value = this.value.toUpperCase();"/>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateCompanyAddressCity" class="form-label form-label-lg required_label">Address Line 2</label>
                                <input class="form-control form-control-lg" type="text" id="associateCompanyAddressCity" name="associateCompanyAddressCity" value="{{ old('associateCompanyAddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateCompanyAddress3" class="form-label form-label-lg">Address Line 3</label>
                                <input class="form-control form-control-lg" type="text" id="associateCompanyAddress3" name="associateCompanyAddress3" value="{{ old('associateCompanyAddress3') }}"  oninput="this.value = this.value.toUpperCase();"/>
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
                                <label for="associateOfficialWebsite" class="form-label form-label-lg">Official Website</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficialWebsite" name="associateOfficialWebsite" value="{{ old('associateOfficialWebsite') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficialNumber" class="form-label form-label-lg required_label">Office No.</label>
                                <input class="form-control form-control-lg" type="number" id="associateOfficialNumber" name="associateOfficialNumber" value="{{ old('associateOfficialNumber') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateFaxNumber" class="form-label form-label-lg">Fax No.</label>
                                <input class="form-control form-control-lg" type="number" id="associateFaxNumber" name="associateFaxNumber" value="{{ old('associateFaxNumber') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateSSMRegNumber" class="form-label form-label-lg required_label">SSM Registration No.</label>
                                <input class="form-control form-control-lg" type="text" id="associateSSMRegNumber" name="associateSSMRegNumber" value="{{ old('associateSSMRegNumber') }}" oninput="this.value = this.value.toUpperCase();" />
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
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next associate-general-information-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="associate-company-admin" class="content associate-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Company Admin</h5>
                        </div>
                        <div class="row g3">
                            <div class="mb-3 col-md-12">
                                <label for="associateAdminTitle" class="form-label form-label-lg">Title</label>
                                <select id="associateAdminTitle" name="associateAdminTitle" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('associateAdminTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateNameOfAdmin" class="form-label form-label-lg required_label">Admin Name</label>
                                <input class="form-control form-control-lg" type="text" id="associateNameOfAdmin" name="associateNameOfAdmin" value="{{ old('associateNameOfAdmin') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateAdminDesignation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="associateAdminDesignation" name="associateAdminDesignation" value="{{ old('associateAdminDesignation') }}" oninput="this.value = this.value.toUpperCase();" />
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
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next associate-company-admin-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="associate-official-representative-1" class="content associate-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Official Representative</h5>
                        </div>
                        <div class="row g3">
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial1Title" class="form-label form-label-lg required_label">Title</label>
                                <select id="associateOfficial1Title" name="associateOfficial1Title" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('associateOfficial1Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial1Nop" class="form-label form-label-lg required_label">Official Representative Name</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficial1Nop" name="associateOfficial1Nop" value="{{ old('associateOfficial1Nop') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial1MyKadSelect" class="form-label
                                form-label-lg required_label">Type of Identity</label>
                                <select id="associateOfficial1MyKadSelect" name="associateOfficial1MyKadSelect" class="form-select form-select-lg mykadSelect1">
                                    <option value="1">MyKad No.</option>
                                    <option value="2">Passport No.</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12 mykadDiv1">
                                <label for="associateOfficial1MyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                <input class="form-control form-control-lg mykad1" type="number" id="associateOfficial1MyKad" name="associateOfficial1MyKad" value="{{ old('associateOfficial1MyKad') }}" />
                            </div>
                            <div class="mb-3 col-md-12 passportDiv1">
                                <label for="associateOfficial1Passportno" class="form-label form-label-lg required_label">Passport No.</label>
                                <input class="form-control form-control-lg passport1" type="text" id="associateOfficial1Passportno" name="associateOfficial1Passportno" value="{{ old('associateOfficial1Passportno') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial1Designation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficial1Designation" name="associateOfficial1Designation" value="{{ old('associateOfficial1Designation') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial1Gender" class="form-label form-label-lg required_label">Gender:</label>
                                <br>
                                @foreach($genders as $gender)
                                <div class="form-check-inline">
                                    <input class="form-check-input associateOfficial1Gender" type="radio" name="associateOfficial1Gender" id="associateOfficial1Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('associateOfficial1Gender') ? 'checked' : '' }}>
                                    <label class="form-check-label form-label-lg" for="associateOfficial1Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial1ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficial1ProQualification" name="associateOfficial1ProQualification" value="{{ old('associateOfficial1ProQualification') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                <input class="form-control form-control-lg" type="text" id="associateOfficial1Address" name="associateOfficial1Address" value="{{ old('associateOfficial1Address') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial1AddressCity" class="form-label form-label-lg required_label">City</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficial1AddressCity" name="associateOfficial1AddressCity" value="{{ old('associateOfficial1AddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('associateOfficial1SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial1SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficial1SecretartName" name="associateOfficial1SecretartName" value="{{ old('associateOfficial1SecretartName') }}" oninput="this.value = this.value.toUpperCase();" />
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
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next associate-official-representative-1-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="associate-official-representative-2" class="content associate-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Alternate Representative</h5>
                        </div>
                        <div class="row mt-3">
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial2Title" class="form-label form-label-lg required_label">Title</label>
                                <select id="associateOfficial2Title" name="associateOfficial2Title" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('associateOfficial2Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial2Nop" class="form-label form-label-lg required_label">Alternate Representative Name</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficial2Nop" name="associateOfficial2Nop" value="{{ old('associateOfficial2Nop') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial2MyKad2Select" class="form-label
                                form-label-lg required_label">Type of Identity</label>
                                <select id="associateOfficial2MyKad2Select" name="associateOfficial2MyKad2Select" class="form-select form-select-lg mykadSelect2">
                                    <option value="1">MyKad No.</option>
                                    <option value="2">Passport No.</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12 mykadDiv2">
                                <label for="associateOfficial2MyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                <input class="form-control form-control-lg mykad2" type="number" id="associateOfficial2MyKad" name="associateOfficial2MyKad" value="{{ old('associateOfficial2MyKad') }}" />
                            </div>
                            <div class="mb-3 col-md-12 passportDiv2">
                                <label for="associateOfficial2Passportno" class="form-label form-label-lg required_label">Passport No.</label>
                                <input class="form-control form-control-lg passport2" type="text" id="associateOfficial2Passportno" name="associateOfficial2Passportno" value="{{ old('associateOfficial2Passportno') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial2Designation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficial2Designation" name="associateOfficial2Designation" value="{{ old('associateOfficial2Designation') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial2Gender" class="form-label form-label-lg required_label">Gender:</label>
                                <br>
                                @foreach($genders as $gender)
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="associateOfficial2Gender" id="associateOfficial2Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('associateOfficial2Gender') ? 'checked' : '' }}>
                                    <label class="form-check-label form-label-lg" for="associateOfficial2Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial2ProQualification" class="form-label form-label-lg">Professional Qualification (If Any)</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficial2ProQualification" name="associateOfficial2ProQualification" value="{{ old('associateOfficial2ProQualification') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                <input class="form-control form-control-lg" type="text" id="associateOfficial2Address" name="associateOfficial2Address" value="{{ old('associateOfficial2Address') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial2AddressCity" class="form-label form-label-lg required_label">City</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficial2AddressCity" name="associateOfficial2AddressCity" value="{{ old('associateOfficial2AddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('associateOfficial2SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="associateOfficial2SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                <input class="form-control form-control-lg" type="text" id="associateOfficial2SecretartName" name="associateOfficial2SecretartName" value="{{ old('associateOfficial2SecretartName') }}" oninput="this.value = this.value.toUpperCase();" />
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
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="submit" class="btn btn-success btn-next btn-submit" id="associate-btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <form method="POST" action="{{ route('rehdayouth.register') }}" name="rehdayouth-membership-form" enctype="multipart/form-data">
                @csrf
                    <div id="rehdayouth-general-information" class="content rehdayouth-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">General Information</h5>
                        </div>
                        <div class="row mt-3">
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOrdinaryMembershipNumber" class="form-label form-label-lg required_label">Company Registered Under REHDA (Membership No.)</label>
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthOrdinaryMembershipNumber" name="rehdaYouthOrdinaryMembershipNumber" value="{{ old('rehdaYouthOrdinaryMembershipNumber') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthCompanyName" class="form-label form-label-lg required_label">Company Name</label>
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthCompanyName" name="rehdaYouthCompanyName" value="{{ old('rehdaYouthCompanyName') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthCompanyAddress" class="form-label form-label-lg required_label">Address Line 1</label>
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthCompanyAddress" name="rehdaYouthCompanyAddress" value="{{ old('rehdaYouthCompanyAddress') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthCompanyAddressCity" class="form-label form-label-lg required_label">Address Line 2</label>
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthCompanyAddressCity" name="rehdaYouthCompanyAddressCity" value="{{ old('rehdaYouthCompanyAddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthCompanyAddressCity3" class="form-label form-label-lg">Address Line 3</label>
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthCompanyAddressCity3" name="rehdaYouthCompanyAddressCity3" value="{{ old('rehdaYouthCompanyAddressCity3') }}" oninput="this.value = this.value.toUpperCase();" />
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
                                <label for="rehdaYouthOfficialWebsite" class="form-label form-label-lg">Official Website</label>
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficialWebsite" name="rehdaYouthOfficialWebsite" value="{{ old('rehdaYouthOfficialWebsite') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficialNumber" class="form-label form-label-lg required_label">Office No.</label>
                                <input class="form-control form-control-lg" type="number" id="rehdaYouthOfficialNumber" name="rehdaYouthOfficialNumber" value="{{ old('rehdaYouthOfficialNumber') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthFaxNumber" class="form-label form-label-lg">Fax No.</label>
                                <input class="form-control form-control-lg" type="number" id="rehdaYouthFaxNumber" name="rehdaYouthFaxNumber" value="{{ old('rehdaYouthFaxNumber') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev member-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next member-next rehdayouth-general-information-btn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="rehdayouth-official-representative-1" class="content rehdayouth-body">
                        <div class="content-header mb-3">
                            <h5 class="mb-0 text-uppercase">Official Representative</h5>
                        </div>
                        <div class="row mt-3">
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1Title" class="form-label form-label-lg required_label">Title</label>
                                <select id="rehdaYouthOfficial1Title" name="rehdaYouthOfficial1Title" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('rehdaYouthOfficial1Title') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1Nop" class="form-label form-label-lg required_label">Official Representative Name</label>
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1Nop" name="rehdaYouthOfficial1Nop" value="{{ old('rehdaYouthOfficial1Nop') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1MyKadSelect" class="form-label
                                form-label-lg required_label">Type of Identity</label>
                                <select id="rehdaYouthOfficial1MyKadSelect" name="rehdaYouthOfficial1MyKadSelect" class="form-select form-select-lg mykadSelect1">
                                    <option value="1">MyKad No.</option>
                                    <option value="2">Passport No.</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12 mykadDiv1">
                                <label for="rehdaYouthOfficial1MyKad" class="form-label form-label-lg required_label">MyKad No.</label>
                                <input class="form-control form-control-lg mykad1" type="number" id="rehdaYouthOfficial1MyKad" name="rehdaYouthOfficial1MyKad" value="{{ old('rehdaYouthOfficial1MyKad') }}" />
                            </div>
                            <div class="mb-3 col-md-12 passportDiv1">
                                <label for="rehdaYouthOfficial1Passportno" class="form-label form-label-lg required_label">Passport No.</label>
                                <input class="form-control form-control-lg passport1" type="text" id="rehdaYouthOfficial1Passportno" name="rehdaYouthOfficial1Passportno" value="{{ old('rehdaYouthOfficial1Passportno') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1Designation" class="form-label form-label-lg required_label">Designation</label>
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1Designation" name="rehdaYouthOfficial1Designation" value="{{ old('rehdaYouthOfficial1Designation') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1Gender" class="form-label form-label-lg required_label">Gender:</label>
                                <br>
                                @foreach($genders as $gender)
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="rehdaYouthOfficial1Gender" id="rehdaYouthOfficial1Gender{{ $gender->gid }}" value="{{ $gender->gid }}" {{ $gender->gid == old('rehdaYouthOfficial1Gender') ? 'checked' : '' }}>
                                    <label class="form-check-label form-label-lg" for="rehdaYouthOfficial1Gender{{ $gender->gid }}">{{ $gender->gname }}</label>
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
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1Address" name="rehdaYouthOfficial1Address" value="{{ old('rehdaYouthOfficial1Address') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1AddressCity" class="form-label form-label-lg required_label">City</label>
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1AddressCity" name="rehdaYouthOfficial1AddressCity" value="{{ old('rehdaYouthOfficial1AddressCity') }}" oninput="this.value = this.value.toUpperCase();" />
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
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1MembersNominationsForm" class="form-label form-label-lg required_label">Members Nominations Form</label>
                                <input class="form-control form-control-lg" type="file" id="rehdaYouthOfficial1MembersNominationsForm" name="rehdaYouthOfficial1MembersNominationsForm" value="" accept="application/pdf" />
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1MyKadCopy" class="form-label form-label-lg required_label">MyKad Copy (front and back)</label>
                                <input class="form-control form-control-lg" type="file" id="rehdaYouthOfficial1MyKadCopy" name="rehdaYouthOfficial1MyKadCopy" value="" accept="application/pdf" />
                            </div>
                            <hr>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1SecretartTitle" class="form-label form-label-lg">Title</label>
                                <select id="rehdaYouthOfficial1SecretartTitle" name="rehdaYouthOfficial1SecretartTitle" class="form-select form-select-lg">
                                    <option value="" selected disabled>Select Title</option>
                                    <option value="0">-</option>
                                    @foreach($titles as $title)
                                    <option value="{{ $title->sid }}" {{ $title->sid == old('rehdaYouthOfficial1SecretartTitle') ? 'selected' : '' }}>{{ $title->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1SecretartName" class="form-label form-label-lg">Secretary Name (If any)</label>
                                <input class="form-control form-control-lg" type="text" id="rehdaYouthOfficial1SecretartName" name="rehdaYouthOfficial1SecretartName" value="{{ old('rehdaYouthOfficial1SecretartName') }}" oninput="this.value = this.value.toUpperCase();" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1SecretartEmail" class="form-label form-label-lg">Secretary Email</label>
                                <input class="form-control form-control-lg" type="email" id="rehdaYouthOfficial1SecretartEmail" name="rehdaYouthOfficial1SecretartEmail" value="{{ old('rehdaYouthOfficial1SecretartEmail') }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="rehdaYouthOfficial1SecretartContact" class="form-label form-label-lg">Secretary Contact No.</label>
                                <input class="form-control form-control-lg" type="number" id="rehdaYouthOfficial1SecretartContact" name="rehdaYouthOfficial1SecretartContact" value="{{ old('rehdaYouthOfficial1SecretartContact') }}" />
                            </div>

                        </div>
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev member-prev">
                                        <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button type="submit" class="btn btn-success btn-next btn-submit" id="rehdayouth-btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@include('layouts.footer')

@endsection

@section('auth-js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="{{ asset('backend/assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>

<script>
    $(document).ready(function() {

        var validateCompanyNameUrl = "{{ route('validateCompanyName') }}";
        var validateOrdinaryMembershipNumberUrl = "{{ route('validateCompanyRegNo') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="csrf-token"]').val()
            }
        });

        function setDefaultHeader()
        {
            $(".ordinary-head").show();
            $(".subsidiary-head").hide();
            $(".affiliate-head").hide();
            $(".associate-head").hide();
            $(".rehdayouth-head").hide();
        }

        var stepper = new Stepper(document.querySelector('.bs-stepper'));

        var ordinaryMembershipForm = $("form[name='ordinary-membership-form']");
        ordinaryMembershipForm.validate({
            ignore: [],
            rules: {
                ordinaryCompanyPreferBranch: "required",
                ordinaryCompanyName: {
                    required: true,
                    remote: {
                        url: validateCompanyNameUrl,
                        type: "POST",
                        data: {
                            company_name: function() {
                                return $("#ordinaryCompanyName").val();
                            },
                            _token: "{{ csrf_token() }}"
                        },
                        dataFilter: function (response) {
                            const result = JSON.parse(response);
                            return result.isUnique ? false : true;
                        }
                    }
                },
                ordinaryCompanyAddress: "required",
                ordinaryCompanyAddressCity: "required",
                ordinaryCompanyAddressState: "required",
                ordinaryCompanyAddressPc: "required",
                ordinaryCompanyAddressCountry: "required",
                // ordinaryOfficialWebsite: "required",
                ordinaryOfficialNumber: "required",
                ordinarySSMRegNumber: "required",
                ordinaryDateOfCompanyFormation: "required",
                ordinaryLatestPaidUpCapital: "required",
                ordinaryCopySSMCert: "required",
                ordinaryCopyOfAnnualReturn: "required",
                ordinaryHouseDevelopingLicense: "required",
                ordinaryCopyOfHousingDeveloperLicense: "required",
                ordinaryNominationForm: "required",
                ordinaryNameOfAdmin: "required",
                ordinaryAdminTitle: "required",
                ordinaryAdminDesignation: "required",
                ordinaryAdminEmail: "required",
                ordinaryAdminContactNumber: "required",
                ordinaryOfficial1Nop: "required",
                ordinaryOfficial1Title: "required",
                ordinaryMyKadSelect: "required",
                ordinaryMyKad: {
                    required: function(element) {
                        return $("#ordinaryMyKadSelect").val() == 1;
                    },
                    minlength: 12,
                    maxlength: 12,
                },
                ordinaryPassportno: {
                    required: function(element) {
                        return $("#ordinaryMyKadSelect").val() == 2;
                    }
                },
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
                ordinaryMyKad2Select: "required",
                ordinaryMyKad2: {
                    required: function(element) {
                        return $("#ordinaryMyKad2Select").val() == 1;
                    },
                    minlength: 12,
                    maxlength: 12,
                },
                ordinary2Passportno: {
                    required: function(element) {
                        return $("#ordinaryMyKad2Select").val() == 2;
                    }
                },
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
            messages: {
                ordinaryCompanyName: {
                    remote: "This company name is already taken."
                }
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });

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
                $("#ordinary-btn").prop('disabled', true);

                // $('.error-message').remove();
                // Clear any existing error messages
                $('.error-message').remove();

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
                            // toastr.success(response.message, 'Success');
                            $("#ordinary-btn").prop('disabled', false);
                            // setDefaultHeader();
                            // stepper.to(0);
                            window.location.href = "{{ route('register-success') }}";
                        } else {
                            toastr.error(response.message, 'Error');
                            $("#ordinary-btn").prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        $("#ordinary-btn").prop('disabled', false);
                        var errors = xhr.responseJSON.errors;

                        // Flag to track if an accordion item has been opened
                        var hasOpenedAccordion = false;

                        toastr.error('Please fill all required fields correctly', 'Error');
                        // Iterate through the errors
                        $.each(errors, function(field, message) {
                            if (!hasOpenedAccordion) {
                                var inputField = $("#" + field);

                                // Activate the accordion item related to the field with an error
                                var accordionItem = inputField.closest('.accordion-item');
                                accordionItem.addClass('active');
                                accordionItem.find('.accordion-collapse').addClass('show');

                                var ordinaryGeneral = [
                                    "#ordinaryCompanyPreferBranch",
                                    "#ordinaryCompanyName",
                                    "#ordinaryCompanyAddress",
                                    "#ordinaryCompanyAddressCity",
                                    "#ordinaryCompanyAddressState",
                                    "#ordinaryCompanyAddressPc",
                                    "#ordinaryCompanyAddressCountry",
                                    "#ordinaryOfficialWebsite",
                                    "#ordinaryOfficialNumber",
                                    "#ordinarySSMRegNumber",
                                    "#ordinaryDateOfCompanyFormation",
                                    "#ordinaryLatestPaidUpCapital",
                                    "#ordinaryCopySSMCert",
                                    "#ordinaryCopyOfAnnualReturn",
                                    "#ordinaryHouseDevelopingLicense",
                                    "#ordinaryCopyOfHousingDeveloperLicense",
                                    "#ordinaryCopyForm24",
                                    "#ordinaryCopyForm49",
                                    "#ordinaryNominationForm",
                                ];
                                if (ordinaryGeneral.includes("#" + field)) {
                                    stepper.to(2);
                                }

                                var ordinaryCompany = ["#ordinaryAdminTitle", "#ordinaryNameOfAdmin", "#ordinaryAdminDesignation", "#ordinaryAdminEmail", "#ordinaryAdminContactNumber"];
                                if (ordinaryCompany.includes("#" + field)) {
                                    stepper.to(3);
                                }

                                var ordinaryOR1 = ["#ordinaryOfficial1Title", "#ordinaryOfficial1Nop", "#ordinaryMyKad", "#ordinaryOfficial1Designation", "#ordinaryOfficial1Email", "#ordinaryOfficial1Contact", "#ordinaryOfficial1Address", "#ordinaryOfficial1AddressCity", "#ordinaryOfficial1AddressState", "#ordinaryOfficial1AddressPc", "#ordinaryOfficial1AddressCountry","#ordinaryOfficial1SecretartEmail"];
                                if (ordinaryOR1.includes("#" + field)) {
                                    stepper.to(4);
                                }

                                var ordinaryOR2 = ["#ordinaryOfficial2Title", "#ordinaryOfficial2Nop", "#ordinaryMyKad2", "#ordinaryOfficial2Designation", "#ordinaryOfficial2Email", "#ordinaryOfficial2Contact", "#ordinaryOfficial2Address", "#ordinaryOfficial2AddressCity", "#ordinaryOfficial2AddressState", "#ordinaryOfficial2AddressPc", "#ordinaryOfficial2AddressCountry","#ordinaryOfficial2SecretartEmail"];
                                if (ordinaryOR2.includes("#" + field)) {
                                    stepper.to(5);
                                }

                                // Show the error message
                                var errorElement = $('<div class="error-message form-label-lg" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                                inputField.focus();

                                // Set the flag to true to prevent opening other accordion items
                                hasOpenedAccordion = true;
                            } else {
                                // If already opened, just show the error message without opening another accordion
                                var inputField = $("#" + field);
                                var errorElement = $('<div class="error-message form-label-lg" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                            }
                        });
                    }
                });
            }
        });

        var subsidiaryMembershipForm = $("form[name='subsidiary-membership-form']");
        subsidiaryMembershipForm.validate({
            ignore: [],
            rules: {
                subsidiaryCompanyPreferBranch: "required",
                subsidiaryOrdinaryMembershipNumber: {
                    required: true,
                    minlength: 15
                },
                subsidiaryCompanyName: {
                    required: true,
                    remote: {
                        url: validateCompanyNameUrl,
                        type: "POST",
                        data: {
                            company_name: function() {
                                return $("#subsidiaryCompanyName").val();
                            },
                            _token: "{{ csrf_token() }}"
                        },
                        dataFilter: function (response) {
                            const result = JSON.parse(response);
                            return result.isUnique ? false : true;
                        }
                    }
                },
                subsidiaryCompanyAddress: "required",
                subsidiaryCompanyAddressCity: "required",
                subsidiaryCompanyAddressState: "required",
                subsidiaryCompanyAddressPc: "required",
                subsidiaryCompanyAddressCountry: "required",
                // subsidiaryOfficialWebsite: "required",
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
                subsidiaryMyKadSelect: "required",
                subsidiaryMyKad: {
                    required: function(element) {
                        return $("#subsidiaryMyKadSelect").val() == 1;
                    },
                    minlength: 12,
                    maxlength: 12,
                },
                subsidiaryPassportno: {
                    required: function(element) {
                        return $("#subsidiaryMyKadSelect").val() == 2;
                    }
                },
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
            messages: {
                subsidiaryCompanyName: {
                    remote: "This company name is already taken."
                }
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });

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
                $("#subsidiary-btn").prop('disabled', true);

                $('.error-message').remove();
                // Clear any existing error messages
                $('.error-message').remove();

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
                            // toastr.success(response.message, 'Success');
                            $("#subsidiary-btn").prop('disabled', false);
                            // setDefaultHeader();
                            // stepper.to(0);
                            window.location.href = "{{ route('register-success') }}";
                        } else {
                            toastr.error(response.message, 'Error');
                            $("#subsidiary-btn").prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        $("#subsidiary-btn").prop('disabled', false);
                        var errors = xhr.responseJSON.errors;

                        // Flag to track if an accordion item has been opened
                        var hasOpenedAccordion = false;

                        toastr.error('Please fill all required fields correctly', 'Error');
                        // Iterate through the errors
                        $.each(errors, function(field, message) {
                            if (!hasOpenedAccordion) {
                                var inputField = $("#" + field);

                                // Activate the accordion item related to the field with an error
                                var accordionItem = inputField.closest('.accordion-item');
                                accordionItem.addClass('active');
                                accordionItem.find('.accordion-collapse').addClass('show');

                                var subsidiaryGeneral = [
                                    "#subsidiaryCompanyPreferBranch",
                                    "#subsidiaryOrdinaryMembershipNumber",
                                    "#subsidiaryCompanyName",
                                    "#subsidiaryCompanyAddress",
                                    "#subsidiaryCompanyAddressCity",
                                    "#subsidiaryCompanyAddressState",
                                    "#subsidiaryCompanyAddressPc",
                                    "#subsidiaryCompanyAddressCountry",
                                    "#subsidiaryOfficialWebsite",
                                    "#subsidiaryOfficialNumber",
                                    "#subsidiarySSMRegNumber",
                                    "#subsidiaryDateOfCompanyFormation",
                                    "#subsidiaryLatestPaidUpCapital",
                                    "#subsidiaryCopySSMCert",
                                    "#subsidiaryCopyOfAnnualReturn",
                                    "#subsidiaryHouseDevelopingLicense",
                                    "#subsidiaryCopyOfHousingDeveloperLicense",
                                    "#subsidiaryCopyForm24",
                                    "#subsidiaryCopyForm49",
                                ];
                                if (subsidiaryGeneral.includes("#" + field)) {
                                    stepper.to(6);
                                }

                                var subsidiaryCompany = ["#subsidiaryAdminTitle", "#subsidiaryNameOfAdmin", "#subsidiaryAdminDesignation", "#subsidiaryAdminEmail", "#subsidiaryAdminContactNumber"];
                                if (subsidiaryCompany.includes("#" + field)) {
                                    stepper.to(7);
                                }

                                var subsidiaryOR1 = ["#subsidiaryOfficial1Title", "#subsidiaryOfficial1Nop", "#subsidiaryMyKad", "#subsidiaryOfficial1Designation", "#subsidiaryOfficial1Email", "#subsidiaryOfficial1Contact", "#subsidiaryOfficial1Address", "#subsidiaryOfficial1AddressCity", "#subsidiaryOfficial1AddressState", "#subsidiaryOfficial1AddressPc", "#subsidiaryOfficial1AddressCountry","#subsidiaryOfficial1SecretartEmail"];
                                if (subsidiaryOR1.includes("#" + field)) {
                                    stepper.to(8);
                                }

                                // Show the error message
                                var errorElement = $('<div class="error-message form-label-lg" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                                inputField.focus();

                                // Set the flag to true to prevent opening other accordion items
                                hasOpenedAccordion = true;
                            } else {
                                // If already opened, just show the error message without opening another accordion
                                var inputField = $("#" + field);
                                var errorElement = $('<div class="error-message form-label-lg" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                            }
                        });
                    }
                });
            }

        });

        var affiliateMembershipForm = $("form[name='affiliate-membership-form']");
        affiliateMembershipForm.validate({
            ignore: [],
            rules: {
                affiliateCompanyPreferBranch: "required",
                affiliateOrdinaryMembershipNumber: {
                    required: true,
                    minlength: 15
                },
                affiliateCompanyName: {
                    required: true,
                    remote: {
                        url: validateCompanyNameUrl,
                        type: "POST",
                        data: {
                            company_name: function() {
                                return $("#affiliateCompanyName").val();
                            },
                            _token: "{{ csrf_token() }}"
                        },
                        dataFilter: function (response) {
                            const result = JSON.parse(response);
                            return result.isUnique ? false : true;
                        }
                    }
                },
                affiliateCompanyAddress: "required",
                affiliateCompanyAddressCity: "required",
                affiliateCompanyAddressState: "required",
                affiliateCompanyAddressPc: "required",
                affiliateCompanyAddressCountry: "required",
                // affiliateOfficialWebsite: "required",
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
                affiliateMyKadSelect: "required",
                affiliateMyKad: {
                    required: function(element) {
                        return $("#affiliateMyKadSelect").val() == 1;
                    },
                    minlength: 12,
                    maxlength: 12,
                },
                affiliatePassportno: {
                    required: function(element) {
                        return $("#affiliateMyKadSelect").val() == 2;
                    }
                },
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
                affiliateMyKad2Select: "required",
                affiliateMyKad2: {
                    required: function(element) {
                        return $("#affiliateMyKad2Select").val() == 1;
                    },
                    minlength: 12,
                    maxlength: 12,
                },
                affiliate2Passportno: {
                    required: function(element) {
                        return $("#affiliateMyKad2Select").val() == 2;
                    }
                },
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
            messages: {
                affiliateCompanyName: {
                    remote: "This company name is already taken."
                }
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });

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
                $("#affiliate-btn").prop('disabled', true);

                $('.error-message').remove();
                // Clear any existing error messages
                $('.error-message').remove();

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
                            // toastr.success(response.message, 'Success');
                            $("#affiliate-btn").prop('disabled', false);
                            // setDefaultHeader();
                            // stepper.to(0);
                            window.location.href = "{{ route('register-success') }}";
                        } else {
                            toastr.error(response.message, 'Error');
                            $("#affiliate-btn").prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        $("#affiliate-btn").prop('disabled', false);
                        var errors = xhr.responseJSON.errors;

                        // Flag to track if an accordion item has been opened
                        var hasOpenedAccordion = false;

                        toastr.error('Please fill all required fields correctly', 'Error');
                        // Iterate through the errors
                        $.each(errors, function(field, message) {
                            if (!hasOpenedAccordion) {
                                var inputField = $("#" + field);

                                // Activate the accordion item related to the field with an error
                                var accordionItem = inputField.closest('.accordion-item');
                                accordionItem.addClass('active');
                                accordionItem.find('.accordion-collapse').addClass('show');

                                var affiliateGeneral = [
                                    "#affiliateCompanyPreferBranch",
                                    "#affiliateOrdinaryMembershipNumber",
                                    "#affiliateCompanyName",
                                    "#affiliateCompanyAddress",
                                    "#affiliateCompanyAddressCity",
                                    "#affiliateCompanyAddressState",
                                    "#affiliateCompanyAddressPc",
                                    "#affiliateCompanyAddressCountry",
                                    "#affiliateOfficialWebsite",
                                    "#affiliateOfficialNumber",
                                    "#affiliateSSMRegNumber",
                                    "#affiliateDateOfCompanyFormation",
                                    "#affiliateLatestPaidUpCapital",
                                    "#affiliateCopySSMCert",
                                    "#affiliateCopyOfAnnualReturn",
                                    "#affiliateHouseDevelopingLicense",
                                    "#affiliateCopyOfHousingDeveloperLicense",
                                    "#affiliateCopyForm24",
                                    "#affiliateCopyForm49",
                                ];
                                if (affiliateGeneral.includes("#" + field)) {
                                    stepper.to(9);
                                }

                                var affiliateCompany = ["#affiliateAdminTitle", "#affiliateNameOfAdmin", "#affiliateAdminDesignation", "#affiliateAdminEmail", "#affiliateAdminContactNumber"];
                                if (affiliateCompany.includes("#" + field)) {
                                    stepper.to(10);
                                }

                                var affiliateOR1 = ["#affiliateOfficial1Title", "#affiliateOfficial1Nop", "#affiliateMyKad", "#affiliateOfficial1Designation", "#affiliateOfficial1Email", "#affiliateOfficial1Contact", "#affiliateOfficial1Address", "#affiliateOfficial1AddressCity", "#affiliateOfficial1AddressState", "#affiliateOfficial1AddressPc", "#affiliateOfficial1AddressCountry","#affiliateOfficial1SecretartEmail"];
                                if (affiliateOR1.includes("#" + field)) {
                                    stepper.to(11);
                                }

                                var affiliateOR2 = ["#affiliateOfficial2Title", "#affiliateOfficial2Nop", "#affiliateMyKad2", "#affiliateOfficial2Designation", "#affiliateOfficial2Email", "#affiliateOfficial2Contact", "#affiliateOfficial2Address", "#affiliateOfficial2AddressCity", "#affiliateOfficial2AddressState", "#affiliateOfficial2AddressPc", "#affiliateOfficial2AddressCountry","#affiliateOfficial2SecretartEmail"];
                                if (affiliateOR2.includes("#" + field)) {
                                    stepper.to(12);
                                }

                                // Show the error message
                                var errorElement = $('<div class="error-message form-label-lg" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                                inputField.focus();

                                // Set the flag to true to prevent opening other accordion items
                                hasOpenedAccordion = true;
                            } else {
                                // If already opened, just show the error message without opening another accordion
                                var inputField = $("#" + field);
                                var errorElement = $('<div class="error-message form-label-lg" style="color:red;"></div>').text(message);
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
                $("#associate-official-representative-2 :input").not(':button').attr("disabled", false);
                $("#associate-company-admin :input").not(':button').attr("disabled", false);
                $(".requiredtitle").html('<span class="badge bg-danger text-uppercase required-badge">Required</span>');
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
                $("#associate-official-representative-2 :input").not(':button').attr("disabled", true);
                $("#associate-company-admin :input").not(':button').attr("disabled", true);
                $(".requiredtitle").html('<span class="badge bg-secondary text-uppercase required-badge">Not Applicable</span>');
            }
        });

        var associateMembershipForm = $("form[name='associate-membership-form']");
        associateMembershipForm.validate({
            ignore: [],
            rules: {
                associateCompanyPreferBranch: "required",
                associateAccType: "required",
                associateCompanyName: {
                    required: true,
                    remote: {
                        url: validateCompanyNameUrl,
                        type: "POST",
                        data: {
                            company_name: function() {
                                return $("#associateCompanyName").val();
                            },
                            _token: "{{ csrf_token() }}"
                        },
                        dataFilter: function (response) {
                            const result = JSON.parse(response);
                            return result.isUnique ? false : true;
                        }
                    }
                },
                associateCompanyAddress: "required",
                associateCompanyAddressCity: "required",
                associateCompanyAddressState: "required",
                associateCompanyAddressPc: "required",
                associateCompanyAddressCountry: "required",
                // associateOfficialWebsite: "required",
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
                associateOfficial1MyKadSelect: "required",
                associateOfficial1MyKad: {
                    required: function(element) {
                        return $("#associateOfficial1MyKadSelect").val() == 1;
                    },
                    minlength: 12,
                    maxlength: 12,
                },
                associateOfficial1Passportno: {
                    required: function(element) {
                        return $("#associateOfficial1MyKadSelect").val() == 2;
                    }
                },
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
                associateOfficial2MyKad2Select: "required",
                associateOfficial2MyKad: {
                    required: function(element) {
                        return $("#associateOfficial2MyKad2Select").val() == 1;
                    },
                    minlength: 12,
                    maxlength: 12,
                },
                associateOfficial2Passportno: {
                    required: function(element) {
                        return $("#associateOfficial2MyKad2Select").val() == 2;
                    }
                },
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
            messages: {
                associateCompanyName: {
                    remote: "This company name is already taken."
                }
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });

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
                $("#associate-btn").prop('disabled', true);

                $('.error-message').remove();
                // Clear any existing error messages
                $('.error-message').remove();

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
                            // toastr.success(response.message, 'Success');
                            $("#associate-btn").prop('disabled', false);
                            // $(".requiredtitle").html('<span class="badge bg-danger text-uppercase required-badge">Required</span>');
                            // setDefaultHeader();
                            // stepper.to(0);
                            window.location.href = "{{ route('register-success') }}";
                        } else {
                            toastr.error(response.message, 'Error');
                            $("#associate-btn").prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        $("#associate-btn").prop('disabled', false);
                        var errors = xhr.responseJSON.errors;

                        // Flag to track if an accordion item has been opened
                        var hasOpenedAccordion = false;

                        toastr.error('Please fill all required fields correctly', 'Error');
                        // Iterate through the errors
                        $.each(errors, function(field, message) {
                            if (!hasOpenedAccordion) {
                                var inputField = $("#" + field);

                                // Activate the accordion item related to the field with an error
                                var accordionItem = inputField.closest('.accordion-item');
                                accordionItem.addClass('active');
                                accordionItem.find('.accordion-collapse').addClass('show');

                                var associateGeneral = [
                                    "#associateCompanyPreferBranch",
                                    "#associateAccType",
                                    "#associateCompanyName",
                                    "#associateCompanyAddress",
                                    "#associateCompanyAddressCity",
                                    "#associateCompanyAddressState",
                                    "#associateCompanyAddressPc",
                                    "#associateCompanyAddressCountry",
                                    "#associateOfficialWebsite",
                                    "#associateOfficialNumber",
                                    "#associateSSMRegNumber",
                                    "#associateDateOfCompanyFormation",
                                    "#associateLatestPaidUpCapital",
                                    "#associateCopySSMCert",
                                    "#associateCopyOfAnnualReturn",
                                    "#associateCopyForm24",
                                    "#associateCopyForm49",
                                ];
                                if (associateGeneral.includes("#" + field)) {
                                    stepper.to(13);
                                }

                                var associateCompany = ["#associateAdminTitle", "#associateNameOfAdmin", "#associateAdminDesignation", "#associateAdminEmail", "#associateAdminContactNumber"];
                                if (associateCompany.includes("#" + field)) {
                                    stepper.to(14);
                                }

                                var associateOR1 = ["#associateOfficial1Title", "#associateOfficial1Nop", "#associateOfficial1MyKad", "#associateOfficial1Designation", "#associateOfficial1Email", "#associateOfficial1Contact", "#associateOfficial1Address", "#associateOfficial1AddressCity", "#associateOfficial1AddressState", "#associateOfficial1AddressPc", "#associateOfficial1Country","#associateOfficial1SecretartEmail"];
                                if (associateOR1.includes("#" + field)) {
                                    stepper.to(15);
                                }

                                var associateOR2 = ["#affiliateOfficial2Title", "#affiliateOfficial2Nop", "#affiliateMyKad2", "#affiliateOfficial2Designation", "#affiliateOfficial2Email", "#affiliateOfficial2Contact", "#affiliateOfficial2Address", "#affiliateOfficial2AddressCity", "#affiliateOfficial2AddressState", "#affiliateOfficial2AddressPc", "#affiliateOfficial2AddressCountry","#affiliateOfficial2SecretartEmail"];
                                if (associateOR2.includes("#" + field)) {
                                    stepper.to(16);
                                }

                                // Show the error message
                                var errorElement = $('<div class="error-message form-label-lg" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                                inputField.focus();

                                // Set the flag to true to prevent opening other accordion items
                                hasOpenedAccordion = true;
                            } else {
                                // If already opened, just show the error message without opening another accordion
                                var inputField = $("#" + field);
                                var errorElement = $('<div class="error-message form-label-lg" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                            }
                        });
                    }
                });
            }

        });

        var rehdayouthMembershipForm = $("form[name='rehdayouth-membership-form']");
        rehdayouthMembershipForm.validate({
            ignore: [],
            rules: {
                rehdaYouthOrdinaryMembershipNumber: {
                    required: true,
                    minlength: 15,
                    remote: {
                        url: validateOrdinaryMembershipNumberUrl,
                        type: "POST",
                        data: {
                            membership_number: function() {
                                return $("#rehdaYouthOrdinaryMembershipNumber").val();
                            },
                            _token: "{{ csrf_token() }}"
                        },
                        dataFilter: function (response) {
                            const result = JSON.parse(response);
                            if(result.found == false){
                                $("#rehdaYouthCompanyName").val(result.company_name).prop("readonly", true).css('background-color', 'rgba(75, 70, 92, 0.08)');
                            }
                            return result.found ? false : true;
                        }
                    }
                },
                rehdaYouthCompanyName: {
                    required: true,
                    remote: {
                        url: validateCompanyNameUrl,
                        type: "POST",
                        data: {
                            company_name: function() {
                                return $("#rehdaYouthCompanyName").val();
                            },
                            membership_number: function() {
                                return $("#rehdaYouthOrdinaryMembershipNumber").val();
                            },
                            _token: "{{ csrf_token() }}"
                        },
                        dataFilter: function (response) {
                            const result = JSON.parse(response);
                            return result.isUnique ? false : true;
                        }
                    }
                },
                rehdaYouthCompanyAddress: "required",
                rehdaYouthCompanyAddressCity: "required",
                rehdaYouthCompanyAddressState: "required",
                rehdaYouthCompanyAddressPc: "required",
                rehdaYouthCompanyAddressCountry: "required",
                // rehdaYouthOfficialWebsite: "required",
                rehdaYouthOfficialNumber: "required",
                rehdaYouthOfficial1Nop: "required",
                rehdaYouthOfficial1Title: "required",
                rehdaYouthOfficial1MyKadSelect: "required",
                rehdaYouthOfficial1MyKad: {
                    required: function(element) {
                        return $("#rehdaYouthOfficial1MyKadSelect").val() == 1;
                    },
                    minlength: 12,
                    maxlength: 12,
                },
                rehdaYouthOfficial1Passportno: {
                    required: function(element) {
                        return $("#rehdaYouthOfficial1MyKadSelect").val() == 2;
                    }
                },
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
                rehdaYouthOfficial1AddressCountry: "required",
                rehdaYouthOfficial1MembersNominationsForm: "required",
                rehdaYouthOfficial1MyKadCopy: "required",
            },
            messages: {
                rehdaYouthOrdinaryMembershipNumber: {
                    remote: "Invalid Ordinary Membership No."
                },
                rehdaYouthCompanyName: {
                    remote: "This company name is already taken."
                }
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });

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
                $("#rehdayouth-btn").prop('disabled', true);

                $('.error-message').remove();
                // Clear any existing error messages
                $('.error-message').remove();

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
                            // toastr.success(response.message, 'Success');
                            $("#rehdayouth-btn").prop('disabled', false);
                            // setDefaultHeader();
                            // stepper.to(0);
                            window.location.href = "{{ route('register-success') }}";
                        } else {
                            toastr.error(response.message, 'Error');
                            $("#rehdayouth-btn").prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        $("#rehdayouth-btn").prop('disabled', false);
                        var errors = xhr.responseJSON.errors;

                        // Flag to track if an accordion item has been opened
                        var hasOpenedAccordion = false;

                        toastr.error('Please fill all required fields correctly', 'Error');
                        // Iterate through the errors
                        $.each(errors, function(field, message) {
                            if (!hasOpenedAccordion) {
                                var inputField = $("#" + field);

                                // Activate the accordion item related to the field with an error
                                var accordionItem = inputField.closest('.accordion-item');
                                accordionItem.addClass('active');
                                accordionItem.find('.accordion-collapse').addClass('show');

                                var associateGeneral = [
                                    "#rehdaYouthOrdinaryMembershipNumber",
                                    "#rehdaYouthCompanyName",
                                    "#rehdaYouthCompanyAddress",
                                    "#rehdaYouthCompanyAddressCity",
                                    "#rehdaYouthCompanyAddressState",
                                    "#rehdaYouthCompanyAddressPc",
                                    "#rehdaYouthCompanyAddressCountry",
                                    "#rehdaYouthOfficialWebsite",
                                    "#rehdaYouthOfficialNumber",
                                ];
                                if (associateGeneral.includes("#" + field)) {
                                    stepper.to(17);
                                }

                                var associateOR1 = ["#rehdaYouthOfficial1Title", "#rehdaYouthOfficial1Nop", "#rehdaYouthOfficial1MyKad", "#rehdaYouthOfficial1Designation", "#rehdaYouthOfficial1Email", "#rehdaYouthOfficial1Contact", "#rehdaYouthOfficial1Address", "#rehdaYouthOfficial1AddressCity", "#rehdaYouthOfficial1AddressState", "#rehdaYouthOfficial1AddressPc", "#rehdaYouthOfficial1AddressCountry","#rehdaYouthOfficial1SecretartEmail", "#rehdaYouthOfficial1MembersNominationsForm", "#rehdaYouthOfficial1MyKadCopy"];
                                if (associateOR1.includes("#" + field)) {
                                    stepper.to(18);
                                }

                                // Show the error message
                                var errorElement = $('<div class="error-message form-label-lg" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                                inputField.focus();

                                // Set the flag to true to prevent opening other accordion items
                                hasOpenedAccordion = true;
                            } else {
                                // If already opened, just show the error message without opening another accordion
                                var inputField = $("#" + field);
                                var errorElement = $('<div class="error-message form-label-lg" style="color:red;"></div>').text(message);
                                inputField.after(errorElement);
                            }
                        });
                    }
                });
            }

        });

        // $(".membertype-next").on("click", function () {
        //     if($(".membertype").valid()){
        //         stepper.next();
        //     } else {
        //         ordinaryMembershipForm.find(":input.error").first().focus();
        //     }
        // });

        $(".ordinary-general-information-btn").on("click", function () {
            if($("#ordinaryCompanyPreferBranch, #ordinaryCompanyName, #ordinaryCompanyAddress, #ordinaryCompanyAddressCity, #ordinaryCompanyAddressState, #ordinaryCompanyAddressPc, #ordinaryCompanyAddressCountry, #ordinaryOfficialWebsite, #ordinaryOfficialNumber, #ordinarySSMRegNumber, #ordinaryDateOfCompanyFormation, #ordinaryLatestPaidUpCapital, #ordinaryCopySSMCert, #ordinaryCopyOfAnnualReturn, #ordinaryHouseDevelopingLicense, #ordinaryCopyOfHousingDeveloperLicense, #ordinaryNominationForm").valid()){
                stepper.next();
            } else {
                ordinaryMembershipForm.find(":input.error").first().focus();
            }
        });
        $(".ordinary-company-admin-btn").on("click", function () {
            if($("#ordinaryAdminTitle, #ordinaryNameOfAdmin, #ordinaryAdminDesignation, #ordinaryAdminEmail, #ordinaryAdminContactNumber").valid()){
                stepper.next();
            } else {
                ordinaryMembershipForm.find(":input.error").first().focus();
            }
        });
        $(".ordinary-official-representative-1-btn").on("click", function () {
            if($("#ordinaryOfficial1Title, #ordinaryOfficial1Nop, #ordinaryMyKad, #ordinaryPassportno #ordinaryOfficial1Designation, .ordinaryGender, #ordinaryOfficial1Email, #ordinaryOfficial1Contact, #ordinaryOfficial1Address, #ordinaryOfficial1AddressCity, #ordinaryOfficial1AddressState, #ordinaryOfficial1AddressPc, #ordinaryOfficial1AddressCountry, #ordinaryOfficial1SecretartEmail").valid()){
                stepper.next();
            } else {

                // Trigger validation on all fields to display error messages
                $("#ordinaryOfficial1Title, #ordinaryOfficial1Nop, #ordinaryMyKad, #ordinaryPassportno, #ordinaryOfficial1Designation, .ordinaryGender, #ordinaryOfficial1Email, #ordinaryOfficial1Contact, #ordinaryOfficial1Address, #ordinaryOfficial1AddressCity, #ordinaryOfficial1AddressState, #ordinaryOfficial1AddressPc, #ordinaryOfficial1AddressCountry, #ordinaryOfficial1SecretartEmail").each(function() {
                    $(this).valid();  // This will trigger the validation and display errors
                });
                // Focus on the first invalid input field
                ordinaryMembershipForm.find(":input.error").first().focus();
            }
        });


        $(".subsidiary-general-information-btn").on("click", function () {
            if($("#subsidiaryCompanyPreferBranch, #subsidiaryOrdinaryMembershipNumber, #subsidiaryCompanyName, #subsidiaryCompanyAddress, #subsidiaryCompanyAddressCity, #subsidiaryCompanyAddressState, #subsidiaryCompanyAddressPc, #subsidiaryCompanyAddressCountry, #subsidiaryOfficialWebsite, #subsidiaryOfficialNumber, #subsidiarySSMRegNumber, #subsidiaryDateOfCompanyFormation, #subsidiaryLatestPaidUpCapital, #subsidiaryCopySSMCert, #subsidiaryCopyOfAnnualReturn, #subsidiaryHouseDevelopingLicense, #subsidiaryCopyOfHousingDeveloperLicense").valid()){
                stepper.next();
            } else {
                subsidiaryMembershipForm.find(":input.error").first().focus();
            }
        });
        $(".subsidiary-company-admin-btn").on("click", function () {
            if($("#subsidiaryAdminTitle, #subsidiaryNameOfAdmin, #subsidiaryAdminDesignation, #subsidiaryAdminEmail, #subsidiaryAdminContactNumber").valid()){
                stepper.next();
            } else {
                subsidiaryMembershipForm.find(":input.error").first().focus();
            }
        });


        $(".affiliate-general-information-btn").on("click", function () {
            if($("#affiliateCompanyPreferBranch, #affiliateOrdinaryMembershipNumber, #affiliateCompanyName, #affiliateCompanyAddress, #affiliateCompanyAddressCity, #affiliateCompanyAddressState, #affiliateCompanyAddressPc, #affiliateCompanyAddressCountry, #affiliateOfficialWebsite, #affiliateOfficialNumber, #affiliateSSMRegNumber, #affiliateDateOfCompanyFormation, #affiliateLatestPaidUpCapital, #affiliateCopySSMCert, #affiliateCopyOfAnnualReturn, #affiliateHouseDevelopingLicense, #affiliateCopyOfHousingDeveloperLicense").valid()){
                stepper.next();
            } else {
                affiliateMembershipForm.find(":input.error").first().focus();
            }
        });
        $(".affiliate-company-admin-btn").on("click", function () {
            if($("#affiliateAdminTitle, #affiliateNameOfAdmin, #affiliateAdminDesignation, #affiliateAdminEmail, #affiliateAdminContactNumber").valid()){
                stepper.next();
            } else {
                affiliateMembershipForm.find(":input.error").first().focus();
            }
        });
        $(".affiliate-official-representative-1-btn").on("click", function () {
            if($("#affiliateOfficial1Title, #affiliateOfficial1Nop, #affiliateMyKad, #affiliatePassportno, #affiliateOfficial1Designation, .affiliateOfficial1Gender, #affiliateOfficial1Email, #affiliateOfficial1Contact, #affiliateOfficial1Address, #affiliateOfficial1AddressCity, #affiliateOfficial1AddressState, #affiliateOfficial1AddressPc, #affiliateOfficial1AddressCountry, #affiliateOfficial1SecretartEmail").valid()){
                stepper.next();
            } else {
                affiliateMembershipForm.find(":input.error").first().focus();
            }
        });


        $(".associate-general-information-btn").on("click", function () {
            if($("#associateCompanyPreferBranch, .associateAccType, #associateCompanyName, #associateCompanyAddress, #associateCompanyAddressCity, #associateCompanyAddressState, #associateCompanyAddressPc, #associateCompanyAddressCountry, #associateOfficialWebsite, #associateOfficialNumber, #associateSSMRegNumber, #associateDateOfCompanyFormation, #associateLatestPaidUpCapital, #associateCopySSMCert, #associateCopyForm24, #associateCopyForm49, #associateCopyOfAnnualReturn").valid()){
                stepper.next();
            } else {
                associateMembershipForm.find(":input.error").first().focus();
            }
        });
        $(".associate-company-admin-btn").on("click", function () {
            if($("input:radio[name='associateAccType']:checked").val() == "1") {
                if($("#associateAdminTitle, #associateNameOfAdmin, #associateAdminDesignation, #associateAdminEmail, #associateAdminContactNumber").valid()){
                    stepper.next();
                } else {
                    associateMembershipForm.find(":input.error").first().focus();
                }
            } else {
                stepper.next();
            }
        });
        $(".associate-official-representative-1-btn").on("click", function () {
            if($("#associateOfficial1Title, #associateOfficial1Nop, #associateOfficial1MyKad, #associateOfficial1Passportno, #associateOfficial1Designation, .associateOfficial1Gender, #associateOfficial1Email, #associateOfficial1Contact, #associateOfficial1Address, #associateOfficial1AddressCity, #associateOfficial1AddressState, #associateOfficial1AddressPc, #associateOfficial1Country, #associateOfficial1SecretartEmail").valid()){
                stepper.next();
            } else {
                associateMembershipForm.find(":input.error").first().focus();
            }
        });


        $(".rehdayouth-general-information-btn").on("click", function () {
            if($("#rehdaYouthOrdinaryMembershipNumber, #rehdaYouthCompanyName, #rehdaYouthCompanyAddress, #rehdaYouthCompanyAddressCity, #rehdaYouthCompanyAddressState, #rehdaYouthCompanyAddressPc, #rehdaYouthCompanyAddressCountry, #rehdaYouthOfficialWebsite, #rehdaYouthOfficialNumber").valid()){
                stepper.next();
            } else {
                rehdayouthMembershipForm.find(":input.error").first().focus();
            }
        });


        $(".member-prev").on("click", function (e) {
            e.preventDefault();
            // stepper.previous();
            var activeStepIndex = $('.step.active').index('.step');
            if($('input[name="membertype"]:checked').val() == "ordinary") {
                stepper.previous();
            } else if(activeStepIndex == 5 && $('input[name="membertype"]:checked').val() == "subsidiary") {
                stepper.to(0);
            } else if(activeStepIndex == 8 && $('input[name="membertype"]:checked').val() == "affiliate") {
                stepper.to(0);
            } else if(activeStepIndex == 12 && $('input[name="membertype"]:checked').val() == "associate") {
                stepper.to(0);
            } else if(activeStepIndex == 16 && $('input[name="membertype"]:checked').val() == "rehdayouth") {
                stepper.to(0);
            } else {
                stepper.previous();
            }
        });

        setDefaultHeader();

        $(".membertype").on("change", function() {
            if($(this).val() == "ordinary") {
                $(".ordinary-head").show();
                $(".subsidiary-head").hide();
                $(".affiliate-head").hide();
                $(".associate-head").hide();
                $(".rehdayouth-head").hide();
            } else if($(this).val() == "subsidiary") {
                $(".ordinary-head").hide();
                $(".subsidiary-head").show();
                $(".affiliate-head").hide();
                $(".associate-head").hide();
                $(".rehdayouth-head").hide();
            } else if($(this).val() == "affiliate") {
                $(".ordinary-head").hide();
                $(".subsidiary-head").hide();
                $(".affiliate-head").show();
                $(".associate-head").hide();
                $(".rehdayouth-head").hide();
            } else if($(this).val() == "associate") {
                $(".ordinary-head").hide();
                $(".subsidiary-head").hide();
                $(".affiliate-head").hide();
                $(".associate-head").show();
                $(".rehdayouth-head").hide();
            } else if($(this).val() == "rehdayouth") {
                $(".ordinary-head").hide();
                $(".subsidiary-head").hide();
                $(".affiliate-head").hide();
                $(".associate-head").hide();
                $(".rehdayouth-head").show();
            } else {
                setDefaultHeader();
            }
        });

        $("form[name='membertype-form']").validate({
            rules: {
                membertype: "required",
            },
            invalidHandler: function(form, validator) {
                if (validator.numberOfInvalids() > 0) {
                    validator.showErrors();

                    $('label.error').each(function(i) {
                        if ($(this).text().length == 0) {
                            $(this).remove();
                        }
                    });
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
                // stepper.next();
                if($('input[name="membertype"]:checked').val() == "ordinary") {
                    stepper.next();
                } else if($('input[name="membertype"]:checked').val() == "subsidiary") {
                    stepper.to(6);
                } else if($('input[name="membertype"]:checked').val() == "affiliate") {
                    stepper.to(9);
                } else if($('input[name="membertype"]:checked').val() == "associate") {
                    stepper.to(13);
                } else if($('input[name="membertype"]:checked').val() == "rehdayouth") {
                    stepper.to(17);
                }
            }
        });

        $(".mykadDiv1").show();
        $(".passportDiv1").hide();

        $(".mykadSelect1").on("change", function() {
            if($(this).val() == 1){
                $(".mykadDiv1").show();
                $(".passportDiv1").hide();
                $(".passport1").val('');
            } else {
                $(".mykadDiv1").hide();
                $(".passportDiv1").show();
                $(".mykad1").val('');
            }
        });

        $(".mykadDiv2").show();
        $(".passportDiv2").hide();

        $(".mykadSelect2").on("change", function() {
            if($(this).val() == 1){
                $(".mykadDiv2").show();
                $(".passportDiv2").hide();
                $(".passport2").val('');
            } else {
                $(".mykadDiv2").hide();
                $(".passportDiv2").show();
                $(".mykad2").val('');
            }
        });

    });
</script>

@endsection
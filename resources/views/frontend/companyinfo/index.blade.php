@extends('layouts.app')

@section('title', 'Company Information')

@section('css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
<link href="{{ asset('frontend/css/pages/choosecompany.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('choosecompant.index') }}">Other Accounts</a>
                </li>

                <li class="breadcrumb-item active">Company Information</li>

            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Company Information</h5>
        </div>
        <!-- <div class="card-datatable table-responsive"> -->
        <div class="card-body">
        @if(isset($memberComp) && $memberComp)
            @if($memberComp->member->m_type != 6)
            <form method="POST" action="{{ route('companyinfo.update') }}" onsubmit="disableSubmitButton(this)" id="companyinfo-form">
            @csrf
            @endif
                <div class="row mt-3">
                    <div class="mb-3 col-md-12">
                        <label for="company" class="form-label form-label-lg required_label">Company Name</label>
                        <p class="mb-0 form-label-lg">{{ $memberComp->d_compname }}</p>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="ssmno" class="form-label form-label-lg required_label">SSM Registration No.</label>
                        <p class="mb-0 form-label-lg">{{ $memberComp->d_compssmno }}</p>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="date_of_company_formation" class="form-label form-label-lg required_label">Date of Incorporation</label>
                        <input class="form-control form-control-lg date_of_company_formation" type="date" id="date_of_company_formation" name="date_of_company_formation" value="{{ $memberComp->d_datecompform }}" {{ $memberComp->member->m_type == 6 ? 'disabled' : '' }} />
                        @if ($errors->has('date_of_company_formation'))
                        <span class="error">{{ $errors->first('date_of_company_formation') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="latest_paid_up_capital" class="form-label form-label-lg required_label">Latest Paid-Up Capital</label>
                        <select id="latest_paid_up_capital" name="latest_paid_up_capital" class="form-select form-select-lg" disabled>
                            @foreach($paidups as $paidup)
                                <option value="{{ $paidup->pt_id }}" {{ ($paidup->pt_id == $memberComp->d_paidcapital) ? 'selected' : '' }}>{{ $paidup->pt_desc }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('latest_paid_up_capital'))
                        <span class="error">{{ $errors->first('latest_paid_up_capital') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="official_website" class="form-label form-label-lg">Official Website</label>
                        <input class="form-control form-control-lg official_website" type="text" id="official_website" name="official_website" value="{{ $memberComp->d_comp_weburl }}" {{ $memberComp->member->m_type == 6 ? 'disabled' : '' }} />
                        @if ($errors->has('official_website'))
                        <span class="error">{{ $errors->first('official_website') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="address" class="form-label form-label-lg required_label">Address (Line 1)</label>
                        <input class="form-control form-control-lg address" type="text" id="address" name="address" value="{{ $memberComp->d_compadd }}" {{ $memberComp->member->m_type == 6 ? 'disabled' : '' }} oninput="this.value = this.value.toUpperCase();" />
                        @if ($errors->has('address'))
                        <span class="error">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="city" class="form-label form-label-lg required_label">Address (Line 2)</label>
                        <input class="form-control form-control-lg city" type="text" id="city" name="city" value="{{ $memberComp->d_compaddcity }}" {{ $memberComp->member->m_type == 6 ? 'disabled' : '' }} oninput="this.value = this.value.toUpperCase();" />
                        @if ($errors->has('city'))
                        <span class="error">{{ $errors->first('city') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="address_3" class="form-label form-label-lg">Address (Line 3)</label>
                        <input class="form-control form-control-lg address_3" type="text" id="address_3" name="address_3" value="{{ $memberComp->d_compadd_3 }}" {{ $memberComp->member->m_type == 6 ? 'disabled' : '' }} oninput="this.value = this.value.toUpperCase();" />
                        @if ($errors->has('address_3'))
                        <span class="error">{{ $errors->first('address_3') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="postcode" class="form-label form-label-lg required_label">Postcode</label>
                        <input class="form-control form-control-lg postcode" type="text" id="postcode" name="postcode" value="{{ $memberComp->d_compaddpcode }}" {{ $memberComp->member->m_type == 6 ? 'disabled' : '' }} />
                        @if ($errors->has('postcode'))
                        <span class="error">{{ $errors->first('postcode') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="state" class="form-label form-label-lg required_label">State</label>
                        <select id="state" name="state" class="form-select form-select-lg" {{ $memberComp->member->m_type == 6 ? 'disabled' : '' }}>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->state_id }}" {{ ($state->state_id == $memberComp->d_compaddstate) ? 'selected' : '' }}>{{ $state->state_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('state'))
                        <span class="error">{{ $errors->first('state') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="country" class="form-label form-label-lg">Country</label>
                        <select id="country" name="country" class="form-select form-select-lg" {{ $memberComp->member->m_type == 6 ? 'disabled' : 'disabled' }}>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->country_id }}" {{ ($country->country_id == $memberComp->d_compaddcountry) ? 'selected' : '' }}>{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('country'))
                        <span class="error">{{ $errors->first('country') }}</span>
                        @endif
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="office_no" class="form-label form-label-lg required_label">Office Contact No.</label>
                        <input class="form-control form-control-lg office_no" type="text" id="office_no" name="office_no" value="{{ $memberComp->d_offno }}" {{ $memberComp->member->m_type == 6 ? 'disabled' : '' }} oninput="this.value = this.value.toUpperCase();" />
                        @if ($errors->has('office_no'))
                        <span class="error">{{ $errors->first('office_no') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="faxno" class="form-label form-label-lg">Fax No.</label>
                        <input class="form-control form-control-lg faxno" type="text" id="faxno" name="faxno" value="{{ $memberComp->d_faxno }}" {{ $memberComp->member->m_type == 6 ? 'disabled' : '' }} oninput="this.value = this.value.toUpperCase();" />
                        <span class="error"></span>
                    </div>

                    @if(!empty($memberComp->d_f9ssm))
                    <div class="mb-3 col-md-12">
                        <label for="ssmcertificate" class="form-label form-label-lg required_label">Attachment: Copy of SSM Certification</label>
                        <p class="mb-0"><a href="{{ url(str_replace('../','',$memberComp->d_f9ssm)) }}" target="_blank">View</a></p>
                    </div>
                    @endif
                    @if(!empty($memberComp->d_f24))
                    <div class="mb-3 col-md-12">
                        <label for="ssmcertificate" class="form-label form-label-lg required_label">Attachment: Copy of Form 24</label>
                        <p class="mb-0"><a href="{{ url(str_replace('../','',$memberComp->d_f24)) }}" target="_blank">View</a></p>
                    </div>
                    @endif
                    @if(!empty($memberComp->d_f49))
                    <div class="mb-3 col-md-12">
                        <label for="ssmcertificate" class="form-label form-label-lg required_label">Attachment: Copy of Form 49</label>
                        <p class="mb-0"><a href="{{ url(str_replace('../','',$memberComp->d_f49)) }}" target="_blank">View</a></p>
                    </div>
                    @endif
                    @if(!empty($memberComp->d_anualretuncopy))
                    <div class="mb-3 col-md-12">
                        <label for="ssmcertificate" class="form-label form-label-lg required_label">Attachment: Copy of Annual Return</label>
                        <p class="mb-0"><a href="{{ url(str_replace('../','',$memberComp->d_anualretuncopy)) }}" target="_blank">View</a></p>
                    </div>
                    @endif
                    @if(!empty($memberComp->d_devlicense))
                    <div class="mb-3 col-md-12">
                        <label for="ssmcertificate" class="form-label form-label-lg required_label">House Developer License No.</label>
                        <p class="mb-0 form-label-lg">{{ $memberComp->d_devlicense }}</p>
                    </div>
                    @endif
                    @if(!empty($memberComp->d_devlicensecopy))
                    <div class="mb-3 col-md-12">
                        <label for="ssmcertificate" class="form-label form-label-lg required_label">Attachment: Copy of Housing Developer's License No.</label>
                        <p class="mb-0"><a href="{{ url(str_replace('../','',$memberComp->d_devlicensecopy)) }}" target="_blank">View</a></p>
                    </div>
                    @endif
                </div>
                @if($memberComp->member->m_type != 6)
                <div class="mt-2">
                    <button type="submit" class="btn btn-lg btn-primary me-2" id="submitBtn">Update</button>
                </div>
            </form>
                @endif
        @endif
        </div>
    </div>

</div>
@endsection

<script>
    function disableSubmitButton(form) {
        // Disable the submit button
        const submitButton = form.querySelector("#submitBtn");
        submitButton.disabled = true;
    }
</script>
@extends('layouts.app')

@section('title', 'Edit Member')

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('backend/assets/css/pages/edit-member-profile.css') }}" /> --}}
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Members</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Member</li>
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
            <div class="card mb-4">
                <h5 class="card-header">Edit Member</h5>
                <form class="card-body addnew" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
                    @csrf
                    @if($data->m_type = 2 || $data->m_type == 3 || $data->m_type == 4 || $data->m_type == 6)
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="ordmm">Ordinary Member-Membership No.<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <select id="ordmm" class="select2 form-select" name="ordmm">
                                @if(count($ordinaryMembers))
                                    @foreach($ordinaryMembers as $member)
                                        <option value="{{ $member->mid }}" {{ $data->d_parentcomp == $member->mid ? 'selected' : '' }}>
                                            {{ $member->member_no }} {{ $member->d_compname }}
                                        </option>
                                    @endforeach
                                    <option value="">Select</option>
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    @endif
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="compname">Company Name<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="compname" name="compname" class="form-control" placeholder="Company Name" value="{{ $data->d_compname }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="compadd">Address<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="compadd" name="compadd" class="form-control" placeholder="Address" value="{{ $data->d_compadd }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="compcity">City<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="compcity" name="compcity" class="form-control" placeholder="City" value="{{ $data->d_compaddcity }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="compstate">State<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <select id="compstate" name="compstate" class="form-control">
                                <option value="">Select State</option>
                                @foreach ($states as $stateId => $stateName)
                                    <option value="{{ $stateId }}" {{ $data->d_compaddstate == $stateId ? 'selected' : '' }}>
                                        {{ $stateName }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="comppc">Postcode<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="comppc" name="comppc" class="form-control" placeholder="Postcode" value="{{ $data->d_compaddpcode }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="compcountry">Country<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <select id="compcountry" name="compcountry" class="form-control">
                                <option value="">Select Country</option>
                                @foreach ($countries as $countryId => $countryName)
                                    <option value="{{ $countryId }}" {{ $data->d_compaddcountry == $countryId ? 'selected' : '' }}>
                                        {{ $countryName }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="d_comp_weburl">Official Website URL<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="d_comp_weburl" name="d_comp_weburl" class="form-control" placeholder="Official Website URL" value="{{ $data->d_comp_weburl }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="d_offno">Office No.<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="d_offno" name="d_offno" class="form-control" placeholder="Office No." value="{{ $data->d_offno }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="d_faxno">Fax No.</label>
                        <div class="col-sm-10">
                            <input type="text" id="d_faxno" name="d_faxno" class="form-control" placeholder="Fax No." value="{{ $data->d_faxno }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    @if($data->m_type != 5 && $data->m_type != 6)
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="d_compssmno">SSM Registration No.<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="d_compssmno" name="d_compssmno" class="form-control" placeholder="SSM Registration No." value="{{ $data->d_compssmno }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="d_datecompform">Date Formation<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="d_datecompform" name="d_datecompform" class="form-control" placeholder="2021-02-21" value="{{ $data->d_datecompform }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="d_paidcapital">Latest Paid-Up Capital ({{config('currency.base_currency')}})<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <select id="d_paidcapital" name="d_paidcapital" class="form-control">
                                @foreach ($plantiers as $ptierId => $ptdesc)
                                    <option value="{{ $ptierId }}" {{ $data->d_paidcapital == $ptierId ? 'selected' : '' }}>
                                        {{ $ptdesc }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    @endif
                    <hr class="my-4 mx-n4">

                    @if($data->m_type != 5 && $data->m_type != 6)
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="f9">SSM<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="f9" name="f9"/>
                            @if(!empty($data->d_f9ssm))
                                <a href="{{ asset('/storage') . "/" . $data->d_f9ssm}}" target="_blank"><i class="tf-icons ti ti-photo"></i></i>Form 9</a>
                                <input name="ef9" type="hidden" value="{{$data->d_f9ssm}}" readonly>
                            @endif
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="f24">Form 24<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="f24" name="f24"/>
                            @if(!empty($data->d_f24))
                                <a href="{{ asset('/storage') . "/" . $data->d_f24}}" target="_blank"><i class="tf-icons ti ti-photo"></i></i>Form 24</a>
                                <input name="ef24" type="hidden" value="{{$data->d_f24}}" readonly>
                            @endif
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="f49">Form 49<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="f49" name="f49"/>
                            @if(!empty($data->d_f49))
                                <a href="{{ asset('/storage') . "/" . $data->d_f49}}" target="_blank"><i class="tf-icons ti ti-photo"></i></i>Form 49</a>
                                <input name="ef49" type="hidden" value="{{$data->d_f49}}" readonly>
                            @endif
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="annreturn">Annual Return<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="annreturn" name="annreturn"/>
                            @if(!empty($data->d_anualretuncopy))
                                <a href="{{ asset('/storage') . "/" . $data->d_anualretuncopy}}" target="_blank"><i class="tf-icons ti ti-photo"></i></i>Annual Return</a>
                                <input name="eannreturn" type="hidden" value="{{$data->d_anualretuncopy}}" readonly>
                            @endif
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    @if($data->m_type != 4)
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="devlic">Housing Developer's License<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="d_devlicense" name="d_devlicense" class="form-control" placeholder="Housing Developer's License" value="{{ $data->d_devlicense }}">
                            <input type="file" class="form-control my-3" id="devlic" name="devlic"/>
                            @if(!empty($data->d_devlicensecopy))
                                <a href="{{ asset('/storage') . "/" . $data->d_devlicensecopy}}" target="_blank"><i class="tf-icons ti ti-photo"></i></i>Housing Developer's License</a>
                                <input name="edevlic" type="hidden" value="{{$data->d_devlicensecopy}}" readonly>
                            @endif
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    @endif
                    @elseif($data->m_type == 5)
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="f9">Supporting Document</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="f9" name="f9"/>
                            @if(!empty($data->d_f9ssm))
                                <a href="{{ asset('/storage') . "/" . $data->d_f9ssm}}" target="_blank"><i class="tf-icons ti ti-photo"></i></i>Supporting Document</a>
                                <input name="ef9" type="hidden" value="{{$data->d_f9ssm}}" readonly>
                            @endif
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    @endif

                    <hr class="my-4 mx-n4">


                    <h5 class="pb-3">Company Admin</h5>

                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="adminname">Full Name<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="adminname" name="adminname" class="form-control" placeholder="Full Name" value="{{ $userProfile->up_fullname }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <input id="upadminid" name="upadminid" value="{{ $userProfile->up_id}}" type="hidden" readonly>

                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="admintitle">Title<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <select id="admintitle" name="admintitle" class="form-control">
                                @foreach ($salutations as $sId => $sName)
                                    <option value="{{ $sId }}" {{ $sId == $userProfile->up_title ? 'selected' : '' }}>
                                        {{ $sName }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="adminpost">Designation<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="adminpost" name="adminpost" class="form-control" placeholder="Designation" value="{{ $userProfile->up_designation }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="adminemail">Email<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="email" id="adminemail" name="adminemail" class="form-control" placeholder="Email" value="{{ $userProfile->up_emailadd }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="adminmobile">Contact No.<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="adminmobile" name="adminmobile" class="form-control" placeholder="Contact No." value="{{ $userProfile->up_contactno }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>


                    <hr class="my-4 mx-n4">

                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="rem">Remarks (For office use)</label>
                        <div class="col-sm-10">
                            <textarea id="rem" name="rem" class="form-control">{{ $data->d_remarks }}</textarea>
                        </div>
                    </div>

                    <div class="pt-4">
                        <label class="col-sm-2" for="rem"></label>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Submit</button>
                        <a href="{{ url()->previous() ?? '/members/active' }}" class="btn btn-label-secondary waves-effect">Back</a>
                    </div>
                </form>
            </div>

    </div>
    <!-- / Content -->

@endsection

@section('page-js')
    <script>
        var getNewRegistrations = "{{ route('members.newRegistration') }}";
        var updateMemberProfileUrl = "{{ route('active-members.profile.update', ['id' => $mid]) }}";
    </script>

    <script src="{{ addPageJsLink('edit-member-profile.js?v=' . assetVersion() . time()) }}"></script>
@endsection

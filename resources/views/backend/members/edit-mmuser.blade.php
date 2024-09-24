@extends('layouts.app')

@section('title', 'Edit Member User')

@section('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/pages/edit-registrations.css') }}" />
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
                    <li class="breadcrumb-item active">Edit Member User</li>
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
            <div class="card mb-4">
                <h4 class="card-header">Edit Member</h4>
                <hr class="my-4 mb-0 mt-0">
                <form class="card-body addnew" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
                    @csrf
                    <input type="hidden" name="id" value="{{request()->query('id')}}">
                    <input type="hidden" name="mid" value="{{request()->query('mid')}}">
                    @if($memberProfile->up_usertype == 1)
                        <h5 class="pb-3">Official Representative</h5>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_fullname">Full Name<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="up_fullname" name="up_fullname" class="form-control" placeholder="Full Name" value="{{ $memberProfile->up_fullname }}" required="required">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="title">Title<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <select id="title" name="title" class="form-control">
                                    @foreach ($salutations as $sId => $sName)
                                        <option value="{{ $sId }}" {{ $sId == $memberProfile->up_title ? 'selected' : '' }}>
                                            {{ $sName }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="mykad">MyKad No. <small>(Member Login Username)</small><span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="mykad" name="mykad" class="form-control" placeholder="MyKad No." value="{{ $memberProfile->up_mykad }}" required="required">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="designation">Designation<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="designation" name="designation" class="form-control" placeholder="Designation" value="{{ $memberProfile->up_designation }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="gender">Gender<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <select id="gender" name="gender" class="form-control">
                                    @foreach ($genders as $gId => $gName)
                                        <option value="{{ $gId }}" {{ $gId == $memberProfile->up_gender ? 'selected' : '' }}>
                                            {{ $gName }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_profq">Professional Qualification (if any)</label>
                            <div class="col-sm-10">
                                <input type="text" id="up_profq" name="up_profq" class="form-control" placeholder="Professional Qualification" value="{{ $memberProfile->up_profq }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="emailadd">Email<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="emailadd" name="emailadd" class="form-control" placeholder="Email" value="{{ $memberProfile->up_emailadd }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="mobileno">Contact No.<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="mobileno" name="mobileno" class="form-control" placeholder="Contact No." value="{{ $memberProfile->up_contactno }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_address">Correspondence Address<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="up_address" name="up_address" class="form-control" placeholder="Correspondence Address" value="{{ $memberProfile->up_address }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_city">City<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="up_city" name="up_city" class="form-control" placeholder="City" value="{{ $memberProfile->up_city }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_state">State<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <select id="up_state" name="up_state" class="form-control" required="required">
                                    <option value="" selected disabled>Select State</option>
                                    @foreach ($states as $stateId => $stateName)
                                        <option value="{{ $stateId }}" {{ $memberProfile->up_state == $stateId ? 'selected' : '' }}>
                                            {{ $stateName }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_postcode">Postcode<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="up_postcode" name="up_postcode" class="form-control" placeholder="Postcode" value="{{ $memberProfile->up_postcode }}" required="required">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_country">Country<span class="required">*</span></label>
                            <div class="col-sm-10">
                                <select id="up_country" name="up_country" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $countryId => $countryName)
                                        <option value="{{ $countryId }}" {{ $memberProfile->up_country == $countryId ? 'selected' : '' }}>
                                            {{ $countryName }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <hr class="my-4 mx-n4">
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_sec_name">Secretary Name</label>
                            <div class="col-sm-10">
                                <input type="text" id="up_sec_name" name="up_sec_name" class="form-control" placeholder="Secretary Name" value="{{ $memberProfile->up_sec_name }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_sec_title">Title</label>
                            <div class="col-sm-10">
                                <select id="up_sec_title" name="up_sec_title" class="form-control">
                                    @foreach ($salutations as $sId => $sName)
                                        <option value="{{ $sId }}" {{ $sId == $memberProfile->up_sec_title ? 'selected' : '' }}>
                                            {{ $sName }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_sec_email">Secretary Email</label>
                            <div class="col-sm-10">
                                <input type="text" id="up_sec_email" name="up_sec_email" class="form-control" placeholder="Secretary Email" value="{{ $memberProfile->up_sec_email }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3 pb-3">
                            <label class="col-sm-2 col-form-label" for="up_sec_mobile">Secretary Contact No.</label>
                            <div class="col-sm-10">
                                <input type="text" id="up_sec_mobile" name="up_sec_mobile" class="form-control" placeholder="Secretary Contact No" value="{{ $memberProfile->up_sec_mobile }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    @else
                    <h5 class="pb-3">Company Admin</h5>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="adminname">Full Name<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="adminname" name="adminname" class="form-control" placeholder="Full Name" value="{{ $memberProfile->up_fullname }}" required="required">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="admintitle">Title<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <select id="admintitle" name="admintitle" class="form-control">
                                @foreach ($salutations as $sId => $sName)
                                    <option value="{{ $sId }}" {{ $sId == $memberProfile->up_title ? 'selected' : '' }}>
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
                            <input type="text" id="adminpost" name="adminpost" class="form-control" placeholder="Designation" value="{{ $memberProfile->up_designation }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="adminemail">Email<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="email" id="adminemail" name="adminemail" class="form-control" placeholder="Email" value="{{ $memberProfile->up_emailadd }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row g-3 pb-3">
                        <label class="col-sm-2 col-form-label" for="adminmobile">Contact No.<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="adminmobile" name="adminmobile" class="form-control" placeholder="Contact No." value="{{ $memberProfile->up_contactno }}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    @endif

                    <div class="pt-4">
                        <label class="col-sm-2" for="rem"></label>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Submit</button>
                        <a href="{{ url()->previous() }}" class="btn btn-label-secondary waves-effect">Back</a>
                    </div>
                </form>
            </div>

    </div>
    <!-- / Content -->

@endsection

@section('page-js')
    <script>
        var getNewRegistrations = "{{ route('members.newRegistration') }}";
        var updateMMUserUrl = "{{ route('active-members.updateUser')}}";

    </script>

    <script src="{{ addPageJsLink('edit-mmuser.js?v=' . assetVersion() . time()) }}"></script>
@endsection

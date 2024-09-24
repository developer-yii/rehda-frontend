@extends('layouts.frontend.app')

@section('title', 'Add Member Office Rep')

@section('css')
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
                    <li class="breadcrumb-item active">Add Member Office Rep</li>
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
        <div class="card mb-4">
            <h4 class="card-header">Add Member Office Rep</h4>
            <hr class="my-4 mb-0 mt-0">
            <form class="card-body addnew" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
                @csrf
                <input type="hidden" name="mid" value="{{$mid}}" readonly>
                <h5 class="pb-3">Official Representative</h5>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="up_fullname">Full Name<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="up_fullname" name="up_fullname" class="form-control"
                            placeholder="Full Name">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="title">Title<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <select id="title" name="title" class="form-control">
                            <option value="">Select Title</option>
                            @foreach ($salutations as $sId => $sName)
                                <option value="{{ $sId }}">
                                    {{ $sName }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="mykad">MyKad No. <small>(Member Login
                            Username)</small><span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="mykad" name="mykad" class="form-control" placeholder="MyKad No.">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="designation">Designation<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="designation" name="designation" class="form-control"
                            placeholder="Designation">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="gender">Gender<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <select id="gender" name="gender" class="form-control">
                            @foreach ($genders as $gId => $gName)
                                <option value="{{ $gId }}">
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
                        <input type="text" id="up_profq" name="up_profq" class="form-control"
                            placeholder="Professional Qualification">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="emailadd">Email<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="emailadd" name="emailadd" class="form-control" placeholder="Email">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="mobileno">Contact No.<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="mobileno" name="mobileno" class="form-control"
                            placeholder="Contact No.">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="up_address">Correspondence Address<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="up_address" name="up_address" class="form-control"
                            placeholder="Correspondence Address">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="up_city">City<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="up_city" name="up_city" class="form-control" placeholder="City">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="up_state">State<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <select id="up_state" name="up_state" class="form-control">
                            <option value="" selected disabled>Select State</option>
                            @foreach ($states as $stateId => $stateName)
                                <option value="{{ $stateId }}">
                                    {{ $stateName }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="up_postcode">Postcode<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="up_postcode" name="up_postcode" class="form-control"
                            placeholder="Postcode">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="up_country">Country<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <select id="up_country" name="up_country" class="form-control">
                            <option value="">Select Country</option>
                            @foreach ($countries as $countryId => $countryName)
                                <option value="{{ $countryId }}">
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
                        <input type="text" id="up_sec_name" name="up_sec_name" class="form-control"
                            placeholder="Secretary Name">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="up_sec_title">Title</label>
                    <div class="col-sm-10">
                        <select id="up_sec_title" name="up_sec_title" class="form-control">
                            @foreach ($salutations as $sId => $sName)
                                <option value="{{ $sId }}">
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
                        <input type="text" id="up_sec_email" name="up_sec_email" class="form-control"
                            placeholder="Secretary Email">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="up_sec_mobile">Secretary Contact No.</label>
                    <div class="col-sm-10">
                        <input type="text" id="up_sec_mobile" name="up_sec_mobile" class="form-control"
                            placeholder="Secretary Contact No">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="pt-4">
                    <label class="col-sm-2" for="rem"></label>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Submit</button>
                    {{-- <a href="{{ url()->previous() }}" class="btn btn-label-secondary waves-effect">Back</a> --}}
                    <button type="button" onclick="window.open('', '_self', ''); window.close();" class="btn btn-label-secondary waves-effect">Close</button>
                </div>
            </form>
        </div>

    </div>
    <!-- / Content -->

@endsection

@section('page-js')
    <script>
        var addOffrepMMUserUrl = "{{ route('active-members.post-addmmOffUser') }}";
    </script>

    <script src="{{ addPageJsLink('add-offrep-member.js?v=' . assetVersion() . time()) }}"></script>
@endsection

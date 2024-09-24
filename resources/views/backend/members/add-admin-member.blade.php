@extends('layouts.frontend.app')

@section('title', 'Add Member Admin')

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
                    <li class="breadcrumb-item active">Add Member Admin</li>
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
        <div class="card mb-4">
            <h4 class="card-header">Add Member Admin</h4>
            <hr class="my-4 mb-0 mt-0">
            <form class="card-body addnew" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
                @csrf
                <input type="hidden" name="mid" value="{{$mid}}" readonly>
                <h5 class="pb-3">Company Admin</h5>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="adminname">Full Name<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="adminname" name="adminname" class="form-control"
                            placeholder="Full Name">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="admintitle">Title<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <select id="admintitle" name="admintitle" class="form-control">
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
                    <label class="col-sm-2 col-form-label" for="adminpost">Designation<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="adminpost" name="adminpost" class="form-control"
                            placeholder="Designation">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="adminemail">Email<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="adminemail" name="adminemail" class="form-control" placeholder="Email">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="adminmobile">Contact No.<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="adminmobile" name="adminmobile" class="form-control"
                            placeholder="Contact No.">
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
        var addAdminMMUserUrl = "{{ route('active-members.post-addmmAdmUser') }}";
    </script>

    <script src="{{ addPageJsLink('add-admin-member.js?v=' . assetVersion() . time()) }}"></script>
@endsection

@extends('layouts.app')

@section('title', 'Branch Newsletter| Create')

@section('content')
 <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashbord</a>
                    </li>
                    <li class="breadcrumb-item active">New Newsletter</li>
                </ol>
            </nav>
        </div>

        {{-- Newsletter --}}
        <div class="card mb-4">
            <h5 class="card-header">New Newsletter</h5>
            <form class="card-body addNewsletter" method="post"  enctype="multipart/form-data" name="addnewsletter" id="addnewsletter">
                @csrf
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="bu_name">Newsletter Title<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="bu_name" name="bu_name" class="form-control" placeholder="Newsletter Title">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="bu_yr">Newsletter Year<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="bu_yr" name="bu_yr" class="form-control" placeholder="Newsletter Year">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="bu_img_cover">Newsletter Image<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" id="bu_img_cover" name="bu_img_cover" class="form-control" accept=".jpeg, .jpg, .png">
                        <small class="text-danger">Max file size: 1MB per image.</small><br>
                        <small class="text-danger">Recommended: 212 x 236 (JPEG,JPG,PNG).</small>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="bu_file_path">Newsletter PDF<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" id="bu_file_path" name="bu_file_path" class="form-control" accept=".pdf">
                        <small class="text-danger">Max file size: 10MB per file.</small><br>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="bu_status">Status</label>
                    <div class="col-sm-10">
                        <select name="bu_status" id="bu_status" class="form-control">
                            <option value="2">Publish</option>
                            <option value="1">Draft</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="pt-4">
                    <label class="col-sm-2" for="rem"></label>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Submit</button>
                    <a href="{{ route('newsletters.index')}}" class="btn btn-label-secondary waves-effect">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        var storeUrl = "{{ route('newsletters.store') }}";
    </script>
    <script src="{{ addPageJsLink('add-newSletters.js?v=' . assetVersion() . time()) }}"></script>

@endsection

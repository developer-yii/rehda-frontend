@extends('layouts.app')

@section('title', 'Branch Circulars | Edit')


@php
    $pdf = str_replace('../', '', $data->ar_file_path);
    $pdfUrl = asset('storage/' . $pdf);
@endphp
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Branch Circulars</li>
                </ol>
            </nav>
        </div>

        {{-- Circular --}}
        <div class="card mb-4">
            <h5 class="card-header">Edit Branch Circular</h5>
            <form class="card-body editCircular" method="post" enctype="multipart/form-data" name="editcircular"
                id="editcircular">
                @csrf
                <input type="hidden" name="ar_id" id="ar_id" value="{{ $data->ar_id }}">
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="ar_date">Branch Circular Date<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="datepicker" value="{{ $data->ar_date }}" name="ar_date" placeholder="Select a date"
                            class="form-control"  />
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="ar_name">Branch Circular Title<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="ar_name" name="ar_name" value="{{ $data->ar_name }}" class="form-control"
                            placeholder="Branch Circular Title" >
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="ar_yr">Branch Circular Description<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <div>
                            <textarea name="ar_yr" id="ar_yr" rows="15" class="form-control">{{ $data->ar_yr }}</textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>


                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="ar_file_path">Branch Circular PDF<span
                            class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" id="ar_file_path" name="ar_file_path" class="form-control" accept=".pdf"
                            >
                            <a href="{{ $pdfUrl }}" target="_blank"><i class="tf-icons ti ti-file me-2"></i> Notice
                                PDF</a><br>
                        <small class="text-danger">Max file size: 10MB per file.</small><br>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row g-3 pb-3">
                    <label class="col-sm-2 col-form-label" for="ar_status">Status</label>
                    <div class="col-sm-10">
                        <select name="ar_status" id="ar_status" class="form-control">
                            <option value="2" {{ $data->ar_status == 2 ? 'selected' : '' }}>Publish</option>
                            <option value="1" {{ $data->ar_status == 1 ? 'selected' : '' }}>Draft</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="pt-4">
                    <label class="col-sm-2" for="rem"></label>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Submit</button>
                    <a href="{{ route('notices.index') }}" class="btn btn-label-secondary waves-effect">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="https://cdn.tiny.cloud/1/jqr6fryyvp757ant1wfm7o98aa9ofvsu6upc16bwosc412ii/tinymce/7/tinymce.min.js"></script>
    <script>
        var updateUrl = "{{ route('notices.update') }}";
    </script>
    <script src="{{ addPageJsLink('edit-notice.js?v=' . assetVersion() . time()) }}"></script>

@endsection

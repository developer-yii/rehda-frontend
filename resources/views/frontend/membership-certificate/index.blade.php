@extends('layouts.app')

@section('title', 'Membership Certificate')

@section('css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                        <a href="{{ route('choosecompant.index') }}">Other Accounts</a>
                    </li>

                    <li class="breadcrumb-item active">Membership Certificate</li>

                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">Membership Certificate</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="membershipCertificateTable">
                    <thead class="border-top">
                        <tr>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

</div>

@endsection

@section('page-js')
<script>
        var getMembershipCertificate = "{{ route('membership-certificate.index') }}";
</script>
<script src="{{ asset('frontend/js/pages/membership-certificate.js') }}"></script>
@endsection
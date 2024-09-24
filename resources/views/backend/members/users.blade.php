@extends('layouts.frontend.app')

@section('title', 'New Registrations | List')

@section('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/pages/member-users.css') }}" />
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Users List Table -->
        <div class="card">
            <h5 class="card-header">List of Users for {{ $companyName }}</h5>
            <div class="card-datatable table-responsive">
              <table class="dt-responsive table" width="100%">
                <thead>
                  <tr>
                    <th></th>
                    <th>User Type</th>
                    <th>Full Name</th>
                    <th>MyKad No.</th>
                    <th>Designation</th>
                    <th>Gender</th>
                    <th>Professional Qualification</th>
                    <th>Email</th>
                    <th>Contact No.</th>
                    <th>Correspondence Address</th>
                    <th>Secretary Details</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($userProfiles as $profile)
                    @if($profile->pas_status == 2)
                        @php $stringStatus =  '<span class="label label-success lb-lg">Active</span>'; @endphp
                    @elseif($profile->pas_status == 1)
                        @php $stringStatus =  '<span class="label label-warning lb-lg">Inactive</span>'; @endphp
                    @endif
                    <tr>
                        <td></td>
                        <td>
                            {{ getMemberUserType($profile->up_usertype,$profile->up_id,$profile->up_mid) }}
                        </td>
                        <td>
                          {{ getTitle($profile->up_title) }} {{$profile->up_fullname}}
                        </td>
                        <td>
                          {{ $profile->up_mykad }}
                        </td>
                        <td>
                          {{ $profile->up_designation }}
                        </td>
                        <td>
                            {{ getGender($profile->up_gender) }}
                        </td>
                        <td>
                            {{ $profile->up_profq }}
                        </td>
                        <td>
                            {{ $profile->up_emailadd }}
                        </td>
                        <td>
                            {{ $profile->up_contactno }}
                        </td>
                        <td>
                            {{ $profile->up_address }}
                        </td>
                        <td>
                            {{ getTitle($profile->up_sec_title) }}{{ $profile->up_sec_name }}
                            {{ $profile->up_sec_email }}
                            {{ $profile->up_sec_mobile }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
    </div>
    <!-- / Content -->
@endsection

@section('page-js')
    <script src="{{ addPageJsLink('member-userlist.js?v=' . assetVersion() . time()) }}"></script>
@endsection

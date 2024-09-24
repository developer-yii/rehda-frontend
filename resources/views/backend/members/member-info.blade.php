@extends('layouts.frontend.app')

@section('title', 'Active Member Info')

@section('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/pages/member-info.css') }}" />
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Users List Table -->
        <div class="card">
            <h5 class="card-header">View More - {{ $memberComp->d_compname }}</h5>
            <div class="card-body border-top">
                <div id="accordionIcon" class="accordion mt-3 accordion-without-arrow">
                    <div class="accordion-item card">
                        <h2 class="accordion-header text-body d-flex justify-content-between" id="accordionIconOne">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#accordionIcon-1" aria-controls="accordionIcon-1">
                                <h4 class="mb-0">Company Details</h4>
                            </button>
                        </h2>

                        <div id="accordionIcon-1" class="accordion-collapse collapse" data-bs-parent="#accordionIcon">
                            <div class="accordion-body project_details">
                                <p class="title">Member Type</p>
                                <p>{{ $memberType }}</p>
                                <p class="title">Company Name</p>
                                <p>{{ $memberComp->d_compname }} @if($memberComp->d_compssmno != '') {{ $memberComp->d_compssmno }} @endif </p>
                                <p class="title">Membership No.</p>
                                <p>{{ getMembershipNo($memberComp->d_mid) }}</p>
                                @if($memberComp->d_parentcomp != 0)
                                    <p class="title">Parent Membership No.</p>
                                    <p>{{ getMembershipNobyMID($memberComp->d_parentcomp) }}</p>
                                @endif
                                <p class="title">Date Formation</p>
                                <p>{{ $memberComp->d_datecompform }}</p>
                                <p class="title">Company Address</p>
                                <p>{{ $memberComp->d_compadd." ".$memberComp->d_compaddcity." ".getStatex($memberComp->d_compaddstate)." ".$memberComp->d_compaddpcode." ".getCountryx($memberComp->d_compaddcountry) }}</p>
                                <p class="title">Website URL</p>
                                <p>@if(!empty($memberComp->d_comp_weburl)) <a href="{{getWebUrl($memberComp->d_comp_weburl)}}" target="_blank">{{$memberComp->d_comp_weburl}}</a> @endif</p>
                                <p class="title">Office No.</p>
                                <p>{{ $memberComp->d_offno }}</p>
                                <p class="title">Fax No.</p>
                                <p>{{ $memberComp->d_faxno }}</p>
                                <p class="title">Paid-Up Capital ({{config('currency.base_currency')}})</p>
                                <p>{{ getCapital($memberComp->d_paidcapital) }}</p>
                                <p class="title">Approval Date</p>
                                <p>{{ $memberComp->member->m_approval_at }}</p>
                                <p class="title">Registration Date</p>
                                <p>{{ $memberComp->d_created_at }}</p>
                                <p class="title">Remarks (For office use)</p>
                                <p>{{ $memberComp->d_remarks }}</p>
                                <p class="title">Status</p>
                                <p>{!! $status !!}</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item card">
                        <h2 class="accordion-header text-body d-flex justify-content-between" id="accordionIconTwo">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#accordionIcon-2" aria-controls="accordionIcon-2">
                                <h4 class="mb-0">Supporting Docs</h4>
                            </button>
                        </h2>
                        <div id="accordionIcon-2" class="accordion-collapse collapse" data-bs-parent="#accordionIcon">
                            <div class="accordion-body">
                                <ol>
                				    @if(!empty($memberComp->d_f9ssm))
                				        <li><a href="{{asset('/storage') . "/" . $memberComp->d_f9ssm}}" target="_blank">SSM <i class="fa fa-link"></i></a></li>
                				    @endif
                				    @if(!empty($memberComp->d_f24))
                                        <li><a href="{{asset('/storage') . "/" . $memberComp->d_f24}}" target="_blank">Form 24 <i class="fa fa-link"></i></a></li>
                                        @endif
                                    @if(!empty($memberComp->d_f49))
                                        <li><a href="{{asset('/storage') . "/" . $memberComp->d_f49}}" target="_blank">Form 49 <i class="fa fa-link"></i></a></li>
                                    @endif
                                    @if(!empty($memberComp->d_anualretuncopy))
                                        <li><a href="{{asset('/storage') . "/" . $memberComp->d_anualretuncopy}}" target="_blank">Annual Return <i class="fa fa-link"></i></a></li>
                                    @endif
                                    @if(!empty($memberComp->d_devlicense))
                                        <li>Housing Developer\'s License No. <a href="{{asset('/storage') . "/" . $memberComp->d_devlicensecopy}}" target="_blank"> {{$memberComp->d_devlicense}}<i class="fa fa-link"></i></a></li>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item card">
                        <h2 class="accordion-header text-body d-flex justify-content-between" id="accordionIconThree">
                            <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                data-bs-target="#accordionIcon-3" aria-expanded="true" aria-controls="accordionIcon-3">
                                <h4 class="mb-0">Users</h4>
                            </button>
                        </h2>
                        <div id="accordionIcon-3" class="accordion-collapse collapse" data-bs-parent="#accordionIcon">
                            <div class="accordion-body">
                                @if(auth()->user()->can('memberusers-create'))
                                <a href="{{route('active-members.addmmOffUser',['mid' => $memberComp->did])}}" class="btn btn-warning btn-sm me-1"><i class="fa fa-plus me-1"></i> Office Rep</a>
                                <a href="{{route('active-members.addmmAdmUser',['mid' => $memberComp->did])}}" class="btn btn-success btn-sm"><i class="fa fa-plus me-1"></i> Admin</a><br>
                                @endif
                                <div class="card-datatable table-responsive">
                                    <table class="datatables-users table" id="registrations">
                                        <thead class="border-top">
                                            <tr>
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
                                                <th width="3%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>
                                                        {{ getMemberUserType($user->up_usertype, $user->up_id, $user->up_mid) }}
                                                    </td>
                                                    <td>
                                                        {{ getTitle($user->up_title) }} {{ $user->up_fullname }}
                                                        <br>
                                                        {!! getMMStatus($user->ml_status) !!}
                                                        @can('memberusers-edit')
                                                        <div class="pt-2">
                                                            <label class="switch">
                                                                <input id="uu{{ $user->ml_id }}" name="uu{{ $user->ml_id }}" value="{{ $user->ml_id }}" type="checkbox" {{ $user->ml_status === 1 ? 'checked' : '' }} class="switch-input" />
                                                                <span class="switch-toggle-slider">
                                                                  <span class="switch-on"></span>
                                                                  <span class="switch-off"></span>
                                                                </span>

                                                            </label>

                                                        </div>
                                                        @endcan
                                                    </td>
                                                    <td>{{ $user->up_mykad }}</td>
                                                    <td>{{ $user->up_designation }}</td>
                                                    <td>{{ getGender($user->up_gender) }}</td>
                                                    <td>{{ $user->up_profq }}</td>
                                                    <td>{{ $user->up_emailadd }}</td>
                                                    <td>{{ $user->up_contactno }}</td>
                                                    <td>{{ $user->up_address }}</td>
                                                    <td>
                                                        {{ getTitle($user->up_sec_title) }} {{ $user->up_sec_name }}
                                                        {{ $user->up_sec_email }}
                                                        {{ $user->up_sec_mobile }}
                                                    </td>
                                                    <td>
                                                        @can('memberusers-edit')
                                                            <a href="javascript:void(0);" data-username="{{ $user->ml_username}}" class="btn btn-outline-secondary btn-xs mb-1 w-max change-password"><i class="fa fa-edit me-1"></i> Reset Password</a><br>
                                                            <a href="{{ route('active-members.editUser', ['id' => $user->ml_id, 'mid' => request()->query('pid')]) }}" class="btn btn-info btn-xs mb-1"><i class="fa fa-edit me-1"></i> Edit</a><br>
                                                        @endcan
                                                        @can('memberusers-delete')
                                                            <a href="javascript:void(0);" class="btn btn-danger btn-xs del-usr" data-id="{{ $user->up_id }}"><i class="fa fa-trash me-1"></i> Del</a><br>
                                                        @endcan
                                                    </td>
                                                </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item card">
                        <h2 class="accordion-header text-body d-flex justify-content-between" id="accordionIconFour">
                            <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                data-bs-target="#accordionIcon-4" aria-expanded="true" aria-controls="accordionIcon-4">
                                <h4 class="mb-0">Membership Certificate</h4>
                            </button>
                        </h2>
                        <div id="accordionIcon-4" class="accordion-collapse collapse" data-bs-parent="#accordionIcon">
                            <div class="accordion-body">
                                <ol>
                                    @foreach($memberCerts as $cert)
                                        @if(!empty($cert->mc_cert_path))
                                            <li>
                                                <a href="{{ asset('storage').'/'.$cert->certificate_path }}" target="_blank">
                                                    {{ $cert->mc_yr }} <i class="fa fa-external-link-square"></i>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Modal -->
    <div class="modal fade" id="passwordChangeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordChangeModalLabel">Change Password Member User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" name="passwordChangeForm" id="passwordChangeForm">
                        @csrf
                        <input type="hidden" id="mid" name="mid" value="" readonly="">
                        <div class="row g-3">
                            <div class="mb-3">
                                <label class="form-label" for="username">Username<span class="required">*</span></label>
                                <input type="text" id="username" name="username" required="required" class="form-control" readonly>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3">
                                <label class="form-label" for="password">Password<span class="required">*</span></label>
                                <input type="password" id="password" name="password" required="required" class="form-control" placeholder="Min. 6 chars with upper & lower case & number">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Re-type Password<span class="required">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required="required" class="form-control" placeholder="Min. 6 chars with upper & lower case & number">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Change Password</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        var sendInvoiceUrl = "{{ route('mm-userlists.invoice-send') }}";
        var changeUserStatusUrl = "{{ route('mm-userlists.change-status')}}";
        var changePasswordUrl = "{{ route('active-members.resetPassword')}}";
        var delUserUrl = "{{ route('active-members.deleteUser') }}";
    </script>
    <script src="{{ addPageJsLink('member-info.js?v=' . assetVersion() . time()) }}"></script>
@endsection

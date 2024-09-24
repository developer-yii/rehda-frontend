@extends('layouts.app')

@section('title', 'Role | List')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">@if(!empty($role)) {{ __('translation.label_update') }} @else {{ __('translation.label_create') }} @endif {{ __('translation.label_role_and_permission') }}</h5>
                <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                    <div class="col-md-4 user_role"></div>
                    <div class="col-md-4 user_plan"></div>
                    <div class="col-md-4 user_status"></div>
                </div>
            </div>
            <!-- Add Role Modal -->
            <div class="card-body">
                <!-- Add role form -->
                <form id="addRole" class="row g-3" method="post">
                    @csrf
                    <input type="hidden" name="role_id" value="{{ @$role->id }}">
                    <div class="col-12 mb-4">
                        <label class="form-label required_label" for="modalRoleName">{{ __('translation.label_role_name') }}</label>
                        <input type="text" id="role_name" name="role_name" class="form-control role_name"
                            placeholder="{{ __('translation.placeholder_enter_a_role_name') }}" tabindex="-1" value="{{ @$role->name }}"/>
                        <span class="error"></span>
                    </div>
                    <div class="col-12">
                        <h5>Role Permissions</h5>
                        <!-- Permission table -->
                        <div class="table-responsive overflow-hidden">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-medium">
                                        {{ __('translation.label_administrator_access') }}
                                            <i class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Allows a full access to the system"></i>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll" />
                                                <label class="form-check-label" for="selectAll">{{ __('translation.label_select_all') }}
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <span class="error"></span>
                                    @foreach ($permissions ?? [] as $key => $value)
                                    <tr>
                                        <td class="text-nowrap fw-medium">{{ $key }} {{ __('translation.label_management') }}</td>
                                        <td>
                                            <div class="row">
                                                @foreach ($value as $val)
                                                    <div class="col-3 form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="permission" name="permissions[]" value="{{ $val->name }}" @if(in_array($val->name, $getrolepermission)) checked @endif/>
                                                        <label class="form-check-label" for="userManagementRead">
                                                            {{ $val->name }} </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">{{ __('translation.label_submit') }}</button>
                        <a href="{{ route('roles.index') }}" type="reset" class="btn btn-label-secondary">
                        {{ __('translation.label_cancel') }}
                        </a>
                    </div>
                </form>
                <!--/ Add role form -->
            </div>
        </div>
        <!--/ Add Role Modal -->


    </div>
    </div>
    <!-- / Content -->

@endsection

@section('page-js')
    <script>
        var createRole = "{{ route('roles.add') }}";
    </script>

    <script src="{{ addPageJsLink('roles-edit.js?v=' . assetVersion() . time()) }}"></script>
@endsection

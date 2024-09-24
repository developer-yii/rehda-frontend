@extends('layouts.app')

@section('title', 'User | List')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @can('dashboard-view')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">{{ __('translation.label_dashboard') }}</a>
                        </li>
                    @endcan
                    @can('room-view')
                        <li class="breadcrumb-item active">{{ __('translation.label_user') }}</li>
                    @endcan
                </ol>
            </nav>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">{{ __('translation.label_users') }}</h5>
                <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                    <div class="col-md-4 user_role"></div>
                    <div class="col-md-4 user_plan"></div>
                    <div class="col-md-4 user_status"></div>
                </div>
                @can('user-create')
                    <div class="btn-add-user add-customer">
                        <a href="javascript:void(0)" class="btn btn-primary">{{ __('translation.label_add_new_user') }}</a>
                    </div>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="users">
                    <thead class="border-top">
                        <tr>
                            <th>{{ __('translation.label_user') }}</th>
                            <th>{{ __('translation.label_role') }}</th>
                            <th>{{ __('translation.label_email') }}</th>
                            <th>Branch</th>
                            <th>{{ __('translation.label_active') }}</th>
                            @canany(['user-update', 'user-delete'])
                                <th>{{ __('translation.label_actions') }}</th>
                            @else
                            <th></th>
                            @endcan
                        </tr>
                    </thead>
                </table>
            </div>


        </div>
    </div>
    <!-- / Content -->

    <!-- Modal -->
    <div class="modal modal-top fade" id="userCreate" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" id="saveUser" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" class="user_id" id="user_id" />
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTopTitle">{{ __('translation.label_add_user') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="nameSlideTop" class="form-label required_label">{{ __('translation.label_first_name') }}</label>
                            <input type="text" id="first_name" class="form-control first_name" name="first_name"
                                placeholder="{{ __('translation.placeholder_enter_first_name') }}" />
                            <span class="error"></span>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="nameSlideTop" class="form-label required_label">{{ __('translation.label_last_name') }}</label>
                            <input type="text" id="last_name" class="form-control last_name" name="last_name"
                                placeholder="{{ __('translation.placeholder_enter_last_name') }}" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label required_label">{{ __('translation.label_email') }}</label>
                            <input type="text" id="email" class="form-control email" name="email"
                                placeholder="xyz@gmail.com" />
                            <span class="error"></span>
                        </div>
                        <div class="col-6 mb-0">
                            <label for="dobSlideTop" class="form-label">{{ __('translation.label_phone_number') }}</label>
                            <input type="text" id="phone_number" name="phone_number" placeholder="1234567890"
                                class="form-control phone_number" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6 mb-3">
                            <label for="dobSlideTop" class="form-label required_label">{{ __('translation.label_role') }}</label>
                            <select id="role" class="select2 form-select form-select-lg" name="role"
                                data-allow-clear="true">
                                <option value="">{{ __('translation.label_select_role') }}</option>
                                @foreach ($role as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <span class="error"></span>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="password" class="form-label required_label">{{ __('translation.label_password') }}</label>
                            <input type="password" id="password" name="password" class="form-control password" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-6 mb-3 w-25">
                        <label for="active" class="form-label">{{ __('translation.label_is_active') }}</label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" value="1" name="is_active" id="active"
                                checked="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 w-100 mb-3">
                            <label for="nameSlideTop" class="form-label">{{ __('translation.label_choose_image') }}</label>
                            <input class="form-control user_image" type="file" id="user_image" name="user_image">
                            <input type="hidden" name="hidden_image" class="hidden_image">
                            <span class="error"></span>
                        </div>
                        <div class="col-5 mb-3 float-end">
                            <div class="gallery">
                                <img id="modal-preview" src=""
                                    alt="Preview" class="form-group mt-2 img-size" width="200" height="200">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">{{ __('translation.label_save') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!--End Modal -->
@endsection

@section('page-js')
    <script>
        var getUser = "{{ route('user.getUser') }}";
        var getSingleUser = "{{ route('user.getSingleUser') }}/";
        var createUser = "{{ route('user.createUser') }}";
        var deleteUser = "{{ route('user.deleteUser') }}";
        var basepath = "{{ asset('storage/user_image') }}/";
        var defaultimg = "{{ asset('backend/assets/img/default-image.png') }}/";
    </script>

    <script src="{{ addPageJsLink('user.js?v=' . assetVersion() . time()) }}"></script>
@endsection

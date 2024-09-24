<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo w-auto h-auto">
                <img src="{{ getLogoPath() }}" height="40px" />
            </span>
            {{-- <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#7367F0" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="#7367F0" />
                </svg> --}}
            <span class="app-brand-text demo menu-text fw-bold">{{ __('translation.label_pms') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Page -->
        <!-- Dashboard -->


        <li class="menu-item {{ request()->is('dashboard') || request()->is('calendar') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="{{ __('translation.label_dashboard') }}">{{ __('translation.label_dashboard') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-calendar"></i>
                        <div data-i18n="{{ __('translation.label_overview') }}">{{ __('translation.label_overview') }}
                        </div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-item {{ request()->is('user') || request()->is('roles') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="{{ __('translation.label_user_access') }}">{{ __('translation.label_user_access') }}
                </div>
            </a>
            <ul class="menu-sub">
                <!-- User interface -->
                <li class="menu-item {{ request()->is('user') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-user"></i>
                        <div data-i18n="{{ __('translation.label_users') }}">{{ __('translation.label_users') }}</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('roles') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-lock"></i>
                        <div data-i18n="{{ __('translation.label_role_management') }}">
                            {{ __('translation.label_role_management') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('members') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Members">Members</div>
            </a>
            <ul class="menu-sub">

                <!-- User interface -->
                <li class="menu-item {{ request()->routeIs('members.newRegistration') ? 'active' : '' }}">
                    <a href="{{ route('members.newRegistration') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="New Registration">New Registration</div>
                    </a>
                </li>


                <li class="menu-item {{ request()->routeIs('mm-registration-reject.index') ? 'active' : '' }}">
                    <a href="{{ route('mm-registration-reject.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Rejected Registration">Rejected Registration</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('active-members.index') ? 'active' : '' }}">
                    <a href="{{ route('active-members.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Active Members">Active Members</div>
                    </a>
                </li>

                    <li class="menu-item {{ request()->routeIs('in-active-members.index') ? 'active' : '' }}">
                        <a href="{{route('in-active-members.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-devices"></i>
                            <div data-i18n="Inactive Members">Inactive Members</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('members') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-users"></i>
                            <div data-i18n="List of Member Users">List of Member Users</div>
                        </a>
                        <ul class="menu-sub">
                                <!-- User interface -->
                                <li class="menu-item {{ request()->routeIs('members.ordinaryUsers') ? 'active' : '' }}">
                                    <a href="{{route('members.ordinaryUsers')}}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-devices"></i>
                                    <div data-i18n="Ordinary Users">Ordinary Users</div>
                                    </a>
                                </li>

                                <!-- User interface -->
                                <li class="menu-item {{ request()->routeIs('members.subsidiaryUsers') ? 'active' : '' }}">
                                    <a href="{{route('members.subsidiaryUsers')}}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-devices"></i>
                                    <div data-i18n="Subsidiary Users">Subsidiary Users</div>
                                    </a>
                                </li>

                                <li class="menu-item {{ request()->routeIs('members.affiliateUsers') ? 'active' : '' }}">
                                    <a href="{{route('members.affiliateUsers')}}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-devices"></i>
                                    <div data-i18n="Affiliate Users">Affiliate Users</div>
                                    </a>
                                </li>

                                <li class="menu-item {{ request()->routeIs('members.associateUsers') ? 'active' : '' }}">
                                    <a href="{{route('members.associateUsers')}}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-devices"></i>
                                    <div data-i18n="Associate Users">Associate Users</div>
                                    </a>
                                </li>

                                <li class="menu-item {{ request()->routeIs('members.youthUsers') ? 'active' : '' }}">
                                    <a href="{{route('members.youthUsers')}}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-devices"></i>
                                    <div data-i18n="Youth Users">Youth Users</div>
                                    </a>
                                </li>


                        </ul>
                    </li>

            </ul>
        </li>

        <li class="menu-item {{ request()->is('official-rep') ? 'active' : '' }}">
            <a href="{{route('official-rep.change.requests')}}" class="menu-link">
                <i class="menu-icon ti ti-refresh"></i>
                <div data-i18n="Request Change Official Rep">Request Change Official Rep</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('circulars') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon ti ti-speakerphone"></i>
                <div data-i18n="Circulars">Circulars</div>
            </a>
            <ul class="menu-sub">

                <!-- Branch -->
                <li class="menu-item {{ request()->routeIs('circulars.index') ? 'active' : '' }}">
                    <a href="{{ route('circulars.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="List of Circulars">List of Circulars</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ request()->routeIs('circulars.create') || request()->routeIs('circulars.edit') ? 'active' : '' }}">
                    <a href="{{ route('circulars.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Add New Circulars">Add New Circulars</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('newsletters') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon ti ti-news"></i>
                <div data-i18n="Branch Newsletters">Branch Newsletters</div>
            </a>
            <ul class="menu-sub">

                <!-- Branch -->
                <li class="menu-item {{ request()->routeIs('newsletters.index') ? 'active' : '' }}">
                    <a href="{{ route('newsletters.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="List of Branch Newsletters">List of Branch Newsletters</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ request()->routeIs('newsletters.create') || request()->routeIs('newsletters.edit') ? 'active' : '' }}">
                    <a href="{{ route('newsletters.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Add New Branch Newsletter">Add New Branch Newsletter</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('newsletters.sortTable') ? 'active' : '' }}">
                    <a href="{{ route('newsletters.sortTable') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Sort Branch Newsletter">Sort Branch Newsletter</div>
                    </a>
                </li>

            </ul>
        </li>

        <li class="menu-item {{ request()->is('notices') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon  ti ti-speakerphone"></i>
                <div data-i18n="Branch Circulars">Branch Circulars</div>
            </a>
            <ul class="menu-sub">

                <!-- Branch -->
                <li class="menu-item {{ request()->routeIs('notices.index') ? 'active' : '' }}">
                    <a href="{{ route('notices.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="List of Branch Circulars">List of Branch Circulars</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ request()->routeIs('notices.create') || request()->routeIs('notices.edit') ? 'active' : '' }}">
                    <a href="{{ route('notices.create') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Add New Branch Circulars">Add New Branch Circulars</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon  ti ti-file-invoice"></i>
                <div data-i18n="Invoice / Receipt / Payment">Invoice / Receipt / Payment</div>
            </a>
            <ul class="menu-sub">

                <li class="menu-item">
                    <a href="{{ route('notices.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Unpaid Invoices">Unpaid Invoices</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('notices.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Paid Invoices">Paid Invoices</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('notices.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Cancelled Invoices">Cancelled Invoices</div>
                    </a>
                </li>
            </ul>
        </li>


        @can('setting-view')
            <li class="menu-item {{ request()->is('category') || request()->is('templates') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div data-i18n="{{ __('translation.label_setting') }}">{{ __('translation.label_setting') }}</div>
                </a>
                <ul class="menu-sub">
                    @can('setting-view')
                        <li class="menu-item {{ request()->is('setting') ? 'active' : '' }}">
                            <a href="{{ route('setting.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-settings"></i>
                                <div data-i18n="{{ __('translation.label_setting_configuration') }}">
                                    {{ __('translation.label_setting_configuration') }}</div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcanany
    </ul>
</aside>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('bulletin.index') }}" class="app-brand-link">
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

        <li class="menu-item {{ request()->is('user-profile') ? 'active' : '' }}">
            <a href="{{ route('userprofile.index') }}" class="menu-link">
            <i class="menu-icon  ti ti-user"></i>
            <div data-i18n="User Profile">User Profile</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('companyinfo') ? 'active' : '' }}">
            <a href="{{ route('companyinfo.index') }}" class="menu-link">
            <i class="menu-icon  ti ti-info-circle"></i>
                <div data-i18n="Company Info">Company Info</div>
            </a>
        </li>

        @if(auth()->user()->ml_priv == "CompanyAdmin")
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon  ti ti-users-group"></i>
                <div data-i18n="Official Representative">Official Representative</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('official-representative') ? 'active' : '' }}">
                    <a href="{{ route('official-representative.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Official Representative">Official Representative</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('alternate-representative') ? 'active' : '' }}">
                    <a href="{{ route('alternate-representative.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Alternate Representative">Alternate Representative</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <li class="menu-item {{ request()->is('statement-of-account') ? 'active' : '' }}">
            <a href="{{ route('statement-of-account.index') }}" class="menu-link">
            <i class="menu-icon  ti ti-report"></i>
                <div data-i18n="Statement of Account">Statement of Account</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('invoice') ? 'active' : '' }}">
            <a href="{{ route('invoice.index') }}" class="menu-link">
                <i class="menu-icon  ti ti-file-invoice"></i>
                <div data-i18n="Invoice / Receipt / Payment">Invoice / Receipt / Payment</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('membership-certificate') ? 'active' : '' }}">
            <a href="{{ route('membership-certificate.index') }}" class="menu-link">
                <i class="menu-icon  ti ti-file-certificate"></i>
                <div data-i18n="Membership Certificate">Membership Certificate</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('annualreport') ? 'active' : '' }}">
            <a href="{{ route('annualreport.index') }}" class="menu-link">
                <i class="menu-icon  ti ti-report-analytics"></i>
                <div data-i18n="Annual Report">Annual Report</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('bulletin') ? 'active' : '' }}">
            <a href="{{ route('bulletin.index') }}" class="menu-link">
                <i class="menu-icon  ti ti-book"></i>
                <div data-i18n="Bulletin">Bulletin</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon  ti ti-speakerphone"></i>
                <div data-i18n="HQ Circular">HQ Circular</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('circular') ? 'active' : '' }}">
                    <a href="{{ route('circular.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="HQ Circular">HQ Circular</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('branch-circular') ? 'active' : '' }}">
                    <a href="{{ route('branch-circular.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-devices"></i>
                        <div data-i18n="Branch Circular">Branch Circular</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('branch-newsletter') ? 'active' : '' }}">
            <a href="{{ route('branch-newsletter.index') }}" class="menu-link">
                <i class="menu-icon  ti ti-news"></i>
                <div data-i18n="Branch Newsletter">Branch Newsletter</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('others') ? 'active' : '' }}">
            <a href="{{ route('others.index') }}" class="menu-link">
                <i class="menu-icon  ti ti-news"></i>
                <div data-i18n="Others">Others</div>
            </a>
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

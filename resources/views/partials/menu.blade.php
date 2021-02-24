<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('home.user')}}">
                    <h2 class="brand-text mb-0">StockTrack</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none f ont-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>

    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
            <li>
                <div id="profile" style="height:75px; border-radius: 10px; background-color: #727E8C; color:#1a233a; margin-bottom:10px; padding-top: 10%;" class="text-center ">
                    @if(Session::has('activeCompany') && Session::has('activeCompany'))
                    <h7 style="font-size: 20px; line-height: 30px;">
                        {{ Session::get('activeCompany')->name }}
                    </h7>
                    <br>
                    <b>
                        <h7 style="font-weight: 600; font-size: 14px;">

                        </h7>
                    </b>
                    @endif
                </div>
            </li>

            <!-- @can('dashboard_access')
        <li class="nav-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}"><a href="/admin/dashboard"><i class="menu-livicon" data-icon="desktop"></i><span class="menu-title" data-i18n="Dashboard">{{ trans('global.dashboard') }}</span></a>
        </li>
        @endcan -->

            </li>
            <!-- @can('user_access')
                    <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}"><a href="{{ route("admin.users.index") }}"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="{{ trans('cruds.user.title') }}">Users</span></a>
                    </li>
                @endcan

                <li class="nav-item {{ request()->is('admin/employees*') ? 'active' : '' }}"><a href="{{ route("admin.employees.index") }}"><i class="menu-livicon" data-icon="building"></i><span class="menu-title" data-i18n="{{ trans('cruds.user.title') }}">Employees</span></a>
                </li> -->

            <li class="nav-item {{ request()->is('admin/shareholders*') ? 'active' : '' }}"><a href="{{ route("admin.shareholders.index") }}"><i class="menu-livicon" data-icon="dashboard"></i><span class="menu-title" data-i18n="{{ trans('cruds.user.title') }}">Shareholders</span></a>
            </li>

            <li class="nav-item {{ request()->is('admin/certificates*') ? 'active' : '' }}"><a href="{{ route("admin.certificates.index") }}"><i class="menu-livicon" data-icon="notebook"></i><span class="menu-title" data-i18n="{{ trans('cruds.user.title') }}">Certificates</span></a>
            </li>

            <li class="nav-item {{ request()->is('admin/log_transact') ? 'active' : '' }}"><a href="{{ route("admin.logTransacts.index") }}"><i class="menu-livicon" data-icon="check-alt"></i><span class="menu-title" data-i18n="{{ trans('cruds.user.title') }}">Log Transact</span></a>
            </li>

            <li class="nav-item {{ request()->is('admin/pending_transact') ? 'active' : '' }}">
                <a href="/admin/pending_transact">
                    <i class="menu-livicon" data-icon="diagram"></i>
                    <span class="menu-title" data-i18n="{{ trans('cruds.client.title') }}">
                        Pending Transact
                    </span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/splits') ? 'active' : '' }}">
                <a href="/admin/splits">
                    <i class="menu-livicon" data-icon="priority-low"></i>
                    <span class="menu-title" data-i18n="{{ trans('cruds.client.title') }}">
                        Devidend/Splits
                    </span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/companies*') ? 'active' : '' }}">
                <a href="{{ route("admin.companies.index") }}">
                    <i class="menu-livicon" data-icon="building"></i>
                    <span class="menu-title" data-i18n="{{ trans('cruds.client.title') }}">
                        Companies
                    </span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/reports') ? 'active' : '' }}">
                <a href="/admin/reports">
                    <i class="menu-livicon" data-icon="settings"></i>
                    <span class="menu-title" data-i18n="{{ trans('cruds.client.title') }}">
                        Reports
                    </span>
                </a>
            </li>

            <!-- @can('role_access')
                    <li class="nav-item {{ request()->is('admin/roles*') ? 'active' : '' }}"><a href="{{ route("admin.roles.index") }}"><i class="menu-livicon" data-icon="diagram"></i><span class="menu-title" data-i18n="{{ trans('cruds.role.title') }}">{{ trans('cruds.role.title') }}</span></a>
                    </li>
                    @endcan -->

        </ul>
    </div>
</div>
</body>
<!-- END: Main Menu-->

<style type="text/css">
    body.semi-dark-layout .main-menu {
        background-color: black !important;
    }
</style>
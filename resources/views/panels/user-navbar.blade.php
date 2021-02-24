<div class="header-navbar-shadow"></div>
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
{{--                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon bx bx-calendar-alt"></i></a></li>--}}
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    @if(Session::has('currentEmployee') && Session::has('activeEmployee'))
                        @if(Session::get('currentEmployee')->id != Session::get('activeEmployee')->employee_id)
                            <a href="/admin/employees/set/{{Session::get('currentEmployee')->id}}" style="margin-top:25px; text-transform: uppercase; font-size: 12px;">
                                My Dashboard
                            </a>
                        @endif
                    @endif
                    <!-- <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li> -->
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                            </div>
                            <span><img class="round" src="{{asset('images/portrait/small/avatar-s-11.jpg')}}" alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0">
                            <!-- @if(Session::has('currentEmployee'))
                                @if(Session::get('currentEmployee')->role_id != 5)
                                    <a class="dropdown-item" href="/admin/employees">
                                        <i class="bx bx-building mr-50"></i> Employees
                                    </a>
                                @endif
                            @endif -->
                            <!-- <a class="dropdown-item" href="{{ route("admin.home") }}"><i class="bx bx-wrench mr-50"></i> Settings</a> -->
                            <a class="dropdown-item" href="{{asset('user/logout')}}"><i class="bx bx-power-off mr-50"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>


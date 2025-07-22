<aside class="left-sidebar sidebar-dark" id="left-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <div class="app-brand">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Skynetwing">
                <span class="brand-name">Skynetwing</span>
            </a>
        </div>
        <div class="sidebar-left" data-simplebar style="height: 100%;">
            <ul class="nav sidebar-inner" id="sidebar-menu">
                @can('dashboard')
                    <li class="">
                        <a class="sidenav-item-link" href="{{ route('home') }}">
                            <i class="mdi mdi-briefcase-account-outline"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                @else
                    <li class="">
                        <a class="sidenav-item-link" href="{{ route('home') }}">
                            <i class="mdi mdi-briefcase-account-outline"></i>
                            <span class="nav-text">Welcome</span>
                        </a>
                    </li>
                @endcan

                @can('users')
                    <li class="section-title">
                        Users
                    </li>
                    <li class="has-sub">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#users"
                            aria-expanded="false" aria-controls="users">
                            <i class="mdi mdi-account-group"></i>
                            <span class="nav-text">Users</span> <b class="caret"></b>
                        </a>
                        <ul class="collapse" id="users" data-parent="#sidebar-menu">
                            <div class="sub-menu">
                                @can('menu-manage-users')
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('users.index') }}">
                                            <span class="nav-text">Manage Users</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('menu-manage-role')
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('roles.index') }}">
                                            <span class="nav-text">Manage Role</span>
                                        </a>
                                    </li>
                                @endcan
                            </div>
                        </ul>
                    </li>
                @endcan

                <li class="section-title">
                    Side Menu
                </li>
                <li class="has-sub">
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse"
                        data-target="#ui-elements" aria-expanded="false" aria-controls="ui-elements">
                        <i class="mdi mdi-folder-outline"></i>
                        <span class="nav-text">Side Menu</span> <b class="caret"></b>
                    </a>
                    <ul class="collapse" id="ui-elements" data-parent="#sidebar-menu">
                        <div class="sub-menu">
                            <li class="has-sub">
                                <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse"
                                    data-target="#buttons" aria-expanded="false" aria-controls="buttons">
                                    <span class="nav-text">Side Menu 1</span> <b class="caret"></b>
                                </a>
                                <ul class="collapse" id="buttons">
                                    <div class="sub-menu">
                                        <li>
                                            <a href="button-default.html">Side Menu 1.1</a>
                                        </li>
                                        <li>
                                            <a href="button-dropdown.html">Side Menu 1.2</a>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                            <li>
                                <a class="sidenav-item-link" href="card.html">
                                    <span class="nav-text">Side Menu 2</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>

                <li class="section-title">
                    Settings
                </li>
                <li class="">
                    <a class="sidenav-item-link" href="{{ route('settings') }}">
                        <i class="mdi mdi-settings"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

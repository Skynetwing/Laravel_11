<header class="main-header" id="header">
    <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
        <button id="sidebar-toggler" class="sidebar-toggle">
            <span class="sr-only">Toggle navigation</span>
        </button>
        {{-- <span class="page-title">@yield('page-title')</span> --}}
        <div class="navbar-right ">
            <ul class="nav navbar-nav">
                <li class="dropdown user-menu">
                    <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <img src="{{ Auth::user()->user_pic ?? asset('assets/images/user.png')}}" class="user-image rounded-circle"
                            alt="User Image" />
                        <span class="d-none d-lg-inline-block">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <a class="dropdown-link-item" href="user-profile.html">
                                <i class="mdi mdi-account-outline"></i>
                                <span class="nav-text">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-link-item" href="email-inbox.html">
                                <i class="mdi mdi-email-outline"></i>
                                <span class="nav-text">Message</span>
                                <span class="badge badge-pill badge-primary">24</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-link-item" href="user-activities.html">
                                <i class="mdi mdi-diamond-stone"></i>
                                <span class="nav-text">Activitise</span></a>
                        </li>
                        <li>
                            <a class="dropdown-link-item" href="user-account-settings.html">
                                <i class="mdi mdi-settings"></i>
                                <span class="nav-text">Account Setting</span>
                            </a>
                        </li>

                        <li class="dropdown-footer">
                            <a class="dropdown-link-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i
                                    class="mdi mdi-logout"></i> Log Out</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

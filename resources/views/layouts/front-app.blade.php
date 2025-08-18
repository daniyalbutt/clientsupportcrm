<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/horizontal-menu.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="layout-top-nav light-skin theme-primary fixed">
        <div class="wrapper">
            <div id="loader"></div>
            <header class="main-header">
                <div class="inside-header">
                    <div class="d-flex align-items-center logo-box justify-content-start">
                        <!-- Logo -->
                        <a href="index.html" class="logo">
                            <!-- logo-->
                            <div class="logo-lg">
                                <span class="light-logo">
                                    TERMINAL
                                </span>
                                <span class="dark-logo">
                                    TERMINAL
                                </span>
                            </div>
                        </a>
                    </div>
                    <!-- Header Navbar -->
                    <nav class="navbar navbar-static-top">
                        <!-- Sidebar toggle button-->
                        <div class="app-menu">
                            <ul class="header-megamenu nav">
                                <li class="btn-group nav-item d-none d-xl-inline-block">
                                    <div class="app-menu">
                                        <div class="search-bx mx-5">
                                            
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="navbar-custom-menu r-side">
                            <ul class="nav navbar-nav">
                                <!-- User Account-->
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle p-0 text-dark hover-primary ms-md-30 ms-10" data-bs-toggle="dropdown" title="User">
                                        <span class="ps-30 d-md-inline-block d-none">Hello,</span>
                                        <strong class="d-md-inline-block d-none">{{ Auth::user()->name }}</strong>
                                        <img src="{{ asset('images/user.jpg') }}" class="user-image rounded-circle avatar bg-white mx-10" alt="User Image">
                                    </a>
                                    <ul class="dropdown-menu animated flipInX">
                                        <li class="user-body">
                                            <a class="dropdown-item" href="{{ route('change.index') }}"><i class="ti-user text-muted me-2"></i> Change Password </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="ti-lock text-muted me-2"></i> Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </header>
            <nav class="main-nav" role="navigation">
                <!-- Mobile menu toggle button (hamburger/x icon) -->
                <input id="main-menu-state" type="checkbox" />
                <label class="main-menu-btn" for="main-menu-state">
                    <span class="main-menu-btn-icon"></span> Toggle main menu visibility </label>
                <!-- Sample menu definition -->
                <ul id="main-menu" class="sm sm-blue">
                    @can('view payment')
                    <li class="{{ request()->routeIs('home') ? 'current' : '' }}">
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Dashboard</a>
                    </li>
                    @endcan
                    @can('view client')
                    <li class="{{ request()->routeIs('clients.*') ? 'current' : '' }}">
                        <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'active' : '' }}">Clients</a>
                    </li>
                    @endcan
                    @can('view brand')
                    <li class="{{ request()->routeIs('brand.*') ? 'current' : '' }}">
                        <a href="{{ route('brand.index') }}" class="{{ request()->routeIs('brand.*') ? 'active' : '' }}">Brands</a>
                    </li>
                    @endcan
                    @can('view merchant')
                    <li class="{{ request()->routeIs('merchant.*') ? 'current' : '' }}">
                        <a href="{{ route('merchant.index') }}" class="{{ request()->routeIs('merchant.*') ? 'active' : '' }}">Merchants</a>
                    </li>
                    @endcan
                    @can('view currency')
                    <li class="{{ request()->routeIs('currency.*') ? 'current' : '' }}">
                        <a href="{{ route('currency.index') }}" class="{{ request()->routeIs('currency.*') ? 'active' : '' }}">Currency</a>
                    </li>
                    @endcan
                    @can('role')
                    <li class="{{ request()->routeIs('roles.*') ? 'current' : '' }}">
                        <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">Roles</a>
                    </li>
                    @endcan
                    @can('user')
                    <li class="{{ request()->routeIs('users.*') ? 'current' : '' }}">
                        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a>
                    </li>
                    @endcan
                </ul>
            </nav>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.Content Right Sidebar -->
            <footer class="main-footer">
                &copy; 2023 <a href="">Multipurpose Themes</a>. All Rights Reserved.
            </footer>
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        <!-- Vendor JS -->
        <script src="{{ asset('js/vendors.min.js') }}"></script>
        <script src="{{ asset('js/datatables.min.js') }}"></script>
        <script src="{{ asset('js/template.js') }}"></script>
        @stack('scripts')
    </body>
</html>
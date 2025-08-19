<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8" />
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />

    <!-- CSRF Token -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('global/img/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('global/img/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('global/img/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('global/img/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('global/img/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('global/img/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('global/img/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('global/img/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('global/img/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('global/img/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('global/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('global/img/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('global/img/favicon-16x16.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('global/img/ms-icon-144x144.png') }}">

    <!-- plugin css -->
    <link href="{{ asset('leadsglobal/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('leadsglobal/css/preloader.min.css') }}" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('leadsglobal/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- DataTables -->
    <link href="{{ asset('leadsglobal/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('leadsglobal/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('leadsglobal/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('leadsglobal/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('global/img/sidebarlogo.png') }}" alt="{{ config('app.name') }}" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('global/img/sidebarlogo.png') }}" alt="{{ config('app.name') }}" height="24"> <span
                                    class="logo-txt">ProjectCamp</span>
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('global/img/sidebarlogo.png') }}" alt="{{ config('app.name') }}" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('global/img/sidebarlogo.png') }}" alt="{{ config('app.name') }}" height="24"> <span
                                    class="logo-txt">ProjectCamp</span>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                </div>

                <div class="d-flex">

                    <div class="dropdown d-none d-sm-inline-block">
                        <button type="button" class="btn header-item" id="mode-setting-btn">
                            <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                            <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon position-relative"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i data-feather="bell" class="icon-lg"></i>
                            <span class="badge bg-danger rounded-pill">{{count(auth()->user()->unreadNotifications)}}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Notifications </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small text-reset text-decoration-underline"> Unread ({{count(auth()->user()->unreadNotifications)}})</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                            @php
                            $k = 0;
                            @endphp
                            @foreach(auth()->user()->unreadnotifications as $notifications)
                            @if($notifications->type == 'App\Notifications\LeadNotification')
                                <a href="{{ route('admin.client.shownotification', ['client' => $notifications->data['id'], 'id' => $notifications->id] ) }}" class="text-reset notification-item">
                                @elseif($notifications->type == 'App\Notifications\PaymentNotification')
                                <a href="" class="text-reset notification-item">
                                @else
                                <a href="" class="text-reset notification-item">
                                @endif
                                <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-sm me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                @if($notifications->type == 'App\Notifications\LeadNotification')
                                                    <i class="bx bxs-user-plus"></i>
                                                @elseif($notifications->type == 'App\Notifications\PaymentNotification')
                                                    <i class="bx bx-money"></i>
                                                @else
                                                    <i class="bx bx-list-ol"></i>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{$notifications->data['text']}}</h6>
                                            <div class="font-size-13 text-muted">
                                                <p class="mb-1">{{$notifications->data['name']}}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>{{ $notifications->created_at->diffForHumans() }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                @if($loop->last)

                                @endif
                                @php
                                    $k++;
                                @endphp
                                @endforeach
                            </div>
                            <!-- <div class="p-2 border-top d-grid">
                                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> <span>View More..</span>
                                </a>
                            </div> -->
                        </div>
                    </div>


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item bg-soft-light border-start border-end"
                            id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            @if(Auth::user()->image != '')
                                <img src="{{ asset(Auth::user()->image) }}" class="rounded-circle header-profile-user">
                            @else
                                <img src="{{ asset('global/img/user.png') }}" class="rounded-circle header-profile-user">
                            @endif
                            <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ Auth::user()->name }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="{{ route('admin.edit.profile') }}"><i
                                    class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Edit Profile</a>
                            <a class="dropdown-item" href="{{ route('admin.change.password') }}"><i
                                    class="mdi mdi-lock font-size-16 align-middle me-1"></i> Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i
                                    class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" data-key="t-menu">Menu</li>

                        <li>
                            <a href="{{ route('admin.home') }}">
                                <i data-feather="home"></i>
                                <span data-key="t-dashboard">Dashboard</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.leads.dashboard') ? 'mm-active' : '' }}">
                            <a class="{{ request()->routeIs('admin.leads.dashboard') ? 'active' : '' }}" href="{{ route('admin.leads.dashboard') }}">
                                <i data-feather="archive"></i>
                                <span data-key="t-dashboard">Leads Dashboard</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('data-bank.index') || request()->routeIs('data-bank.details') ? 'mm-active' : '' }}">
                            <a class="{{ request()->routeIs('data-bank.index') || request()->routeIs('data-bank.details') ? 'active' : '' }}" href="{{ route('data-bank.index') }}">
                            <i class="mdi mdi-bank-outline"></i>
                                <span data-key="t-dashboard">Data Bank</span>
                            </a>
                        </li>

                        <li class="menu-title" data-key="t-apps">Data Logs</li>

                        <li class="{{ request()->routeIs('data-bank.merchant-log') ? 'mm-active' : '' }}">
                            <a class="{{ request()->routeIs('data-bank.merchant-log') ? 'active' : '' }}" href="{{ route('data-bank.merchant-log') }}">
                            <i class="mdi mdi-credit-card-multiple-outline"></i>
                                <span data-key="t-dashboard">Merhcnat Logs</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('data-bank.refund-log') ? 'mm-active' : '' }}">
                            <a class="{{ request()->routeIs('data-bank.refund-log') ? 'active' : '' }}" href="{{ route('data-bank.refund-log') }}">
                            <i class="mdi mdi-credit-card-multiple"></i>
                                <span data-key="t-dashboard">Refund Logs</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('data-bank.telnyx-call-log') ? 'mm-active' : '' }}">
                            <a class="{{ request()->routeIs('data-bank.telnyx-call-log') ? 'active' : '' }}" href="{{ route('data-bank.telnyx-call-log') }}">
                            <i class="mdi mdi-file-phone-outline"></i>
                                <span data-key="t-dashboard">Telnyx Call</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('data-bank.ringCentral-call-log') ? 'mm-active' : '' }}">
                            <a class="{{ request()->routeIs('data-bank.ringCentral-call-log') ? 'active' : '' }}" href="{{ route('data-bank.ringCentral-call-log') }}">
                            <i class="mdi mdi-file-phone-outline"></i>
                                <span data-key="t-dashboard">RingCentral Call</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('data-bank.designnes-chat') ? 'mm-active' : '' }}">
                            <a class="{{ request()->routeIs('data-bank.designnes-chat') ? 'active' : '' }}" href="{{ route('data-bank.designnes-chat') }}">
                            <i class="mdi mdi-message-text-lock-outline"></i>
                                <span data-key="t-dashboard">Designnes Chat</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('data-bank.marketingNotch-chat') ? 'mm-active' : '' }}">
                            <a class="{{ request()->routeIs('data-bank.marketingNotch-chat') ? 'active' : '' }}" href="{{ route('data-bank.marketingNotch-chat') }}">
                            <i class="mdi mdi-message-text-lock-outline"></i>
                                <span data-key="t-dashboard">MarketingNotch Chat</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('data-bank.web-forms') ? 'mm-active' : '' }}">
                            <a class="{{ request()->routeIs('data-bank.web-forms') ? 'active' : '' }}" href="{{ route('data-bank.web-forms') }}">
                            <i class="mdi mdi-web"></i>
                                <span data-key="t-dashboard">WebForms Data</span>
                            </a>
                        </li>


                        <li class="menu-title" data-key="t-apps">Clients Related</li>

                        <li>
                            <a href="{{ route('admin.message') }}">
                                <i data-feather="message-square"></i>
                                <span data-key="t-dashboard">Messages</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.client.index') }}">
                                <i data-feather="user-check"></i>
                                <span data-key="t-chat">Clients</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.invoice') }}">
                                <i data-feather="credit-card"></i>
                                <span data-key="t-chat">Invoices</span>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('admin.brief.pending') }}">
                            <i class="mdi mdi-briefcase-clock-outline"></i>
                                <span data-key="t-chat">Brief Pending</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.pending.project') }}">
                            <i class="mdi mdi-calendar-clock-outline"></i>
                                <span data-key="t-chat">Pending Projects</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.project.index') }}">
                            <i class="mdi mdi-briefcase-account-outline"></i>
                                <span data-key="t-chat">Projects</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.task.index') }}">
                            <i class="mdi mdi-clipboard-list-outline"></i>
                                <span data-key="t-chat">Tasks</span>
                            </a>
                        </li>

                        <li class="menu-title mt-2" data-key="t-components">Components & Settings</li>

                        <li>
                            <a href="{{ route('admin.merchant.index') }}">
                                <i data-feather="briefcase"></i>
                                <span data-key="t-dashboard">Merchant</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('service.index') }}">
                            <i class="mdi mdi-library"></i>
                                <span data-key="t-chat">Services</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('brand.index') }}">
                            <i class="mdi mdi-medal-outline"></i>
                                <span data-key="t-chat">Brand</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('currency.index') }}">
                            <i class="mdi mdi-calculator-variant-outline"></i>
                                <span data-key="t-chat">Currency</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                            <i class="mdi mdi-cart-outline"></i>
                                <span data-key="t-multi-level">Package</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ route('category.index') }}" data-key="t-level-1-1">Category</a></li>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow" data-key="t-level-1-2">Packages</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li class="{{ (request()->routeIs('package.create') ) ? 'active' : '' }}">
                                            <a href="{{ route('package.create') }}" data-key="t-level-2-1">Create Package</a>
                                        </li>
                                        <li class="{{ (request()->routeIs('package.index') ) || (request()->routeIs('package.edit') ) ? 'active' : '' }}">
                                            <a href="{{ route('package.index') }}" data-key="t-level-2-2">Packages List</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-title" data-key="t-pages">Sales/Production</li>


                        <li>
                            <a href="{{ route('admin.user.production') }}">
                            <i class="mdi mdi-account-hard-hat"></i>
                                <span data-key="t-chat">Production</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.user.sales') }}">
                            <i class="mdi mdi-account-convert-outline"></i>
                                <span data-key="t-chat">Sale Agent</span>
                            </a>
                        </li>

                    </ul>

                    <!-- <div class="card sidebar-alert shadow-none text-center mx-4 mb-0 mt-5">
                        <div class="card-body">
                            <img src="images/giftbox.png" alt="">
                            <div class="mt-4">
                                <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                                <p class="font-size-13">‘Business Plan’.
                                </p>
                                <a href="#!" class="btn btn-primary mt-2">Now</a>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                @yield('content')
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                            <p class="m-0">&copy; <?php echo date('Y'); ?> {{ config('app.name') }}</p>
                            <p class="m-0">All rights reserved</p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('leadsglobal/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/feather-icons/feather.min.js') }}"></script>
    <!-- pace js -->
    <script src="{{ asset('leadsglobal/libs/pace-js/pace.min.js') }}"></script>


    <!-- apexcharts -->
    <script src="{{ asset('leadsglobal/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('leadsglobal/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}">
    </script>
    <script
        src="{{ asset('leadsglobal/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>

    <script src="{{ asset('leadsglobal/js/pages/allchart.js') }}"></script>
    <!-- dashboard init -->
    <script src="{{ asset('leadsglobal/js/pages/dashboard.init.js') }}"></script>

    <script src="{{ asset('leadsglobal/js/app.js') }}"></script>
    <script src="{{ asset('newglobal/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/toastr.min.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('leadsglobal/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('leadsglobal/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('leadsglobal/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('leadsglobal/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('leadsglobal/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('leadsglobal/js/pages/datatables.init.js') }}"></script>

    @stack('scripts')
    @if (session()->has('success'))
        <script>
            var timerInterval;
            swal({
                type: 'success',
                title: 'Success!',
                text: "{{ session()->get('success') }}",
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-success',
                timer: 2000
            });
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            toastr.success("", "{{ session()->get('success') }}", {
                timeOut: "50000"
            });
        </script>
    @endif
    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}", {
                    timeOut: "50000"
                });
            @endforeach
        @endif
    </script>
    <script>
        if ($('#zero_configuration_table').length != 0) {
            $('#zero_configuration_table').DataTable({
                order: [
                    [0, "desc"]
                ],
                responsive: true,
            });
        }
        if ($('#zero_configuration_table_1').length != 0) {
            $('#zero_configuration_table_1').DataTable({
                order: [
                    [0, "desc"]
                ],
                responsive: true,
            });
        }

        if ($('.select2').length != 0) {
            $('.select2').select2();
        }
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        setInterval(() => {
            $.ajax({
                type: 'POST',
                url: "{{ url('keep-alive') }}",
                success: function(data) {
                    console.log(data);
                }
            });
        }, 1200000)
    </script>

    {{-- PUSHER NOTIFICATION --}}
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = false;
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: 'ap2',
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
            }
        });
        var channel = pusher.subscribe('private.{{ Auth::user()->id }}');
        channel.bind('send-event', function(data) {
            console.log('admin')
            console.log('send-event')
            console.log(data)
            if (!window.Notification) {
                console.log('Browser does not support notifications.');
            } else {
                if (Notification.permission === 'granted') {
                    var notify = new Notification(data.title, {
                        body: data.message,
                        icon: '{{ asset('icons') }}/' + data.image,
                    });
                    notify.onclick = function(event) {
                        event.preventDefault();
                        window.open(data.link, '_blank');
                    }
                } else {
                    // request permission from user
                    Notification.requestPermission().then(function(p) {
                        if (p === 'granted') {
                            var notify = new Notification(response.title, {
                                body: response.message,
                                icon: '{{ asset('icons') }}/' + response.image,
                            });
                            notify.onclick = function(event) {
                                event.preventDefault();
                                window.open(response.link, '_blank');
                            }
                        } else {
                            console.log('User blocked notifications.');
                        }
                    }).catch(function(err) {
                        console.error(err);
                    });
                }
            }

        });

        channel.bind('send-lead-notifiction', function(response) {

            console.log('admin')
            console.log('send-lead-notifiction')
            console.log(response)
            if (!window.Notification) {
                console.log('Browser does not support notifications.');
            } else {
                // check if permission is already granted
                if (Notification.permission === 'granted') {
                    var notify = new Notification(response.title, {
                        body: response.message,
                        icon: '{{ asset('icons') }}/' + response.image,
                    });
                    notify.onclick = function(event) {
                        event.preventDefault();
                        window.open(response.link, '_blank');
                    }
                } else {
                    // request permission from user
                    Notification.requestPermission().then(function(p) {
                        if (p === 'granted') {
                            // show notification here
                        } else {
                            console.log('User blocked notifications.');
                        }
                    }).catch(function(err) {
                        console.error(err);
                    });
                }
            }

        });
    </script>

    @yield('script')
</body>

</html>

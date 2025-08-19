<div class="main-header">
    <div class="logo">
        <img src="{{ asset('global/img/sidebarlogo.png') }}" alt="{{ config('app.name') }}">
    </div>
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="d-flex align-items-center">
        <!-- / Mega menu -->
        <div class="search-bar">
            <input type="text" placeholder="Search">
            <i class="search-icon text-muted i-Magnifi-Glass1"></i>
        </div>
        <a href="javascript:;" class="brands-list" style="margin-top: 3px;">
            @foreach(Auth::user()->brands as $brands)
            <span>{{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $brands->name))) }}</span>
            @endforeach 
        </a>
    </div>
    <div style="margin: auto"></div>
    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
        <!-- Grid menu Dropdown -->
        <!-- Notificaiton -->
        <div class="dropdown">
            <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="badge badge-primary">{{count(auth()->user()->unreadNotifications)}}</span>
                <i class="i-Bell text-muted header-icon"></i>
            </div>
            <!-- Lead Notification dropdown -->
            <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
                @php
                $k = 0;
                @endphp
                @foreach(auth()->user()->unreadnotifications as $notifications)
                @if($notifications->type == 'App\Notifications\LeadNotification')
                <a href="{{ route('admin.client.shownotification', ['client' => $notifications->data['id'], 'id' => $notifications->id] ) }}" class="dropdown-item d-flex">
                @elseif($notifications->type == 'App\Notifications\PaymentNotification')
                <a href="" class="dropdown-item d-flex">
                @else
                <a href="" class="dropdown-item d-flex">
                @endif
                    <div class="notification-icon">
                        @if($notifications->type == 'App\Notifications\LeadNotification')
                            <i class="i-Checked-User text-primary mr-1"></i>
                        @elseif($notifications->type == 'App\Notifications\PaymentNotification')
                            <i class="i-Money-Bag text-success mr-1"></i>
                        @else
                            <i class="i-Blinklist text-info mr-1"></i>
                        @endif
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span class="lead-heading">{{$notifications->data['text']}}</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-3">{{ $notifications->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="text-small text-muted m-0">Name: {{$notifications->data['name']}}</p>
                    </div>
                </a>
                @if($loop->last)
                    
                @endif
                @php
                    $k++;
                @endphp
                @endforeach
            </div>
        </div>
        <!-- Notificaiton End -->
        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                @if(Auth::user()->image != '')
                <img src="{{ asset(Auth::user()->image) }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @else
                <img src="{{ asset('global/img/user.png') }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @endif
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{ Auth::user()->name }}
                    </div>
                    <a class="dropdown-item" href="{{ route('sale.edit.profile') }}">Edit Profile</a>
                    <a class="dropdown-item" href="{{ route('sale.change.password') }}">Change Password</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ (request()->routeIs('home'))? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ url('home') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->routeIs('sale.tickets') || request()->routeIs('sale.issue.show') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('sale.tickets') }}">
                    <i class="nav-icon i-Thread"></i>
                    <span class="nav-text">QA Reports</span>
                    <span class="counter">{{ Auth()->user()->issueCounts() }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ ( request()->routeIs('client.index') || request()->routeIs('client.edit') || request()->routeIs('client.generate.payment') || request()->routeIs('client.create')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('client.index') }}">
                    <i class="nav-icon i-Add-User"></i>
                    <span class="nav-text">Clients</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('sale.invoice')) || (request()->routeIs('sale.single.invoice') || request()->routeIs('sale.link')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('sale.invoice') }}">
                    <i class="nav-icon i-Credit-Card"></i>
                    <span class="nav-text">Invoices</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('sale.brief.pending')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('sale.brief.pending') }}">
                    <i class="nav-icon i-Folder-Close"></i>
                    <span class="nav-text">Brief Pending</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('sale.project') || request()->routeIs('sale.form') || request()->routeIs('sale.task.show') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('sale.project') }}">
                    <i class="nav-icon i-Suitcase"></i>
                    <span class="nav-text">All Projects</span>
                </a>
                <div class="triangle"></div>
            </li>

        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>


<!-- <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>

                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="" style="padding: 6px 0px !important; margin-right: 0;">
                        <img class="brand-logo" alt="KWSB logo" src="{{ asset('global/img/sidebarlogo.png') }}" >
                        <h3 class="brand-text">Technified Labs</h3>
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                    <li>
                        <a href="javascript:;" class="brands-list nav-link nav-link-expand pl-0 font-weight-bold" style="margin-top: 3px;">
                            @foreach(Auth::user()->brands as $brands)
                            <span>{{ $brands->name }}</span>
                            @endforeach
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    @if(Auth::user()->status != 0)
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" id="panic" href="#" data-toggle="dropdown"><i class="ficon ft-info"></i><span class="badge badge-pill badge-danger badge-up badge-glow">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right" data-href="" id="panic-notf-show">
                            
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" id="notf_user" href="#" data-toggle="dropdown"><i class="ficon ft-users"></i><span class="badge badge-pill badge-danger badge-up badge-glow">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right" data-href="" id="user-notf-show">
                            
                        </ul>
                    </li>
                    @endif
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                        <span>{{ Auth::user()->name }} {{ Auth::user()->last_name }}
                        <span class="user-name text-bold-700"></span>
                        </span>
                        <span class="avatar avatar-online">
                        @if(Auth::user()->image != '')
                        <img src="{{ asset(Auth::user()->image) }}" alt="avatar"><i></i></span>
                        @else
                        <img src="{{ asset('global/img/user.png') }}" alt="avatar"><i></i></span>
                        @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('sale.edit.profile') }}"><i class="ft-user"></i> Edit Profile</a>
                            <a class="dropdown-item" href="{{ route('sale.change.password') }}"><i class="ft-lock"></i> Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav> -->
<!-- <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if(Auth::user()->status == 0)
            <li class="active">
                <a class="menu-item" href="{{ url('home') }}" data-i18n="nav.templates.vert.main"><i class="la la-close"></i>No Option Available</a>
            </li>
            @else
            <li class="{{ (request()->routeIs('home'))? 'active' : '' }}">
                <a class="menu-item" href="{{ url('home') }}" data-i18n="nav.templates.vert.main"><i class="la la-home"></i>Dashboard</a>
            </li>
            <li class=" nav-item">
                <a href="#"><i class="la la-users"></i><span class="menu-title" data-i18n="nav.templates.main">Clients</span></a>
                <ul class="menu-content">
                    <li class="{{ (request()->routeIs('client.create'))? 'active' : '' }}">
                        <a class="menu-item" href="{{ route('client.create') }}" data-i18n="nav.templates.vert.main">Create Client</a>
                    </li>
                    <li class="{{ ( request()->routeIs('client.index') || request()->routeIs('client.edit') || request()->routeIs('client.generate.payment')) ? 'active' : '' }}">
                        <a class="menu-item" href="{{ route('client.index') }}" data-i18n="nav.templates.vert.main">Clients List</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="#"><i class="la la-sticky-note"></i><span class="menu-title" data-i18n="nav.templates.main">Projects</span></a>
                <ul class="menu-content">
                    <li class="{{ (request()->routeIs('project.create'))? 'active' : '' }}">
                        <a class="menu-item" href="{{ route('project.create') }}" data-i18n="nav.templates.vert.main">Create Project</a>
                    </li>
                    <li class="{{ ( request()->routeIs('project.index') || request()->routeIs('project.edit'))? 'active' : '' }}">
                        <a class="menu-item" href="{{ route('project.index') }}" data-i18n="nav.templates.vert.main">Projects List</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="#"><i class="la la-list-alt"></i><span class="menu-title" data-i18n="nav.templates.main">Task</span></a>
                <ul class="menu-content">
                    <li class="{{ (request()->routeIs('task.create'))? 'active' : '' }}">
                        <a class="menu-item" href="{{ route('task.create') }}" data-i18n="nav.templates.vert.main">Create Task</a>
                    </li>
                    <li class="{{ ( request()->routeIs('task.index') || request()->routeIs('task.show')) ? 'active' : '' }}">
                        <a class="menu-item" href="{{ route('task.index') }}" data-i18n="nav.templates.vert.main">Tasks List</a>
                    </li>
                </ul>
            </li>
            <li class="{{ (request()->routeIs('assigned.client'))? 'active' : '' }} nav-item">
                <a href="{{ route('assigned.client') }}"><i class="la la-user"></i><span class="menu-title" data-i18n="nav.templates.main">Assigned Client</span></a>
            </li>
            @endif
        </ul>
    </div>
</div> -->
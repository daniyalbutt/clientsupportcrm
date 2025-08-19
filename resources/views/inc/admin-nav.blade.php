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
                        <p class="text-small text-muted m-0">{{$notifications->data['name']}}</p>
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
                    <a class="dropdown-item" href="{{ route('admin.edit.profile') }}">Edit Profile</a>
                    <a class="dropdown-item" href="{{ route('admin.change.password') }}">Change Password</a>
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
            <li class="nav-item {{ (request()->routeIs('admin.home'))? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.home') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.merchant.index') || request()->routeIs('admin.merchant.edit') || request()->routeIs('admin.merchant.create') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.merchant.index') }}">
                    <i class="nav-icon i-ID-Card"></i>
                    <span class="nav-text">Merchant</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.tickets') || request()->routeIs('admin.issue.edit') || request()->routeIs('admin.issue.show') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.tickets') }}">
                    <i class="nav-icon i-Thread"></i>
                    <span class="nav-text">QA Reports</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.message') || request()->routeIs('admin.message.show') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.message') }}">
                    <i class="nav-icon i-Speach-Bubble-3"></i>
                    <span class="nav-text">Messages</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('admin.link')) || (request()->routeIs('admin.invoice.index') ) || (request()->routeIs('admin.client.create') ) || (request()->routeIs('admin.client.index') ) || (request()->routeIs('admin.client.show') ) || (request()->routeIs('admin.client.edit') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.client.index') }}">
                    <i class="nav-icon i-Checked-User"></i>
                    <span class="nav-text">Clients</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ (request()->routeIs('admin.invoice')) || (request()->routeIs('admin.single.invoice') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.invoice') }}">
                    <i class="nav-icon i-Credit-Card"></i>
                    <span class="nav-text">Invoices</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ (request()->routeIs('admin.brief.pending')) || (request()->routeIs('admin.brief.pending') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.brief.pending') }}">
                    <i class="nav-icon i-Folder-Close"></i>
                    <span class="nav-text">Brief Pending</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ (request()->routeIs('admin.pending.project')) || (request()->routeIs('admin.pending.project.details') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.pending.project') }}">
                    <i class="nav-icon i-Folder-Loading"></i>
                    <span class="nav-text">Pending Projects</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ (request()->routeIs('admin.project.index') ) || (request()->routeIs('admin.project.show') ) || (request()->routeIs('admin.project.edit') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.project.index') }}">
                    <i class="nav-icon i-Suitcase"></i>
                    <span class="nav-text">Projects</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('admin.task.index') ) || (request()->routeIs('admin.task.show') ) || (request()->routeIs('admin.task.edit') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.task.index') }}">
                    <i class="nav-icon i-Receipt-4"></i>
                    <span class="nav-text">Tasks</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ (request()->routeIs('service.index') ) || (request()->routeIs('service.edit') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('service.index') }}">
                    <i class="nav-icon i-Library"></i>
                    <span class="nav-text">Services</span>
                </a>
                <div class="triangle"></div>
            </li>

            <!-- <li class="nav-item {{ (request()->routeIs('category.index') ) || (request()->routeIs('category.edit') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('category.index') }}">
                    <i class="nav-icon i-Library"></i>
                    <span class="nav-text">Category</span>
                </a>
                <div class="triangle"></div>
            </li> -->
            <li class="nav-item {{ (request()->routeIs('brand.index') ) || (request()->routeIs('brand.edit') ) || (request()->routeIs('brand.show') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('brand.index') }}">
                    <i class="nav-icon i-Medal-2"></i>
                    <span class="nav-text">Brand</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('currency.index') ) || (request()->routeIs('currency.edit') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('currency.index') }}">
                    <i class="nav-icon i-Cash-register-2"></i>
                    <span class="nav-text">Currency</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item" data-item="packages">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Shopping-Cart"></i>
                    <span class="nav-text">Package</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ ( request()->routeIs('admin.user.production') ) || ( request()->routeIs('admin.user.production.edit') ) || ( request()->routeIs('admin.user.production.create') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.user.production') }}">
                    <i class="nav-icon i-Add-UserStar"></i>
                    <span class="nav-text">Production</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ ( request()->routeIs('admin.user.sales') ) || ( request()->routeIs('admin.user.sales.edit') ) || ( request()->routeIs('admin.user.sales.create') )  ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('admin.user.sales') }}">
                    <i class="nav-icon i-Administrator"></i>
                    <span class="nav-text">Sale Agent</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <!-- Submenu Dashboards-->
        <ul class="childNav" data-parent="packages">
            <li class="nav-item {{ (request()->routeIs('category.index') ) || (request()->routeIs('category.edit') ) ? 'active' : '' }}">
                <a href="{{ route('category.index') }}">
                    <i class="nav-icon i-Blinklist"></i>
                    <span class="item-name">Category</span>
                </a>
            </li>
            <li class="nav-item dropdown-sidemenu">
                <a href="#">
                    <i class="nav-icon i-Suitcase"></i>
                    <span class="item-name">Packages</span>
                    <i class="dd-arrow i-Arrow-Down"></i>
                </a>
                <ul class="submenu">
                    <li class="{{ (request()->routeIs('package.create') ) ? 'active' : '' }}">
                        <a href="{{ route('package.create') }}">Create Package</a>
                    </li>
                    <li class="{{ (request()->routeIs('package.index') ) || (request()->routeIs('package.edit') ) ? 'active' : '' }}">
                        <a href="{{ route('package.index') }}">Packages List</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- chartjs-->
    </div>
    <div class="sidebar-overlay"></div>
</div>
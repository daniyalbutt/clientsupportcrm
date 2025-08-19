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
        <i class="i-Credit-Card-2 text-muted header-icon" role="button" id="bank-info" type="button"></i>
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
                        <i class="i-Lock-User mr-1"></i> {{ Auth::user()->name }} {{ Auth::user()->last_name }}
                    </div>
                    <a class="dropdown-item" href="{{ route('manager.edit.profile') }}">Edit Profile</a>
                    <a class="dropdown-item" href="{{ route('manager.change.password') }}">Change Password</a>
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
            <li class="nav-item {{ (request()->routeIs('salemanager.dashboard'))? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ url('manager/dashboard') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->routeIs('manager.message') || request()->routeIs('manager.message.show') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('manager.message') }}">
                    <i class="nav-icon i-Speach-Bubble-3"></i>
                    <span class="nav-text">Messages</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->routeIs('manager.notification') || request()->routeIs('manager.notification') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('manager.notification') }}">
                    <i class="nav-icon i-Bell"></i>
                    <span class="nav-text">Notificaiton</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->routeIs('manager.tickets') || request()->routeIs('manager.issue.show') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('manager.tickets') }}">
                    <i class="nav-icon i-Thread"></i>
                    <span class="nav-text">QA Reports</span>
                    <span class="counter">{{ Auth()->user()->issueCounts() }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ ( request()->routeIs('salemanager.client.index') || request()->routeIs('salemanager.client.create') || request()->routeIs('manager.generate.payment') || request()->routeIs('manager.client.edit')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('salemanager.client.index') }}">
                    <i class="nav-icon i-Add-User"></i>
                    <span class="nav-text">Clients</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('manager.invoice')) || (request()->routeIs('manager.single.invoice')) || (request()->routeIs('manager.invoice.edit')) || (request()->routeIs('manager.link')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('manager.invoice') }}">
                    <i class="nav-icon i-Credit-Card"></i>
                    <span class="nav-text">Invoices</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('manager.brief.pending')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('manager.brief.pending') }}">
                    <i class="nav-icon i-Folder-Close"></i>
                    <span class="nav-text">Brief Pending</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('manager.pending.project')) || (request()->routeIs('manager.pending.project.details') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('manager.pending.project') }}">
                    <i class="nav-icon i-Folder-Loading"></i>
                    <span class="nav-text">Pending Projects</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('manager.project.index') ) || (request()->routeIs('manager.project.show') ) || (request()->routeIs('manager.project.edit') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('manager.project.index') }}">
                    <i class="nav-icon i-Suitcase"></i>
                    <span class="nav-text">Projects</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->routeIs('manager.task.index') ) || (request()->routeIs('manager.task.show') ) || (request()->routeIs('manager.task.edit') ) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('manager.task.index') }}">
                    <i class="nav-icon i-Receipt-4"></i>
                    <span class="nav-text">Tasks</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>
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
        
    </div>
    <div style="margin: auto"></div>
    <div class="header-part-right">
        {{-- <label class="switch switch-dark mb-0"><span>Dark</span>
            <input type="checkbox" id="theme-mode"/><span class="slider"></span>
        </label> --}}
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
                @foreach(auth()->user()->unreadnotifications as $notifications)
                <a href="{{ route('client.message', ['notify' => $notifications->id]) }}" class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Speach-Bubble-8 text-primary mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span class="lead-heading">{{$notifications->data['text']}}</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-3">{{ $notifications->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="text-small text-muted m-0">{{$notifications->data['details']}}</p>
                    </div>
                </a>
                @endforeach
                <a href="{{ route('client.read.notification') }}" class="dropdown-item d-flex mark-as-read">
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span class="lead-heading">MARK AS READ</span>
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- Notificaiton End -->
        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <span class="auth-name">{{Auth::user()->name}} {{Auth::user()->last_name}}</span>
                @if(Auth::user()->image != '')
                <img src="{{ asset(Auth::user()->image) }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @else
                <img src="{{ asset('global/img/user.png') }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @endif
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{ Auth::user()->name }}
                    </div>
                    <a class="dropdown-item" href="{{ route('client.profile') }}">Edit Profile</a>
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
            <!-- <li class="nav-item {{ (request()->routeIs('client.home'))? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('client.home') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li> -->
            <!-- <li class="nav-item {{ ( request()->routeIs('client.project') || request()->routeIs('client.task.show') )? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('client.project') }}">
                    <i class="nav-icon i-Suitcase"></i>
                    <span class="nav-text">Projects</span>
                </a>
                <div class="triangle"></div>
            </li> -->

            <li class="nav-item {{ request()->routeIs('client.home') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('client.home') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->routeIs('client.message') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('client.message') }}">
                    <i class="nav-icon i-Speach-Bubble-3"></i>
                    <span class="nav-text">Message</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->routeIs('client.brief') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('client.brief') }}">
                    <i class="nav-icon i-File-Horizontal-Text"></i>
                    <span class="nav-text">Brief</span>
                    <span class="number">{{ Auth()->user()->getBriefPendingCount() }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            @php
                $client_detail = \App\Models\Client::where('id', '=', Auth()->user()->client_id)->first();
                
                $affiliate_apply = preg_match('/https:\/\/www\./', $client_detail->brand->url) 
                                    ? preg_replace('/https:\/\/www\./', '', $client_detail->brand->url) 
                                    : preg_replace('/https:\/\//', '', $client_detail->brand->url);
                
                
            @endphp
            @if($client_detail->brand->name == "American Book Services" || $client_detail->brand->name == "Authors time" || $client_detail->brand->name == "The Native Publishers" || $client_detail->brand->name == "Amazon Publisher Hub")
            <li class="nav-item">
                <a class="nav-item-hold" href="https://www.{{ $affiliate_apply }}/affiliate_apply/" target="_blank">
                    <i class="nav-icon i-Stamp-2"></i>
                    <span class="nav-text">Apply Affiliate</span>
                    <span class="number" style="width: 40px;">NEW!</span>
                </a>
                <div class="triangle"></div>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-item-hold" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="nav-icon i-Double-Tap"></i>
                    <span class="nav-text">Logout</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>
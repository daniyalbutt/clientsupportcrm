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

        <i class="i-Cloud-Sun header-icon d-none d-sm-inline-block" onclick="changeMode()"></i>
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
                @if($notifications->type == 'App\Notifications\AssignProjectNotification')
                <a href="{{ route('create.task.by.project.id', ['id' => $notifications->data['project_id'], 'name' => $notifications->data['text'], 'notify' => $notifications->id]) }}" class="dropdown-item d-flex">
                @elseif($notifications->type == 'App\Notifications\TaskNotification')
                <a href="{{ route('support.task.show', ['id' => $notifications->data['task_id'], 'notify' => $notifications->id]) }}" class="dropdown-item d-flex">
                @elseif($notifications->type == 'App\Notifications\MessageNotification')
                <a href="{{ route('support.message.show.id', ['id' => $notifications->data['id'], 'name' => $notifications->data['name'], 'notify' => $notifications->id]) }}" class="dropdown-item d-flex">
                @elseif($notifications->type == 'App\Notifications\ObjectionNotification')
                <a href="javascript:;" class="dropdown-item d-flex">
                @else
                @php
                $task_id = 0;
                $project = \App\Models\Project::where('client_id', $notifications->data['id'])->first();
                if($project != null){
                    if(count($project->tasks) != 0){
                        $task_id = $project->tasks[0]->id;
                    }
                }
                @endphp
                <a href="{{ route('support.task.show', ['id' => $task_id, 'notify' => $notifications->id]) }}" class="dropdown-item d-flex">
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
                            <span class="lead-heading">{{ strip_tags($notifications->data['text']) }}</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-3">{{ $notifications->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="text-small text-muted m-0">Name: {{$notifications->data['name']}}</p>
                    </div>
                </a>
                @endforeach
                <a href="{{ route('support.read.notification') }}" class="dropdown-item d-flex mark-as-read">
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
                        <i class="i-Lock-User mr-1"></i> {{ Auth::user()->name }} {{ Auth::user()->last_name}}
                    </div>
                    <a class="dropdown-item" href="{{ route('support.edit.profile') }}">Edit Profile</a>
                    <a class="dropdown-item" href="{{ route('support.change.password') }}">Change Password</a>
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
            <li class="nav-item {{ (request()->routeIs('support.home'))? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('support.home') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->routeIs('support.message.get.by.support') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('support.message.get.by.support') }}">
                    <i class="nav-icon i-Speach-Bubble-3"></i>
                    <span class="nav-text">Messages</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ ( request()->routeIs('support.project') || request()->routeIs('support.form') || request()->routeIs('create.task.by.project.id')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('support.project') }}">
                    <i class="nav-icon i-Suitcase"></i>
                    <span class="nav-text">Projects</span>
                    <span class="counter">{{ Auth()->user()->projects_count() }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ ( request()->routeIs('support.task') || request()->routeIs('support.task.show')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('support.task') }}">
                    <i class="nav-icon i-Receipt-4"></i>
                    @php
                    $notifications = Auth()->user()->unreadnotifications->where('type', 'App\Notifications\TaskNotification')->all();
                    @endphp
                    <span class="nav-text">Tasks</span>
                    <span class="counter">{{ count($notifications) }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->routeIs('support.tickets') || request()->routeIs('support.issue.show') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('support.tickets') }}">
                    <i class="nav-icon i-Thread"></i>
                    <span class="nav-text">QA Reports</span>
                    <span class="counter">{{ Auth()->user()->issueCounts() }}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item">
                <a class="nav-item-hold scroll-to-bottom" href="javascript:;">
                    <i class="nav-icon i-Down"></i>
                    <span>Scroll Bottom</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>

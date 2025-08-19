<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <title>{{ config('app.name', 'Kamay Backoffice') }}</title> -->
    <title>{{ config('app.name') }} - @yield('title')</title> 
    <!-- Scripts -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('global/img/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('global/img/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('global/img/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('global/img/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('global/img/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('global/img/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('global/img/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('global/img/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('global/img/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('global/img/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('global/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('global/img/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('global/img/favicon-16x16.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('global/img/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('newglobal/css/lite-purple.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('newglobal/css/perfect-scrollbar.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('newglobal/css/toastr.css') }}" rel="stylesheet" />
    <link href="{{ asset('newglobal/css/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('newglobal/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('newglobal/css/sweetalert2.min.css') }}" rel="stylesheet" />
    <style type="text/css">
        .file {
              visibility: hidden;
              position: absolute;
            }
            .checked {
              color: orange;
            }

            #chartdiv {
              width: 100%;
              height: 500px;
            }
    </style>
    @stack('styles')
</head>
<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        @include('inc.production-nav')
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="main-content">
                @if(Auth::user()->status == 0)
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h3 class="alert-heading mb-2 font-weight-bold">Account is Under Review</h3>
                                <p>Your Account is Under Review! After Admin Approval you are enable to Start Posting...</p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                @yield('content')
                @endif    
            </div>
            <div class="flex-grow-1"></div>
            <div class="app-footer">
                <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
                    <span class="flex-grow-1"></span>
                    <div class="d-flex align-items-center">
                        <img class="logo" src="{{ asset('global/img/sidebarlogo.png') }}" alt="">
                        <div>
                            <p class="m-0">&copy; <?php echo date("Y"); ?> {{ config('app.name') }}</p>
                            <p class="m-0">All rights reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--     
    <script src="{{ asset('global/js/vendors.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('global/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('global/js/app-menu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('global/js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('global/js/customizer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('global/js/datatables.min.js') }}"></script>
    <script src="{{ asset('global/js/datatable-basic.min.js') }}"></script>
    <script src="{{ asset('global/js/form-select2.min.js') }}"></script>
    <script src="{{ asset('global/js/ajaxHelper.js') }}"></script>
    <script src="{{ asset('global/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('global/js/highlight.js') }}"></script>
    <script src="{{ asset('global/js/toastr.min.js') }}"></script>
    <script src="{{ asset('global/js/custom_script.js') }}"></script> -->
    <script src="{{ asset('newglobal/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/script.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/echarts.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/echart.options.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/datatables.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/toastr.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/select2.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/Chart.min.js') }}"></script>
    <script src="{{ asset('newglobal/js/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js" integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            if($('.repeater').length != 0){
                $('.repeater').repeater({
                    // (Required if there is a nested repeater)
                    // Specify the configuration of the nested repeaters.
                    // Nested configuration follows the same format as the base configuration,
                    // supporting options "defaultValues", "show", "hide", etc.
                    // Nested repeaters additionally require a "selector" field.
                    repeaters: [{
                        // (Required)
                        // Specify the jQuery selector for this nested repeater
                        selector: '.inner-repeater'
                    }]
                });
            }
        });
    </script>
    @yield('script')

    @stack('scripts')
    @if(session()->has('success'))
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
    <script>
        if($('.select2').length != 0){
            $('.select2').select2();
        }
        if($('.zero-configuration').length != 0){
            $('.zero-configuration').DataTable({
                order: [[0, "desc"]],
                responsive: true,
            });
        }
    </script>
    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        setInterval(() => {
            $.ajax({
                type:'POST',
                url:"{{ url('keep-alive') }}",
                success:function(data){
                    if(data.ok == false){
                        document.getElementById('logout-form').submit();
                    }
                }
            });
        }, 1200000)
    </script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        if (!window.Notification) {
            console.log('Browser does not support notifications.');
        } else {
            // check if permission is already granted
            if (Notification.permission === 'granted') {
                // show notification here
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

        Pusher.logToConsole = true;
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
        channel.bind('send-task-notifiction', function(data) {
            console.log('manager')
            console.log('send-event')
            console.log(data)
            if (!window.Notification) {
                console.log('Browser does not support notifications.');
            } else {
                // check if permission is already granted
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
</body>
</html>
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
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('global/img/android-icon-192x192.png') }}">
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
    @stack('styles')
    <style>
        .select2-container .select2-selection--single {
            height: 34px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 31px;
            background-color: #f8f9fa;
        }

        .select2-container--default .select2-selection--single {
            background-color: transparent;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        span.number {
            width: 15px;
            height: 15px;
            display: inline-block;
            font-size: 10px;
            border-radius: 50px;
            color: white;
            position: absolute;
            top: 22px;
            font-weight: bold;
            right: 35px;
            color: #7f231c;
            background-color: #fdd9d7;
            border-color: #fccac7;
        }

        .layout-sidebar-large .sidebar-left .navigation-left .nav-item .nav-item-hold {
            position: relative;
        }
    </style>
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        @include('inc.client-nav')
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="main-content">
                @yield('content')
            </div>
            <div class="flex-grow-1"></div>
            <div class="app-footer">
                <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
                    <span class="flex-grow-1"></span>
                    <div class="d-flex align-items-center">
                        <img class="logo" src="{{ asset('global/img/sidebarlogo.png') }}" alt="">
                        <div>
                            <p class="m-0">&copy; <?php echo date('Y'); ?> {{ config('app.name') }}</p>
                            <p class="m-0">All rights reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

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
    @yield('script')

    @stack('scripts')
    @if (session()->has('success'))
        <script>
            var timerInterval;
            swal({
                type: 'success',
                title: 'Success!',
                text: '{{ session()->get('success') }}',
                timer: 2000,
                showCancelButton: false,
                showConfirmButton: false
            });
        </script>
        <!-- <script>
            toastr.success("", "{{ session()->get('success') }}", {
                timeOut: "50000"
            });
        </script> -->
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

        if ($('.select2').length != 0) {
            $('.select2').select2();
        }
        $(document).ready(function() {
            $('#theme-mode').change(function(e) {
                if (this.checked) {
                    console.log('checked');
                } else {
                    console.log('un checked');
                }
            });
        })
    </script>


    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
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

        channel.bind('receivemessage', function(data) {
            $('#dropdownNotification span').text(parseInt($('#dropdownNotification span').text()) + 1);
            $('.notification-dropdown').prepend(`<a href="${data.link}" class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Speach-Bubble-8 text-primary mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span class="lead-heading">${data.user.name} ${data.user.last_name} has send you a Message</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-3">Now</span>
                        </p>
                        <p class="text-small text-muted m-0">${data.message}</p>
                    </div>
                </a>`);
            var file_wrapper = '';
            if(data.files.length != 0){
                for(var i = 0; i < data.files.length; i++){
                    file_wrapper += '<ul>';
                    file_wrapper += '<li><button class="btn btn-dark btn-sm">'+(i+1)+'</button></li>';
                    var file_wrapper_image = '';
                    if((data.files[i]['extension'] == 'jpg') || (data.files[i]['extension'] == 'png') || ((data.files[i]['extension'] == 'jpeg'))){
                        file_wrapper_image = '<img src="'+ data.files[i]['path'] + '" alt="' + data.files[i]['name'] +'" width="40">';
                    }
                    file_wrapper += '<li><a href="'+data.files[i]['path']+'" target="_blank">'+file_wrapper_image+'</a></li>';
                    file_wrapper += '<li><a href="'+data.files[i]['path']+'" target="_blank">'+data.files[i]['name']+'</a></li>';
                    file_wrapper += '<li><a href="'+data.files[i]['path']+'" target="_blank" download>Download</a></li>';
                    file_wrapper += '<ul>';
                }
            }
            // console.log(data);
                $('#message-box-wrapper').append(`<div class="card mb-3 right-card">
                    <div class="card-body">
                        <div class="card-content collapse show">
                            <div class="ul-widget__body mt-0">
                                <div class="ul-widget3 message_show">
                                    <div class="ul-widget3-item mt-0 mb-0">
                                        <div class="ul-widget3-header">
                                            <div class="ul-widget3-info">
                                                <a class="__g-widget-username" href="#">
                                                    <span class="t-font-bolder">${data.user.name}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ul-widget3-body">
                                            <p>${data.full_message}</p>
                                            <span class="ul-widget3-status text-success t-font-bolder text-right">
                                                ${data.date}
                                            </span>
                                        </div>
                                        <div class="file-wrapper">
                                            ${file_wrapper}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <i class="fa-solid fa-check fa-not-seen"></i>
                        </div>
                    </div>
                </div>`);
                // $(".message-box-wrapper").mCustomScrollbar("scrollTo", "bottom");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url:'{{ route("message.seen") }}',
                    dataType: 'json',
                    data: {
                        'id' : data.user.id,
                    },
                    success:function(data) {
                        console.log(data);
                    } 
                });
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
    </script>
</body>

</html>

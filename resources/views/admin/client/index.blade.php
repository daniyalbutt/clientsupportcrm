@extends('layouts.app-admin')
@section('title', 'Leads')
@push('styles')
    <style>
        .select2-container {
            z-index: 1;
            text-align: left;
        }
    </style>
@endpush
@section('content')
    <div class="breadcrumb row">
        <div class="col-md-6">
            <h1 class="mr-2">Clients</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.client.create') }}" class="btn btn-primary">Create Client</a>
        </div>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card text-left">
                <div class="card-body">
                    <form action="{{ route('admin.client.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3 form-group mb-3">
                                <label for="name">Search Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ Request::get('name') }}">
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="email">Search Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ Request::get('email') }}">
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="brand">Search From Brand</label>
                                <select name="brand" id="brand" class="form-control">
                                    <option value="">Any</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ Request::get('brand') == $brand->id ? 'selected' : ' ' }}>
                                            {{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="status">Select Status</label>
                                <select class="form-control select2" name="status" id="status">
                                    <option value="">Any</option>
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="text-right">
                                    <button class="btn btn-primary">Search Result</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3 count-card-title">Client's Details <span> Total: <span id="count-record">
                                {{ $data->total() }} </span></span>
                    </h4>
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name / Email</th>
                                    <th>Crate Login</th>
                                    <th>Brand</th>
                                    <th>Payment Link</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Active</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-client">
                                @foreach ($data as $datas)
                                    <tr>
                                        <td>{{ $datas->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.client.show', $datas->id) }}">{{ $datas->name }}
                                                {{ $datas->last_name }}</a>
                                            <br>
                                            {{ $datas->email }}
                                        </td>
                                        <td>
                                            <a href="javascript:;"
                                                class="btn btn-{{ $datas->user_id == null ? 'primary' : 'success' }} btn-sm auth-create"
                                                data-id="{{ $datas->id }}"
                                                data-auth="{{ $datas->user_id == null ? 0 : 1 }}"
                                                data-password="{{ $datas->user_id == null ? '' : '' }}">{{ $datas->user_id == null ? 'Click Here' : 'Reset Pass' }}</a>
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm">{{ $datas->brand->name }}</button>
                                            @if ($datas->url != null)
                                                <button class="btn btn-secondary btn-sm">From Website</button>
                                            @endif
                                        </td>
                                        <td><a href="{{ route('admin.invoice.index', $datas->id) }}"
                                                class="btn btn-primary btn-sm">Generate Payment</a></td>
                                        <td>
                                            @if ($datas->status == 1)
                                                <button class="btn btn-success btn-sm">Active</button><br>
                                            @else
                                                <button class="btn btn-danger btn-sm">Deactive</button><br>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-secondary">{{ $datas->created_at->format('h:m a - d M, Y') }}</button>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.client.edit', $datas->id) }}"
                                                class="btn btn-blue btn-icon btn-sm">
                                                <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                            </a>
                                            <a href="{{ route('admin.client.show', $datas->id) }}"
                                                class="btn btn-dark btn-icon btn-sm">
                                                <span class="ul-btn__icon"><i class="i-Eyeglasses-Smiley"></i></span>
                                            </a>
                                            <form method="POST" action="{{ route('admin.client.destroy', $datas->id) }}"
                                                style="display: inline-block;">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button class="btn btn-danger btn-icon btn-sm" type="submit">
                                                    <span class="ul-btn__icon"><i class="i-Delete-File"></i></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name / Email</th>
                                    <th>Crate Login</th>
                                    <th>Brand</th>
                                    <th>Payment Link</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Active</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $data->appends(['name' => Request::get('name'), 'email' => Request::get('email'), 'brand' => Request::get('brand'), 'status' => Request::get('status')])->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        let htmlTag = new Promise((resolve) => {
            setTimeout(() => {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.client.agent') }}",
                    success: function(data) {
                        var getData = data.data;
                        htmlTag = '<select id="MySelect" class="form-control select2">';
                        for (var i = 0; i < getData.length; i++) {
                            htmlTag += '<option value="' + getData[i].id + '">' + getData[i]
                                .name + ' ' + getData[i].last_name + '</option>'
                        }
                        htmlTag += '</select>';
                        resolve(htmlTag);
                    }
                });
            }, 1000)
        })

        function getAgent() {

        }

        function assignAgent(id) {
            getAgent()
            console.log(htmlTag);
            swal({
                title: 'Select Agent',
                html: htmlTag,
                showCancelButton: true,
                onOpen: function() {
                    $('.select2').select2();
                },
                inputValidator: function(value) {
                    return new Promise(function(resolve, reject) {
                        if (value !== '') {
                            resolve();
                        } else {
                            resolve('You need to select a Tier');
                        }
                    });
                }
            }).then(function(result) {
                let agent_id = $('#MySelect option:selected').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.client.update.agent') }}",
                    data: {
                        id: id,
                        agent_id: agent_id
                    },
                    success: function(data) {
                        if (data.success == true) {
                            swal("Agent Assigned", "Page will be loaded in order to reflect data",
                                "success");
                            setTimeout(function() {
                                location.reload(true);
                            }, 3000);
                        } else {
                            return swal({
                                title: "Error",
                                text: "There is an Error, Plase Contact Administrator",
                                type: "danger"
                            })
                        }
                    }
                });
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        html: 'You selected: ' + result.value
                    });
                }
            });
        }

        function generatePassword() {
            var length = 16,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }
            return retVal;
        }
        $('.auth-create').on('click', function() {
            var auth = $(this).data('auth');
            var id = $(this).data('id');
            var pass = generatePassword();
            if (auth == 0) {
                swal({
                    title: "Enter Password",
                    input: "text",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Enter Password",
                    inputValue: pass
                }).then(function(inputValue) {
                    if (inputValue === false) {
                        return swal({
                            title: "Field cannot be empty",
                            text: "Password Not Inserted/Updated because it is Empty",
                            type: "danger"
                        })
                    }
                    if (inputValue === "") {
                        return swal({
                            title: "Field cannot be empty",
                            text: "Password Not Inserted/Updated because it is Empty",
                            type: "danger"
                        })
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.client.createauth') }}",
                        data: {
                            id: id,
                            pass: inputValue
                        },
                        success: function(data) {
                            if (data.success == true) {
                                swal("Auth Created", "Password is : " + inputValue, "success");
                            } else {
                                return swal({
                                    title: "Error",
                                    text: "There is an Error, Plase Contact Administrator",
                                    type: "danger"
                                })
                            }
                        }
                    });
                });
            } else {
                swal({
                    title: "Enter Password",
                    input: "text",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Enter Password",
                    inputValue: pass
                }).then(function(inputValue) {
                    if (inputValue === false) {
                        return swal({
                            title: "Field cannot be empty",
                            text: "Password Not Inserted/Updated because it is Empty",
                            type: "danger"
                        })
                    }
                    if (inputValue === "") {
                        return swal({
                            title: "Field cannot be empty",
                            text: "Password Not Inserted/Updated because it is Empty",
                            type: "danger"
                        })
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.client.updateauth') }}",
                        data: {
                            id: id,
                            pass: inputValue
                        },
                        success: function(data) {
                            if (data.success == true) {
                                swal("Auth Created", "Password is : " + inputValue, "success");
                            } else {
                                return swal({
                                    title: "Error",
                                    text: "There is an Error, Plase Contact Administrator",
                                    type: "danger"
                                })
                            }
                        }
                    });
                });
            }
        });
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


        channel.bind('send-lead-notifiction', function(data) {
            let responseData = JSON.parse(data.data)

            let data_record = $(`<tr>
                <td>${responseData.id}</td>
                <td>
                    <a href="${window.origin}/admin/client/${responseData.id}">${responseData.name}</a><br>
                    ${responseData.email}
                </td>
                <td>
                    <a href="javascript:;" class="btn btn-primary btn-sm auth-create" data-id="${responseData.id}" data-auth="0" data-password="">Click Here</a>
                </td>
                <td>
                    <button class="btn btn-info btn-sm">${responseData.brand.name}</button>
                    <button class="btn btn-secondary btn-sm">From Website</button>
                </td>
                <td>
                    <a href="${window.origin}/admin/create-invoice/${responseData.id}" class="btn btn-primary btn-sm">Generate Payment</a>
                </td>
                <td>
                    <button class="btn btn-success btn-sm">Active</button><br>
                </td>
                <td>
                    <button class="btn btn-sm btn-secondary">NOW</button>
                </td>
                <td>
                    <a href="${window.origin}/admin/client/${responseData.id}/edit" class="btn btn-primary btn-icon btn-sm">
                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                        <span class="ul-btn__text">Edit</span>
                    </a>
                    <a href="${window.origin}/admin/client/${responseData.id}" class="btn btn-dark btn-icon btn-sm">
                        <span class="ul-btn__icon"><i class="i-Eyeglasses-Smiley"></i></span>
                        <span class="ul-btn__text">View</span>
                    </a>
                    <form method="POST" action="${window.origin}/admin/client/${responseData.id}" style="display: inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                        <button class="btn btn-danger btn-icon btn-sm" type="submit">
                            <span class="ul-btn__icon"><i class="i-Delete-File"></i></span>
                            <span class="ul-btn__text">Delete</span>
                        </button>
                    </form>
                </td>
            </tr>`).hide();
            $('#tbody-client').prepend(data_record);
            $('#count-record').text(parseInt($('#count-record').text().trim()) + 1)
            $('#tbody-client tr:first').fadeIn('slow');


        });
    </script>
@endpush

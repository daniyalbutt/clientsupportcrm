@extends('layouts.app-sale')
@section('title', 'Invoices')
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Invoices</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <form action="{{ route('sale.invoice') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3 form-group mb-3">
                            <label for="package">Search Package</label>
                            <input type="text" class="form-control" id="package" name="package" value="{{ Request::get('package') }}">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="invoice">Search Invoice#</label>
                            <input type="text" class="form-control" id="invoice" name="invoice" value="{{ Request::get('invoice') }}">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="user">Select User</label>
                            <select class="form-control select2" name="user" id="user">
                                <option value="0">Any</option>
                                @foreach(Auth()->user()->getClient as $getClient)
                                <option value="{{ $getClient->id }}" {{ Request::get('user') == $getClient->id ? 'selected' : '' }}>{{ $getClient->name }} {{ $getClient->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="status">Select Status</label>
                            <select class="form-control select2" name="status" id="status">
                                <option value="0" {{ Request::get('status') == 0 ? 'selected' : '' }}>Any</option>
                                <option value="2" {{ Request::get('status') == 2 ? 'selected' : '' }}>Paid</option>
                                <option value="1" {{ Request::get('status') == 1 ? 'selected' : '' }}>Unpaid</option>
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
                <h4 class="card-title mb-3">Invoice Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>User</th>
                                <th>Brand</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Create Login</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $datas)
                            <tr>
                                <td>
                                    <span class="btn btn-sm btn-dark">#{{ $datas->invoice_number }}</span>
                                </td>
                                <td>
                                    @if($datas->package == 0)
                                    {{ $datas->custom_package }}
                                    @else
                                    {{ $datas->package }}
                                    @endif
                                </td>
                                <td>{{ $datas->name }}<br>{{ $datas->email }}</td>
                                <td>{{ $datas->brands->name }}</td>
                                <td>
                                    @php
                                    $service_list = explode(',', $datas->service);
                                    @endphp
                                    @for($i = 0; $i < count($service_list); $i++)
                                    <span class="btn btn-info btn-sm mb-1">{{ $datas->services($service_list[$i])->name }}</span>
                                    @endfor
                                </td>
                                <td>
                                    <span class="btn btn-{{ App\Models\Invoice::STATUS_COLOR[$datas->payment_status] }} btn-sm">
                                        {{ App\Models\Invoice::PAYMENT_STATUS[$datas->payment_status] }}
                                    </span>
                                </td>
                                <td>{{ $datas->currency_show->sign }}{{ $datas->amount }}</td>
                                <td>                                    
                                    @if($datas->payment_status == 2)
                                    <a href="javascript:;" class="btn btn-{{ $datas->client->user == null ? 'primary' : 'success' }} btn-sm auth-create" data-id="{{ $datas->client->id }}" data-auth="{{ $datas->client->user == null ? 0 : 1 }}" data-password="{{ $datas->client->user == null ? '' : $datas->client->user->password }}">{{ $datas->client->user == null ? 'Click Here' : 'Reset Pass' }}</a>
                                    @else
                                    <span class="btn btn-info btn-sm">Payment Pending</span>
                                    @endif

                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if($datas->payment_status == 1)
                                        <a href="{{ route('sale.invoice.edit', $datas->id) }}" class="btn btn-primary btn-icon btn-sm mr-1">
                                            <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                            <span class="ul-btn__text">Edit</span>
                                        </a>
                                        @endif
                                        <a href="{{ route('sale.link', $datas->id) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>User Name</th>
                                <th>Brand</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Create Login</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $data->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    function generatePassword() {
        var length = 16,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        return retVal;
    }
    $('.auth-create').on('click', function () {
        var auth = $(this).data('auth');
        var id = $(this).data('id');
        var pass = generatePassword();
        if(auth == 0){
            swal({
                title: "Enter Password",
                input: "text",
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: "Enter Password",
                inputValue: pass
                }).then(function (inputValue) {
                if (inputValue === false){
                    return swal({
                        title:"Field cannot be empty",
                        text: "Password Not Inserted/Updated because it is Empty",
                        type:"danger"
                    })
                }
                if (inputValue === "") {
                    return swal({
                        title:"Field cannot be empty",
                        text: "Password Not Inserted/Updated because it is Empty",
                        type:"danger"
                    })
                }
                $.ajax({
                    type:'POST',
                    url: "{{ route('sale.client.createauth') }}",
                    data: {id: id, pass:inputValue},
                    success:function(data) {
                        if(data.success == true){
                            swal("Auth Created", "Password is : " + inputValue, "success");
                        }else{
                            return swal({
                                title:"Error",
                                text: "There is an Error, Plase Contact Administrator",
                                type:"danger"
                            })
                        }
                    }
                });
            });
        }else{
            swal({
                title: "Enter Password",
                input: "text",
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: "Enter Password",
                inputValue: pass
                }).then(function (inputValue) {
                if (inputValue === false){
                    return swal({
                        title:"Field cannot be empty",
                        text: "Password Not Inserted/Updated because it is Empty",
                        type:"danger"
                    })
                }
                if (inputValue === "") {
                    return swal({
                        title:"Field cannot be empty",
                        text: "Password Not Inserted/Updated because it is Empty",
                        type:"danger"
                    })
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    type:'POST',
                    url: "{{ route('sale.client.updateauth') }}",
                    data: {id: id, pass:inputValue},
                    success:function(data) {
                        if(data.success == true){
                            swal("Auth Created", "Password is : " + inputValue, "success");
                        }else{
                            return swal({
                                title:"Error",
                                text: "There is an Error, Plase Contact Administrator",
                                type:"danger"
                            })
                        }
                    }
                });
            });
        }
    });
</script>
@endpush
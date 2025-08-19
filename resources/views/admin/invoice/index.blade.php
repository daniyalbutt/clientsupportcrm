@extends('layouts.app-admin')
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
                <form action="{{ route('admin.invoice') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3 form-group mb-3">
                            <label for="package">Search Package</label>
                            <input type="text" class="form-control" id="package" name="package" value="{{ Request::get('package') }}">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="invoice">Search Invoice Number</label>
                            <input type="text" class="form-control" id="invoice" name="invoice" value="{{ Request::get('invoice') }}">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="customer">Search Customer Name</label>
                            <input type="text" class="form-control" id="customer" name="customer" value="{{ Request::get('customer') }}">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="agent">Search Agent Name</label>
                            <input type="text" class="form-control" id="agent" name="agent" value="{{ Request::get('agent') }}">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="merchant">Select Merchant</label>
                            <select name="merchant" id="merchant" class="form-control">
                                <option value="">Any</option>
                                @foreach ($merchants as $key => $merchant)
                                <option value="{{ $merchant->id }}" {{ Request::get('merchant') == $merchant->id ? 'selected' : ''}}>{{ $merchant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="brand">Select Brand</label>
                            <select class="form-control select2" name="brand" id="brand">
                                <option value="0" {{ Request::get('brand') == 0 ? 'selected' : ''}} >Any</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ Request::get('brand') == $brand->id ? 'selected' : ''}} >{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="status">Select Status</label>
                            <select class="form-control select2" name="status" id="status">
                                <option value="0" {{ Request::get('status') == 0 ? 'selected' : ''}} >Any</option>
                                <option value="2" {{ Request::get('status') == 2 ? 'selected' : '' }}>Paid</option>
                                <option value="1" {{ Request::get('status') == 1 ? 'selected' : '' }}>Unpaid</option>
                                <option value="5" {{ Request::get('status') == 5 ? 'selected' : '' }}>Declined</option>
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
                <h4 class="card-title mb-3 count-card-title">Invoice Details <span> Total: {{ $data->total() }} <span></h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%" id="display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>User Name</th>
                                <th>Agent Name</th>
                                <th>Brand</th>
                                <th>Amount</th>
                                <th>Status</th> 
                                <th>Merchant</th> 
                                <th>Date</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $datas)
                            <tr>
                                <td><span class="btn btn-primary btn-sm">{{ $datas->invoice_number }}</span></td>
                                <td>
                                    @if($datas->package == 0)
                                    {{ $datas->custom_package }}
                                    @else
                                    {{ $datas->package }}
                                    @endif
                                </td>
                                <td>
                                    {{ $datas->client->name }} {{ $datas->client->last_name }}<br>
                                    {{ $datas->client->email }}
                                </td>
                                <td>
                                @if($datas->sales_agent_id != 0)
                                    {{ $datas->sale->name }} {{ $datas->sale->last_name }}
                                @else
                                    From Website
                                @endif
                                </td>
                                <td><button class="btn btn-sm btn-secondary">{{ $datas->brands->name }}</button></td>
                                <td>{{ $datas->currency_show->sign }}{{ $datas->amount }}</td>
                                <td>
                                    <span class="btn btn-{{ App\Models\Invoice::STATUS_COLOR[$datas->payment_status] }} btn-sm">
                                        {{ App\Models\Invoice::PAYMENT_STATUS[$datas->payment_status] }}
                                        @if($datas->payment_status == 1)
                                        <form method="post" action="{{ route('admin.invoice.paid', $datas->id) }}">
                                            @csrf
                                            <button type="submit" class="mark-paid btn btn-danger p-0">Mark As Paid</button>
                                        </form>
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    {{ $datas->merchant->name }}<br>
                                    <button class="btn btn-sm btn-secondary">{{ $datas->merchant->get_merchant_name() }}</button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">{{ date('g:i a - d M, Y', strtotime($datas->created_at)) }}</button>
                                </td>
                                <td>
                                    <a href="{{ route('admin.invoice.edit', ['id' => $datas->id]) }}" class="btn btn-blue btn-icon">
                                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                    </a>
                                    <a href="{{ route('admin.link', $datas->id) }}" class="btn btn-info btn-icon">
                                        <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.invoice.delete', $datas->id) }}" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to submit?');">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger btn-icon" type="submit">
                                            <span class="ul-btn__icon"><i class="i-Folder-Trash"></i></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>User Name</th>
                                <th>Agent Name</th>
                                <th>Brand</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Merchant</th>
                                <th>Date</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="ajax-loading"><img src="{{ asset('newglobal/images/loader.gif') }}" /></div>
                    <!-- {{ $data->appends(['package' => Request::get('package'), 'invoice' => Request::get('invoice'), 'customer' => Request::get('customer'), 'agent' => Request::get('agent'), 'status' => Request::get('status')])->links("pagination::bootstrap-4") }} -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    var SITEURL = "{{ url('/') }}";
    var page = 2;
    load_more(page);
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 1) {
            page++;
            load_more(page); //load content   
        }
    });
    function load_more(page){
        $.ajax({
            url: SITEURL + "/admin/invoice?"+window.location.search.substr(1)+'&page='+ page,
            type: "get",
            datatype: "html",
            beforeSend: function(){
                $('.ajax-loading').show();
            }
        })
        .done(function(data){
            if(data.length == 0){
                $('.ajax-loading').html("No more records!");
                return;
            }
            $('.ajax-loading').hide();
            $("#display tbody").append(data);
        })
        .fail(function(jqXHR, ajaxOptions, thrownError){
            alert('No response from server');
        });
    }
</script>
@endpush
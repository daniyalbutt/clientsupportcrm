@extends('layouts.front-app')
@section('content')
<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Dashboard</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @can('create payment')
            <a href="{{ route('payment.create') }}" class="btn btn-primary">Create Invoice</a>
            @endcan
        </div>
    </div>
</div>
<div class="content">
    <form method="get" action="{{ route('home') }}">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md">
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ Request::get('name') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ Request::get('email') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ Request::get('phone') }}">
                    </div>
                    <div class="col-md">
                        <select class="form-control" name="brand">
                            <option value="" {{ Request::get('brand') == null ? 'selected' : '' }}>All Brands</option>
                            @foreach($brands as $key => $value)
                            <option value="{{ $value->id }}" {{ !is_null(Request::get('brand')) && Request::get('brand') == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md">
                        <select class="form-control" name="status">
                            <option value="" {{ Request::get('status') == null ? 'selected' : '' }}>All Status</option>
                            <option value="2" {{ !is_null(Request::get('status')) && Request::get('status') == 2 ? 'selected' : '' }}>SUCCESS</option>
                            <option value="0" {{ !is_null(Request::get('status')) && Request::get('status') == 0 ? 'selected' : '' }}>PENDING</option>
                            <option value="1" {{ !is_null(Request::get('status')) && Request::get('status') == 1 ? 'selected' : '' }}>DECLINED</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" type="submit" style="width: 100%;">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12">
            <div class="box">
                @if (\Session::has('success'))
                <div class="alert alert-success">{!! \Session::get('success') !!}</div>
                @endif
                <div class="box-header d-flex justify-content-between">
                    <h4 class="box-title">Payment <strong>Details</strong></h4>
                    <h4 class="box-title" style="text-align: right;">{{ date('F') }} Paid: <strong>${{ $month_paid }}</strong> <br> Last ID#{{ $last != null ? $last->id . '- $' . $last->price : '' }}</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped no-border">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Package</th>
                                    <th>Price</th>
                                    <th>Merchant</th>
                                    <th>Brand</th>
                                    <th>Status</th>
                                    <th>Link</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                <tr class="{{ $loop->first ? 'bt-3 border-primary' : '' }} {{ $loop->last ? 'bb-3 border-warning' : '' }}">
                                    <th scope="row">{{ $value->id }}</th>
                                    <td>{{ $value->client->name }}<br>{{ $value->client->email }}</td>
                                    <td>{{ $value->package }}</td>
                                    <td>{{ $value->currency != null ? $value->currency->sign : '$' }}{{ $value->price }}</td>
                                    <td><span class="badge {{ $value->merchant == 0 ? 'badge-primary' : 'badge-secondary'}}">{{ $value->merchants != null ? $value->merchants->name : ($value->merchant == 0 ? 'STRIPE' : 'SQUARE')  }}</span></td>
                                    <td><span class="badge badge-dark">{{ $value->client->brand != null ? $value->client->brand->name : $value->client->brand_name }}</span> {!! $value->is_website == 1 ? '<br><span class="badge badge-info badge-sm">FROM WEBSITE</span>' : '' !!}</td>
                                    <td>
                                        <span class="badge {{ $value->get_badge_status() }}">{{ $value->get_status() }}</span>
                                        @can('download invoice')
                                        @if($value->status == 2)
                                        <a href="{{ route('invoice.download', $value->id) }}" target="_blank" class="btn btn-sm btn-primary mt-2">Invoice <i class="fa-solid fa-circle-down"></i></a>
                                        @endif
                                        @endcan
                                    </td>
                                    <td>
                                        <span class="badge badge-primary" onclick="withJquery('{{ route('pay', [$value->unique_id]) }}')" style="cursor: pointer;">COPY LINK</span>
                                    </td>
                                    <td>{{ $value->created_at->format('d M, Y g:i A') }}</td>
                                    <td>{{ $value->updated_at->format('d M, Y g:i A') }}</td>
                                    <td>
                                        @if($value->status == 2)
                                        <a href="{{ route('show.response', $value->id) }}" class="btn btn-secondary btn-sm">View Response</a>
                                        @endif
                                        <a href="{{ route('payment.show', $value) }}" class="btn btn-info btn-sm">VIEW</a>
                                        @can('delete payment')
                                        <a onclick="return confirm('Are you sure?')"  href="{{ route('payment.delete', ['id' => $value->id]) }}" class="btn btn-danger btn-sm">DELETE</a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-box">
                            {{ $data->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function withJquery(link){
	    var temp = $("<input>");
        $("body").append(temp);
        temp.val(link).select();
        document.execCommand("copy");
        temp.remove();
        console.timeEnd('time1');
    }
</script>
@endpush
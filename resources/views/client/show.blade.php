@extends('layouts.front-app')
@section('content')
<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Clients - {{ $client->name }}</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item" aria-current="page">Clients</li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $client->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @can('view client')
                <a class="btn btn-primary" href="{{ route('clients.index') }}">Client List</a>
            @endcan
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xxxl-4 col-12">
            <div class="box">
                <div class="box-body">
                    <div class="d-flex align-items-center">
                        <img class="me-10 rounded-circle avatar avatar-xl b-2 border-primary" src="{{ asset('images/user.jpg') }}" alt="{{ $client->name }}">
                        <div>
                            <h4 class="mb-0">{{ $client->name }}</h4>
                            <span class="fs-14 text-info">{{ $client->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="box-body border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-phone me-10 fs-24"></i>
                        <h4 class="mb-0">{{ $client->phone }}</h4>
                    </div>
                </div>
                <div class="box-body border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-award me-10 fs-24"></i>
                        <h4 class="mb-0 text-black">{{ $client->brand != null ? $client->brand->name : $client->brand_name }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxxl-8 col-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped no-border">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Package</th>
                                    <th>Price</th>
                                    <th>Merchant</th>
                                    <th>Status</th>
                                    <th>Link</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->payment as $key => $value)
                                <tr class="{{ $loop->first ? 'bt-3 border-primary' : '' }} {{ $loop->last ? 'bb-3 border-warning' : '' }}">
                                    <th scope="row">{{ $value->id }}</th>
                                    <td>{{ $value->package }}</td>
                                    <td>{{ $value->currency != null ? $value->currency->sign : '$' }}{{ $value->price }}</td>
                                    <td><span class="badge {{ $value->merchant == 0 ? 'badge-primary' : 'badge-secondary'}}">{{ $value->merchants != null ? $value->merchants->name : ($value->merchant == 0 ? 'STRIPE' : 'SQUARE')  }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge {{ $value->get_badge_status() }}">{{ $value->get_status() }}</span>
                                            @can('download invoice')
                                            @if($value->status == 2)
                                            <a href="{{ route('invoice.download', $value->id) }}" target="_blank" class="btn btn-sm btn-primary ms-2">Invoice <i class="fa-solid fa-circle-down"></i></a>
                                            @endif
                                            @endcan
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary" onclick="withJquery('{{ route('pay', [$value->unique_id]) }}')" style="cursor: pointer;">COPY LINK</span>
                                    </td>
                                    <td>{{ $value->created_at->format('d M, Y g:i A') }}<br>{{ $value->updated_at->format('d M, Y g:i A') }}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
   
@endpush
@extends('layouts.front-app')
@section('content')
<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Currency</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item active" aria-current="page">Currency</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @can('create currency')
            <a class="btn btn-primary" href="{{ route('currency.create') }}">Add Currency</a>
            @endcan
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <form method="get" action="{{ route('currency.index') }}">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md">
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ Request::get('name') }}">
                    </div>
                    <div class="col-md">
                        <select name="merchant" id="merchant" class="form-control">
                            <option value="">All Merchant</option>
                            <option value="0" {{ Request::get('merchant') !== null && Request::get('merchant') == 0 ? 'selected' : '' }}>Stripe</option>
                        </select>
                    </div>
                    <div class="col-md">
                        <input type="text" name="status" class="form-control" placeholder="Status" value="{{ Request::get('status') }}">
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
                <div class="box-body">
                    <div class="table-responsive rounded card-table">
                        <table class="table border-no" id="example1">
                            <thead>
                                <tr>
                                    <th>SNO</th>
                                    <th>Sign</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $value)
                                <tr class="hover-primary">
                                    <td>#{{ ++$key }}</td>
                                    <td>{{ $value->sign }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{!! $value->status == 0 ? '<span class="badge badge-success badge-sm">ACTIVE</span>' : '<span class="badge badge-danger badge-sm">DEACTIVE</span>' !!}</td>
                                    <td>
                                        <div class="d-flex">
                                            @can('edit currency')
                                            <a href="{{ route('currency.edit', $value->id) }}" class="btn btn-sm btn-primary me-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                            @endcan
                                            @can('delete currency')
                                            <form action="{{ route('currency.destroy', $value->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                            @endcan
                                        </div>
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
@extends('layouts.front-app')
@section('content')
<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Clients</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item active" aria-current="page">Clients</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--<a class="btn btn-primary" href="{{ route('clients.create') }}">Add Client</a>-->
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <form method="get" action="{{ route('clients.index') }}">
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
                        <input type="text" name="brand_name" class="form-control" placeholder="Brand Name" value="{{ Request::get('brand_name') }}">
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
                                    <th>Client ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Brand Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $value)
                                <tr class="hover-primary">
                                    <td>#{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->phone }}</td>
                                    <td>{{ $value->brand != null ? $value->brand->name : $value->brand_name }} {!! $value->is_website == 1 ? '<span class="badge badge-info badge-sm">FROM WEBSITE</span>' : '' !!}</td>
                                    <td>
                                        @can('view client')
                                        <a href="{{ route('clients.show', $value->id) }}" class="btn btn-sm btn-info me-1">View</a>
                                        @endcan
                                        @can('create payment')
                                        <a href="{{ route('payment.create', ['id' => $value->id]) }}" class="btn btn-sm btn-primary me-1">Create Invoice</a>
                                        @endcan
                                        @can('logo form')
                                        @if(count($value->logo_brief))
                                        <div class="btn-group">
                                            <a class="hover-primary dropdown-toggle no-caret" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('logo.brief', $value->id) }}">View Form Details</a>
                                                <!--<a class="dropdown-item" href="#">Edit</a>-->
                                                <!--<a class="dropdown-item" href="#">Delete</a>-->
                                            </div>
                                        </div>
                                        @endif
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
</section>
@endsection

@push('scripts')
   <!-- <script type="text/javascript">-->
   <!-- 	$(function () {-->
   <!-- 		'use strict';-->
   <!-- 		$('#example1').DataTable({-->
		 <!-- 		'paging'      : true,-->
		 <!-- 		'lengthChange': false,-->
		 <!-- 		'searching'   : false,-->
		 <!-- 		'ordering'    : true,-->
		 <!-- 		'info'        : true,-->
		 <!-- 		'autoWidth'   : false-->
			<!--});-->
   <!-- 	});-->
   <!-- </script>-->
@endpush
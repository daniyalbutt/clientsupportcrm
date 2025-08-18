@extends('layouts.front-app')
@section('content')
<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Brands</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item active" aria-current="page">Brands</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @can('create brand')
            <a class="btn btn-primary" href="{{ route('brand.create') }}">Add Brand</a>
            @endcan
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <form method="get" action="{{ route('brand.index') }}">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md">
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ Request::get('name') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="url" class="form-control" placeholder="Url" value="{{ Request::get('url') }}">
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
                                    <th>Name</th>
                                    <th>Url</th>
                                    <th>Currency</th>
                                    <th>Status</th>
                                    <th>Auth Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $value)
                                <tr class="hover-primary">
                                    <td>#{{ ++$key }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->url }}</td>
                                    <td>{{ $value->currency != null ? $value->currency->sign .' - '. $value->currency->name : '$ - USD' }}</td>
                                    <td>{!! $value->status == 0 ? '<span class="badge badge-success badge-sm">ACTIVE</span>' : '<span class="badge badge-danger badge-sm">DEACTIVE</span>' !!}</td>
                                    <td><span class="badge badge-primary" onclick="withJquery('{{ $value->auth_code }}')" style="cursor: pointer;">COPY CODE</span></td>
                                    <td>
                                        <div class="d-flex">
                                            @can('edit brand')
                                            <a href="{{ route('brand.edit', $value->id) }}" class="btn btn-sm btn-primary me-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                            @endcan
                                            @can('delete brand')
                                            <form action="{{ route('brand.destroy', $value->id) }}" method="post">
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
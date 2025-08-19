@extends('layouts.app-admin')
   
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Projects</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <form class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3 col-lg form-group mb-0">
                                <div class="form-group">
                                    <label for="">Select Brand</label>
                                    <select name="brand" class="form-control select2" >
                                        <option value="">All Brand</option>
                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}" {{ $brand->id == app('request')->input('brand') ? 'selected' : ' ' }}>{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-lg form-group mb-0">
                                <div class="form-group">
                                    <label for="client">Client Name / Email</label>
                                    <input type="text" name="client" id="client" class="form-control" value="{{ app('request')->input('client') }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-lg form-group mb-0">
                                <div class="form-group">
                                    <label for="client">Agent Name / Email</label>
                                    <input type="text" name="user" id="user" class="form-control" value="{{ app('request')->input('user') }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-lg form-group mb-0">
                                <div class="form-group">
                                    <label for="category">Select Category</label>
                                    <select name="category" class="form-control select2" >
                                        <option value="">All Category</option>
                                        @foreach($categorys as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-lg form-group mb-0 mt-4">
                                <button class="btn btn-primary btn-block" type="submit">Search</button>
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
                <h4 class="card-title mb-3">Project Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Client</th>
                                <th>Assigned To</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td><a href="javascript:;" title="{{$datas->name}}">{!! \Illuminate\Support\Str::limit(strip_tags($datas->name), 20, $end='...') !!}</a></td>
                                <td>
                                    {{$datas->client->name}} {{$datas->client->last_name}}<br>
                                    {{$datas->client->email}}                                    
                                </td>
                                <td>
                                    {{$datas->added_by->name}} {{$datas->added_by->last_name}} <br>
                                    {{$datas->added_by->email}}
                                </td>
                                <td><button class="btn btn-info btn-sm">{{$datas->brand->name}}</button></td>
                                <td>
                                @foreach($datas->project_category as $project_categories)
                                <button class="btn btn-primary btn-sm">{{$project_categories->name}}</button>
                                @endforeach
                                </td>
                                <td>
                                    @if($datas->status == 1)
                                        <button class="btn btn-success btn-sm">Active</button>
                                    @else
                                        <button class="btn btn-danger btn-sm">Deactive</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.project.edit', $datas->id) }}" class="btn btn-primary btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                        <span class="ul-btn__text">Edit</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Client</th>
                                <th>Assigned To</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $data->appends(['brand' => Request::get('brand'), 'client' => Request::get('client'), 'user' => Request::get('user'), 'category' => Request::get('category')])->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
    
@endpush
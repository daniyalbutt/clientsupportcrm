@extends('layouts.app-admin')
   
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Tasks</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <form class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3 form-group mb-3">
                                <label for="brand">Search From Brand</label>
                                <select name="brand" class="form-control select2" >
                                    <option value="">All Brand</option>
                                    @foreach($brands as $brand)
                                    <option value="{{$brand->id}}" {{ Request::get('brand') ==  $brand->id ? 'selected' : ' '}}>{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-0">
                                <label for="brand">Search From Client Name Or Email</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Request::get('name') }}">
                            </div>
                            <div class="col-md-3 form-group mb-0">
                                <label for="agent">Search From Agent Name</label>
                                <input type="text" class="form-control" id="agent" name="agent" value="{{ Request::get('agent') }}">
                            </div>
                            <div class="col-md-3 form-group mb-0">
                                <label for="category">Search From Category</label>
                                <select name="category" class="form-control select2" >
                                    <option value="">Any</option>
                                    @foreach($categorys as $category)
                                    <option value="{{$category->id}}" {{ Request::get('category') ==  $category->id ? 'selected' : ' '}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-0">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="" {{ Request::get('status') ==  null ? 'selected' : ''}}>Any</option>
                                    <option value="0" {{ Request::get('status') ==  '0' ? 'selected' : ''}}>Open</option>
                                    <option value="1" {{ Request::get('status') ==  '1' ? 'selected' : ''}}>Re Open</option>
                                    <option value="5" {{ Request::get('status') ==  '5' ? 'selected' : ''}}>Sent for Approval</option>
                                    <option value="6" {{ Request::get('status') ==  '6' ? 'selected' : ''}}>Incomplete Brief</option>
                                    <option value="2" {{ Request::get('status') ==  '2' ? 'selected' : ''}}>Hold</option>
                                    <option value="3" {{ Request::get('status') ==  '3' ? 'selected' : ''}}>Completed</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit">Search Result</button>
                                </div>
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
                <h4 class="card-title mb-3 count-card-title">Task Details <span> Total: {{ $data->total() }} <span></h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Project Name</th>
                                <th>Client</th>
                                <th>Agent</th>
                                <th>Brand/Category</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td><a href="{{route('admin.task.show', $datas->id)}}">{!! \Illuminate\Support\Str::limit(strip_tags($datas->description), 25, $end='...') !!}</a></td>
                                <td>{{$datas->projects->name}}</td>
                                <td>{{$datas->projects->client->name}} {{$datas->projects->client->last_name}}</td>
                                <td>{{$datas->user->name}} {{$datas->user->last_name}}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" title="{{$datas->brand->name}}" href="javascript:;">{{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $datas->brand->name))) }}</a>
                                    <a class="btn btn-info btn-sm" title="{{$datas->category->name}}" href="javascript:;">{{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $datas->category->name))) }}</a>
                                </td>
                                <td>{!! $datas->project_status() !!}</td>
                                <td>
                                <!-- {{ route('admin.task.edit', $datas->id) }}  -->
                                    <a href="{{route('admin.task.show', $datas->id)}}" target="_blank" class="btn btn-primary btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Eye"></i></span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Project Name</th>
                                <th>Client</th>
                                <th>Agent</th>
                                <th>Brand/Category</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $data->appends(['brand' => Request::get('brand'), 'name' => Request::get('name'), 'agent' => Request::get('agent'), 'category' => Request::get('category'), 'status' => Request::get('status')])->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
    
@endpush
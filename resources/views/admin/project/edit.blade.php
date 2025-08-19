@extends('layouts.app-admin')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Edit Project (ID: {{$data->id}})</h1>
    <ul>
        <li>Projects</li>
        <li>Edit Project</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>


<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Project Form</div>
                <form class="form" action="{{route('project.update', $data->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">Name <span>*</span></label>
                                <input type="text" id="name" class="form-control" value="{{old('name', $data->name)}}" placeholder="Name" name="name" required="required">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="client">Select Client <span>*</span></label>
                                <select name="client" id="client" class="form-control select2" >
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                    @if($data->client_id == $client->id)
                                    <option value="{{$client->id}}" selected>{{$client->name}} {{$client->last_name}}</option>
                                    @else
                                    <option value="{{$client->id}}">{{$client->name}} {{$client->last_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="status">Select Status <span>*</span></label>
                                <select name="status" id="status" class="form-control" >
                                    <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{$data->status == 0 ? 'selected' : ''}}>Deactive</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="description">Description <span>*</span></label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5" required="required">{{old('description', $data->description)}}</textarea>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <div class="inner-wrapper mb-3">
                                    <label for="cost">Project Cost </label>
                                    <input type="text" id="cost" class="form-control" value="{{old('cost', $data->cost)}}" placeholder="Project Cost" name="cost">
                                </div>
                                <div class="inner-wrapper">
                                    <label for="category">Category <span>*</span></label>
                                    <select name="category[]" id="category" class="form-control select2" required multiple="multiple">
                                        @foreach($category as $categorys)
                                        <option value="{{ $categorys->id }}" {{ isset($data) && in_array($categorys->id, $data->project_category()->pluck('id')->toArray()) ? 'selected' : '' }}> {{$categorys->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Update Project</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
 
@endpush
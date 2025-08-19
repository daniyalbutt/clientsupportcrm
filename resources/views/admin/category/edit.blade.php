@extends('layouts.app-admin')
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Edit Category (ID: {{$data->id}})</h1>
    <ul>
        <li><a href="{{route('category.index')}}">Category</a></li>
        <li>Edit Category</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>


<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Category Form</div>
                <form class="form" action="{{route('category.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')  
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="name">Category Name <span>*</span></label>
                            <input type="text" id="name" class="form-control" placeholder="Category Name" value="{{old('name', $data->name)}}" name="name" required="required">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="status">Select Status <span>*</span></label>
                            <select name="status" id="status" class="form-control" >
                                <option value="1" {{($data->status == 1) ? 'selected' : ''}}>Active</option>
                                <option value="0" {{($data->status == 0) ? 'selected' : ''}}>Deactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Update Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
@endsection
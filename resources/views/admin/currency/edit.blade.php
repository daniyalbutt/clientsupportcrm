@extends('layouts.app-admin')
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Edit Currency (ID: {{$data->id}})</h1>
    <ul>
        <li><a href="{{route('currency.index')}}">Currency</a></li>
        <li>Edit Currency</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Currency Form</div>
                <form class="form" action="{{route('currency.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')  
                    <div class="row">
                        <div class="col-md-4 form-group mb-3">
                            <label for="name">Name <span>*</span></label>
                            <input type="text" id="name" class="form-control" placeholder="Name" value="{{old('name', $data->name)}}" name="name" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="short_name">Short Name <span>*</span></label>
                            <input type="text" id="short_name" class="form-control" placeholder="Short Name" name="short_name" required="required" value="{{ old('short_name', $data->short_name) }}">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="sign">Sign <span>*</span></label>
                            <input type="text" id="sign" class="form-control" placeholder="Sign" name="sign" required="required" value="{{ old('sign', $data->sign) }}">
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Update Currency</button>
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
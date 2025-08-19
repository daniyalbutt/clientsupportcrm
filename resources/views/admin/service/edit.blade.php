@extends('layouts.app-admin')
@section('content')

<div class="breadcrumb">
    <h1 class="mr-2">Edit Service (ID: {{$data->id}})</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Service Update</div>
                <form class="form" action="{{route('service.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')  
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">Name <span>*</span></label>
                                <input type="text" id="name" class="form-control" placeholder="Name" value="{{old('name', $data->name)}}" name="name" required="required">
                            </div>
                            <!-- <div class="col-md-4 form-group mb-3">
                                <label for="brand">Brand Name <span>*</span></label>
                                <select name="brand" id="brand" class="form-control">
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ ($brand->id == $data->brand_id ? 'selected' : '') }}>{{ $brand->name }}</option>
                                    @endforeach 
                                </select>
                            </div> -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="form">Select Form <span>*</span></label>
                                <select name="form" id="form" class="form-control">
                                    <option value="0" {{ $data->form == 0 ? 'selected' : '' }}>No Form</option>
                                    <option value="1" {{ $data->form == 1 ? 'selected' : '' }}>Logo Form</option>
                                    <option value="2" {{ $data->form == 2 ? 'selected' : '' }}>Website Form</option>
                                    <option value="3" {{ $data->form == 3 ? 'selected' : '' }}>Social Media Marketing Form</option>
                                    <option value="4" {{ $data->form == 4 ? 'selected' : '' }}>Content Writing Form</option>
                                    <option value="5" {{ $data->form == 5 ? 'selected' : '' }}>Search Engine Optimization Form</option>
                                    <option value="6" {{ $data->form == 6 ? 'selected' : '' }}>Book Formatting & Publishing Form</option>
                                    <option value="7" {{ $data->form == 7 ? 'selected' : '' }}>Book Writing Form</option>
                                    <option value="8" {{ $data->form == 8 ? 'selected' : '' }}>Author Website Form</option>
                                    <option value="9" {{ $data->form == 9 ? 'selected' : '' }}>Editing & Proofreading Form</option>
                                    <option value="10" {{ $data->form == 10 ? 'selected' : '' }}>Book Cover Design</option>
                                    <option value="11" {{ $data->form == 11 ? 'selected' : '' }}>Book Marketing</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Update Service</button>
                            </div>
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
@extends('layouts.app-admin')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Edit Client (ID: {{$data->id}})</h1>
    <ul>
        <li>Clients</li>
        <li>Edit Client</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>



<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Clien Form</div>
                <form class="form" action="{{route('admin.client.update', $data->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf   
                    @method('PATCH')  
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">First Name <span>*</span></label>
                                <input type="text" id="name" class="form-control" value="{{old('name', $data->name)}}" placeholder="First Name" name="name" required="required">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" class="form-control" value="{{old('last_name', $data->last_name)}}" placeholder="Last Name" name="last_name">
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="email">Email Address <span>*</span></label>
                                <input type="email" id="email" class="form-control" value="{{old('email', $data->email)}}" placeholder="Email Address" name="email" required="required">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="contact">Contact Number</label>
                                <input type="text" id="contact" class="form-control" value="{{old('contact', $data->contact)}}" placeholder="Contact Number" name="contact">
                                @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="brand">Brand<span>*</span></label>
                                <select name="brand_id" id="brand" class="form-control" required>
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{$brand->id == $data->brand_id ? 'selected' : ''}}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- <div class="col-md-4 form-group mb-3">
                                <label for="user">Added By<span>*</span></label>
                                <input type="text" id="user" class="form-control" value="{{ auth()->user()->name }} {{ auth()->user()->last_name }}" placeholder="User" name="user" readonly>
                            </div> -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="status">Select Status <span>*</span></label>
                                <select name="status" id="status" class="form-control" >
                                    <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{$data->status == 0 ? 'selected' : ''}}>Deactive</option>
                                </select>
                                @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Update Client</button>
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
    <script>
        $('#contact').keypress(function(event){
            if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                event.preventDefault(); //stop character from entering input
            }
        });
    </script>
@endpush
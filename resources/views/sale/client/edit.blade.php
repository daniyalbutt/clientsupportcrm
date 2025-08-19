@extends('layouts.app-sale')

@section('content')
<div class="breadcrumb">
    <h1>Edit Client (ID: {{$data->id}})</h1>
    <ul>
        <li><a href="#">Clients</a></li>
        <li>Edit Client (ID: {{$data->id}})</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Client Form</div>
                    <form class="form" action="{{route('client.update', $data->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf   
                        @method('PATCH')  
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">First Name <span>*</span></label>
                                        <input type="text" id="name" class="form-control" value="{{old('name', $data->name)}}" placeholder="First Name" name="name" required="required">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="last_name">Last Name <span>*</span></label>
                                        <input type="text" id="last_name" class="form-control" value="{{old('last_name', $data->last_name)}}" placeholder="Last Name" name="last_name" required="required">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email Address <span>*</span></label>
                                        <input type="email" id="email" class="form-control" value="{{old('email', $data->email)}}" placeholder="Email Address" required="required" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact">Contact</label>
                                        <input type="text" id="contact" class="form-control" value="{{old('contact', $data->contact)}}" placeholder="Contact Number" name="contact">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="brand">Brand<span>*</span></label>
                                    <select name="brand_id" id="brand" class="form-control" required>
                                        <option value="">Select Brand</option>
                                        @foreach(Auth::user()->brands as $brands)
                                        <option value="{{ $brands->id }}" {{ $data->brand_id == $brands->id ? 'selected' : '' }}>{{ $brands->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Select Status <span>*</span></label>
                                        <select name="status" id="status" class="form-control" >
                                            <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Active</option>
                                            <option value="0" {{$data->status == 0 ? 'selected' : ''}}>Deactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <button type="submit" class="btn btn-primary">
                            <i class="la la-check-square-o"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
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
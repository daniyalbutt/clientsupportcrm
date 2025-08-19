@extends('layouts.app-admin')

@section('content')
<div class="breadcrumb">
    <h1>Edit Production (ID: {{$data->id}})</h1>
    <ul>
        <li><a href="#">Production</a></li>
        <li>Edit Production</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Production Form</div>
                <form class="form" action="{{route('admin.user.sales.update', $data->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf   
                    <div class="row">
                        <div class="col-md-4 form-group mb-3">
                            <label for="name">First Name <span>*</span></label>
                            <input type="text" id="name" class="form-control" value="{{old('name', $data->name)}}" placeholder="First Name" name="name" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="last_name">Last Name <span>*</span></label>
                            <input type="text" id="last_name" class="form-control" value="{{old('last_name', $data->last_name)}}" placeholder="Last Name" name="last_name" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="email">Email Address <span>*</span></label>
                            <input type="email" id="email" class="form-control" value="{{old('email', $data->email)}}" placeholder="Email Address" name="email" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="is_employee">Select Role <span>*</span></label>
                            <select name="is_employee" id="is_employee" class="form-control" required>
                                <option value="1" {{ $data->is_employee == 1 ? 'selected' : '' }}>Team Lead</option>
                                <option value="5" {{ $data->is_employee == 5 ? 'selected' : '' }}>Member</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="category">Category <span>*</span></label>
                            <select name="category[]" id="category" class="form-control select2" required multiple="multiple">
                                @foreach ($category as $categorys)
                                <option value="{{ $categorys->id }}" {{ isset($data) && in_array($categorys->id, $data->category()->pluck('id')->toArray()) ? 'selected' : '' }}> {{ $categorys->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="contact">Contact Number</label>
                            <input type="text" id="contact" class="form-control" value="{{old('contact', $data->contact)}}" placeholder="Contact Number" name="contact">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="status">Select Status <span>*</span></label>
                            <select name="status" id="status" class="form-control" >
                                <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{$data->status == 0 ? 'selected' : ''}}>Deactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Update Production</button>
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
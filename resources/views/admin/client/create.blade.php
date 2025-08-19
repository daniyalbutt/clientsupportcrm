@extends('layouts.app-admin')

@section('content')

<div class="breadcrumb">
    <h1>Create Client</h1>
    <ul>
        <li><a href="#">Clients</a></li>
        <li>Create Client</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Client Form</div>
                <form class="form" action="{{route('admin.client.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf   
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">First Name <span>*</span></label>
                                <input type="text" id="name" class="form-control" value="{{old('name')}}" placeholder="First Name" name="name" required="required">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">                                
                                <label for="last_name">Last Name <span>*</span></label>
                                <input type="text" id="last_name" class="form-control" value="{{old('last_name')}}" placeholder="Last Name" name="last_name" required="required">
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="email">Email <span>*</span></label>
                                <input type="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Email" name="email" required="required">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="contact">Contact</label>
                                <input type="text" id="contact" class="form-control" value="{{old('contact')}}" placeholder="Contact" name="contact">
                                @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="brand">Brand<span>*</span></label>
                                <select name="brand_id" id="brand" class="form-control" required>
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="status">Select Status <span>*</span></label>
                                <select name="status" id="status" class="form-control" >
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Save Client</button>
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
        $(document).ready(function(){
            $('#password').val(generatePassword());
        });
        function generatePassword() {
            var length = 16,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }
            return retVal;
        }
        function copyToClipboard() {
            var copyText = document.getElementById("password");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            M.toast({
                html: 'Password Copied'
            }) 
            // alert("Copied the text: " + copyText.value);
        }
        $('#contact').keypress(function(event){
            if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                event.preventDefault(); //stop character from entering input
            }
        });
    </script>
@endpush
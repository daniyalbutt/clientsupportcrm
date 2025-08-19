@extends('layouts.app-admin')
@section('content')
<div class="breadcrumb">
    <h1>Create Sale Agent</h1>
    <ul>
        <li><a href="#">Sale Agent</a></li>
        <li>Create Sale Agent</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Sales / Support Agent Form</div>
                <form class="form" action="{{route('admin.user.sales.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="name">First Name <span>*</span></label>
                            <input type="text" id="name" class="form-control" value="{{old('name')}}" placeholder="First Name" name="name" required="required">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="last_name">Last Name <span>*</span></label>
                            <input type="text" id="last_name" class="form-control" value="{{old('last_name')}}" placeholder="Last Name" name="last_name" required="required">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="email">Email Address <span>*</span></label>
                            <input type="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Email Address" name="email" required="required">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="brand">Brand Name <span>*</span></label>
                            <select name="brand[]" id="brand" class="form-control select2" required multiple="multiple">
                                @foreach($brand as $brands)
                                <option value="{{$brands->id}}">{{$brands->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="contact">Contact Number</label>
                            <input type="text" id="contact" class="form-control" value="{{old('contact')}}" placeholder="Contact Number" name="contact">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="status">Select Status <span>*</span></label>
                            <select name="status" id="status" class="form-control" >
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="password">Password <span>*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Button on right" id="password" name="password" required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="copyToClipboard()">Copy</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="role">Role <span>*</span></label>
                            <select name="is_employee" id="role" class="form-control">
                                <option value="4">Customer Support</option>
                                <option value="0">Sale Agent</option>
                                <option value="6">Sales Manager</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Save Agent</button>
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
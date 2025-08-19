@extends('layouts.app-admin')
   
@section('content')
<div class="breadcrumb row">
    <div class="col-md-8">
        <h1>Agent List</h1>
        <ul>
            <li><a href="#">Agent</a></li>
            <li>Agent List</li>
        </ul>
    </div>
    <div class="col-md-4 text-right">
        <a href="{{ route('admin.user.sales.create') }}" class="btn btn-primary">Create Agent</a>
    </div>
</div>
<div class="separator-breadcrumb border-top"></div>


<div class="row">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Agent Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Brand</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Reset Password</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user as $users)
                            <tr>
                                <td>{{$users->id}}</td>
                                <td>{{$users->name}} {{$users->last_name}}</td>
                                <td><span class="btn btn-primary btn-sm">{{ $users->get_role() }}</span></td>
                                <td>
                                    @if($users->brands != null)
                                    @foreach($users->brands as $brands)
                                    <button class="btn btn-info btn-sm">{{$brands->name}}</button>
                                    @endforeach
                                    @endif
                                </td>
                                <td>{{$users->email}}</td>
                                <td>
                                    @if($users->status == 1)
                                        <button class="btn btn-success btn-sm">Active</button>
                                    @else
                                        <button class="btn btn-danger btn-sm">Deactive</button>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm update-password" onclick="updatePassword({{$users->id}})" data-id="{{$users->id}}">Reset Password</button>
                                </td>
                                <td>
                                    <a href="{{route('admin.user.sales.edit', $users->id)}}" class="btn btn-primary btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                        <span class="ul-btn__text">Edit</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Brand</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Reset Password</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
 aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('update.user.update.password') }}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="" id="user_id">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Update Status?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="password">Password <span>*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Button on right" id="password" name="password" required readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="copyToClipboard()">Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        function updatePassword(id){
            $('#user_id').val(id);
            $('#default').modal('toggle');
            $('#password').val(generatePassword());
        }
        $(document).ready(function(){
            $('.update-password').click(function(){
                var id = $(this).data('id');
                $('#user_id').val(id);
                $('#default').modal('toggle');
                $('#password').val(generatePassword());
            });
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
    </script>
    
@endpush
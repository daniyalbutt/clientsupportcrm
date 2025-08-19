@extends('layouts.app-admin')
   
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">
            @if($status == 1)
            Active
            @else
            Deactive
            @endif
            Seller
        </h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Seller
                    </li>
                    <li class="breadcrumb-item">
                        @if($status == 1)
                        Active
                        @else
                        Deactive
                        @endif
                         Seller
                    </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
            <button class="btn btn-info dropdown-toggle mb-1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
            <div class="dropdown-menu arrow">
                <a class="dropdown-item" href="#"><i class="fa fa-calendar-check mr-1"></i> Calender</a><a class="dropdown-item" href="#"><i class="fa fa-cart-plus mr-1"></i> Cart</a><a class="dropdown-item" href="#"><i class="fa fa-life-ring mr-1"></i> Support</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"><i class="fa fa-cog mr-1"></i> Settings</a>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Zero configuration table -->
    @if (\Session::has('success'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        </div>
    </div>
    @endif
    <section id="configuration">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Active Seller List</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Status</th>
                                            <th>Residential Address</th>
                                            <th>Work Address</th>
                                            <th>City</th>
                                            <th>Active</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user as $users)
                                        <tr>
                                            <td>{{$users->id}}</td>
                                            <td>{{$users->name}}</td>
                                            <td>{{$users->last_name}}</td>
                                            <td>{{$users->email}}</td>
                                            <td>{{$users->contact}}</td>
                                            <td>
                                                @if($users->status == 1)
                                                    <span class="badge badge-success badge-md">Active</span>
                                                    <button class="btn btn-info btn-sm mt-1 active-account" data-id="{{$users->id}}" data-status="0">Deactive Account?</button>
                                                @else
                                                    <span class="badge badge-danger badge-md">Deactive</span>
                                                    <button class="btn btn-info btn-sm mt-1 active-account" data-id="{{$users->id}}" data-status="1">Active Account?</button>
                                                @endif
                                            </td>
                                            <td>{{$users->res_add}}</td>
                                            <td>{{$users->work_add}}</td>
                                            <td>{{$users->city}}</td>
                                            <td>
                                                <a class="btn btn-icon btn-info mr-1 mb-1 color-white btn-sm" href="#"><i class="la la-info"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Status</th>
                                            <th>Residential Address</th>
                                            <th>Work Address</th>
                                            <th>City</th>
                                            <th>Active</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
 aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('update.user.status') }}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="" id="user_id">
                <input type="hidden" name="status" value="" id="status">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Update Status?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Are you sure you wanted to Update this account?</h5>
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
        $(document).ready(function(){
            $('.active-account').click(function(){
                var id = $(this).data('id');
                var status = $(this).data('status');
                $('#user_id').val(id);
                $('#status').val(status);
                $('#default').modal('toggle');
            });
        });
    </script>
    
@endpush
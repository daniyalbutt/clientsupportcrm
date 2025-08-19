@extends('layouts.app-sale')
@section('content')
<div class="breadcrumb">
    <h1>Edit Profile</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Profile Details</div>
                <form class="form" action="{{route('sale.update.profile', Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-body">
                        <div class="media mb-2">
                            <a class="mr-2" href="#">
                                @if(Auth::user()->image != '')
                                <img src="{{ asset(Auth::user()->image) }}" alt="users avatar" class="users-avatar-shadow rounded-circle" height="80" width="80">
                                @else
                                <img src="{{ asset('global/img/user.png') }}" alt="users avatar" class="users-avatar-shadow rounded-circle" height="80" width="80">
                                @endif
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Profile Image</h4>
                                <div class="col-12 px-0 d-flex">
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">First Name <span>*</span></label>
                                    <input type="text" id="name" class="form-control" placeholder="First Name" name="name" required="required" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="last_name">Last Name <span>*</span></label>
                                    <input type="text" id="last_name" class="form-control" placeholder="Last Name" name="last_name" required="required" value="{{ Auth::user()->last_name }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Email <span>*</span></label>
                                    <input type="email" id="email" class="form-control" placeholder="Email" name="email" required="required" value="{{ Auth::user()->email }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <input type="text" id="contact" class="form-control" placeholder="Contact" name="contact" value="{{ Auth::user()->contact }}">
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
@endsection
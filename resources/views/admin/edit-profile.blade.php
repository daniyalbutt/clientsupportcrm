@extends('layouts.app-admin')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Edit Profile</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Profile Details</h4>
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
                        <div class="card-body">
                            <form class="form" action="{{route('admin.update.profile', Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">First Name <span>*</span></label>
                                                <input type="text" id="name" class="form-control" placeholder="First Name" name="name" required="required" value="{{ Auth::user()->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name <span>*</span></label>
                                                <input type="text" id="last_name" class="form-control" placeholder="Last Name" name="last_name" required="required" value="{{ Auth::user()->last_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email <span>*</span></label>
                                                <input type="email" id="email" class="form-control" placeholder="Email" name="email" required="required" value="{{ Auth::user()->email }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact">Contact <span>*</span></label>
                                                <input type="text" id="contact" class="form-control" placeholder="Contact" name="contact" required="required" value="{{ Auth::user()->contact }}">
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
            <div class="col-md-4">
               <div class="card">
                  <div class="card-header">
                     <h4 class="card-title" id="basic-layout-colored-form-control">Information</h4>
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
                     <div class="card-body pt-0">
                        @if($errors->any())
                        <div class="alert alert-danger">
                           <ul>
                              @foreach($errors->all() as $error)
                              <li>{{ $error }}</li>
                              @endforeach
                           </ul>
                        </div>
                        @endif
                        @if (\Session::has('error'))
                        <div class="alert alert-danger">
                           <ul>
                              <li>{!! \Session::get('error') !!}</li>
                           </ul>
                        </div>
                        @endif
                        @if (\Session::has('success'))
                        <div class="alert alert-success">
                           <ul>
                              <li>{!! \Session::get('success') !!}</li>
                           </ul>
                        </div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
        </div>
    </section>
</div>
@endsection
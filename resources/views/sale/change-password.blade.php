@extends('layouts.app-sale')
@section('content')
<div class="breadcrumb">
    <h1>Change Password</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Password Details</div>
                <form class="form" action="{{route('sale.update.password')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="current_password">Current Password <span>*</span></label>
                                    <input type="password" id="current_password" class="form-control" placeholder="Current Password" name="current_password" required="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="new_password">New Password <span>*</span></label>
                                    <input type="password" id="new_password" class="form-control" placeholder="New Password" name="new_password" required="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="new_confirm_password">New Confirm Password <span>*</span></label>
                                    <input type="password" id="new_confirm_password" class="form-control" placeholder="New Confirm Password" name="new_confirm_password" required="required">
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
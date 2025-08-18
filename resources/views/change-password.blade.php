@extends('layouts.front-app')
@section('content')

<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Change Password</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <a class="btn btn-primary" href="{{ route('clients.index') }}">Client List</a>
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-lg-12 col-12">
		    @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
		    <div class="box">
		        <div class="box-header with-border">
		            <h4 class="box-title">Change Password Form</h4>
		        </div>
		        <!-- /.box-header -->
		        <form class="form" method="post" action="{{ route('change.password') }}">
		        	@csrf
		            <div class="box-body">
		                <div class="row">
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label class="form-label">New Password</label>
		                            <input type="password" class="form-control" name="new_password" required>
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label class="form-label">New Confirm Password</label>
		                            <input type="password" class="form-control" name="new_confirm_password" required>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <!-- /.box-body -->
		            <div class="box-footer">
		                <button type="button" class="btn btn-warning me-1">
		                <i class="ti-trash"></i> Cancel
		                </button>
		                <button type="submit" class="btn btn-primary">
		                <i class="ti-save-alt"></i> Save
		                </button>
		            </div>
		        </form>
		    </div>
		    <!-- /.box -->			
		</div>
	</div>
</section>
@endsection

@push('scripts')
@endpush
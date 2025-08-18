@extends('layouts.front-app')
@section('content')

<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Edit Merchant - {{ $data->name }}</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item" aria-current="page">Merchants</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Merchant - {{ $data->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
			@can('view merchant')
            <a class="btn btn-primary" href="{{ route('merchant.index') }}">Merchant List</a>
			@endcan
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-lg-12 col-12">
		    <div class="box">
		        <div class="box-header with-border">
		            <h4 class="box-title">Merchant Form</h4>
		        </div>
		        <!-- /.box-header -->
		        <form class="form" method="post" action="{{ route('merchant.update', $data->id) }}" enctype="multipart/form-data">
		        	@csrf
					@method('PUT')
		            <div class="box-body">
						@if($errors->any())
							{!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
						@endif
						@if(session()->has('success'))
							<div class="alert alert-success">
								{{ session()->get('success') }}
							</div>
						@endif
		                <div class="row">
		                    <div class="col-md-3">
		                        <div class="form-group">
		                            <label class="form-label">Name</label>
		                            <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
		                        </div>
		                    </div>
							<div class="col-md-3">
		                        <div class="form-group">
		                            <label class="form-label">Merchant</label>
									<select name="merchant" id="merchant" class="form-control" required>
										<option value="">Select Merchant</option>
										<option value="0" {{ $data->merchant == 0 ? 'selected' : '' }}>Stripe</option>
									</select>
		                        </div>
		                    </div>
							<div class="col-md-3">
		                        <div class="form-group">
		                            <label class="form-label">Sandbox</label>
									<select name="sandbox" id="sandbox" class="form-control">
										<option value="0" {{ $data->sandbox == 0 ? 'selected' : '' }}>Production</option>
										<option value="1" {{ $data->sandbox == 1 ? 'selected' : '' }}>Sandbox</option>
									</select>
		                        </div>
		                    </div>
		                    <div class="col-md-3">
		                        <div class="form-group">
		                            <label class="form-label">Status</label>
									<select name="status" id="status" class="form-control">
										<option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Active</option>
										<option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Deactive</option>
									</select>
		                        </div>
		                    </div>
							<div class="col-md-12">
		                        <div class="form-group">
		                            <label class="form-label">Publishable key</label>
		                            <input type="text" class="form-control" name="public_key" value="{{ $data->public_key }}" required>
		                        </div>
		                    </div>
							<div class="col-md-12">
		                        <div class="form-group">
		                            <label class="form-label">Secret key</label>
		                            <input type="text" class="form-control" name="private_key" value="{{ $data->private_key }}" required>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <!-- /.box-body -->
		            <div class="box-footer">
		                <button type="submit" class="btn btn-primary">Update Merchant</button>
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
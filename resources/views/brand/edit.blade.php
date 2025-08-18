@extends('layouts.front-app')
@section('content')

<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Edit Brand - {{ $data->name }}</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item" aria-current="page">Brands</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Brand - {{ $data->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <a class="btn btn-primary" href="{{ route('brand.index') }}">Brand List</a>
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-lg-12 col-12">
		    <div class="box">
		        <div class="box-header with-border">
		            <h4 class="box-title">Brand Form</h4>
		        </div>
		        <!-- /.box-header -->
		        <form class="form" method="post" action="{{ route('brand.update', $data->id) }}" enctype="multipart/form-data">
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
								<div class="d-flex align-items-center">
									<img src="{{ asset($data->image) }}" alt="{{ $data->name }}" width="60" class="me-3">
									<div class="form-group">
										<label class="form-label">Logo</label>
										<input type="file" class="form-control" name="image">
									</div>
								</div>
		                    </div>
		                    <div class="col-md-2">
		                        <div class="form-group">
		                            <label class="form-label">Name</label>
		                            <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
		                        </div>
		                    </div>
		                    <div class="col-md-3">
		                        <div class="form-group">
		                            <label class="form-label">Url</label>
		                            <input type="text" class="form-control" name="url" value="{{ $data->url }}" required>
		                        </div>
		                    </div>
							<div class="col-md-2">
		                        <div class="form-group">
		                            <label class="form-label">Currency</label>
									<select name="currency_id" id="currency_id" class="form-control" required>
										<option value="">Select Currency</option>
										@foreach($currency as $key => $value)
										<option value="{{ $value->id }}" {{ $data->currency_id == $value->id ? 'selected' : '' }}>{{ $value->sign }} - {{ $value->name }}</option>
										@endforeach
									</select>
		                        </div>
		                    </div>
		                    <div class="col-md-2">
		                        <div class="form-group">
		                            <label class="form-label">Status</label>
									<select name="status" id="status" class="form-control">
										<option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Active</option>
										<option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Deactive</option>
									</select>
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
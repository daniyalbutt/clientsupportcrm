@extends('layouts.front-app')
@section('content')

<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Edit Currency - {{ $data->name }}</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item" aria-current="page">Currency</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Currency - {{ $data->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
			@can('view currency')
            <a class="btn btn-primary" href="{{ route('currency.index') }}">Currency List</a>
			@endcan
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-lg-12 col-12">
		    <div class="box">
		        <div class="box-header with-border">
		            <h4 class="box-title">Currency Form</h4>
		        </div>
		        <!-- /.box-header -->
		        <form class="form" method="post" action="{{ route('currency.update', $data->id) }}" enctype="multipart/form-data">
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
		                    <div class="col-md-4">
		                        <div class="form-group">
		                            <label class="form-label">Sign</label>
		                            <input type="text" class="form-control" name="sign" value="{{ $data->sign }}" required>
		                        </div>
		                    </div>
							<div class="col-md-4">
		                        <div class="form-group">
		                            <label class="form-label">Name</label>
		                            <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
		                        </div>
		                    </div>
		                    <div class="col-md-4">
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
		                <button type="submit" class="btn btn-primary">Update Currency</button>
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
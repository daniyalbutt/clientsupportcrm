@extends('layouts.front-app')
@section('content')

<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Edit Role - {{ $data->name }}</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item" aria-current="page">Roles</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Role - {{ $data->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
			@can('role')
            <a class="btn btn-primary" href="{{ route('roles.index') }}">Role List</a>
			@endcan
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-lg-12 col-12">
		    <div class="box">
		        <div class="box-header with-border">
		            <h4 class="box-title">Role Form</h4>
		        </div>
		        <!-- /.box-header -->
		        <form class="form" method="post" action="{{ route('roles.update', $data->id) }}">
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
		                            <input type="text" class="form-control" name="name" value="{{ old('name', $data->name) }}" required>
		                        </div>
		                    </div>
		                </div>
						<div class="row">
							<div class="col-md-12">
								<ul class="role-wrapper">
								@foreach($permission as $key => $value)
									<li>
										<input name="permission[]" value="{{ $value->name }}" type="checkbox" id="basic_checkbox_{{$key}}" {{ in_array($value->name, $rolePermissions) ? 'checked' : '' }} />
										<label for="basic_checkbox_{{$key}}">{{ $value->name }}</label>
									</li>
								@endforeach
								</ul>
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
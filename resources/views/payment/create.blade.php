@extends('layouts.front-app')
@section('content')

<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Create Invoice</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item" aria-current="page">Invoices</li>
                            <li class="breadcrumb-item active" aria-current="page">Create Invoice</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <a class="btn btn-primary" href="{{ route('clients.index') }}">Invoice Details</a>
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-lg-12 col-12">
		    <div class="box">
		        <div class="box-header with-border">
		            <h4 class="box-title">Invoice Form</h4>
		        </div>
		        <!-- /.box-header -->
		        <form class="form" method="post" action="{{ route('payment.store') }}">
		        	@csrf
		            <div class="box-body">
						@if($errors->any())
							{!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
						@endif
		                <div class="row">
		                    <div class="col-md-4">
		                        <div class="form-group">
		                            <label class="form-label">Name</label>
		                            <input type="text" class="form-control" name="name" required value="{{ $data != null ? $data->name : '' }}">
		                        </div>
		                    </div>
		                    <div class="col-md-4">
		                        <div class="form-group">
		                            <label class="form-label">E-mail</label>
		                            <input type="email" class="form-control" name="email" required value="{{ $data != null ? $data->email : '' }}">
		                        </div>
		                    </div>
		                    <div class="col-md-4">
		                        <div class="form-group">
		                            <label class="form-label">Contact Number</label>
		                            <input type="text" class="form-control" name="phone" required value="{{ $data != null ? $data->phone : '' }}">
		                        </div>
		                    </div>
		                    <div class="col-md-2">
		                        <div class="form-group">
		                            <label class="form-label">Brand Name</label>
									<select name="brand_name" id="brand_name" class="form-control" required>
										<option value="">Select Brand</option>
										@foreach($brand as $key => $value)
										<option value="{{ $value->id }}" data-currency="{{ $value->currency_id }}">{{ $value->name }}</option>
										@endforeach
									</select>
		                        </div>
		                    </div>
							<div class="col-md-3">
		                        <div class="form-group">
		                            <label class="form-label">Package</label>
		                            <input type="text" class="form-control" name="package" required value="{{ old('package') }}">
		                        </div>
		                    </div>
							<div class="col-md-2">
								<div class="form-group">
		                            <label class="form-label">Currency</label>
									<select name="currency" id="currency" class="form-control">
										<option value="">Select Currency</option>
										@foreach($currency as $key => $value)
										<option value="{{ $value->id }}">{{ $value->sign }} - {{ $value->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-2">
		                        <div class="form-group">
		                            <label class="form-label">Amount</label>
									<input step="any" type="number" class="form-control" required="" name="price" value="{{ old('price') }}">
		                        </div>
		                    </div>
		                    <div class="col-md-3">
		                        <div class="form-group">
		                            <label class="form-label">Merchant</label>
		                            <select name="merchant" class="form-control" id="merchant" required>
										<option value="">Select Merchant</option>
										@foreach($merchant as $key => $value)
										<option value="{{ $value->id }}">{{ $value->name }}</option>
										@endforeach
		                            </select>
		                        </div>
		                    </div>
							<div class="col-md-12">
								<div class="form-group">
		                            <label class="form-label">Discription</label>
									<textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
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
<script>
	$('#brand_name').change(function(){
		const selectedOption = $(this).find('option:selected').data('currency');
		$('#currency').val(selectedOption);
	})
</script>
@endpush
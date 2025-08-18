@extends('layouts.front-app')
@section('content')

<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Payment</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item" aria-current="page">Payment</li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $data->client->name }} - {{ $data->client->email }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            {{-- <a class="btn btn-primary" href="{{ route('payment.index') }}">Payment List</a> --}}
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-lg-12 col-12">
		    <div class="box">
		        <div class="box-header with-border">
		            <h4 class="box-title">Payment Information</h4>
		        </div>
		        <!-- /.box-header -->
		        <div class="form" method="post">
		            <div class="box-body">
		                <div class="row">
		                    <div class="col-md-4">
		                        <div class="form-group">
		                            <label class="form-label">Name</label>
		                            <input type="text" class="form-control" name="name" required value="{{ $data->client->name }}">
		                        </div>
		                    </div>
		                    <div class="col-md-4">
		                        <div class="form-group">
		                            <label class="form-label">E-mail</label>
		                            <input type="email" class="form-control" name="email" required value="{{ $data->client->email }}">
		                        </div>
		                    </div>
		                    <div class="col-md-4">
		                        <div class="form-group">
		                            <label class="form-label">Contact Number</label>
		                            <input type="text" class="form-control" name="phone" required value="{{ $data->client->phone }}">
		                        </div>
		                    </div>
		                    <div class="col-md-4">
		                        <div class="form-group">
		                            <label class="form-label">Brand Name</label>
		                            <input type="text" class="form-control" name="brand_name" required value="{{ $data->client->brand != null ? $data->client->brand->name : $data->client->brand_name }}">
		                        </div>
		                    </div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="form-label">Package Name</label>
									<input type="text" class="form-control" name="package" required value="{{ $data->package }}">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="form-label">Amount ({{ $data->currency != null ? $data->currency->sign . ' - ' . $data->currency->name : '$ - USD' }})</label>
									<input type="number" class="form-control" name="l_name" required step="any" value="{{ $data->price }}">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
		                            <label class="form-label">Discription</label>
									<textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $data->description }}</textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group mt-4">
									<a href="{{ route('pay', [$data->unique_id]) }}" target="_blank" class="alert alert-info">{{ route('pay', [$data->unique_id]) }}</a>
								</div>
							</div>
		                </div>
		            </div>
					@can('auto charge')
					<div class="box-body">
						@php
							$class_array = ['btn-primary', 'btn-secondary', 'btn-danger', 'btn-warning'];
						@endphp
						@if(count($payment_array) != 0)
						<ul class="stripe_payment_method">
							@foreach($payment_array as $key => $value)
							<li class="btn btn-primary {{ $class_array[$key % count($class_array)] }}">
								<form action="{{ route('sale.front') }}" method="post" class="sale-form">
									@csrf
									<input type="hidden" name="payment_id" value="{{ $data->id }}">
									<input type="hidden" name="payment_method" value="{{ $value['id'] }}">
									<button type="submit" class="btn btn-primary {{ $class_array[$key % count($class_array)] }}">
										<h2>{{ $value['cardholderName'] }}</h2>
										<h4>{{ $value['last4'] }} - {{ $value['brand'] }}</h4>
										<p>{{ $value['month'] }} - {{ $value['year'] }}</p>
									</button>
								</form>
							</li>
							@endforeach
						</ul>
						@endif
					</div>
					@endcan
		        </div>
		    </div>
		    <!-- /.box -->			
		</div>
	</div>
</section>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<h5 class="modal-title" id="confirmModalLabel">Are you sure?</h5>
				<p>Do you want to proceed with this payment?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmSubmit">Yes, Submit</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
	let currentForm = null;
	$('.sale-form').submit(function(e){
    	e.preventDefault();
    	currentForm = this; // Save reference to the form being submitted
   		$('#confirmModal').modal('show');
  	});

  	$('#confirmSubmit').click(function() {
    	if (currentForm) {
      		currentForm.submit(); // Submit the original form after confirmation
    	}
   		$('#confirmModal').modal('hide');
  	});
</script>
@endpush
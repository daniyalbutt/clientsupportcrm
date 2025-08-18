@extends('layouts.front-app')
@section('content')
<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Logo Brief Form</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item" aria-current="page">{{ $data->name }}</li>
                            <li class="breadcrumb-item" aria-current="page">Logo Brief Form</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <a href="{{ route('clients.index') }}" class="btn btn-primary">All Clients</a>
        </div>
    </div>
</div>
@foreach($data->logo_brief as $key => $value)
<section class="content">
	<div class="row">
		<div class="col-lg-12 col-12">
		    <div class="box">
		        <div class="box-header with-border">
		            <h4 class="box-title">Logo Brief Form #{{$value->id}}</h4>
		        </div>
		        <div class="box-body">
		            <table class="table table-striped">
		                <tr>
		                    <th>Logo Info</th>
		                    <td>{{ $value->logo_info }}</td>
		                </tr>
		                <tr>
		                    <th>Selected Logo</th>
		                    <td>{{ $value->selected_logo }}</td>
		                </tr>
		                <tr>
		                    <th>Brief Text</th>
		                    <td>{{ $value->brief_text }}</td>
		                </tr>
		                <tr>
		                    <th>Brief Tagline</th>
		                    <td>{{ $value->brief_tagline }}</td>
		                </tr>
		                <tr>
		                    <th>Brief Description</th>
		                    <td>{{ $value->brief_description }}</td>
		                </tr>
		                <tr>
		                    <th>Design Concept</th>
		                    <td>{{ $value->design_concept }}</td>
		                </tr>
		                <tr>
		                    <th>Existing Website</th>
		                    <td>{{ $value->existing_website }}</td>
		                </tr>
		                <tr>
		                    <th>Client Email</th>
		                    <td>{{ $value->client_email }}</td>
		                </tr>
		            </table>
    	        </div>
	        </div>
        </div>
    </div>
</section>
@endforeach
@endsection
@push('scripts')
<script>
    function withJquery(link){
	    var temp = $("<input>");
        $("body").append(temp);
        temp.val(link).select();
        document.execCommand("copy");
        temp.remove();
        console.timeEnd('time1');
    }
</script>
@endpush
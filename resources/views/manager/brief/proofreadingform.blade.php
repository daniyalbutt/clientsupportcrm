@extends('layouts.app-manager')
@section('title', 'Editing & Proofreading Form')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Editing & Proofreading INV#{{$data->invoice->invoice_number}}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form web-brief-form" method="post" route="{{ route('client.web.form.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Details</div>
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="client_name">Client Name</label>
                        <input class="form-control" name="client_name" id="client_name" type="text" placeholder="{{ $data->user->name }} {{ $data->user->last_name }}" value="{{ $data->user->name }} {{ $data->user->last_name }}" required readonly/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="agent_name">Agent Name</label>
                        <input class="form-control" name="agent_name" id="agent_name" type="text" placeholder="{{ $data->invoice->sale->name }} {{ $data->invoice->sale->last_name }}" value="{{ $data->invoice->sale->name }} {{ $data->invoice->sale->last_name }}" readonly required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="brand_name">Brand Name</label>
                        <input class="form-control" name="brand_name" id="brand_name" type="text" placeholder="{{ $data->invoice->brands->name }}" value="{{ $data->invoice->brands->name }}" readonly required/>
                    </div>
                </div>
            </div>
        </div>
        @include('form.proofreadingform')
    </form>
</div>
@endsection

@push('scripts')
@endpush
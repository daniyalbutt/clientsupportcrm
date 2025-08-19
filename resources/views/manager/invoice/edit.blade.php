@extends('layouts.app-manager')

@section('content')
<div class="breadcrumb">
    <h1>Edit Invoice - {{$invoice->client->name}} {{$invoice->client->last_name}} ({{$invoice->id}})</h1>
    <ul>
        <li><a href="#">Invoice</a></li>
        <li>Payment Link for {{$invoice->client->name}} {{$invoice->client->last_name}}</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Payment Details Form</div>
                <form class="form" action="{{route('manager.invoice.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                    <input type="hidden" name="client_id" value="{{$invoice->client->id}}">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">First Name <span>*</span></label>
                                <input type="text" id="name" class="form-control" value="{{ $invoice->client->name }} {{ $invoice->client->last_name }}" placeholder="Name" name="name" required="required">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="email">Email <span>*</span></label>
                                <input type="email" id="email" class="form-control" value="{{ $invoice->client->email }}" placeholder="Email" name="email" required="required">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="contact">Contact</label>
                                <input type="text" id="contact" class="form-control" value="{{ $invoice->client->contact }}" placeholder="Contact" name="contact">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="brand">Brand Name <span>*</span></label>
                                <select name="brand" id="brand" class="form-control select2" required>
                                    <option value="">Select Brand</option>
                                    @foreach($brand as $brands)
                                    <option value="{{ $brands->id }}" {{ $invoice->brand == $brands->id ? 'selected' : '' }}>{{ $brands->name }} - {{ $brands->url }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                            $get_service = explode(',', $invoice->service);
                            @endphp
                            <div class="col-md-4 form-group mb-3">
                                <label for="service">Service <span>*</span></label>
                                <select name="service[]" id="service" class="form-control select2" required multiple>
                                    @foreach($services as $service)
                                    <option {{ in_array($service->id, $get_service) ? 'selected' : ' ' }} value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="package">Package <span>*</span></label>
                                <select name="package" id="package" class="form-control" required>
                                    <option value="">Select Package</option>
                                    <option value="0" {{ $invoice->package == 0 ? 'selected': '' }}>Custom Package</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="custom_package">Name for a Custom Package</label>
                                <input type="text" id="custom_package" class="form-control" value="{{ $invoice->custom_package }}" placeholder="Custom Package Name" name="custom_package">
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label for="currency">Currency<span>*</span></label>
                                <select name="currency" id="currency" class="form-control select2" required>
                                    <option value="">Select Currency</option>
                                    @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}" {{ $currency->id == $invoice->currency ? 'selected' : '' }}>{{$currency->name}} - {{$currency->short_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label for="amount">Amount<span>*</span></label>
                                <input step=".01" type="number" id="amount" class="form-control" value="{{ $invoice->amount }}" placeholder="Amount" name="amount" required min="1">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="payment_type">Payment Type<span>*</span></label>
                                <select class="form-control" name="payment_type" id="payment_type">
                                    <option value="0" {{ $invoice->payment_type == 0 ? 'selected' : '' }}>One-Time Charge</option>
                                    <option value="1" {{ $invoice->payment_type == 1 ? 'selected' : '' }}>Three-Time Charge</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="merchant">Merchant<span>*</span></label>
                                <select name="merchant" id="merchant" class="form-control" required>
                                    @foreach($merchant as $merchants)
                                    <option value="{{ $merchants->id }}" {{ $merchants->id == $invoice->merchant_id ? 'selected' : '' }}>{{ $merchants->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="discription">Description</label>
                                <textarea name="discription" id="" cols="30" rows="6" class="form-control">{{ $invoice->discription }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update Invoice</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
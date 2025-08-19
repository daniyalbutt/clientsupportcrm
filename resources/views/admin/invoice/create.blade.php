@extends('layouts.app-admin')

@section('content')

<div class="breadcrumb">
    <h1>{{$user->name}} {{$user->last_name}} (ID: {{$user->id}})</h1>
    <ul>
        <li><a href="#">Leads</a></li>
        <li>Create Payment Link</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Payment Details</div>
                <form class="form" action="{{route('admin.invoice.create')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="client_id" value="{{$user->id}}">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">First Name <span>*</span></label>
                                <input type="text" id="name" class="form-control" value="{{ $user->name }} {{ $user->last_name }}" placeholder="Name" name="name" required="required">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="email">Email <span>*</span></label>
                                <input type="email" id="email" class="form-control" value="{{ $user->email }}" placeholder="Email" name="email" required="required">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="contact">Contact</label>
                                <input type="text" id="contact" class="form-control" value="{{ $user->contact }}" placeholder="Contact" name="contact">
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="brand">Brand Name <span>*</span></label>
                                <select name="brand" id="brand" class="form-control select2" required>
                                    <option value="">Select Brand</option>
                                    @foreach($brand as $brands)
                                    <option value="{{ $brands->id }}" {{ $brands->id == $user->brand_id ? 'selected' : '' }}>{{ $brands->name }} - {{ $brands->url }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="service">Service <span>*</span></label>
                                <select name="service[]" id="service" class="form-control select2" required multiple>
                                    @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{$service->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="package">Package <span>*</span></label>
                                <select name="package" id="package" class="form-control" required>
                                    <option value="">Select Package</option>
                                    <option value="0" selected>Custom Package</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label for="createform">Create form of Service <span>*</span></label>
                                <select name="createform" id="createform" class="form-control" required="">
                                    <option value="">Select Option</option>
                                    <option value="1">YES</option>
                                    <option value="0">NO</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="custom_package">Name for a Custom Package</label>
                                <input type="text" id="custom_package" class="form-control" value="" placeholder="Custom Package Name" name="custom_package">
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label for="currency">Currency<span>*</span></label>
                                <select name="currency" id="currency" class="form-control select2" required>
                                    <option value="">Select Currency</option>
                                    @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}" {{ $currency->short_name == 'USD' ? 'selected' : '' }}>{{$currency->name}} - {{$currency->short_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label for="amount">Amount<span>*</span></label>
                                <input step=".01" type="number" id="amount" class="form-control" value="" placeholder="Amount" name="amount" required min="1">
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label for="payment_type">Payment Type<span>*</span></label>
                                <select class="form-control" name="payment_type" id="payment_type">
                                    <option value="0">One-Time Charge</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="merchant">Merchant<span>*</span></label>
                                <select name="merchant" id="merchant" class="form-control" required>
                                    @foreach($brand[0]->merchants as $key => $merchants)
                                    <option value="{{ $merchants->id }}" {{ $key == 0 ? 'selected' : '' }}>{{ $merchants->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="discription">Description</label>
                                <textarea name="discription" id="" cols="30" rows="6" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Create Invoice</button>
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
<script>
    // $( "#brand" ).change(function() {
    //     if($(this).val() != ''){
    //         $.getJSON("/admin/service-list/"+ $(this).val(), function(jsonData){
    //             console.log(jsonData);
    //             select = '';
    //             $.each(jsonData, function(i,data)
    //             {
    //                 select +='<option value="'+data.name+'">'+data.name+'</option>';
    //             });
    //             $("#service").html(select);
    //         });
    //     }else{
    //         $("#service").html('');
    //     }
    // });
</script>
@endpush
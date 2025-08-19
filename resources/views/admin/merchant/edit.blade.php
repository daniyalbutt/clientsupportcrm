@extends('layouts.app-admin')
@section('content')
<div class="breadcrumb row">
    <div class="col-md-6">
        <h1 class="mr-2">Edit Merchant (ID: {{$data->id}})</h1>
        <ul>
            <li><a href="{{route('admin.merchant.index')}}">Merchant</a></li>
            <li>Edit Merchant</li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('admin.merchant.index') }}" class="btn btn-primary">Back to Merchants</a>
    </div>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Merchant Form</div>
                <form class="form" action="{{route('admin.merchant.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')  
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="name">Name <span>*</span></label>
                                <input type="text" id="name" class="form-control" value="{{old('name', $data->name)}}" placeholder="Name" name="name" required="required">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">                                
                                <label for="public_key">Public Key <span>*</span></label>
                                <input type="text" id="public_key" class="form-control" value="{{old('public_key', $data->public_key)}}" placeholder="Public Key" name="public_key" required="required">
                                @error('public_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="secret_key">Secret Key <span>*</span></label>
                                <input type="text" id="secret_key" class="form-control" value="{{old('secret_key', $data->secret_key)}}" placeholder="Secret Key" name="secret_key" required="required">
                                @error('secret_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="secret_key">Converge PIN <span>(If Converge Pay Payment)</span></label>
                                <input type="text" id="login_id" class="form-control" value="{{old('login_id', $data->login_id)}}" placeholder="Secret Key" name="login_id">
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="is_authorized">Select Merchant Type <span>*</span></label>
                                <select name="is_authorized" id="is_authorized" class="form-control" >
                                    <option value="">Select Merchant Type</option>
                                    <option value="1" {{ $data->is_authorized == 1 ? 'selected' : ' ' }}>Stripe</option>
                                    <option value="2" {{ $data->is_authorized == 2 ? 'selected' : ' ' }}>Authorize.net</option>
                                    <option value="3" {{ $data->is_authorized == 3 ? 'selected' : ' ' }}>Converge Pay</option>
                                    <option value="4" {{ $data->is_authorized == 4 ? 'selected' : ' ' }}>Thrifty Payments Inc.</option>
                                    <option value="5" {{ $data->is_authorized == 5 ? 'selected' : ' ' }}>Nexio</option>
                                    <option value="6" {{ $data->is_authorized == 6 ? 'selected' : ' ' }}>Paypal</option>
                                    <option value="7" {{ $data->is_authorized == 7 ? 'selected' : ' ' }}>Maverick</option>
                                    <option value="8" {{ $data->is_authorized == 8 ? 'selected' : ' ' }}>Square</option>
                                    <option value="9" {{ $data->is_authorized == 9 ? 'selected' : ' ' }}>NMI</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="status">Select Status <span>*</span></label>
                                <select name="status" id="status" class="form-control" >
                                    <option value="1" {{ $data->status == 1 ? 'selected' : ' ' }}>Active</option>
                                    <option value="0" {{ $data->status == 0 ? 'selected' : ' ' }}>Deactive</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="live_mode">Live Mode <span>*</span></label>
                                <select name="live_mode" id="live_mode" class="form-control" >
                                    <option value="1" {{ $data->live_mode == 1 ? 'selected' : ' ' }}>PRODUCTION</option>
                                    <option value="0" {{ $data->live_mode == 0 ? 'selected' : ' ' }}>SANDBOX</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="hold_merchant">Hold Merchant <span>*</span></label>
                                <select name="hold_merchant" id="hold_merchant" class="form-control" >
                                    <option value="0" {{ $data->hold_merchant == 0 ? 'selected' : ' ' }}>NO</option>
                                    <option value="1" {{ $data->hold_merchant == 1 ? 'selected' : ' ' }}>YES</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Update Merchant</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
@endsection
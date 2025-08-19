@extends('layouts.app-admin')
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Brand</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Brand Form</div>
                <form class="form" action="{{route('brand.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group mb-3">
                            <label for="name">Name <span>*</span></label>
                            <input type="text" id="name" class="form-control" placeholder="Name" name="name" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="url">Url <span>*</span></label>
                            <input type="text" id="url" class="form-control" placeholder="Url" name="url" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="status">Select Status <span>*</span></label>
                            <select name="status" id="status" class="form-control" >
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="status">Logo <span>*</span></label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="phone">Phone <span>*</span></label>
                            <input type="text" id="phone" class="form-control" placeholder="Phone" name="phone" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="phone_tel">Phone Tel <span>*</span></label>
                            <input type="text" id="phone_tel" class="form-control" placeholder="Phone Tel" name="phone_tel" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="email">Email <span>*</span></label>
                            <input type="email" id="email" class="form-control" placeholder="Email" name="email" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="address">Address <span>*</span></label>
                            <input type="text" id="address" class="form-control" placeholder="Address" name="address" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="address_link">Address Link<span>*</span></label>
                            <input type="text" id="address_link" class="form-control" placeholder="Address Link" name="address_link" required="required">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="sign">Amount Sign<span>*</span></label>
                            <select name="sign" id="sign" class="form-control" required>
                                <option value="$">$ - Dollar</option>
                                <option value="£">£ - Euro</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="merchant">Select Merchant<span>*</span></label>
                            <select name="merchant[]" id="merchant" class="form-control select2" required multiple>
                                @foreach ($merchant as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 form-group mb-3">
                            <label for="opt_hide">Option to Hide<span>*</span></label>
                            <select name="opt_hide" id="opt_hide" class="form-control" required>
                                <option value="0">NO</option>
                                <option value="1">YES</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="payment_script">Script of payment link</label>
                            <textarea name="payment_script" id="payment_script" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Save Brand</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Brand Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Phone/Email</th>
                                <th>Url</th>
                                <th>Merchant</th>
                                <th>Auth Key</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td><img src="{{ asset($datas->logo)}}" width="100"></td>
                                <td><a href="{{ route('brand.show', $datas->id) }}">{{$datas->name}}</a></td>
                                <td>{{$datas->phone}}<br>{{$datas->email}}</td>
                                <td>{{$datas->url}}</td>
                                <td>
                                    @foreach ($datas->merchants as $merchant)
                                    <button class="btn btn-secondary btn-sm">{{ $merchant->name }}</button>
                                    @endforeach
                                </td>
                                <td><button class="btn btn-sm btn-info" onclick="authKeyFunction(this)"><input type="hidden" value="{{$datas->auth_key}}">Copy</button></td>
                                <td>
                                @if($datas->status == 1)
                                    <button class="btn btn-success btn-sm">Active</button>
                                @else
                                    <button class="btn btn-danger btn-sm">Deactive</button>
                                @endif
                                </td>
                                <td>
                                    <a href="{{ route('brand.edit', $datas->id) }}"
                                        class="btn btn-primary btn-blue">
                                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                    </a>
                                    <a href="{{ route('brand.show', $datas->id) }}"
                                        class="btn btn-dark btn-icon">
                                        <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Phone/Email</th>
                                <th>Url</th>
                                <th>Merchant</th>
                                <th>Auth Key</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function authKeyFunction(a) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(a).find('input').val()).select();
        document.execCommand("copy");
        $temp.remove();
        toastr.success("", "Auth Key Copied", {
            timeOut: "50000"
        });
    }
</script>
@endpush
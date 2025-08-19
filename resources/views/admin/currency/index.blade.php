@extends('layouts.app-admin')
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Currency</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Currency Form</div>
                <form class="form" action="{{route('currency.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf   
                    <div class="row">
                        <div class="col-md-4 form-group mb-3">
                            <label for="name">Name <span>*</span></label>
                            <input type="text" id="name" class="form-control" placeholder="Name" name="name" required="required" value="{{ old('name') }}">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="short_name">Short Name <span>*</span></label>
                            <input type="text" id="short_name" class="form-control" placeholder="Short Name" name="short_name" required="required" value="{{ old('short_name') }}">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="sign">Sign <span>*</span></label>
                            <input type="text" id="sign" class="form-control" placeholder="Sign" name="sign" required="required" value="{{ old('sign') }}">
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Save Currency</button>
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
                <h4 class="card-title mb-3">Currency Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Short Name</th>
                                <th>Sign</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td>{{$datas->name}}</td>
                                <td>{{$datas->short_name}}</td>
                                <td>{{$datas->sign}}</td>
                                <td>
                                    <a href="{{ route('currency.edit', $datas->id) }}" class="btn btn-primary btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                        <span class="ul-btn__text">Edit</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Short Name</th>
                                <th>Sign</th>
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

@endpush
@extends('layouts.app-admin')
@section('content')

<div class="breadcrumb">
    <h1 class="mr-2">Service</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Service Form</div>
                <form class="form" action="{{route('service.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf   
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">Name <span>*</span></label>
                                <input type="text" id="name" class="form-control" placeholder="Name" name="name" required="required" value="{{ old('name') }}">
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand">Brand Name <span>*</span></label>
                                    <select name="brand" id="brand" class="form-control searcher" required>
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-4 form-group mb-3">
                                <label for="form">Select Form <span>*</span></label>
                                <select name="form" id="form" class="form-control">
                                    <option value="0">No Form</option>
                                    <option value="1">Logo Form</option>
                                    <option value="2">Website Form</option>
                                    <option value="3">Social Media Marketing Form</option>
                                    <option value="4">Content Writing Form</option>
                                    <option value="5">Search Engine Optimization Form</option>
                                    <option value="6">Book Formatting & Publishing Form</option>
                                    <option value="7">Book Writing Form</option>
                                    <option value="8">Author Website Form</option>
                                    <option value="9">Editing & Proofreading Form</option>
                                    <option value="10">Book Cover Design</option>
                                    <option value="11">Book Marketing</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Save Service</button>
                            </div>
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
                <h4 class="card-title mb-3">Service Details</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered zero-configuration">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Form</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $datas)
                            <tr>
                                <td class="text-truncate">{{$datas->id}}</td>
                                <td class="text-truncate">{{$datas->name}}</td>
                                <td>
                                    @if($datas->form == 0)
                                    <span class="btn btn-secondary btn-sm">No Form</span>
                                    @elseif($datas->form == 1)
                                    <span class="btn btn-info btn-sm">Logo Form</span>
                                    @elseif($datas->form == 2)
                                    <span class="btn btn-primary btn-sm">Website Form</span>
                                    @elseif($datas->form == 3)
                                    <span class="btn btn-dark btn-sm">Social Media Marketing Form</span>
                                    @elseif($datas->form == 4)
                                    <span class="btn btn-light btn-sm">Content Writing Form</span>
                                    @elseif($datas->form == 5)
                                    <span class="btn btn-success btn-sm">Search Engine Optimization Form</span>
                                    @elseif($datas->form == 6)
                                    <span class="btn btn-warning btn-sm">Book Formatting & Publishing Form</span>
                                    @elseif($datas->form == 7)
                                    <span class="btn btn-info btn-sm">Book Writing Form</span>
                                    @elseif($datas->form == 8)
                                    <span class="btn btn-info btn-sm">Author Website Form</span>
                                    @elseif($datas->form == 9)
                                    <span class="btn btn-light btn-sm">Editing & Proofreading</span>
                                    @elseif($datas->form == 10)
                                    <span class="btn btn-dark btn-sm">Book Cover Design</span>
                                    @elseif($datas->form == 11)
                                    <span class="btn btn-primary btn-sm">Book Marketing</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('service.edit', $datas->id) }}" class="btn btn-primary btn-icon btn-sm">
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
                                <th>Form</th>
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
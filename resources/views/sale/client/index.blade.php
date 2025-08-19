@extends('layouts.app-sale')
   
@section('content')

<div class="breadcrumb row">
    <div class="col-md-6">
        <h1>Clients List</h1>
        <ul>
            <li><a href="#">Clients</a></li>
            <li>Clients List</li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('client.create') }}" class="btn btn-primary">Create Client</a>
    </div>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <form action="{{ route('client.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3 form-group mb-3">
                            <label for="name">Search Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Request::get('name') }}">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="email">Search Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ Request::get('email') }}">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="contact">Search Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact" value="">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="status">Select Status</label>
                            <select class="form-control select2" name="status" id="status">
                                <option value="">Any</option>
                                <option value="1" {{ Request::get('status') == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ Request::get('status') == 0 ? 'selected' : '' }}>Deactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="text-right">
                                <button class="btn btn-primary">Search Result</button>
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
                <h4 class="card-title mb-3">Client Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Brand</th>
                                <th>Payment Link</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td>{{$datas->name}} {{$datas->last_name}}</td>
                                <td>{{$datas->email}}</td>
                                <td>{{$datas->contact}}</td>
                                <td><span class="btn btn-info btn-sm">{{$datas->brand->name}}</span></td>
                                <td><a href="{{ route('client.generate.payment', $datas->id) }}" class="btn btn-primary btn-sm">Generate Payment</a></td>
                                <td>
                                    @if($datas->status == 1)
                                        <span class="btn btn-success btn-sm">Active</span><br>
                                    @else
                                        <span class="btn btn-danger btn-sm">Deactive</span><br>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('client.edit', $datas->id)}}" class="btn btn-primary btn-icon btn-sm">
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
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Brand</th>
                                <th>Payment Link</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $data->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    
@endpush
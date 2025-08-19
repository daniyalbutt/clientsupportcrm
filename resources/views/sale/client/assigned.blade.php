@extends('layouts.app-sale')
   
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Clients List</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sale.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Clients</li>
                    <li class="breadcrumb-item">Clients List</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">

    <section id="configuration">
        <div class="row">
            <div class="col-12">
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Client Details</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard pt-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Chat</th>
                                            <th>Brand</th>
                                            <th>Url</th>
                                            <th>Payment Link</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $datas)
                                        <tr>
                                            <td>{{$datas->id}}</td>
                                            <td>{{$datas->name}} {{$datas->last_name}}</td>
                                            <td>{{$datas->email}}</td>
                                            <td>{{$datas->contact}}</td>
                                            <td>
                                                @if($datas->user != null)
                                                    <a href="{{ route('sale.chat', $datas->user->id) }}" class="btn btn-primary btn-sm">Start Chat</a>
                                                @endif
                                            </td>
                                            <td><span class="badge badge-info badge-sm">{{$datas->brand->name}}</span></td>
                                            <td>{{$datas->url}}</td>
                                            <td><a href="{{ route('client.generate.payment', $datas->id) }}" class="btn btn-primary btn-sm">Generate Payment</a></td>
                                            <td>
                                                @if($datas->status == 1)
                                                    <span class="badge badge-success badge-md">Active</span><br>
                                                @else
                                                    <span class="badge badge-danger badge-md">Deactive</span><br>
                                                @endif
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
                                            <th>Chat</th>
                                            <th>Brand</th>
                                            <th>Url</th>
                                            <th>Payment Link</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@push('scripts')
    
@endpush
@extends('layouts.app-admin')
@section('title', 'Merchants')
@push('styles')
<style>
    .select2-container {
        z-index: 9999;
        text-align: left;
    }
</style>
@endpush
@section('content')
<div class="breadcrumb row">
    <div class="col-md-6">
        <h1 class="mr-2">Merchants</h1>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('admin.merchant.create') }}" class="btn btn-primary">Create Merchant</a>
    </div>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3 count-card-title">Merchant's Details <span> Total: {{ count($data) }} <span></h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered"  style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Public Key / Login ID</th>
                                <th>Secret Key / Transaction Key</th>
                                <th>Merchant</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td>{{$datas->name}}</td>
                                <td style="overflow-wrap: anywhere;">{{$datas->public_key}}</td>
                                <td style="overflow-wrap: anywhere;">{{$datas->secret_key}}</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary text-uppercase">{{ $datas->get_merchant_name() }}</button>
                                    {!! $datas->hold_merchant() !!}
                                </td>
                                <td>
                                    @if($datas->status == 1)
                                        <button class="btn btn-success btn-sm">Active</button><br>
                                    @else
                                        <button class="btn btn-danger btn-sm">Deactive</button><br>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.merchant.edit', $datas->id) }}" class="btn btn-primary btn-icon btn-sm">
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
                                <th>Public Key</th>
                                <th>Secret Key</th>
                                <th>Merchant</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('scripts')

@endpush
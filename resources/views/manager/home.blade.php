
@extends('layouts.app-manager')
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Dashboard</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Administrator"></i>
                        <p class="text-muted mt-2 mb-2">Clients</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ $clients_count }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Credit-Card"></i>
                        <p class="text-muted mt-2 mb-2">Paid Invoices</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ $paid_invoice }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Credit-Card-3"></i>
                        <p class="text-muted mt-2 mb-2">UnPaid Invoices</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ $un_paid_invoice }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Folder-Close"></i>
                        <p class="text-muted mt-2 mb-2">Brief Pending</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ $brief_count }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

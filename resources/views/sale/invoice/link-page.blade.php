@extends('layouts.app-sale')
@push('styles')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endpush
@section('content')
<!-- Main Content -->
<div class="breadcrumb">
    <h1>Payment Link Generated - {{ $_getInvoiceData->name }} </h1>
</div>

<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs justify-content-end mb-4" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="true">Invoice</a></li>
            </ul>
            <div class="card">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                        <div class="d-sm-flex mb-5" data-view="print">
                            <img src="{{ asset($_getBrand->logo) }}" width="150"/>
                            <span class="m-auto"></span>
                            <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">Print Invoice</button>
                        </div>
                        <!-- -===== Print Area =======-->
                        <div id="print-area">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="font-weight-bold">Invoice Info</h4>
                                    <p>#{{$_getInvoiceData->invoice_number}}</p>
                                </div>
                                <div class="col-md-6 text-sm-right">
                                    <p>
                                        <strong>Invoice status: </strong>
                                        <span>{{  App\Models\Invoice::PAYMENT_STATUS[$_getInvoiceData->payment_status] }}</span>
                                    </p>
                                    <p><strong>Invoice date: </strong>{{ $_getInvoiceData->created_at->format('d M, y h:i a') }}</p>
                                </div>
                            </div>
                            <div class="mt-3 mb-4 border-top"></div>
                            <div class="row mb-5">
                                <div class="col-md-6 mb-3 mb-sm-0">
                                    <h5 class="font-weight-bold">Bill From</h5>
                                    <p class="mb-1">{{ $_getInvoiceData->sale->name }}</p>
                                    <p class="mb-1">{{ $_getInvoiceData->sale->email }}</p>
                                    <p class="mb-1">{{ $_getInvoiceData->sale->contact }}</p>
                                </div>
                                <div class="col-md-6 text-sm-right">
                                    <h5 class="font-weight-bold">Bill To</h5>
                                    <p class="mb-1">{{ $_getInvoiceData->name }}</p>
                                    <p class="mb-1">{{ $_getInvoiceData->email }}</p>
                                    <p class="mb-1">{{ $_getInvoiceData->contact }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-gray-300">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Service</th>
                                                <th scope="col">Payment Type</th>
                                                <th scope="col">Cost</th>
                                                <th scope="col">Link</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>
                                                    @if($_getInvoiceData->package == 0)
                                                    {{ $_getInvoiceData->custom_package }}
                                                    @else
                                                    {{ $_getInvoiceData->package }}
                                                    @endif
                                                </td>
                                                <td>{{$_getBrand->name}}</td>
                                                <td>
                                                    @php
                                                    $service_list = explode(',', $_getInvoiceData->service);
                                                    @endphp
                                                    @for($i = 0; $i < count($service_list); $i++)
                                                    <span class="btn btn-info btn-sm">{{ $_getInvoiceData->services($service_list[$i])->name }}</span>
                                                    @endfor
                                                </td>
                                                <td>{{ $_getInvoiceData->payment_type_show() }}</td>
                                                <td>{{$_getInvoiceData->currency_show->sign}} {{ $_getInvoiceData->amount }}</td>
                                                <td>
                                                    <a href="{{ route('client.paynow', $id) }}" target="_blank" class="btn btn-primary btn-sm">Invoice Link</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-hover">
                                        <thead class="bg-gray-300">
                                            <tr>
                                                <th scope="col">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! $_getInvoiceData->discription !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="invoice-summary">
                                        <p>Sub total: <span>{{$_getInvoiceData->currency_show->sign}}{{ $_getInvoiceData->amount }}</span></p>
                                        <h5 class="font-weight-bold">Grand Total: <span>{{$_getInvoiceData->currency_show->sign}}{{ $_getInvoiceData->amount }}</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ==== / Print Area =====-->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end of main-content -->
</div>

@endsection

@push('scripts')

@endpush
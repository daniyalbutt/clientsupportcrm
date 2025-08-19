@extends('layouts.app-manager')
@push('styles')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <button class="font-weight-bold btn btn-{{ App\Models\Invoice::STATUS_COLOR[$_getInvoiceData->payment_status] }} mb-sm-0 mb-3 text-uppercase ">
                                STATUS: {{  App\Models\Invoice::PAYMENT_STATUS[$_getInvoiceData->payment_status] }}
                                {{ $_getInvoiceData->return_response != null ? '- ' . $_getInvoiceData->return_response : '' }}
                                @if($_getInvoiceData->payment_status == 5)
                                @if($_getInvoiceData->merchant->is_authorized == 1)
                                <br>
                                <span>{{ $_getInvoiceData->invoice_logs->return_response }}</span>
                                @endif
                                @endif
                            </button>
                        </div>
                        <!-- -===== Print Area =======-->
                        <div id="print-area">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    {!! $_getInvoiceData->merchant->is_authorized == 4 ? '<p>'.$_getInvoiceData->return_tresponse.'</p>' : '' !!}
                                    {!! $_getInvoiceData->merchant->is_authorized == 5 ? '<p>'.$_getInvoiceData->return_tresponse.'</p>' : '' !!}
                                    {!! $_getInvoiceData->merchant->is_authorized == 7 ? '<p>'.$_getInvoiceData->return_tresponse.'</p>' : '' !!}
                                </div>
                                <div class="col-md-6">
                                    <h4 class="font-weight-bold">Invoice Info</h4>
                                    <p>{{$_getInvoiceData->invoice_number}}</p>
                                </div>
                                <div class="col-md-6 text-sm-right">
                                    <p class="mb-1">
                                        <strong>Invoice status: </strong>
                                        <span>{{  App\Models\Invoice::PAYMENT_STATUS[$_getInvoiceData->payment_status] }}</span>
                                    </p>
                                    <p class="mb-1"><strong>Invoice date: </strong>{{ $_getInvoiceData->created_at->format('d M, y h:i a') }}</p>
                                    {!! $_getInvoiceData->transaction_id != '' ? '<p class="mb-0"><strong>Transaction ID: </strong> ' . $_getInvoiceData->transaction_id . '</p>' : ' ' !!}
                                    {!! $_getInvoiceData->merchant->is_authorized == 4 && $_getInvoiceData->transaction_id != null ? '<p><strong>Transaction Id: </strong>'.$_getInvoiceData->transaction_id.'</p>' : '' !!}
                                    {!! $_getInvoiceData->merchant->is_authorized == 5 && $_getInvoiceData->transaction_id != null ? '<p><strong>Transaction Id: </strong>'.$_getInvoiceData->transaction_id.'</p>' : '' !!}
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
                                                <th scope="col">Merchant</th>
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
                                                <td>
                                                    <button class="btn btn-sm btn-secondary text-uppercase">{{ $_getInvoiceData->merchant->get_merchant_name() }}</button>
                                                    <button class="btn btn-sm btn-warning text-uppercase">{{ $_getInvoiceData->merchant->name }}</button>
                                                    {!! $_getInvoiceData->merchant->hold_merchant() !!}
                                                </td>
                                                <td>{{$_getInvoiceData->currency_show->sign}} {{ $_getInvoiceData->amount }}</td>
                                                <td>
                                                    <a href="{{ route('client.paynow', $_getInvoiceData->invoice_id) }}" target="_blank" class="btn btn-primary btn-sm">Invoice Link</a>
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
                                    <hr class="mt-0">
                                </div>
                                <div class="col-md-9">
                                    @if($_getInvoiceData->payment_status == 1)
                                    @if($_getInvoiceData->merchant->is_authorized == 2)
                                    @if(count($_getInvoiceData->merchant->client_authorize_customers($_getInvoiceData->client->id)->get()) != 0)
                                    <div class="auto-charge" id="auto-charge">
                                        <ul>
                                        @foreach ($_getInvoiceData->merchant->client_authorize_customers($_getInvoiceData->client->id)->get() as $item)
                                        @foreach ($item->client_authorizes as $client_authorizes)
                                            <li data-invoice_id={{ $_getInvoiceData->id }} data-currency="{{$_getInvoiceData->currency_show->sign}}" data-amount="{{ $_getInvoiceData->amount }}" data-card="{{ $client_authorizes->account_type }}" data-account="{{ $client_authorizes->account_number }}" data-payment_profile_id="{{ $client_authorizes->payment_profile_id }}" data-customer_profile_id="{{ $item->authorize_customer_profile_id }}">
                                                <h2>{{ $client_authorizes->account_number }}<br><p>{{ $client_authorizes->account_type }}</p></h2>
                                                @if($client_authorizes->account_type == 'AmericanExpress')
                                                <i class="fa-brands fa-cc-amex"></i>
                                                @elseif($client_authorizes->account_type == 'Discover')
                                                <i class="fa-brands fa-cc-discover"></i>
                                                @elseif($client_authorizes->account_type == 'JCB')
                                                <i class="fa-brands fa-cc-jcb"></i>
                                                @elseif($client_authorizes->account_type == 'Visa')
                                                <i class="fa-brands fa-cc-visa"></i>
                                                @elseif($client_authorizes->account_type == 'MasterCard')
                                                <i class="fa-brands fa-cc-mastercard"></i>
                                                @else
                                                <i class="fa-solid fa-credit-card"></i>
                                                @endif
                                            </li>
                                        @endforeach
                                        @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    @elseif(($_getInvoiceData->merchant->is_authorized == 7) || ($_getInvoiceData->merchant->is_authorized == 4) || ($_getInvoiceData->merchant->is_authorized == 5))
                                    <div class="auto-charge">
                                        <ul>
                                        @foreach ($_getInvoiceData->merchant->client_authorize_customers($_getInvoiceData->client->id)->orderBy('id', 'desc')->get() as $item)
                                            <li class="paybynmi" data-id="{{ $item->id }}" data-invoice_id="{{ $_getInvoiceData->id }}" data-currency="{{$_getInvoiceData->currency_show->sign}}" data-amount="{{ $_getInvoiceData->amount }}" data-card="{{ $item->get_ccnumber() }}" data-account="Card">
                                                <h2>{{ '***********' . substr($item->get_ccnumber(),-4) }}<br><p>{{ trim(strrev(chunk_split(strrev($item->get_ccexp()),2, ' '))) }}</p></h2>
                                                <i class="fa-solid fa-credit-card"></i>
                                            </li>
                                        @endforeach
                                        </ul>
                                    </div>
                                    @else
                                    @if(count($_getInvoiceData->merchant->client_authorize_customers($_getInvoiceData->client->id)->get()) != 0)
                                    <div class="auto-charge">
                                        <ul>
                                        @foreach ($_getInvoiceData->merchant->client_authorize_customers($_getInvoiceData->client->id)->orderBy('id', 'desc')->get() as $item)
                                        <li data-invoice_id={{ $_getInvoiceData->id }} data-currency="{{$_getInvoiceData->currency_show->sign}}" data-amount="{{ $_getInvoiceData->amount }}" data-card="{{ $item->authorize_customer_profile_id }}">
                                            @php
                                            $data = \Crypt::decrypt($item->authorize_customer_profile_id);
                                            $card_number = json_decode($data)->ssl_card_number;
                                            @endphp
                                            <h2>{{ preg_replace( "#(.*?)(\d{4})$#", "$2", $card_number) }} <br><p>CARD</p></h2>
                                            <i class="fa-solid fa-credit-card"></i>
                                        </li>
                                        @endforeach
                                        </ul>
                                    </div>

                                    @endif
                                    @endif
                                    @endif
                                </div>
                                <div class="col-md-3">
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.paybynmi').on('click', function () {
        var currency = $(this).data('currency');
        var amount = $(this).data('amount');
        var invoice_id = $(this).data('invoice_id');
        var client_authorize_customers_id = $(this).data('id');
        var card = $(this).data('card');
        var account = $(this).data('account');
        swal({
            title: "Charge Amount " + currency + amount,
            html: "Selected Card ( " + card + " )" ,
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "Pay Now " + currency + amount,
        }).then(function (inputValue) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: "{{ route('manager.payment.paybynmi') }}",
                data: {invoice_id: invoice_id, client_authorize_customers_id:client_authorize_customers_id},
                success:function(data) {
                    if(data.success == true){
                        swal("Successfully", data.message);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);

                    }else{
                        return swal({
                            title:"Error",
                            text: data.message,
                            type:"danger"
                        })
                    }
                }
            });
        });
    });

    $('#auto-charge li').on('click', function () {
        var invoice_id = $(this).data('invoice_id');
        var currency = $(this).data('currency');
        var amount = $(this).data('amount');
        var card = $(this).data('card');
        var account = $(this).data('account');
        var payment_profile_id = $(this).data('payment_profile_id');
        var customer_profile_id = $(this).data('customer_profile_id');

        swal({
            title: "Charge Amount " + currency + amount,
            html: "Selected Card " + account + " ( " + card + " )" ,
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "Pay Now " + currency + amount,
        }).then(function (inputValue) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: "{{ route('manager.payment.auto') }}",
                data: {invoice_id: invoice_id, customer_profile_id:customer_profile_id, payment_profile_id:payment_profile_id},
                success:function(data) {
                    if(data.success == true){
                        swal("Successfully", data.message);
                    }else{
                        return swal({
                            title:"Error",
                            text: data.message,
                            type:"danger"
                        })
                    }
                }
            });
        });
    });
</script>
@endpush
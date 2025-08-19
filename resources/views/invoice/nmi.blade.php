<!DOCTYPE html>
<html lang="en">
<head>
    <title>Terminal | {{config('app.name')}} </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{ asset('newglobal/css/paynow.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('newglobal/js/paynow.js') }}"></script>
    {{-- <script src="https://secure.expigate.com/token/Collect.js"
            data-tokenization-key="{{ $_getInvoiceData->merchant->public_key }}"
        ></script> --}}
<style>
    #ccnumber{
        font-family: "Raleway important";
    }
    .paid-container {
        position: FIXED;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: CENTER;
        flex-direction: column;
        background-color: #0000003d;
    }
    .paid-wrapper {
        text-align: center;
        height: 100%;
        display: FLEX;
        align-items: CENTER;
        flex-wrap: wrap;
        flex-direction: column;
        justify-content: center;
    }

    .paid-wrapper h1 {
        text-transform: uppercase;
        font-weight: bold;
    }
  </style>
</head>

<?php $finalamount = $_getInvoiceData->total_amount; ?>
<body>
    @if($_getInvoiceData->payment_status == 2)
    <div class="paid-container">
        <div class="paid-wrapper">
            <h1>This Invoice is Paid</h1>
            {{-- <p>Contact your Administrator in order to resolve the issue</p> --}}
        </div>        
    </div>
    @elseif($_getInvoiceData->payment_status == 5)
    <div class="paid-container declined-paid-container alert alert-danger">
        <div class="paid-wrapper">
            <h1>This Invoice is Declined</h1>
            @if($_getInvoiceData->merchant->is_authorized == 3)
            <p>{{ ($_getInvoiceData->invoice_logs->return_response != null ? json_decode($_getInvoiceData->invoice_logs->return_response)->ssl_result_message : ' ')}}</p>
            @endif
        </div>        
    </div>
    @else
    <form role="form" action="{{ route('client.payment') }}" method="post" class="mt-4 mb-4 container require-validation" id="card-form">
        <input type="hidden" name="payment_method" id="payment_method" value="{{ $_getInvoiceData->merchant->is_authorized }}">
        <input type="hidden" name="payment_token" id="payment_token">
        @if(session('error_msg'))
        <div class="alert alert-danger fade in alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="font-size:20px">×</span>
            </button>    
            {{ session('error_msg') }}
        </div>
        @endif
        @if (\Session::has('stripe_error'))
        <div class="alert alert-danger">
            {!! \Session::get('stripe_error') !!}
        </div>
        @endif
        @csrf
        <input type="hidden" name="invoice_id" class="form-control" value="{{ $_getInvoiceData->id }}">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <h3 class="mb-0 font-weight-bold">PAYMENT TERMINAL</h3>
                                <p class="mb-0">Invoice ID: #{{$_getInvoiceData->invoice_number}}</p>
                            </div>
                            <div class="col-lg-6 text-right">
                                <img src="{{ asset($_getBrand->logo) }}" width="180"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row preload justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Package Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="package_name">Package Name</label>
                                <input id="package_name" name="package_name" type="text" value="{{ ($_getInvoiceData->package == 0) ? $_getInvoiceData->custom_package : $_getInvoiceData->package }}" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label for="currency">Currency</label>
                                <input id="currency" name="currency" type="text" value="{{$_getInvoiceData->currency_show->name}}" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label for="amount">Amount</label>
                                <input id="amount" name="amount" type="text" value="{{$_getInvoiceData->currency_show->sign}}{{$_getInvoiceData->amount}}" readonly>
                            </div>
                            @if($_getInvoiceData->discription != null)
                            <div class="col-lg-12">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" id="description" rows="4" class="form-control" readonly>{{ $_getInvoiceData->discription }}</textarea>
                            </div>
                            @endif
                        </div>      
                    </div>
                </div>
            </div>
        </div>
        <div class="row preload justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">User Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="user_name">Name</label>
                                <input id="user_name" name="user_name" type="text" value="{{$_getInvoiceData->name}}">
                            </div>
                            <div class="col-lg-4">
                                <label for="user_email">Email Address</label>
                                <input id="user_email" name="user_email" type="email" value="{{$_getInvoiceData->email}}">
                            </div>
                            <div class="col-lg-4">
                                <label for="user_phone">Contact</label>
                                <input id="user_phone" name="user_phone" type="text" value="{{$_getInvoiceData->contact}}">
                            </div>
                            <div class="col-lg-8">
                                <label for="address">Street Address *</label>
                                <input name="address" id="address" value="{{ old('address') }}" required>
                            </div>
                            <div class="col-lg-4">
                                <label for="address">City *</label>
                                <input name="city" id="city" required value="{{ old('city') }}">
                            </div>
                            <div class="col-lg-4">
                                <label for="address">State *</label>
                                <span id="state-code"><input type="text" id="state" name="state" value="{{ old('state') }}"></span>
                                <!-- <input name="state" id="state" required> -->
                            </div>
                            <div class="col-lg-4">
                                <label for="address">Zip *</label>
                                <input name="zip" id="zip" required>
                            </div>
                            <div class="col-lg-4">
                                <label for="country">Country *</label>
                                <select name="country" id="country" required>
                                    <option>Select Country</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row preload justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Card Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="creditcard">
                                    <div class="front">
                                        <div id="ccsingle"></div>
                                        <svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                                            <g id="Front">
                                                <g id="CardBackground">
                                                    <g id="Page-1_1_">
                                                        <g id="amex_1_">
                                                            <path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                                                    C0,17.9,17.9,0,40,0z" />
                                                        </g>
                                                    </g>
                                                    <path class="darkcolor greydark" d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
                                                </g>
                                                <text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber" class="st2 st3 st4">0123 4567 8910 1112</text>
                                                <text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname" class="st2 st5 st6">JOHN DOE</text>
                                                <text transform="matrix(1 0 0 1 54.1074 389.8793)" class="st7 st5 st8">cardholder name</text>
                                                <text transform="matrix(1 0 0 1 479.7754 388.8793)" class="st7 st5 st8">expiration</text>
                                                <text transform="matrix(1 0 0 1 65.1054 241.5)" class="st7 st5 st8">card number</text>
                                                <g>
                                                    <text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire" class="st2 st5 st9">01/23</text>
                                                    <text transform="matrix(1 0 0 1 479.3848 417.0097)" class="st2 st10 st11">VALID</text>
                                                    <text transform="matrix(1 0 0 1 479.3848 435.6762)" class="st2 st10 st11">THRU</text>
                                                    <polygon class="st2" points="554.5,421 540.4,414.2 540.4,427.9    " />
                                                </g>
                                                <g id="cchip">
                                                    <g>
                                                        <path class="st2" d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
                                                c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <rect x="82" y="70" class="st12" width="1.5" height="60" />
                                                        </g>
                                                        <g>
                                                            <rect x="167.4" y="70" class="st12" width="1.5" height="60" />
                                                        </g>
                                                        <g>
                                                            <path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
                                                    c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
                                                    C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
                                                    c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
                                                    c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
                                                        </g>
                                                        <g>
                                                            <rect x="82.8" y="82.1" class="st12" width="25.8" height="1.5" />
                                                        </g>
                                                        <g>
                                                            <rect x="82.8" y="117.9" class="st12" width="26.1" height="1.5" />
                                                        </g>
                                                        <g>
                                                            <rect x="142.4" y="82.1" class="st12" width="25.8" height="1.5" />
                                                        </g>
                                                        <g>
                                                            <rect x="142" y="117.9" class="st12" width="26.2" height="1.5" />
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                            <g id="Back">
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="back">
                                        <svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                                            <g id="Front">
                                                <line class="st0" x1="35.3" y1="10.4" x2="36.7" y2="11" />
                                            </g>
                                            <g id="Back">
                                                <g id="Page-1_2_">
                                                    <g id="amex_2_">
                                                        <path id="Rectangle-1_2_" class="darkcolor greydark" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                                                C0,17.9,17.9,0,40,0z" />
                                                    </g>
                                                </g>
                                                <rect y="61.6" class="st2" width="750" height="78" />
                                                <g>
                                                    <path class="st3" d="M701.1,249.1H48.9c-3.3,0-6-2.7-6-6v-52.5c0-3.3,2.7-6,6-6h652.1c3.3,0,6,2.7,6,6v52.5
                                            C707.1,246.4,704.4,249.1,701.1,249.1z" />
                                                    <rect x="42.9" y="198.6" class="st4" width="664.1" height="10.5" />
                                                    <rect x="42.9" y="224.5" class="st4" width="664.1" height="10.5" />
                                                    <path class="st5" d="M701.1,184.6H618h-8h-10v64.5h10h8h83.1c3.3,0,6-2.7,6-6v-52.5C707.1,187.3,704.4,184.6,701.1,184.6z" />
                                                </g>
                                                <text transform="matrix(1 0 0 1 621.999 227.2734)" id="svgsecurity" class="st6 st7">985</text>
                                                <g class="st8">
                                                    <text transform="matrix(1 0 0 1 518.083 280.0879)" class="st9 st6 st10">security code</text>
                                                </g>
                                                <rect x="58.1" y="378.6" class="st11" width="375.5" height="13.5" />
                                                <rect x="58.1" y="405.6" class="st11" width="421.7" height="13.5" />
                                                <text transform="matrix(1 0 0 1 59.5073 228.6099)" id="svgnameback" class="st12 st13">John Doe</text>
                                            </g>
                                        </svg>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="row form-container">
                                    <div class="col-md-12">
                                        <label for="name">Name</label>
                                        <input id="name" maxlength="20" type="text" name="owner" value="{{ old('owner') }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="cardnumber">Card Number</label>
                                        <input id="cardnumber" type="text" inputmode="numeric" class="card-number" size="20" autocomplete='off' name="ccnumber" value="{{ old('ccnumber') }}" required>
                                        <svg id="ccicon" class="ccicon" width="750" height="471" viewBox="0 0 750 471" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">

                                        </svg>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="expirationdate">Expiration (MM/YY)</label>
                                        <input id="expirationdate" type="text" inputmode="numeric" name="ccexp" value="{{ old('ccexp') }}" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="securitycode">Security Code</label>
                                        <input id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric" autocomplete='off' size='4' class="card-cvc" card-cvc name="cvv" value="{{ old('cvv') }}" required>
                                    </div>
                                    <div class='col-md-12 error form-group d-none'>
                                        <div class='alert-danger alert'>Please correct the errors and try
                                            again.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <label for="agree" class="checkout-box-wrapper"><input id="agree" type="checkbox" name="agree" value="agree" required=""> <span>I have read and agree to the <a href="" type="button" data-toggle="modal" data-target="#privacyModal">privacy policy</a> and <a href="" type="button" data-toggle="modal" data-target="#exampleModal">terms of service</a>.</span></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center mt-4">
                <input type="submit" value="Agree & Pay Now ({{$_getInvoiceData->currency_show->sign}}{{$_getInvoiceData->amount}})" id="payButton" class="btn btn-info pl-5 pr-5 form-submit-btn btnAction button-credit-card pl-0" disabled>
                
                {{-- <button class="btn btn-info pl-5 pr-5 form-submit-btn" id="form-submit-btn" type="submit" disabled>Agree & Pay Now ({{$_getInvoiceData->currency_show->sign}}{{$_getInvoiceData->amount}})</button> --}}
            </div>
        </div>
    </form>

    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Terms & Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <h5>Revision Policy</h5>
                    <p>Revisions are contingent on the package selected. Clients can approach us for unlimited free amendments, and we will revise their design with no extra charges, given that the design and concept remain intact. The revision turnaround time will be 48 hours.</p>
                    <h5>Refund Policy</h5>
                    <p>{{ $_getInvoiceData->brands->name }} allows you to have your money back within 45 days of order placement & reserves the right to terminate this, at any time, with or without notice depending upon the scenario. This offer strictly implies that the refund is asked upon viewing the initial samples only; requesting revisions on the initial design work shall be regarded as a continuation of the project & will make this guarantee annulled. We rely on the customer’s prompt feedback during the design process to complete the task effectively and therefore hope that the customer gives proper feedback to get the desired results.</p>
                    <p>We won’t entertain or refund any orders if the client stays non-responsive for 45 Days; however, the client can email us to hold the project if there is some personal issue.</p>
                    <p>If the client wants to forfeit any part of the discounted package, the refund is not applicable. For example; if the client has availed the discounted package for a Logo & Website and only wants to avail one service instead of both, he/she will not be applicable for any refund.</p>
                    <p>Furthermore, the customer shall forfeit the right to the refund outlined above if the customer request additional revisions (1 or more design changes regardless of the complexity) or modifications to any of the initial concepts. You shall also forfeit the right to a refund if you do not respond promptly to a status notification from "{{ $_getInvoiceData->brands->name }} ".</p>
                    <p>In case of finalizing one part of the order, the customer won’t be eligible for a refund for the remaining package.</p>
                    <p>24-hour design fees and 24-hour rush changes are non-refundable.</p>
                    <p>No refund is available for design firms or those who order our design services on behalf of another entity. If an order cancellation request is posted before the delivery of the initial concepts, you are eligible for a refund. In case of a duplicate charge, the 100% amount will be returned. If design requirements are not fulfilled, committed at the time of sale, or the designs are not delivered according to the delivery policy, though a proof is required for such commitment, a refund can be claimed. You agree for bundle packages (e.g., Logo, Stationery, Website, Social Media, and Brochure), the refund can't be claimed if there is any discontinuation with a certain service included in the bundle package once any of the service is availed.</p>
                    <h6>The following terms and conditions apply to all the services purchased by the client and provided by {{ $_getInvoiceData->brands->name }} .</h6>
                    <p>On any occasion, any funds deposited will not be liable for a refund if the initial design and concepts (after delivery) are approved, or a change is asked for unless {{ $_getInvoiceData->brands->name }} cancels or ends your Contract for a reason other than your breach or non-execution.</p>
                    <p>All refund requests will be as per the following arrangement:</p>
                    <p>You make a solicitation when the underlying ideas for a logo are provided. However, once you approve or ask for changes in the initial designs, the refund offer will be void, and a refund request will not be entertained.</p>
                    <p>Once the project has been entered into the revision phase, the refund offer will be void, and the refund request will not be entertained.</p>
                    <p>On the off chance that demand for a refund is made before the delivery of initial design concepts, then you would qualify for a full refund (less 10% administration and preparing charge).</p>
                    <p>If the refund request is made within 48 hours, you will only be eligible for a 66% refund (less 10% administration and preparing expense).</p>
                    <p>If the refund request is made within 48-96 hours after the initial design delivery, you will only be eligible for a 33% refund (less 10% service & processing fee).</p>
                    <p>No refund request will be entertained after 96 hours of the initial design delivery. However, we believe in 100% customer satisfaction, so you are requested to reach out to us to address your concerns.</p>
                    <p>No request for refund will be entertained after inaction by the customer after 7 working days. If you wish to restart the order, you will be charged a certain fee contingent upon your venture.</p>
                    <p>No request for a refund will be entertained if the customer goes unresponsive at any point in time for 5 working days.</p>
                    <p>All refund requests must be communicated to the support department. {{ $_getInvoiceData->brands->name }} reserves the right to approve/reject any refund requests based on an individual case-to-case premise.</p>
                    <p>No refund will be entertained after the final files have been delivered.</p>
                    <p>For Website bundles, no refund will be entertained once the initial design mock-up has been revised or the inner pages created with the client’s approval.</p>
                    <p>All refund requests must be communicated to the support department. {{ $_getInvoiceData->brands->name }}, in light of the infringement of your user agreement, reserves all authority to affirm/object to your solicitation on an individual case to case premise.</p>
                    <p>For {{ $_getInvoiceData->brands->name }} /Custom bundles, a refund will be applied just as on the single packages.</p>
                    <p>For instance, if you request a logo and web design and approve of the logo, you are eligible for the refund of the website service at the time of initial design only.</p>
                    <p>A refund request should have a legitimate reason which must be qualified against the outline brief and client input for revisions. Unless an idea has not been composed as per the brief, a refund will not be approved; however, a discount won’t be given. However, further revisions will be provided until you are satisfied.</p>
                    <p>It is also to be noted that, under any circumstances, both parties ({{ $_getInvoiceData->brands->name }} & Client) agree not to attack/criticize each other and any of its employees, associate/s or partner/s publicly (on public forums, blogs, social networks, etc.) at any given time during or after the contract period. Similarly, both parties agree not to talk on forums, blogs, community groups, or any social media platform in a way that brings a bad name to either party or any of its employees, associate, or partner. In case of a breach, the breaching party would have to pay a reasonable compensation decided by the non-breaching party as damages.</p>
                    <p>Money-Back Guarantee depends on that the request is set per some basic honesty. Where a client has placed design orders with more than one agency for the same job, intending to claim a refund, {{ $_getInvoiceData->brands->name }} does not consider this to be good faith. In such instances, we reserve the right to decline a refund request.</p>
                    <p>All design jobs require client input before finishing the design, so it is requested that the customer be active throughout the process and give feedback to get the required results.</p>
                    <p>100% unique design guarantee qualifies you for a new logo if the logo designed by {{ $_getInvoiceData->brands->name }} is found to be considerably similar to another design that already exists. Any likeness to a current outline will be just a fortuitous event, and {{ $_getInvoiceData->brands->name }} won’t acknowledge any responsibility or claim of any compensation in such a case. After the finalization of the logo it needs to go through a registration process that will be done through the agency, {{ $_getInvoiceData->brands->name }} (USPTO charges applied), in order to have complete ownership and 100% rights over the logo.</p>
                    <p>Change of mind is not applicable for refund.</p>
                    <h5>How To Claim Your Refund</h5>
                    <p>To ensure that your refund request is processed effectively and is approved, please make sure that you meet the following requirements.</p>
                    <ul>
                        <li>1. Specify your concern and claim your refund through any of the following three modes:-</li>
                        <ul>
                            <li>Toll free # {{ $_getInvoiceData->brands->phone }}</li>
                            <li>Live Chat</li>
                            <li>Email ({{ $_getInvoiceData->brands->email }})</li>
                        </ul>
                    </ul>
                    <p>We will try to resolve your query and concern in light of our revision policy immediately or email you a refund request approval from our refund department.</p>
                    <p>After the refund, the rights to your design would be transferred to {{ $_getInvoiceData->brands->name }} and you would not legally be allowed to display any version of the design sent by the company.</p>
                    <p>1. Since the design rights would now be transferred to {{ $_getInvoiceData->brands->name }}, you concur that you will have no right (immediate or circuitous) to use any reaction or other substance, work item, or media, nor will you have any ownership interest for or to the same.</p>
                    <p>2. Working in a joint effort with the Government Copyright Agencies {{ $_getInvoiceData->brands->name }} would share Copyright Acquisition data for the refunded outlines that would confine the re-utilization of the designs as original designs in the future.</p>
                    <p>If you have any questions or concerns about our Refund Policy, please contact us by clicking here ({{ $_getInvoiceData->brands->email }}).</p>
                    <h5>My Account</h5>
                    <p>The My Account area is a convenient way to communicate. It is your sole responsibility to check the account section for all questions, queries, concerns, and any other instructions for the designer. Failure to actively check my account section may become a cause of hindrance in your perusal of a refund. If you are unsure of how to use the My Account area, please get in touch with customer support at any time for prompt assistance.</p>
                    <h5>Quality Assurance Policy</h5>
                    <p>For complete satisfaction, our designers are instructed not to deviate from the specifications provided by the client in the order form.</p>
                    <p>The designs are crafted after adequate and thorough research to ensure quality and uniqueness.</p>
                    <h5>100% Satisfaction Guarantee</h5>
                    <p>We revamp the requested design and continue overhauling it until you are 100% fulfilled (depending upon your package).</p>
                    <h5>Domain and Hosting</h5>
                    <p>Domain and Hosting are provided if included in your customized package.</p>
                    <p>Emails can only be provided if your website is hosted on our server.</p>
                    <p>If you wish to opt-out of hosting the website with us, you will not be provided with email accounts.</p>
                    <h5>Delivery Policy</h5>
                    <p>All design order files are delivered to My Account as specified on the “Order Confirmation” date. An email is also sent to inform the client about their design order delivery to their specific account area. All policies about revision & refund are subject to the date and time of the design order delivered to the client’s account area.</p>
                    <p>All design order files are delivered to “My Account” as per the date specified on the “Order Confirmation.” An email is also sent to inform the client about their design order delivery to their specific account area. All policies about revision & refund are subject to the date and time of the design order delivered to the client’s account area.</p>
                    <p>All customized design orders are delivered via email within 5 to 7 days after receipt of the order.</p>
                    <p>We offer a RUSH DELIVERY service through which you can have your first logo within 24 hours by paying just $100 additional! For further help, get in touch with our customer support department.</p>
                    <p>The sole purpose of the test servers is to design and develop the front end of the website initially. In addition, server testing allows our development team to identify and fix flaws, such as downtime or run-time errors. The duration of the test server is 2 months from the original date of purchase.</p>
                    <h5>Record Maintenance</h5>
                    <p>We keep your final design archived after we deliver your final files. If you wish to receive the final files again, we can email them upon request.</p>
                    <h5>Customer Support</h5>
                    <p>We offer 24-Hour Customer Support to address your questions and queries.</p>
                    <p>You can get in touch with us at whatever time, and we promise a prompt reply.</p>
                    <h5>Correspondence Policy</h5>
                    <p>You concur that {{ $_getInvoiceData->brands->name }} is not at risk for any correspondence from email address (es) other than the ones taken after by our particular area, i.e., “{{ $_getInvoiceData->brands->email }}” or/and any toll-free number that is not specified on our site. {{ $_getInvoiceData->brands->name }} ought not to be considered in charge of any damage(s) brought about by such correspondence. We assume the liability of any correspondence through email address (es) under our space name or/and through the toll-free number, i.e., as specified on {{ $_getInvoiceData->brands->name }} Website.</p>
                    <h5>Money-Back Guarantee</h5>
                    <p>We are extremely confident of the work we do, which is why we back it up with a money-back guarantee. If we are unable to meet and beat your expectations, we’ll give you a refund.</p>
                    <h5>100% Unique Design Guarantee</h5>
                    <p>At {{ $_getInvoiceData->brands->name }} we promise that all of our logos are produced/designed from scratch. We will provide you a logo that is adept and in complete compliance with your design brief.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="privacyModal-modal-body">
                    <h5>Personal Information</h5>
                    <p>When you interact with us, we automatically receive and store certain types of information, such as the content you view, the date and time that you view this content, the products you purchase, or your location information associated with your IP address. We use the information we collect to serve you more relevant advertisements (referred to as "Retargeting"). This is statistical information used to monitor the usage of our website and for advertising purposes. This information does not include personal information. a) Personally Identifiable Information: {{ $_getInvoiceData->brands->name }} Consulting will not rent or sell your personally identifiable information to others. We may store personal information in locations outside the direct control of {{ $_getInvoiceData->brands->name }} Consulting (for instance on servers or databases co-located with hosting providers). Any personally identifiable information you elect to make publicly available on our sites, such as posting comments on our blog page, will be available to others. If you remove information that you have made public on our site, copies may remain viewable in cached and archived pages of our site, or if other users have copied or saved that information. Our blog is managed by a third party application that may require you to register to post a comment. We do not have access or control of the information posted on the blog. You will need to contact or login into the third party application if you want the personal information that was posted to the comments section removed. To learn how the third party application uses your information, please visit their privacy policy. All personal information used within our contact form will be used by the internal team at {{ $_getInvoiceData->brands->name }} for communication purposes. b) Non-Personally Identifiable Information: Non-Personally Identifiable Information: We may share non-personally identifiable information (such as anonymous usage data, referring/exit pages and URLs, platform types, number of clicks, etc,) with interested third parties to help them understand the usage patterns for certain {{ $_getInvoiceData->brands->name }} Consulting services.</p>
                    <h5>Cookies</h5>
                    <p>As you browse {{ $_getInvoiceData->brands->name }}, advertising cookies will be placed on your computer so that we can understand what you are interested in. Our display advertising partner, then enables us to present you with retargeting advertising on other sites based on your previous interaction with {{ $_getInvoiceData->brands->name }}. The techniques our partners employ do not collect personal information such as your name, email address, postal address or telephone number. You can visit this page to opt out of Ad Roll and their partners’ targeted advertising.</p>
                    <h5>Security</h5>
                    <p>We implement a secure processing server on our site when collecting information to ensure a high level of security for your personal information entered such as bank details and credit card information.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <script src="{{ asset('js/country-states.js') }}"></script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            CollectJS.configure({
                'callback': function (response) {
                    $('#payment_token').val(response.token);
                    console.log(response.token);
                    $('#card-form').submit();
                },
                'validationCallback' : function(field, status, message) {
                    if (status) {
                        $('.'+field+'-error').removeClass('alert alert-danger');
                        $('.'+field+'-error').text('');
                    } else {
                        $('.'+field+'-error').addClass('alert alert-danger');
                        $('.'+field+'-error').text(message);
                    }
                },
                variant: 'inline',
                invalidCss: {
                    'color': '#B40E3E',
                    'background-color': '#ff00003d'
                },
                validCss: {
                    color: '#14855F'
                },
                customCss: {
                    'border': '1px solid #dcdcdc',
                    'padding': '8px 15px',
                    'font-size': '16px',
                    'line-height': '1.5',
                    'color': '#495057',
                    'height': '42px',
                    'border-radius': '3px',
                    'margin-bottom': '15px',
                    'font-family': 'Raleway !important'
                },
                focusCss: {
                    'border-color': '#80bdff',
                    'box-shadow' : '0 0 0 0.2rem rgba(0,123,255,.25)'
                }
            });
        });
    </script> --}}
    <script type="text/javascript">
    
        $('input[name=agree]').click(function(){
            if($(this).prop('checked')){
                $('#payButton').prop("disabled", false);
            }else{
                $('#payButton').prop("disabled", true);
            }
        });

   </script>
   <script>
    // user country code for selected option
    let user_country_code = "US";

    (function () {

        // Get the country name and state name from the imported script.
        let country_list = country_and_states['country'];
        let states_list = country_and_states['states'];

        // creating country name drop-down
        let option =  '';
        option += '<option>select country</option>';
        for(let country_code in country_list){
            // set selected option user country
            let selected = (country_code == user_country_code) ? ' selected' : '';
            option += '<option value="'+country_code+'"'+selected+'>'+country_list[country_code]+'</option>';
        }
        document.getElementById('country').innerHTML = option;

        // creating states name drop-down
        let text_box = '<input type="text" class="input-text" id="state">';
        let state_code_id = document.getElementById("state-code");

        function create_states_dropdown() {
            // get selected country code
            let country_code = document.getElementById("country").value;
            let states = states_list[country_code];
            // invalid country code or no states add textbox
            if(!states){
                state_code_id.innerHTML = text_box;
                return;
            }
            let option = '';
            if (states.length > 0) {
                option = '<select id="state" name="set_state">\n';
                for (let i = 0; i < states.length; i++) {
                    option += '<option value="'+states[i].code+'">'+states[i].name+'</option>';
                }
                option += '</select>';
            } else {
                // create input textbox if no states 
                option = text_box
            }
            state_code_id.innerHTML = option;
        }

        // country select change event
        const country_select = document.getElementById("country");
        country_select.addEventListener('change', create_states_dropdown);

        create_states_dropdown();
    })();

    $('.read-terms').click(function(){
        $('#exampleModal').modal('show');
    })

</script>
</body>
</html>
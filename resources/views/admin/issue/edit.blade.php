@extends('layouts.app-admin')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="{{ asset('newglobal/css/image-uploader.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .ul-widget2__username {
        font-size: 0.8rem;
    }

    button.write-message {
        margin-bottom: 30px;
    }

    .ul-widget3-body p {
        margin-bottom: 4px;
    }

    .loader {
        text-align: center;
        display: none;
    }

    .loader img {
        width: 30px;
    }
</style>
@endpush
@section('content')

<div class="breadcrumb">
    <h1></h1>
    <ul>
        <li><a href="#">Tickets</a></li>
        <li>Edit Issue Reporting Ticket</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <form action="/admin/update/ticket/{{ $issue->id }}" method="POST" id="ticket-form" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-4 form-group mb-3">
                            <label for="brand">Select Brand <span>*</span></label>
                            <select class="form-control select2" name="brand" id="brand">
                                <option value="" disabled>Select Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $issue->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="agent-name-wrapper">Sale Agent: <span>*</span></label>
                            <select name="user_id[]" id="agent-name-wrapper" class="form-control select2" required multiple="multiple">
                                <option value="" disabled>Select Agent</option>
                                @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ in_array($agent->id, json_decode($issue->user_id, true)) ? 'selected' : '' }}>{{ $agent->name }} {{ $agent->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="client-name-wrapper">Sale Client: <span>*</span></label>
                            <select name="client_id" id="client-name-wrapper" class="form-control" required>
                                <option value="" disabled>Select Client</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $issue->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }} {{ $client->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 form-group text-center">
                            <label style="font-size: 15px;font-weight: bold;">Checkmark Issues</label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: bold;" for="">Product/Deliverables Issues</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="deliverable[]" class="form-check-input" id="p1" style="margin-top: 0.2rem;" value="Product/Deliverables Issue/Wrong" {{ in_array('Product/Deliverables Issue/Wrong', json_decode($issue->issue, true)['deliverable'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="p1">Product/Deliverables Issue/Wrong</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="deliverable[]" class="form-check-input" id="p2" value="Product not as described/agreed" style="margin-top: 0.2rem;" {{ in_array('Product not as described/agreed', json_decode($issue->issue, true)['deliverable'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="p2">Product not as described/agreed</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: bold;" for="">Agent-Related Issues</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="agent_related[]" class="form-check-input" id="a1" value="Agent Issue/Misbehavior/Fraud attempt/Manipulation/Threat" style="margin-top: 0.2rem;" {{ in_array('Agent Issue/Misbehavior/Fraud attempt/Manipulation/Threat', json_decode($issue->issue, true)['agent_related'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="a1">Agent Issue/Misbehavior/Fraud attempt/Manipulation/Threat</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="agent_related[]" class="form-check-input" value="Agent pretending to be from another entity/organization" id="a2" style="margin-top: 0.2rem;" {{ in_array('Agent pretending to be from another entity/organization', json_decode($issue->issue, true)['agent_related'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="a2">Agent pretending to be from another entity/organization</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: bold;" for="">Deliverables and Production Issues</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="production_related[]" value="Deliverables Issue" class="form-check-input" id="d1" style="margin-top: 0.2rem;" {{ in_array('Deliverables Issue', json_decode($issue->issue, true)['production_related'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="d1">Deliverables Issue</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="production_related[]" value="Printed Copies +100" class="form-check-input" id="d2" style="margin-top: 0.2rem;" {{ in_array('Printed Copies +100', json_decode($issue->issue, true)['production_related'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="d2">Printed Copies +100</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: bold;" for="">Communication Issues</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="communication[]" class="form-check-input" id="c1" style="margin-top: 0.2rem;" value="Descriptor not communicated" {{ in_array('Descriptor not communicated', json_decode($issue->issue, true)['communication'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="c1">Descriptor not communicated</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="communication[]" class="form-check-input" id="c2" value="Upsell attempted, Customer not Interested" style="margin-top: 0.2rem;" {{ in_array('Upsell attempted, Customer not Interested', json_decode($issue->issue, true)['communication'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="c2">Upsell attempted, Customer not Interested</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="communication[]" value="Wrong TAT communicated/committed" class="form-check-input" id="c3" style="margin-top: 0.2rem;" {{ in_array('Wrong TAT communicated/committed', json_decode($issue->issue, true)['communication'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="c3">Wrong TAT communicated/committed</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="communication[]" class="form-check-input" value="Package details are not shared via email" id="c4" style="margin-top: 0.2rem;" {{ in_array('Package details are not shared via email', json_decode($issue->issue, true)['communication'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="c4">Package details are not shared via email</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="communication[]" value="No communication found" class="form-check-input" id="c5" style="margin-top: 0.2rem;" {{ in_array('No communication found', json_decode($issue->issue, true)['communication'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="c5">No communication found</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: bold;" for="">Customer Refund or Legal Issues</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="customer_legal[]" value="Chargeback/Refund/Legal threat" class="form-check-input" id="r1" style="margin-top: 0.2rem;" {{ in_array('Chargeback/Refund/Legal threat', json_decode($issue->issue, true)['customer_legal'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="r1">Chargeback/Refund/Legal threat</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="customer_legal[]" value="Customer asking for Refund" class="form-check-input" id="r2" style="margin-top: 0.2rem;" {{ in_array('Customer asking for Refund', json_decode($issue->issue, true)['customer_legal'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="r2">Customer asking for Refund</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="customer_legal[]" value="Chargeback/payment dispute Process guided to the customer" class="form-check-input" id="r3" style="margin-top: 0.2rem;" {{ in_array('Chargeback/payment dispute Process guided to the customer', json_decode($issue->issue, true)['customer_legal'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="r3">Chargeback/payment dispute Process guided to the customer</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="customer_legal[]" value="Customer has potential for chargeback" class="form-check-input" id="r4" style="margin-top: 0.2rem;" {{ in_array('Customer has potential for chargeback', json_decode($issue->issue, true)['customer_legal'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="r4">Customer has potential for chargeback</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: bold;" for="">Service Delivery Issues</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="service_delivery[]" value="Delay in service delivery/deliverables" class="form-check-input" id="s1" style="margin-top: 0.2rem;" {{ in_array('Delay in service delivery/deliverables', json_decode($issue->issue, true)['service_delivery'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="s1">Delay in service delivery/deliverables</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="service_delivery[]" value="Forced/Unauthorized Sale or payment charged" class="form-check-input" id="s2" style="margin-top: 0.2rem;" {{ in_array('Forced/Unauthorized Sale or payment charged', json_decode($issue->issue, true)['service_delivery'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="s2">Forced/Unauthorized Sale or payment charged</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="service_delivery[]" value="Dissatisfied With Services" class="form-check-input" id="s3" style="margin-top: 0.2rem;" {{ in_array('Dissatisfied With Services', json_decode($issue->issue, true)['service_delivery'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="s3">Dissatisfied With Services</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="service_delivery[]" value="100% Refund committed to contract" class="form-check-input" id="s4" style="margin-top: 0.2rem;" {{ in_array('100% Refund committed to contract', json_decode($issue->issue, true)['service_delivery'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="s4">100% Refund committed to contract</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: bold;" for="">Operational Issues</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="operational[]" value="Customer not created" class="form-check-input" id="o1" style="margin-top: 0.2rem;" {{ in_array('Customer not created', json_decode($issue->issue, true)['operational'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="o1">Customer not created</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="operational[]" value="Task not Created" class="form-check-input" id="o2" style="margin-top: 0.2rem;" {{ in_array('Task not Created', json_decode($issue->issue, true)['operational'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="o2">Task not Created</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="operational[]" value="Project not created" class="form-check-input" id="o3" style="margin-top: 0.2rem;" {{ in_array('Project not created', json_decode($issue->issue, true)['operational'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="o3">Project not created</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="operational[]" value="Task Pending" class="form-check-input" id="o4" style="margin-top: 0.2rem;" {{ in_array('Task Pending', json_decode($issue->issue, true)['operational'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="o4">Task Pending</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: bold;" for="">Special Case Issues</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="special_case[]" value="Fraud Client (previously had CB/Refund history)" class="form-check-input" id="i1" style="margin-top: 0.2rem;" {{ in_array('Fraud Client (previously had CB/Refund history)', json_decode($issue->issue, true)['special_case'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="i1">Fraud Client (previously had CB/Refund history)</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="special_case[]" value="Skeptical Client/Dissatisfied customer" class="form-check-input" id="i2" style="margin-top: 0.2rem;" {{ in_array('Skeptical Client/Dissatisfied customer', json_decode($issue->issue, true)['special_case'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="i2">Skeptical Client/Dissatisfied customer</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="special_case[]" value="ROI Commitment" class="form-check-input" id="i3" style="margin-top: 0.2rem;" {{ in_array('ROI Commitment', json_decode($issue->issue, true)['special_case'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="i3">ROI Commitment</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="special_case[]" value="Barnes & Nobles/Physical Book Store Sales" class="form-check-input" id="i4" style="margin-top: 0.2rem;" {{ in_array('Barnes & Nobles/Physical Book Store Sales', json_decode($issue->issue, true)['special_case'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="i4">Barnes & Nobles/Physical Book Store Sales</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="special_case[]" value="Amazon Affiliation" class="form-check-input" id="i5" style="margin-top: 0.2rem;" {{ in_array('Amazon Affiliation', json_decode($issue->issue, true)['special_case'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="i5">Amazon Affiliation</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: bold;" for="">Financial Issues</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="financial[]" value="Undercharged Product" class="form-check-input" id="f1" style="margin-top: 0.2rem;" {{ in_array('Undercharged Product', json_decode($issue->issue, true)['financial'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="f1">Undercharged Product</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="financial[]" value="Conflicting amount" class="form-check-input" id="f2" style="margin-top: 0.2rem;" {{ in_array('Conflicting amount', json_decode($issue->issue, true)['financial'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="f2">Conflicting amount</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="financial[]" value="Payment Debit/Credit Card Blocked" class="form-check-input" id="f3" style="margin-top: 0.2rem;" {{ in_array('Payment Debit/Credit Card Blocked', json_decode($issue->issue, true)['financial'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="f3">Payment Debit/Credit Card Blocked</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: bold;" for="">Verification and Quality Assurance</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="qa_varified" value="QA Verified" class="form-check-input" id="v1" style="margin-top: 0.2rem;" {{ json_decode($issue->issue, true)['qa_varified'] == 'QA Verified' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="v1">QA Verified</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="level">Security Level <span>*</span></label>
                            <select name="level" class="form-control" required>
                                <option value="" disabled>Select Security Level</option>
                                <option value="Low" style="color: #fff;" class="bg-default" {{ $issue->level == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="High" style="color: #fff;" class="bg-warning" {{ $issue->level == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Critical" style="color: #fff;" class="bg-danger" {{ $issue->level == 'Critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="status">Status <span>*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="" disabled>Select Status</option>
                                <option value="Open" style="color: #fff;" class="bg-danger" {{ $issue->status == 'Open' ? 'selected' : '' }}>Open</option>
                                <option value="In Progress" style="color: #fff;" class="bg-warning" {{ $issue->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Closed" style="color: #fff;" class="bg-success" {{ $issue->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <div class="d-flex align-items-end">
                                <div class="chat-wrapper">
                                    <div class="dropzone" id="my-awesome-dropzone"></div>
                                    <p class="message" contenteditable="true">{{ $issue->description }}</p>
                                </div>
                                <button class="btn btn-icon btn-rounded me-2 btn-outline-primary add-file-dropzone" type="button">
                                    <i class="i-Add-File"></i>
                                </button>
                                <button class="btn btn-icon btn-rounded btn-primary btn-send-message" type="submit">
                                    Update
                                    <div class="loader-img">
                                        <img src="{{ asset('newglobal/images/loader.gif') }}" alt="Loading">
                                    </div>
                                </button>
                            </div>
                            <input type="hidden" name="fileData" id="fileData">
                            <input type="hidden" name="description" id="description">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js" integrity="sha512-OF6VwfoBrM/wE3gt0I/lTh1ElROdq3etwAquhEm2YI45Um4ird+0ZFX1IwuBDBRufdXBuYoBb0mqXrmUA2VnOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('newglobal/js/image-uploader.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var file_array = [];

    $(document).ready(function() {
        $('#brand').on('change', function() {
            var brand = $(this).val();
            getBrandUsers(brand);
        });
    });

    function getBrandUsers(brand_id) {
        $('#agent-name-wrapper').html('<option value="" disabled>Select Agent</option>');
        if (brand_id) {
            $.ajax({
                type: 'GET',
                url: '/admin/get/brand/users',
                data: {
                    brand_id: brand_id
                },
                success: function(data) {
                    var getData = data.data;
                    for (var i = 0; i < getData.length; i++) {
                        var fullName = getData[i].name + ' ' + getData[i].last_name;
                        var role = getData[i].is_employee == 6 ? 'Sale Manager' : 'Sale Agent';
                        $('#agent-name-wrapper').append('<option ' + (getData[i].is_employee == 6 ? 'class="text-danger"' : 'style="color: #0F9ABB"') + ' value="' + getData[i].id + '">' + fullName + ' (' + role + ')</option>');
                    }
                    var getClient = data.client;
                    for (var i = 0; i < getClient.length; i++) {
                        var fullName = getClient[i].name + ' ' + getClient[i].last_name;
                        $('#client-name-wrapper').append('<option value="' + getClient[i].id + '">' + fullName + '</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    }

    var $ = window.$; // use the global jQuery instance

    if ($("#my-awesome-dropzone").length > 0) {
        var token = $('input[name=_token]').val();

        // A quick way setup
        var myDropzone = new Dropzone("#my-awesome-dropzone", {
            // Setup chunking
            chunking: true,
            method: "POST",
            maxFilesize: 1000000000,
            chunkSize: 5000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            url: "{{ route('admin.send.chunks') }}"
        });

        var $list = $('#file-upload-list');

        myDropzone.on('sending', function(file, xhr, formData) {
            formData.append("_token", token);
            formData.append("client_id", $('#client_id').val());
            formData.append("message", $("input[name='message']").val());
            var dropzoneOnLoad = xhr.onload;
            xhr.onload = function(e) {
                dropzoneOnLoad(e)
                var uploadResponse = JSON.parse(xhr.responseText);
                if (typeof uploadResponse.name === 'string') {
                    $('.btn-generate').removeAttr('disabled', 'disabled');
                    file_array.push(uploadResponse);
                    $('#fileData').val(JSON.stringify(file_array));
                    $list.html('<li>Uploaded Successfully</li>');
                }
            }
        })

        // Process the query when file is added to the input
        $('input[name=file]').on('change', function() {
            if (typeof this.files[0] === 'object') {
                myDropzone.addFile(this.files[0]);
            }
        });

        myDropzone.on('addedfile', function() {
            $('.btn-generate').attr('disabled', 'disabled');
            $list.append('<li>Uploading</li>')
        })
    }

    $('.add-file-dropzone').click(function() {
        document.getElementsByClassName("dropzone")[0].click();
    });

    $('#ticket-form').on('input', '.message', function() {
        $('#description').val($(this).text());
    });
</script>

@endpush
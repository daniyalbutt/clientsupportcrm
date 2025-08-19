@extends('layouts.app-leads-dashboard')
@section('content')

<link href="{{ asset('leadsglobal/libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet"
    type="text/css" />

<!-- preloader css -->
<link rel="stylesheet" href="{{ asset('leadsglobal/css/preloader.min.css') }}" type="text/css" />
<style>
#data_table tbody tr td {
    text-transform: capitalize;
    font-size: 10px;
}

.focus-btn-group{
    display: none !important;
}

#add_lead_btn,
#search_lead_btn {
    display: inline-block !important;
}
.table > :not(caption) > * > *{
    padding: .45rem .45rem .45rem .45rem !important;
}
</style>
@php
function coverDateTime($datetime){
$input = $datetime;
$timestamp = strtotime($input);

return date('d/m/Y h:i:s A', $timestamp);
}
@endphp

<div class="container-fluid">
    <div class="row" id="add-lead-div" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Missing Data</h4>
                    <p class="card-title-desc">
                        Please add a refrence phone, email or transaction ID to attach to the related data.
                    </p>
                </div>
                <div class="card-body">
                    <form class="needs-validation" method="post" action="{{ route('admin.leads.store') }}"
                        style="background: #80808040;padding: 15px;border-radius: 15px;">
                        @csrf
                        <div class="row">
                            <div class="col-md-4" style="display: none;">
                                <div class="mb-3">
                                    @php
                                    $lead_no = random_int(100000, 999999);
                                    @endphp
                                    <label class="form-label" for="validationCustom01">Lead#</label>
                                    <input type="text" class="form-control" id="validationCustom01" name="lead_no"
                                        placeholder="First name" value="Lead# {{$lead_no}}" readonly>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Full Name" value="">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                    <div class="invalid-feedback">
                                        Please provide a valid Email.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone">
                                    <div class="invalid-feedback">
                                        Please provide a valid Phone.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="brand_id">Brand</label>
                                    <select class="form-control" name="brand_id" style="display: block !important;">
                                        <option value="" selected>Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a valid Brand.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="transaction_id">Transaction ID</label>
                                    <input type="text" class="form-control" name="transaction_id"
                                        placeholder="Transaction ID (23123123232)">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update Missing Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row" id="search-div" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Search Data
                    </h4>
                </div>
                <div class="card-body">
                    <form id="searchForm">
                        <div class="row">
                            <div class="col-md-4 p-2">
                                <label for="transaction_id">Transactions Search</label>
                                <input class="form-control" type="text" id="transaction_id" name="transaction_id"
                            placeholder="Search by Transaction ID">
                            </div>
                            <div class="col-md-4 p-2">
                                <label for="search_phone">Transactions Search</label>
                                <input class="form-control" type="text" id="search_phone" name="search_phone" placeholder="Search by Phone">
                            </div>
                            <div class="col-md-4 p-2">
                                <label for="search_email">Transactions Search</label>
                                <input class="form-control" type="text" id="search_email" name="search_email" placeholder="Search by Email">
                            </div>
                            <div class="col-md-4 p-2">
                                <label for="amount">Transactions Search</label>
                                <input class="form-control" type="text" id="amount" name="amount" placeholder="Search by Amount">
                            </div>
                             <div class="col-md-4 p-2">
                                <label for="invoice_number">Invoice Search</label>
                                <input class="form-control" type="text" id="invoice_number" name="invoice_number"
                            placeholder="Search by Invoice Number">
                            </div>
                            <div class="col-md-4 p-2">
                                <label for="brand">Invoice Search</label>
                                <select class="form-control" id="brand" name="brand" style="display: block !important;">
                                    <option value="" selected>All Brands</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 p-2">
                                <label for="search_date_from">Transactions Search</label>
                                <input class="form-control" type="date" id="search_date_from" name="search_date_from"
                            placeholder="Search by Date From">
                            </div>
                            <div class="col-md-4 p-2">
                                <style>
                                    #status{
                                        display: block !important;
                                    }
                                </style>
                                <label for="status">Transactions Search</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="" selected>Any Status</option>
                                    <option value="settledSuccessfully">settledSuccessfully</option>
                                    <option value="refundSettledSuccessfully">refundSettledSuccessfully</option>
                                </select>
                            </div>
                            <div class="col-md-4 p-2">
                            <button class="btn btn-primary" type="button" id="search_button">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Bank</h4>
                    <div class="float-right" style="display: block !important;float: right;margin-top: -31px;">
                        <button class="btn btn-success" id="add_lead_btn">Add Missing Data</button>
                        <button class="btn btn-secondary" id="search_lead_btn">Search Data</button>
                    </div>
                </div>
                <div class="card-body" style="padding: 5px !important;">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="data_table" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Transactions</th>
                                        <th>Invoices</th>
                                        <th>Call Logs</th>
                                        <th>Brand Forms</th>
                                        <th>Chat Logs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mergedData as $data)
                                    {{-- @php
                                        dd($data);
                                    @endphp --}}
                                    <tr>
                                        <!-- Transactions Column -->
                                        <td style="overflow-wrap: anywhere;background: #1212;font-weight: bolder;">
                                            <p class="copy-text" style="display: none;">{{ $data['transaction']->transaction_id }}</p>
                                            <span style="display: flex;justify-content: center;" class="copy-btn-transaction btn btn-sm btn-secondary"><strong>ID:</strong>
                                                {{ $data['transaction']->transaction_id }} &nbsp;<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" x="0" y="0" viewBox="0 0 699.428 699.428" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M502.714 0H240.428C194.178 0 153 42.425 153 87.429l-25.267.59c-46.228 0-84.019 41.834-84.019 86.838V612c0 45.004 41.179 87.428 87.429 87.428H459c46.249 0 87.428-42.424 87.428-87.428h21.857c46.25 0 87.429-42.424 87.429-87.428v-349.19L502.714 0zM459 655.715H131.143c-22.95 0-43.714-21.441-43.714-43.715V174.857c0-22.272 18.688-42.993 41.638-42.993l23.933-.721v393.429C153 569.576 194.178 612 240.428 612h262.286c0 22.273-20.765 43.715-43.714 43.715zm153-131.143c0 22.271-20.765 43.713-43.715 43.713H240.428c-22.95 0-43.714-21.441-43.714-43.713V87.429c0-22.272 20.764-43.714 43.714-43.714H459c-.351 50.337 0 87.975 0 87.975 0 45.419 40.872 86.882 87.428 86.882H612v306zm-65.572-349.715c-23.277 0-43.714-42.293-43.714-64.981V44.348L612 174.857h-65.572zm-43.714 131.537H306c-12.065 0-21.857 9.77-21.857 21.835 0 12.065 9.792 21.835 21.857 21.835h196.714c12.065 0 21.857-9.771 21.857-21.835 0-12.065-9.792-21.835-21.857-21.835zm0 109.176H306c-12.065 0-21.857 9.77-21.857 21.834 0 12.066 9.792 21.836 21.857 21.836h196.714c12.065 0 21.857-9.77 21.857-21.836 0-12.064-9.792-21.834-21.857-21.834z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg></span>
                                            <ul style="padding-left: 15px;list-style: disclosure-open;">
                                                <li class="pt-2">
                                                    <strong>Amount:</strong> ${{ $data['transaction']->amount }}
                                                </li>
                                                <li>
                                                    <strong>Name:</strong> {{ $data['transaction']->name }}
                                                </li>
                                                <li>
                                                    <strong>Email:</strong> {{ $data['transaction']->email }}
                                                </li>
                                                <li class="pb-2">
                                                    <strong>Phone:</strong> {{ $data['transaction']->phone }}
                                                </li>
                                                <li>
                                                    <strong>Company:</strong><span style="color: #d81717;">{{ $data['transaction']->table_name }}</span>
                                                </li>
                                                <li>
                                                    <strong>Status:</strong> {{ $data['transaction']->status }}
                                                </li>
                                                <li>
                                                    <strong>Date:</strong>
                                                    {{ $data['transaction']->payment_date }}
                                                </li>
                                            </ul>
                                            <a href="{{ route('data-bank.details', ['contact' => $data['transaction']->phone]) }}" class="btn btn-sm btn-warning more-detail" style="display: flex;justify-content: center;">More Details</a>
                                        </td>

                                        <!-- Invoices Column -->
                                        @if ($data['invoice'])
                                        <td
                                            style="overflow-wrap: anywhere;background: #4fa843b8;font-weight: 450;color: #fff;">
                                            <p class="copy-text-invoice" style="display: none;">{{ $data['invoice']->invoice_number }}</p>
                                            <span class="copy-btn-invoice btn btn-sm btn-danger" style="display: flex;justify-content: center;"><strong>Invoice No:</strong>
                                                {{ $data['invoice']->invoice_number }}  &nbsp;<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" x="0" y="0" viewBox="0 0 699.428 699.428" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M502.714 0H240.428C194.178 0 153 42.425 153 87.429l-25.267.59c-46.228 0-84.019 41.834-84.019 86.838V612c0 45.004 41.179 87.428 87.429 87.428H459c46.249 0 87.428-42.424 87.428-87.428h21.857c46.25 0 87.429-42.424 87.429-87.428v-349.19L502.714 0zM459 655.715H131.143c-22.95 0-43.714-21.441-43.714-43.715V174.857c0-22.272 18.688-42.993 41.638-42.993l23.933-.721v393.429C153 569.576 194.178 612 240.428 612h262.286c0 22.273-20.765 43.715-43.714 43.715zm153-131.143c0 22.271-20.765 43.713-43.715 43.713H240.428c-22.95 0-43.714-21.441-43.714-43.713V87.429c0-22.272 20.764-43.714 43.714-43.714H459c-.351 50.337 0 87.975 0 87.975 0 45.419 40.872 86.882 87.428 86.882H612v306zm-65.572-349.715c-23.277 0-43.714-42.293-43.714-64.981V44.348L612 174.857h-65.572zm-43.714 131.537H306c-12.065 0-21.857 9.77-21.857 21.835 0 12.065 9.792 21.835 21.857 21.835h196.714c12.065 0 21.857-9.771 21.857-21.835 0-12.065-9.792-21.835-21.857-21.835zm0 109.176H306c-12.065 0-21.857 9.77-21.857 21.834 0 12.066 9.792 21.836 21.857 21.836h196.714c12.065 0 21.857-9.77 21.857-21.836 0-12.064-9.792-21.834-21.857-21.834z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg></span>
                                            <ul style="padding-left: 15px;list-style: disclosure-open;">
                                                <li class="pt-2">
                                                    <strong>Amount:</strong> ${{ $data['invoice']->amount }}
                                                </li>
                                                <li>
                                                    <strong>Email:</strong> {{ $data['invoice']->email }}
                                                </li>
                                                <li>
                                                    <strong>Phone:</strong> {{ $data['invoice']->contact }}
                                                </li>
                                                <li class="pt-2">
                                                    <strong>Brand:</strong> <span
                                                        class="text-dark fw-bold">{{ isset($data['invoice']->brand_name) ? $data['invoice']->brand_name : 'No Brand Attached' }}</span>
                                                </li>
                                                <li>
                                                    <strong>Created At:</strong>
                                                    {{ coverDateTime($data['invoice']->created_at) }}
                                                </li>
                                            </ul>
                                        </td>
                                        @else
                                        <td
                                            style="overflow-wrap: anywhere;background: white;font-weight: 450;color: #000;">
                                            No Data
                                        </td>
                                        @endif

                                        <!-- Call Logs Column -->
                                        @if ($data['call_log'])
                                        <td
                                            style="overflow-wrap: anywhere;background: #599de1b2;font-weight: 450;color: #fff;">
                                            <span class="btn btn-sm btn-dark" style="display: flex;justify-content: center;"><strong>Direction:</strong>
                                                {{ $data['call_log']->direction }} </span>
                                            <ul style="padding-left: 15px;list-style: disclosure-open;">
                                                <li class="pt-2">
                                                    <strong>To:</strong> <span
                                                        class="text-dark fw-bold">{{ $data['call_log']->cld }} </span>
                                                </li>
                                                <li>
                                                    <strong>From:</strong> <span
                                                        class="text-dark fw-bold">{{ $data['call_log']->cli }} </span>
                                                </li>
                                                <li>
                                                    <strong>Duration:</strong>
                                                    {{ gmdate("H:i:s", $data['call_log']->call_sec) }}
                                                </li>
                                                <li class="pt-2">
                                                    <strong>Started At:</strong>
                                                    {{ coverDateTime($data['call_log']->started_at) }}
                                                </li>
                                                <li>
                                                    <strong>Finished At:</strong>
                                                    {{ coverDateTime($data['call_log']->finished_at) }}
                                                </li>
                                            </ul>
                                        </td>
                                        @else
                                        <td
                                            style="overflow-wrap: anywhere;background: white;font-weight: 450;color: #000;">
                                            No Data
                                        </td>
                                        @endif

                                        <!-- Brand Leads Column -->
                                        @if ($data['brand_form'])
                                        <td
                                            style="overflow-wrap: anywhere;background: #125ea2ab;color: #fff;font-weight: 450;">
                                            <span class="btn btn-sm btn-success" style="display: flex;justify-content: center;"><strong>Brand:</strong>
                                                {{ $data['brand_form']->brand_name }} </span>
                                            <ul style="padding-left: 15px;list-style: disclosure-open;">
                                                <li class="pt-2">
                                                    <strong>Name:</strong> {{ $data['brand_form']->name }}
                                                </li>
                                                <li>
                                                    <strong>Email:</strong> {{ $data['brand_form']->email }}
                                                </li>
                                                <li>
                                                    <strong>Phone:</strong> {{ $data['brand_form']->phone }}
                                                </li>
                                                <li class="pt-2">
                                                    <strong>Created At:</strong>
                                                    {{ coverDateTime($data['brand_form']->created_at) }}
                                                </li>
                                            </ul>
                                        </td>
                                        @else
                                        <td
                                            style="overflow-wrap: anywhere;background: white;font-weight: 450;color: #000;">
                                            No Data
                                        </td>
                                        @endif

                                        <!-- Marketing Chat Dumps Column -->
                                        @if ($data['marketing_chat'])
                                        <td
                                            style="overflow-wrap: anywhere;background:rgba(230, 132, 5, 0.67);color: #fff;font-weight: 450;">
                                            <span class="btn btn-sm btn-success" style="display: flex;justify-content: center;"><strong>Agent:</strong>
                                                {{ $data['marketing_chat']->agent_names }} </span>
                                                <ul style="padding-left: 15px;list-style: disclosure-open;">
                                                    <li class="pt-2">
                                                        <strong>Visitor:</strong> {{ $data['marketing_chat']->visitor_name }}
                                                    </li>
                                                    <li>
                                                        <strong>Email:</strong> {{ $data['marketing_chat']->visitor_email }}
                                                    </li>
                                                    <li>
                                                        <strong>Duration:</strong>
                                                        {{ gmdate("H:i:s", intval($data['marketing_chat']->duration)) }}
                                                    </li>
                                                    <li>
                                                        <strong>Source:</strong>
                                                        Marketing Notch
                                                    </li>
                                                </ul>
                                        </td>
                                        @elseif ($data['designnes_chat'])
                                        <td
                                            style="overflow-wrap: anywhere;background:rgba(17, 17, 16, 0.67);color: #fff;font-weight: 450;">
                                            <span class="btn btn-sm btn-success" style="display: flex;justify-content: center;"><strong>Agent:</strong>
                                                {{ $data['designnes_chat']->agent_names }} </span>
                                                <ul style="padding-left: 15px;list-style: disclosure-open;">
                                                    <li class="pt-2">
                                                        <strong>Visitor:</strong> {{ $data['designnes_chat']->visitor_name }}
                                                    </li>
                                                    <li>
                                                        <strong>Email:</strong> {{ $data['designnes_chat']->visitor_email }}
                                                    </li>
                                                    <li>
                                                        <strong>Duration:</strong>
                                                        {{ gmdate("H:i:s", intval($data['designnes_chat']->duration)) }}
                                                    </li>
                                                    <li>
                                                        <strong>Source:</strong>
                                                        Designness
                                                    </li>
                                                </ul>
                                        </td>
                                        @else
                                        <td
                                            style="overflow-wrap: anywhere;background: white;font-weight: 450;color: #000;">
                                            No Data
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="ajax-loading" style="display: flex;justify-content: center;"><img style="width: 5%;padding: 10px;" src="{{ asset('newglobal/images/loader.gif') }}" /></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>
@endsection
@push('scripts')
<!-- Responsive Table js -->
<script src="{{ asset('leadsglobal/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
<!-- Init js -->
<script src="{{ asset('leadsglobal/js/pages/table-responsive.init.js') }}"></script>
<!-- pristine js -->
<script src="{{ asset('leadsglobal/libs/pristinejs/pristine.min.js') }}"></script>
<!-- form validation -->
<script src="{{ asset('leadsglobal/js/pages/form-validation.init.js') }}"></script>
<script>
var SITEURL = "{{ url('/') }}";
var page = 1; // Start from page 1
var searchParams = ""; // Store search query

$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 1) {
        page++;
        load_more(page, searchParams); // Pass search parameters
    }
});

function load_more(page, searchParams = "") {
    $.ajax({
            url: SITEURL + "/admin/dataBank?" + searchParams + '&page=' + page,
            type: "get",
            datatype: "html",
            beforeSend: function() {
                $('.ajax-loading').show();
            }
        })
        .done(function(data) {
            if (data.length == 0) {
                $('.ajax-loading').html("No more records!");
                return;
            }
            $('.ajax-loading').hide();
            $("#data_table tbody").append(data);
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });
}

$(document).ready(function() {
    $('#search_button').on('click', function() {
        page = 1; // Reset page number on new search

        let data = {
            search_phone: $('#search_phone').val(),
            search_brand: $('#brand').val(),
            search_email: $('#search_email').val(),
            search_invoice: $('#invoice_number').val(),
            search_transaction: $('#transaction_id').val(),
            search_amount: $('#amount').val(),
            search_date_from: $('#search_date_from').val(),
            search_status: $('#status').val()
        };

        searchParams = $.param(data); // Convert object to query string

        $.ajax({
            url: "/admin/dataBank",
            method: "GET",
            data: data,
            success: function(response) {
                $("#data_table tbody").empty();
                $("#data_table tbody").html(response);
                history.pushState(null, '', "/admin/dataBank?" + searchParams); // Update URL
            },
            error: function() {
                alert("Error fetching search results.");
            }
        });
    });
});
</script>

<script>
    $(document).ready(function() {
        $('#add_lead_btn').on('click', function() {
            $('#add-lead-div').slideToggle();
        })
        $('#search_lead_btn').on('click', function() {
            $('#search-div').slideToggle();
        })
    });
    $(document).on("click", ".copy-btn-transaction", function() {
            // Get the associated paragraph text
            var textToCopy = $(this).siblings(".copy-text").text();

            // Create a temporary textarea
            var tempInput = $("<textarea>");
            $("body").append(tempInput);
            tempInput.val(textToCopy).select();

            // Copy to clipboard
            document.execCommand("copy");

            // Remove the temporary element
            tempInput.remove();

            // Optional: Change button text to indicate copied
            $(this).text("Copied!").prop("disabled", true);
            setTimeout(() => {
                $(this).html('<strong>ID:</strong>' + textToCopy + '&nbsp;<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" x="0" y="0" viewBox="0 0 699.428 699.428" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M502.714 0H240.428C194.178 0 153 42.425 153 87.429l-25.267.59c-46.228 0-84.019 41.834-84.019 86.838V612c0 45.004 41.179 87.428 87.429 87.428H459c46.249 0 87.428-42.424 87.428-87.428h21.857c46.25 0 87.429-42.424 87.429-87.428v-349.19L502.714 0zM459 655.715H131.143c-22.95 0-43.714-21.441-43.714-43.715V174.857c0-22.272 18.688-42.993 41.638-42.993l23.933-.721v393.429C153 569.576 194.178 612 240.428 612h262.286c0 22.273-20.765 43.715-43.714 43.715zm153-131.143c0 22.271-20.765 43.713-43.715 43.713H240.428c-22.95 0-43.714-21.441-43.714-43.713V87.429c0-22.272 20.764-43.714 43.714-43.714H459c-.351 50.337 0 87.975 0 87.975 0 45.419 40.872 86.882 87.428 86.882H612v306zm-65.572-349.715c-23.277 0-43.714-42.293-43.714-64.981V44.348L612 174.857h-65.572zm-43.714 131.537H306c-12.065 0-21.857 9.77-21.857 21.835 0 12.065 9.792 21.835 21.857 21.835h196.714c12.065 0 21.857-9.771 21.857-21.835 0-12.065-9.792-21.835-21.857-21.835zm0 109.176H306c-12.065 0-21.857 9.77-21.857 21.834 0 12.066 9.792 21.836 21.857 21.836h196.714c12.065 0 21.857-9.77 21.857-21.836 0-12.064-9.792-21.834-21.857-21.834z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg>').prop("disabled", false);
            }, 1500);
        });
        $(document).on("click", ".copy-btn-invoice", function() {
            // Get the associated paragraph text
            var textToCopy = $(this).siblings(".copy-text-invoice").text();

            // Create a temporary textarea
            var tempInput = $("<textarea>");
            $("body").append(tempInput);
            tempInput.val(textToCopy).select();

            // Copy to clipboard
            document.execCommand("copy");

            // Remove the temporary element
            tempInput.remove();

            // Optional: Change button text to indicate copied
            $(this).text("Copied!").prop("disabled", true);
            setTimeout(() => {
                $(this).html('<strong>Invoice No:</strong>' + textToCopy + '&nbsp;<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" x="0" y="0" viewBox="0 0 699.428 699.428" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M502.714 0H240.428C194.178 0 153 42.425 153 87.429l-25.267.59c-46.228 0-84.019 41.834-84.019 86.838V612c0 45.004 41.179 87.428 87.429 87.428H459c46.249 0 87.428-42.424 87.428-87.428h21.857c46.25 0 87.429-42.424 87.429-87.428v-349.19L502.714 0zM459 655.715H131.143c-22.95 0-43.714-21.441-43.714-43.715V174.857c0-22.272 18.688-42.993 41.638-42.993l23.933-.721v393.429C153 569.576 194.178 612 240.428 612h262.286c0 22.273-20.765 43.715-43.714 43.715zm153-131.143c0 22.271-20.765 43.713-43.715 43.713H240.428c-22.95 0-43.714-21.441-43.714-43.713V87.429c0-22.272 20.764-43.714 43.714-43.714H459c-.351 50.337 0 87.975 0 87.975 0 45.419 40.872 86.882 87.428 86.882H612v306zm-65.572-349.715c-23.277 0-43.714-42.293-43.714-64.981V44.348L612 174.857h-65.572zm-43.714 131.537H306c-12.065 0-21.857 9.77-21.857 21.835 0 12.065 9.792 21.835 21.857 21.835h196.714c12.065 0 21.857-9.771 21.857-21.835 0-12.065-9.792-21.835-21.857-21.835zm0 109.176H306c-12.065 0-21.857 9.77-21.857 21.834 0 12.066 9.792 21.836 21.857 21.836h196.714c12.065 0 21.857-9.77 21.857-21.836 0-12.064-9.792-21.834-21.857-21.834z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg>').prop("disabled", false);
            }, 1500);
        });
    </script>
@endpush

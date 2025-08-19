@extends('layouts.app-leads-dashboard')
@section('content')

<link href="{{ asset('leadsglobal/libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet"
    type="text/css" />

<!-- preloader css -->
<link rel="stylesheet" href="{{ asset('leadsglobal/css/preloader.min.css') }}" type="text/css" />
<style>
#tech-companies-1 tbody tr td {
    text-transform: capitalize;
    font-size: 10px;
}

.focus-btn-group,
.dropdown-btn-group {
    display: none !important;
}

#add_lead_btn,
#search_lead_btn {
    display: inline-block !important;
}
</style>
@php
function coverDateTime($datetime){
    $input = $datetime;
    $timestamp = strtotime($input);

    return date('m/d/Y h:i:s A', $timestamp);
}
@endphp
<div class="container-fluid">
    <div class="row" id="add-lead-div" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Lead</h4>
                </div>
                <div class="card-body">
                    <form class="needs-validation" method="post" action="{{ route('admin.leads.store') }}"
                        style="background: #80808040;padding: 15px;border-radius: 15px;">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    @php
                                    $lead_no = random_int(100000, 999999);
                                    @endphp
                                    <label class="form-label" for="validationCustom01">Lead#</label>
                                    <input type="text" class="form-control" id="validationCustom01" name="lead_no"
                                        placeholder="First name" value="Lead# {{$lead_no}}" required readonly>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Full Name" value="" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                        required>
                                    <div class="invalid-feedback">
                                        Please provide a valid Email.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone"
                                        required>
                                    <div class="invalid-feedback">
                                        Please provide a valid Phone.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="source">Source</label>
                                    <input type="text" class="form-control" id="source" name="source"
                                        placeholder="Source" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid Source.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="brand_id">Brand</label>
                                    <select class="form-control" id="brand_id" name="brand_id" required>
                                        <option value="" selected>Select Brand</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a valid Brand.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="lead_status">Status</label>
                                    <select class="form-control" id="lead_status" name="lead_status" required>
                                        <option value="" selected>Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Deactivated">Deactivated</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a valid Status.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Add New Lead</button>
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
                    <form id="search-form" action="/admin/leads" class="form"
                        style="background: #80808040;padding: 15px;border-radius: 15px;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoice_no">Invoice#</label>
                                    <input type="text" class="form-control" id="invoice_no" name="invoice_no"
                                        placeholder="Search Using Invoice#">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="client_name">Client Name</label>
                                    <input type="text" class="form-control" id="client_name" name="client_name"
                                        placeholder="Search Using Client Email">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="client_email">Client Email</label>
                                    <input type="text" class="form-control" id="client_email" name="client_email"
                                        placeholder="Search Using Client Email">
                                </div>
                            </div>
                            <div class="col-md-4 pt-3">
                                <div class="form-group">
                                    <label for="client_phone">Client Phone</label>
                                    <input type="text" class="form-control" id="client_phone" name="client_phone"
                                        placeholder="Search Using Client Phone#">
                                </div>
                            </div>
                            <div class="col-md-4 pt-3">
                                <div class="form-group">
                                    <label for="date_time">Date Search</label>
                                    <input type="date" class="form-control" id="date_time" name="date_time"
                                        placeholder="Search Using Client Phone#">
                                </div>
                            </div>
                            <div class="col-md-4 pt-3">
                                <div class="form-group">
                                    <label for="column_name">Column For Date Search</label>
                                    <select name="column_name" id="column_name" class="form-control">
                                        <option value="">SELECT DATA TYPE</option>
                                        <option value="invoice">Invoice</option>
                                        <option value="call_data_telnyx">Telnyx Call Log</option>
                                        <option value="call_data_ring_central">Ring Central Call Log</option>
                                        <option value="designnes_chat">Designnes Chat</option>
                                        <option value="marketing_notch_chat">Marketing Notch Chat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pt-3">
                                <div class="form-group">
                                    <label for="agent_name">Agent Name</label>
                                    <input type="text" class="form-control" id="agent_name" name="agent_name"
                                        placeholder="Search Using Agent Name">
                                </div>
                            </div>
                            <div class="col-md-4 pt-3">
                                <div class="form-group">
                                    <label for="client_ip">Client IP Address</label>
                                    <input type="text" class="form-control" id="client_ip" name="client_ip"
                                        placeholder="Search Using Client IP Address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pt-3">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" id="search-button" value="Search">
                                </div>
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
                    <h4 class="card-title">Leads</h4>
                    <div class="float-right" style="display: block !important;float: right;margin-top: -31px;">
                        <button class="btn btn-success" id="add_lead_btn">Add Lead</button>
                        <button class="btn btn-secondary" id="search_lead_btn">Search Data</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table">
                                <thead>
                                    <tr>
                                        <th data-priority="1">Details</th>
                                        <th data-priority="2">Invoice</th>
                                        <th data-priority="3">Call Log (Telnyx)</th>
                                        <th data-priority="4">Designnes Chat Dump</th>
                                        <th data-priority="5">Marketing Notch Chat Dump</th>
                                        <th data-priority="6">Web Form</th>
                                        <th>Leads Data</th>
                                    </tr>
                                </thead>
                                <tbody id="data-bank">
                                    @foreach($_data as $type => $data)
                                    <tr>
                                        <td style="background: #1212;font-weight: bolder;">
                                            Name: {{ $data['invoice']->name }}
                                            <br>
                                            Email: <span
                                                style="text-transform: lowercase;">{{ $data['invoice']->email }}</span>
                                            <br>
                                            Phone:
                                            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['invoice']->contact) ?? 'N/A' }}
                                            <br>
                                            <span class="text-danger">Brand:
                                                <b>{{ $data['invoice']->brands->name }}</b></span>
                                            <br>
                                            <a href="{{ route('leads.details', ['contact' => $data['invoice']->contact]) }}" class="btn btn-sm btn-secondary more-detail">More Details</a>
                                        </td>
                                        <td style="background: #bb7d3da6;font-weight: 450;color: #fff;">
                                            @if($data['invoice'] !== 'N/A')
                                            Invoice#: {{ $data['invoice']->invoice_number ?? 'N/A' }}
                                            <br>
                                            Amount: ${{ $data['invoice']->amount ?? 'N/A' }}
                                            <br>
                                            @if(
                                            strlen(preg_replace(
                                            '/[ \,\.\-\(\)\+\s]/',
                                            '',
                                            $data['invoice']->contact
                                            )) > 14
                                            )
                                            @php
                                            $part1 = substr(preg_replace(
                                            '/[ \,\.\-\(\)\+\s]/',
                                            '',
                                            $data['invoice']->contact
                                            ), 0, strlen(preg_replace(
                                            '/[ \,\.\-\(\)\+\s]/',
                                            '',
                                            $data['invoice']->contact
                                            )) / 2);
                                            $part2 = substr(preg_replace(
                                            '/[ \,\.\-\(\)\+\s]/',
                                            '',
                                            $data['invoice']->contact
                                            ), strlen(preg_replace(
                                            '/[ \,\.\-\(\)\+\s]/',
                                            '',
                                            $data['invoice']->contact
                                            )) / 2);
                                            @endphp
                                            Contacts:
                                            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $part1) ?? 'N/A' }}
                                            ,
                                            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $part2) ?? 'N/A' }}
                                            @else
                                            Contact:
                                            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['invoice']->contact) ?? 'N/A' }}

                                            @endif
                                            <br>
                                            Created: {{ coverDateTime($data['invoice']->created_at) ?? 'N/A' }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td style="background: #4fa843b8;font-weight: 450;color: #fff;">
                                            @if($data['call_log_direction'] !== 'N/A')
                                            {{ $data['call_log_direction']->direction ?? 'Direction Not Available' }}
                                            <br>
                                            To:
                                            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['call_log_direction']->cld) ?? 'N/A' }}
                                            <br>
                                            From:
                                            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['call_log_direction']->cli) ?? 'N/A' }}
                                            <br>
                                            Duration: {{ gmdate("H:i:s", $data['call_log_direction']->call_sec) }}
                                             <br>
                                            Started: {{ coverDateTime($data['call_log_direction']->started_at) }}
                                              <!--              <br>
                                                            Answered: {{ $data['call_log_direction']->answered_at }}
                                                            <br>
                                                            Finished: {{ $data['call_log_direction']->finished_at }} -->
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td style="background: #599de1b2;font-weight: 450;color: #fff;">
                                            @if($data['designnes_chat_dump'] !== 'N/A')
                                            Visitor Name: {{ $data['designnes_chat_dump']->visitor_name ?? 'N/A' }}
                                            <br>
                                            Visitor Phone:
                                            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['designnes_chat_dump']->visitor_phone) ?? 'N/A' }}
                                            <br>
                                            Agent: {{ $data['designnes_chat_dump']->agent_names }}
                                            <br>
                                            Duration:
                                            {{ gmdate("H:i:s", intval($data['designnes_chat_dump']->duration)) }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td style="background: #e68f6db8;font-weight: 450;color: #fff;">
                                            @if($data['marketing_notch_chat_dump'] !== 'N/A')
                                            Visitor Name:
                                            {{ $data['marketing_notch_chat_dump']->visitor_name ?? 'N/A' }}
                                            <br>
                                            Visitor Phone:
                                            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['marketing_notch_chat_dump']->visitor_phone) ?? 'N/A' }}
                                            <br>
                                            Agent: {{ $data['marketing_notch_chat_dump']->agent_names }}
                                            <br>
                                            Duration:
                                            {{ gmdate("H:i:s", intval($data['marketing_notch_chat_dump']->duration)) }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td style="background: #125ea2ab;color: #fff;font-weight: 450;">
                                            @if($data['web_form'] !== 'N/A')
                                            Name: {{ $data['web_form']->name ?? 'N/A' }}
                                            <br>
                                            Email: <span
                                                style="text-transform: lowercase;">{{ $data['web_form']->email ?? 'N/A' }}</span>
                                            <br>
                                            Phone:
                                            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['web_form']->phone) ?? 'N/A' }}
                                            <br>
                                            Created: {{ coverDateTime($data['web_form']->created_at) ?? 'N/A' }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td style="background:rgba(6, 115, 211, 0.67);color: #fff;font-weight: 450;">
                                            @if($data['lead_data'] !== 'N/A')
                                            Name: {{ $data['lead_data']->name ?? 'N/A' }}
                                            <br>
                                            Email: <span
                                                style="text-transform: lowercase;">{{ $data['lead_data']->email ?? 'N/A' }}</span>
                                            <br>
                                            Phone:
                                            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['lead_data']->phone) ?? 'N/A' }}
                                            <br>
                                            Created: {{ coverDateTime($data['lead_data']->created_at) ?? 'N/A' }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $_Invoices->appends(request()->query())->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- end cardaa -->
        </div> <!-- end col -->
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

    <!-- <script>
$(document).ready(function () {
    let page = 1;
    let searchParams = {};

    function loadMoreData(append = true) {
        const query = $.param(searchParams);
        $.ajax({
            url: '?page=' + page + (query ? '&' + query : ''),
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                $('.ajax-loading').show();
            },
            success: function (response) {
                if(response.data.length == 0){
                    $('.ajax-loading').html("No more records!");
                    return;
                }
                $('.ajax-loading').hide();
                if (append) {
                    $('#data-bank').append(response.data); // Append new data to the existing table
                } else {
                    $('#data-bank').html(response.data); // Replace current data with new data
                }
                // $('#pagination').html(response.pagination); // Update pagination links
                page+= 1; // Increment the page number
                console.log(page);
                
            },
            error: function () {
                console.error('Failed to load data.');
            }
        });
    }

    // Function to collect search form parameters
    function updateSearchParams() {
        const formData = $('#search-form').serializeArray();
        searchParams = {}; // Reset search parameters
        formData.forEach(({ name, value }) => {
            if (value.trim() !== '') {
                searchParams[name] = value.trim();
            }
        });
        page = 1; // Reset page to 1 for new search
    }

    // Scroll listener
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            loadMoreData();
        }
    });

    // Initial load
    loadMoreData();

    // Search form submission
    $('#search-form').on('submit', function (e) {
        e.preventDefault();
        updateSearchParams();
        loadMoreData(false); // Load data without appending
    });
});
</script> -->

    <!-- <script>
    $(document).ready(function() {
        let page = 1;

        function loadMoreData(searchParams = {}) {
            $.ajax({
                url: '?page=' + page,
                type: 'GET',
                data: searchParams,
                dataType: 'json',
                success: function(response) {
                    $('#data-bank').append(response
                        .data); // Append the new data to the existing table
                    $('#pagination').html(response
                        .pagination); // Update pagination links if necessary
                    page++; // Increment the page number
                }
            });
        }

        // Check if the user has scrolled near the bottom of the page
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) { // Trigger when near the bottom
                loadMoreData();
            }
        });

        loadMoreData();
    });
    </script> -->

    <script>
    $(document).ready(function() {
        $('#add_lead_btn').on('click', function() {
            $('#add-lead-div').slideToggle();
        })
        $('#search_lead_btn').on('click', function() {
            $('#search-div').slideToggle();
        })

    });
    </script>
    <script>
    $(document).ready(function() {
        $('#createLeadBtn').click(function() {
            $('#leadForm')[0].reset(); // Clear the form
            $('#leadId').val(''); // Clear the lead ID
            $('#lead_no').val(''); // Clear the lead number (or set it to be generated in the backend)
            $('#leadModal').modal('show'); // Show the modal
        });
        // Open modal for adding or editing
        $('.edit-btn').click(function() {
            var id = $(this).data('id');
            $.get('/leads/' + id, function(data) {
                $('#leadId').val(data.id);
                $('#lead_no').val(data.lead_no);
                $('#status').val(data.status);
                $('#leadModal').modal('show');
            });
        });

        // Submit form via AJAX
        $('#leadForm').submit(function(e) {
            e.preventDefault();
            var id = $('#leadId').val();
            var url = id ? '/leads/' + id : '/leads';
            var method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: {
                    _token: '{{ csrf_token() }}',
                    lead_no: $('#lead_no').val(),
                    status: $('#status').val(),
                },
                success: function(response) {
                    $('#leadModal').modal('hide');
                    location.reload();
                },
                error: function(response) {
                    alert('An error occurred.');
                }
            });
        });

        // Delete lead
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to delete this lead?')) {
                $.ajax({
                    url: '/leads/' + id,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(response) {
                        alert('An error occurred.');
                    }
                });
            }
        });
    });
    </script>
    @endpush
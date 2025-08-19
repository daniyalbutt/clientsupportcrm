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

    return date('d/m/Y h:i:s A', $timestamp);
}
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="overflow-wrap: anywhere;background: #1212;font-weight: bolder;">
                <div class="card-header">
                    <h4 class="card-title">Transaction Details</h4>
                    <div class="float-right" style="display: block !important;float: right;margin-top: -31px;">
                        <a href="{{ route('data-bank.index') }}" class="btn btn-secondary">Back to list</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable-transactions" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                    <tr>
                                        <td>
                                            {{ $transaction->transaction_id }}
                                        </td>
                                        <td>
                                            {{ $transaction->email }}
                                        </td>
                                        <td>
                                            {{ $transaction->phone }}
                                        </td>
                                        <td>
                                            {{ $transaction->status }}
                                        </td>
                                        <td>
                                            {{ $transaction->amount }}
                                        </td>
                                        <td>
                                            {{ coverDateTime($transaction->payment_date) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card" style="overflow-wrap: anywhere;background: #4fa843b8;font-weight: 450;color: #fff;">
                <div class="card-header">
                    <h4 class="card-title">Invoices Details</h4>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable-invoices" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Brand</th>
                                        <th>Invoice#</th>
                                        <th>Amount</th>
                                        <th>Contact</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->name }}</td>
                                        <td>{{ $invoice->email }}</td>
                                        <td>{{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $invoice->contact) ?? 'N/A' }}</td>
                                        <td>{{ $invoice->brands->name }}</td>
                                        <td>{{ $invoice->invoice_number ?? 'N/A' }}</td>
                                        <td>${{ $invoice->amount ?? 'N/A' }}</td>
                                        <td>{{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $invoice->contact) ?? 'N/A' }}</td>
                                        <td>{{ coverDateTime($invoice->created_at) ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card" style="overflow-wrap: anywhere;background: #599de1b2;font-weight: 450;color: #fff;">
                <div class="card-header">
                    <h4 class="card-title">Call Logs (Telnyx)</h4>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable-telnyx" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Direction</th>
                                    <th>To</th>
                                    <th>From</th>
                                    <th>Duration</th>
                                    <th>Started</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($callLogs as $callLog)
                                <tr>
                                    <td>{{ $callLog->direction ?? 'Direction Not Available' }}</td>
                                    <td>{{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $callLog->cld) ?? 'N/A' }}</td>
                                    <td>{{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $callLog->cli) ?? 'N/A' }}</td>
                                    <td>{{ gmdate("H:i:s", $callLog->call_sec) }}</td>
                                    <td>{{ coverDateTime($callLog->started_at) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card" style="overflow-wrap: anywhere;background: #125ea2ab;color: #fff;font-weight: 450;">
                <div class="card-header">
                    <h4 class="card-title">Web Forms</h4>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable-web-form" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($webForms as $form)
                                    <tr>
                                        <td>{{ $form->name ?? 'N/A' }}</td>
                                        <td>{{ $form->email ?? 'N/A' }}</td>
                                        <td>{{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $form->phone) ?? 'N/A' }}</td>
                                        <td>{{ coverDateTime($form->created_at) ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                     
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card" style="overflow-wrap: anywhere;background:rgba(17, 17, 16, 0.67);color: #fff;font-weight: 450;">
                <div class="card-header">
                    <h4 class="card-title">Designnes Chat Dumps</h4>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable-dnnchat" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Visitor Name</th>
                                    <th>Visitor Phone</th>
                                    <th>Agent Names</th>
                                    <th>Duration</th>
                                    <th>Session Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($designnesChats as $chat)
                                <tr>
                                    <td>{{ $chat->visitor_name ?? 'N/A' }}</td>
                                    <td>{{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $chat->visitor_phone) ?? 'N/A' }}</td>
                                    <td>{{ $chat->agent_names }}</td>
                                    <td>{{ gmdate("H:i:s", intval($chat->duration)) }}</td>
                                    <td>{{ coverDateTime($chat->session_start_date) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card" style="overflow-wrap: anywhere;background:rgba(230, 132, 5, 0.67);color: #fff;font-weight: 450;">
                <div class="card-header">
                    <h4 class="card-title">Marketing Notch Chat Dumps</h4>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable-mnchat" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Visitor Name</th>
                                        <th>Visitor Phone</th>
                                        <th>Agent Names</th>
                                        <th>Duration</th>
                                        <th>Session Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($marketingNotchChats as $chat)
                                    <tr>
                                        <td>{{ $chat->visitor_name ?? 'N/A' }}</td>
                                        <td>{{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $chat->visitor_phone) ?? 'N/A' }}</td>
                                        <td>{{ $chat->agent_names }}</td>
                                        <td>{{ gmdate("H:i:s", intval($chat->duration)) }}</td>
                                        <td>{{ coverDateTime($chat->session_start_date) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Leads Data</h4>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable-lead" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leadData as $lead)
                                    <tr>
                                        <td>{{ $lead->transaction_id ?? 'N/A' }}</td>
                                        <td>{{ $lead->name ?? 'N/A' }}</td>
                                        <td>{{ $lead->email ?? 'N/A' }}</td>
                                        <td>{{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $lead->phone) ?? 'N/A' }}</td>
                                        <td>{{ coverDateTime($lead->created_at) ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Responsive Table js -->
    <script src="{{ asset('leadsglobal/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
    <!-- Init js -->
    <script src="{{ asset('leadsglobal/js/pages/table-responsive.init.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('#datatable-transactions').DataTable({
                "columnDefs": [{
                    "targets": 5, // Change to the actual column index
                    "type": "date",
                    "render": function(data, type, row) {
                        return type === 'sort' ? new Date(data).getTime() : data;
                    }
                }],
                "order": [[5, "desc"]]
            });
            $('#datatable-invoices').DataTable({
                "columnDefs": [{
                    "targets": 7, // Change to the actual column index
                    "type": "date",
                    "render": function(data, type, row) {
                        return type === 'sort' ? new Date(data).getTime() : data;
                    }
                }],
                "order": [[7, "desc"]]
            });
            $('#datatable-telnyx').DataTable({
                "columnDefs": [{
                    "targets": 4, // Change to the actual column index
                    "type": "date",
                    "render": function(data, type, row) {
                        return type === 'sort' ? new Date(data).getTime() : data;
                    }
                }],
                "order": [[4, "desc"]]
            });
            $('#datatable-dnnchat').DataTable({
                "columnDefs": [{
                    "targets": 4, // Change to the actual column index
                    "type": "date",
                    "render": function(data, type, row) {
                        return type === 'sort' ? new Date(data).getTime() : data;
                    }
                }],
                "order": [[4, "desc"]]
            });
            $('#datatable-mnchat').DataTable({
                "columnDefs": [{
                    "targets": 4, // Change to the actual column index
                    "type": "date",
                    "render": function(data, type, row) {
                        return type === 'sort' ? new Date(data).getTime() : data;
                    }
                }],
                "order": [[4, "desc"]]
            });
            $('#datatable-web-form').DataTable({
                "columnDefs": [{
                    "targets": 3, // Change to the actual column index
                    "type": "date",
                    "render": function(data, type, row) {
                        return type === 'sort' ? new Date(data).getTime() : data;
                    }
                }],
                "order": [[3, "desc"]]
            });
            $('#datatable-lead').DataTable({
                "columnDefs": [{
                    "targets": 3, // Change to the actual column index
                    "type": "date",
                    "render": function(data, type, row) {
                        return type === 'sort' ? new Date(data).getTime() : data;
                    }
                }],
                "order": [[3, "desc"]]
            });
        });
    </script>
@endpush

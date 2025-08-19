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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Refund Transactions Logs</h4>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <table id="datatable-merchant" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Refunded Amount</th>
                                        <th>Payment Date</th>
                                        <th>Transaction ID</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($refunds as $refund)
                                    <tr>
                                        <td>{{ $refund->email }}</td>
                                        <td>{{ $refund->formatted_phone }}</td>
                                        <td>{{ $refund->amount }}</td>
                                        <td>{{ $refund->payment_date }}</td>
                                        <td>{{ $refund->transaction_id }}</td>
                                        <td>{{ $refund->status }}</td>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script>
    $(document).ready(function() {
        $('#datatable-merchant').DataTable({
           "columnDefs": [{
                "targets": 3, // Column index for datetime
                "type": "datetime",
                "render": function(data, type, row) {
                    if (type === 'sort') {
                        return moment(data, "YYYY/MM/DD hh:mm:ss A").valueOf();
                    }
                    return data;
                }
            }],
            "order": [[3, "desc"]]
        });
    });
</script>

@endpush

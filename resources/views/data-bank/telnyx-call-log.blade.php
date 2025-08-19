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
                    <h4 class="card-title">Telnyx Call Log</h4>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <table id="datatable-telnyx" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>Calling Line Destination (CLD)</th>
                                        <th>Calling Line Identity (CLI)</th>
                                        <th>Direction</th>
                                        <th>Call Duration</th>
                                        <th>Started At</th>
                                        <th>Answered At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($telnyx_call_logs as $log)
                                    <tr>
                                        <!-- <td>{{ $log->id }}</td> -->
                                        <td>{{ $log->cld }}</td>
                                        <td>{{ $log->cli }}</td>
                                        <td>{{ $log->direction }}</td>
                                        <td>{{ gmdate("H:i:s", $log->call_sec) }}</td>
                                        <td>{{ coverDateTime($log->started_at) }}</td>
                                        @if($log->answered_at == null)
                                        <td>{{ coverDateTime($log->answered_at) }}</td>
                                        @else
                                        <td>Not Answered</td>
                                        @endif
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

<script>
    $(document).ready(function() {
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
    });
</script>

@endpush
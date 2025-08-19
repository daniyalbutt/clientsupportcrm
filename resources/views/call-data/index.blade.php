<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call Data</title>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css' rel="stylesheet">
    <link href='https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css' rel="stylesheet">
</head>

<body>
    <h1>Call Data</h1>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Index</th>
                <th>Started At</th>
                <th>Answered At</th>
                <th>Finished At</th>
                <th>Direction</th>
                <th>Caller Number</th>
                <th>Destination Number</th>
                <th>Call Seconds</th>
                <th>CLD (RECEIVER)</th>
                <th>CLI (CALLER)</th>
                <th>C-Code</th>
            </tr>
        </thead>
        <tbody>
            @foreach($callData as $index => $call)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ array_key_exists('started_at', $call) ? $call['started_at'] : 'N/A' }}</td>
                <td>{{ array_key_exists('answered_at', $call) ? $call['answered_at'] : 'N/A' }}</td>
                <td>{{ array_key_exists('finished_at', $call) ? $call['finished_at'] : 'N/A' }}</td>
                <td>{{ array_key_exists('direction', $call) ? $call['direction'] : 'N/A' }}</td>
                <td>{{ array_key_exists('caller_number', $call) ? $call['caller_number'] : 'N/A' }}</td>
                <td>{{ array_key_exists('dest_number', $call) ? $call['dest_number'] : 'N/A' }}</td>
                <td>{{ array_key_exists('call_sec', $call) ? $call['call_sec'] : 'N/A' }}</td>
                <td>{{ array_key_exists('cld', $call) ? $call['cld'] : 'N/A' }}</td>
                <td>{{ array_key_exists('cli', $call) ? $call['cli'] : 'N/A' }}</td>
                <td>{{ array_key_exists('country_code', $call) ? $call['country_code'] : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

    <script src='https://code.jquery.com/jquery-3.7.1.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js'></script>
    <script src='https://cdn.datatables.net/2.1.8/js/dataTables.js'></script>
    <script src='https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js'></script>
    <script>
    new DataTable('#example');
    </script>
</body>

</html>
<!DOCTYPE html>
<html>
<head>
    <title>Website Form</title>
    <style>
        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }
        table {
            border-collapse: collapse;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .table td, .table th {
            text-align:left;
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.05);
        }
    </style>
</head>
<body>
    <table class="table">
        <tr>
            <th>Business Name</th>
            <td>{{ $data->business_name }}</td>
        </tr>
        <tr>
            <th>Website address – or desired Domain(s)</th>
            <td>{{ $data->website_address }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $data->address }}</td>
        </tr>
        <tr>
            <th>Are there other decision makers? Please specify</th>
            <td>{!! nl2br($data->decision_makers) !!}</td>
        </tr>
        <tr>
            <th>Please give me a brief overview of the company, what you do or produce?</th>
            <td>{!! nl2br($data->about_company) !!}</td>
        </tr>
        <tr>
            <th>What is the purpose of this site?</th>
            <td>
            @php
            $purposes = json_decode($data->purpose);
            @endphp
            @foreach($purposes as $purpose)
            {{$purpose}}, 
            @endforeach
            </td>
        </tr>
        <tr>
            <th>If you have a specific deadline, please state why?</th>
            <td>{!! nl2br($data->deadline) !!}</td>
        </tr>
        <tr>
            <th>Who will visit this site? Describe your potential clients. (Young, old, demographics, etc)</th>
            <td>{!! nl2br($data->potential_clients) !!}</td>
        </tr>
        <tr>
            <th>Why do you believe site visitors should do business with you rather than with a competitor? What problem are you solving for them?</th>
            <td>{!! nl2br($data->competitor) !!}</td>
        </tr>
        <tr>
            <th>What action(s) should the user perform when visiting your site?</th>
            <td>
                @php
                $user_performs = json_decode($data->user_perform);
                @endphp
                @foreach($user_performs as $datas)
                {{$datas}}, 
                @endforeach
            </td>
        </tr>
        <tr>
            <th colspan="2">What are you offering? Make a list of all the sections/pages you think that you'll need. (Samples below are just an example to get you started, please fill this out completely.)</th>
        </tr>
        <tr>
            <th>Page</th>
            <th>Content Notes</th>
        </tr>
    </table>
</body>
</html>
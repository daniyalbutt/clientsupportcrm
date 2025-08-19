<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
</head>
<body>
    <h2>Transaction List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Transaction ID</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Payment Date</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Batch ID</th>
        </tr>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->transaction_id }}</td>
            <td>{{ $transaction->status }}</td>
            <td>{{ $transaction->amount }}</td>
            <td>{{ $transaction->payment_date }}</td>
            <td>{{ $transaction->email }}</td>
            <td>{{ $transaction->phone }}</td>
            <td>{{ $transaction->batch_id }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}" type="text/css"> 
    <title>Invoice #{{ $invoice_id }}</title>
    <style>
        body {
            font-family: 'roboto', sans-serif;
        }
    
        h1 {
            font-family: 'roboto';
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <img src="{{ public_path($brand_image) }}" alt="{{ $brand_name }}" width="200" />
                <p class="brand_name">{{ $brand_name }}</p>
            </td>
            <td class="w-half">
                <h2 class="invoice-text">INVOICE<br>#{{ $invoice_id }}</h2>
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div><h4>Bill To:</h4></div>
                    <div>{{ $client_name }}</div>
                </td>
                <td class="w-half">
                    <table class="date-table">
                        <tr>
                            <td>Date:</td>
                            <td>{{ $paid_date }}</td>
                        </tr>
                        <tr>
                            <td>Balance Due:</td>
                            <td>{{ $currency }}0.00</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
 
            <tr class="items">
                <td><strong>{{ $item }}</strong></td>
                <td>1</td>
                <td>{{ $currency }}{{ $amount }}</td>
                <td>{{ $currency }}{{ $amount }}</td>
            </tr>
        </table>
    </div>
 
    <div class="total">
        <div class="total-innter">
            <span>Total:</span><span>{{ $currency }}{{ $amount }}</span>
        </div>
        <div class="total-innter">
            <span>Amount Paid:</span><span>{{ $currency }}{{ $amount }}</span>
        </div>
    </div>
 
    <div class="footer margin-top">
        <div>Notes:</div>
        <div>Charges will appear on your statement as TECHDECK</div>
    </div>
</body>
</html>
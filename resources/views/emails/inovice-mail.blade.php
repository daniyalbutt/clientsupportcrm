<html>
    <body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
        <table style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
            <thead>
                <tr>
                    <th style="text-align:left;">
                        <img style="max-width: 150px;" src="{{ asset($details['brand_logo']) }}" alt="{{ $details['brand_name'] }}">
                    </th>
                    <th style="text-align:right;font-weight:400;">{{ $details['date'] }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="height:35px;"></td>
                </tr>
                <tr>
                    <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                        <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">Order status</span><b style="color:red;font-weight:normal;margin:0">Unpaid</b></p>
                        <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Invoice Number</span> {{ $details['invoice_number'] }}</p>
                        <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Order amount</span> {{ $details['currency_sign'] }}{{ $details['amount'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="height:35px;"></td>
                </tr>
                <tr>
                    <td style="width:50%;padding: 0px 20px;vertical-align:top">
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Name</span> {{ $details['name'] }}</p>
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone</span> {{ $details['contact'] }}</p>
                    </td>
                    <td style="width:50%;padding: 0px 20px;vertical-align:top">
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Email</span> {{ $details['email'] }}</p>
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Payment Link</span> <a href="{{ $details['link'] }}">Click Here</a></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width:100%;padding: 0px 20px;vertical-align:top">
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Discription</span> {{ $details['discription'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Package</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:15px;">
                        <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;">
                            <span style="display:block;font-size:13px;font-weight:normal;">{{ $details['package_name'] }}</span>
                        </p>
                    </td>
                </tr>
            </tbody>
            <tfooter>
                <tr>
                    <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
                        <strong style="display:block;margin:0 0 10px 0;">Regards</strong> {{ $details['brand_name'] }}<br> {{ $details['brand_address'] }}<br><br>
                        <b>Phone:</b> {{ $details['brand_phone'] }}<br>
                        <b>Email:</b> {{ $details['brand_email'] }}
                    </td>
                </tr>
            </tfooter>
        </table>
    </body>
</html>
<html>
    <body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
        <table style="max-width:670px;min-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px #df3c3f;">
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
                    <td colspan="2" style="width:100%;padding: 0px 20px;vertical-align:top">
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Message</span> {!! $details['discription'] !!}<br><a href="{{ env('APP_URL') }}">Please login to reply on this message....</a></p>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
                        <strong style="display:block;margin:0 0 10px 0;">Regards</strong> {{ $details['sender_name'] }}<br> {{ $details['sender_email'] }}<br><br>
                        <b>Phone:</b> {{ $details['brand_phone'] }}<br>
                        <b>Email:</b> {{ $details['brand_email'] }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
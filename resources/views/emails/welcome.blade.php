<html>
    <body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
        <table width="670" style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px #df3c3f;">
            <thead>
                <tr>
                    <th style="text-align:left;"><img style="min-width:150px;max-width:150px;width:150px" src="{{ $mailData['logo'] }}" alt="{{ env('APP_NAME') }}"></th>
                    <th style="text-align:right;font-weight:400;">{{ $mailData['current_date'] }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        <h2>{{$mailData['heading']}}</h2>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:15px;"></td>
                </tr>
                <tr>
                    <td colspan="2">{!!$mailData['content']!!}</td>
                </tr>
                <tr>
                    <td colspan="2" style="height:35px;"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
                        <strong style="display:block;margin:0 0 10px 0;">Best regards,<br>
                        {{$mailData['brand_name']}} Support Team
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
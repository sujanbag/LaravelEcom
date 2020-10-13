
<html>
    <head>
        <title>Register Email</title>
    </head>
    <body>
        <table>
            <tr><td>Dear {{$messageData['name']}}</td><tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Please click on below link to activate your account:</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><a href="{{ url('confirm/'.$messageData['code']) }}">Confirm your account</a></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thanks & Regards,</td></tr>
            <tr><td>Gov-E-com website</td></tr>


        </table>
    </body>
</html>



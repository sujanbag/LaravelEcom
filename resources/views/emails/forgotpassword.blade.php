<html>
    <head>
        <title>Forgot Password Email</title>
    </head>
    <body>
        <table>
            <tr><td>Dear {{$messageData['name']}},</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Your account has been successfully created.<br>Your account information is as below with new password::</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Email:{{$messageData['email']}}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Password:{{$messageData['password']}} </td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thanks & Regards,</td></tr>
            <tr><td>Gov-E-Com Website</td></tr>
        </table>
    </body>
</html>
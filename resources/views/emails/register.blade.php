<html>
    <head>
        <title>Register Email</title>
    </head>
    <body>
        <table>
            <tr><td>Dear {{$messageData['name']}}</td><tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Your account has been created Successfully.<br>
                Your account information is as below:</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Email:{{$messageData['email']}}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Password: *****(as chosen by you)</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thanks & Regards,</td></tr>
            <tr><td>Gov-E-com website</td></tr>


        </table>
    </body>
</html>
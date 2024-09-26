<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password Notification</h1>

    <p>Hi,</p>
    <p>You are receiving this email because we received a password reset request for your account.</p>

    <p>
        <a href="{{ url('password/reset', $token) . '?email=' . $emailadd }}">
            Reset Password
        </a>
    </p>

    <p>If you did not request a password reset, no further action is required.</p>

    <p>Regards,<br>Your Application</p>
</body>
</html>

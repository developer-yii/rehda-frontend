<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>

    <p>Dear {{ $user->memberUserProfile->up_fullname ?? null }},</p>
    <p>
        You are receiving this email because a password reset request was made for your REHDA account<br>
        (Membership No/MyKad No: {{ $user->ml_username }})
    </p>

    <p>To reset your password, please click the link below:</p>

    <p>
        <a href="{{ url('password/reset', $token) . '?email=' . $emailadd }}">
            Reset Password
        </a>
    </p>

    <p>If you did not request this reset, please disregard this email - no further action is needed.</p>

    <p>For any assistance, feel free to contact REHDA Secretariat at 03-7803 2978.</p>

    <p>Best regards,<br>REHDA Secretariat</p>
</body>
</html>

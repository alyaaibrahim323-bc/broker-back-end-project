<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
</head>
<body>
    <h1>Password Reset Request</h1>
    <p>Hello,</p>
    <p>You have requested to reset your password. Please use the following OTP to verify your request:</p>
    <h2>{{ $otp }}</h2>
    <p>This OTP is valid for 10 minutes. If you did not request a password reset, please ignore this email.</p>
    <p>Thank you,</p>
    <p>Your App Team</p>
</body>
</html>
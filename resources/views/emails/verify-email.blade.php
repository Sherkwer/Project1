<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f4f8;
            font-family: Arial, Helvetica, sans-serif;
            color: #333333;
        }
        .wrapper {
            width: 100%;
            padding: 40px 16px;
        }
        .card {
            max-width: 560px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .header {
            background-color: #3490dc;
            padding: 32px 40px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .body {
            padding: 36px 40px;
        }
        .body p {
            margin: 0 0 16px;
            font-size: 15px;
            line-height: 1.6;
            color: #555555;
        }
        .body p.greeting {
            font-size: 16px;
            color: #333333;
            font-weight: 600;
        }
        .btn-wrapper {
            text-align: center;
            margin: 28px 0;
        }
        .btn {
            display: inline-block;
            padding: 14px 36px;
            background-color: #3490dc;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .divider {
            border: none;
            border-top: 1px solid #e8e8e8;
            margin: 24px 0;
        }
        .fallback {
            font-size: 13px;
            color: #888888;
            word-break: break-all;
        }
        .fallback a {
            color: #3490dc;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 40px;
            text-align: center;
        }
        .footer p {
            margin: 0;
            font-size: 12px;
            color: #aaaaaa;
            line-height: 1.5;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">

        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <div class="body">
            <p class="greeting">Hello, {{ $user->fname ?? $user->name ?? 'User' }}!</p>

            <p>
                Thank you for registering. Please verify your email address by clicking
                the button below. This link will expire in
                <strong>{{ config('auth.verification.expire', 60) }} minutes</strong>.
            </p>

            <div class="btn-wrapper">
                <a href="{{ $verificationUrl }}" class="btn">Verify Email Address</a>
            </div>

            <p>
                If you did not create an account, no further action is required — you can
                safely ignore this email.
            </p>

            <hr class="divider">

            <p class="fallback">
                If the button above does not work, copy and paste the following link into
                your browser:<br>
                <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
            </p>
        </div>

        <div class="footer">
            <p>
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
                This is an automated message — please do not reply to this email.
            </p>
        </div>

    </div>
</div>
</body>
</html>

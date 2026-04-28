<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Verify Your Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f1f4f8; }
        .card { max-width: 520px; margin: 6rem auto; }
        .btn-gap { gap: 0.5rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h3 class="card-title mb-3">Verify Your Email Address</h3>

            {{-- Success messages --}}
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Legacy status key used by Laravel's built-in resend --}}
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" role="alert">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            {{-- Error messages --}}
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="mb-4">
                Before proceeding, please check your email for a verification link.
                If you did not receive the email, click the button below to request another.
            </p>

            <div class="d-flex flex-wrap btn-gap">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Logout</button>
                </form>
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Resend Verification Email</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

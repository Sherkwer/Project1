<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Your Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f1f4f8; }
        .card { max-width: 520px; margin: 6rem auto; }
        .spinner-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }
        .spinner-border { width: 40px; height: 40px; }
        .loading-text {
            color: #6c757d;
            font-weight: 500;
            animation: pulse 1.5s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        .verification-status {
            display: none;
            text-align: center;
        }
        .verification-status.show {
            display: block;
        }
        .success-icon {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 15px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title">Verify Your Email Address</h3>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" role="alert">
                    A new verification link has been sent to the email address you provided during Login.
                </div>
            @endif

            <!-- Loading State -->
            <div id="loadingState">
                <p class="mb-3">
                    Verification email has been sent to your email address. Waiting for confirmation...
                </p>
                <div class="spinner-container">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="loading-text">Waiting for verification...</span>
                </div>
            </div>

            <!-- Verification Complete State -->
            <div id="verificationState" class="verification-status">
                <div class="success-icon">✓</div>
                <h5 class="text-success">Email Verified Successfully!</h5>
                <p class="text-muted">Your email has been verified. Redirecting to home page...</p>
            </div>

            <!-- Action Buttons -->
            <div id="actionButtons" class="action-buttons">
                <form method="POST" action="{{ route('logout') }}" class="flex-grow-1">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary w-100">Logout</button>
                </form>
                <form method="POST" action="{{ route('verification.resend') }}" class="flex-grow-1">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">Resend Verification Email</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingState = document.getElementById('loadingState');
    const verificationState = document.getElementById('verificationState');
    const actionButtons = document.getElementById('actionButtons');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Check email verification status every 2 seconds
    let checkCount = 0;
    const maxChecks = 300; // Check for 10 minutes (300 * 2 seconds)

    function checkEmailVerification() {
        checkCount++;

        // Get current user's verification status via API
        fetch('{{ route("api.check-email-verification") }}', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.verified) {
                // Email is verified
                loadingState.style.display = 'none';
                verificationState.classList.add('show');
                actionButtons.style.display = 'none';

                // Redirect to home after 2 seconds
                setTimeout(() => {
                    window.location.href = '{{ route("home") }}';
                }, 2000);
            } else if (checkCount < maxChecks) {
                // Continue checking
                setTimeout(checkEmailVerification, 2000);
            } else {
                // Timeout - show manual options
                loadingState.innerHTML = '<p class="text-danger">Verification timeout. Please check your email or resend the verification link.</p>';
            }
        })
        .catch(error => {
            console.error('Error checking verification status:', error);
            if (checkCount < maxChecks) {
                setTimeout(checkEmailVerification, 2000);
            }
        });
    }

    // Start checking immediately
    checkEmailVerification();
});
</script>
</body>
</html>

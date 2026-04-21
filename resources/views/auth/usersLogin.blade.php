<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<title>Login - College Admin</title>

<!-- Bootstrap CSS -->
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="container d-flex justify-content-center">
    <div class="row container-card g-0 w-100">

        <!-- LEFT PANEL -->
        <div class="col-lg-5 left-panel">

            <div class="system-title">
                <img src="{{ asset('images/landing/ifsu-logo.png') }}" alt="IFSU Logo" class="logo" style="width: 60px; height: 60px;"> Ifugao State University

                {{-- <strong>IFSU Ontime: <br>Student Real-Time Event Attendance and Fee Monitoring System</strong>
                <span>
                    @if(!empty($loginRole))
                        {{ $loginRole }}
                    @endif
                </span>
                 <br>
                <span style="font-weight:400;">Login Form</span> --}} 
            </div>

            <div class="system-subtitle mt-4">
                <strong>IFSU Ontime: <br>Student Real-Time Event Attendance and Fee Monitoring System</strong>
            </div>

            <p style="font-size:14px;">
                Manage student records, manage payments, monitor attendance, and streamline
                college operations all in one place.
            </p>

            <ul class="feature-list">
                <li>Real-time attendance monitoring</li>
                <li>Automated attendance checking</li>
                <li>Student Fees tracking</li>
                <li>Secure data management</li>
            </ul>

        </div>

        <!-- RIGHT PANEL -->
        <div class="col-lg-7 right-panel">
            <div class=" my-3 justify-content-start " style="position: absolute"><a href="{{ route('welcome') }}" class="small-note fas fa-arrow-left">Return</a>
            </div>

            <div class="avatar-circle"></i></div>
            <span class="login-role text-center d-block mb-3 form-label">
                @if(!empty($loginRole))
                    {{ $loginRole }}
                @endif

                <br>
            <span style="font-weight:400;">Login Form</span>
            </span>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- show flash status messages (success, error) from redirects --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('usersLogin.submit') }}">
                @csrf
                <input type="hidden" name="role" value="{{ request()->query('role') ?? old('role') }}">

                <div class="mb-3">
                    <label class="form-label">Email / Username</label>
                    <input type="email" name="email" class="form-control"
                        placeholder="Enter your email or username" required value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="Enter your password" required>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn login-btn" href="{{ route('home') }}">Login</button>
                </div>

                <div class="forgot-link">
                    <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#forgotPasswordModal">
                        Forgot Password?
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('password.forgot.reset') }}" id="forgotPasswordForm">
                    @csrf

                    <div class="mb-3">
                        <label for="fp-email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="fp-email" name="email" placeholder="Enter your registered email" required>
                    </div>

                    <div class="mb-3 d-flex gap-2 align-items-end">
                        <div class="flex-grow-1">
                            <label for="fp-otp" class="form-label">OTP Code</label>
                            <input type="text" class="form-control" id="fp-otp" name="otp" placeholder="Enter OTP received via email" maxlength="6">
                        </div>
                        <button type="button" class="btn btn-outline-success" id="send-otp-btn">
                            Send OTP
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="fp-password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="fp-password" name="password" minlength="8" required>
                    </div>

                    <div class="mb-3">
                        <label for="fp-password-confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="fp-password-confirmation" name="password_confirmation" minlength="8" required>
                    </div>

                    <div id="forgot-password-status" class="small text-muted mb-2"></div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sendOtpBtn = document.getElementById('send-otp-btn');
        const statusEl = document.getElementById('forgot-password-status');
        const emailInput = document.getElementById('fp-email');
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

        if (sendOtpBtn) {
            sendOtpBtn.addEventListener('click', function () {
                if (!emailInput.value.trim()) {
                    statusEl.textContent = 'Please enter your email address first.';
                    statusEl.classList.remove('text-success');
                    statusEl.classList.add('text-danger');
                    return;
                }

                statusEl.textContent = 'Sending OTP...';
                statusEl.classList.remove('text-danger');
                statusEl.classList.add('text-muted');

                fetch('{{ route('password.forgot.sendOtp') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        email: emailInput.value.trim()
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusEl.textContent = data.message || 'OTP has been sent to your email.';
                        statusEl.classList.remove('text-danger', 'text-muted');
                        statusEl.classList.add('text-success');
                    } else {
                        statusEl.textContent = data.message || 'Unable to send OTP. Please try again.';
                        statusEl.classList.remove('text-success', 'text-muted');
                        statusEl.classList.add('text-danger');
                    }
                })
                .catch(() => {
                    statusEl.textContent = 'An error occurred while sending the OTP. Please try again.';
                    statusEl.classList.remove('text-success', 'text-muted');
                    statusEl.classList.add('text-danger');
                });
            });
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    var submitBtn = loginForm.querySelector('button[type="submit"]');
    if (!submitBtn) return;

    loginForm.addEventListener('submit', function () {
        // Prevent double submission
        if (submitBtn.disabled) return;

        // Save original content in case of client-side restore
        try { submitBtn.dataset.originalHtml = submitBtn.innerHTML; } catch (e) {}

        submitBtn.disabled = true;
        submitBtn.setAttribute('aria-busy', 'true');
        submitBtn.classList.add('disabled');
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Signing in...';
    });
});
</script>

</body>
</html>
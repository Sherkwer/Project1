<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login — IFSU Ontime</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg,#e1e2e1 0%, #f3faf7 100%); min-height:100vh; }
        .student-card { max-width:920px; margin:6vh auto; border-radius:14px; overflow:hidden; box-shadow:0 20px 50px rgba(2,6,23,0.3); }
        .student-illustration { background:linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02)); padding:30px; display:flex; align-items:center; justify-content:center; }
        .student-illustration img { max-width:320px; height:auto; border-radius:8px; }
        .student-form { padding:34px; background:#fff; }
        .student-brand { font-weight:700; letter-spacing:0.2px; }
        .student-sub { color:#6b7280; font-size:0.95rem; }
        .student-avatar { width:72px; height:72px; border-radius:12px; background:#f3f4f6; display:inline-flex; align-items:center; justify-content:center; }
        .btn-student { background:#06b6d4; color:#fff; border-radius:8px; }
        .btn-student:disabled { opacity:0.7; }
        .small-note { font-size:0.9rem; color:#6b7280; }
    </style>
</head>
<body>
<div class="card student-card d-flex flex-row">
    <div class="text-center my-3" style="position: absolute">
        <button><a href="{{ route('welcome') }}" class="small-note">Back to Role Selection</a>
        </button>
    </div>
    <div class="student-illustration d-none d-md-flex col-md-6">

        <div class="text-center">
            <img src="{{ asset('images/landing/Hero_Student.png') }}" alt="Student Illustration">
            <h3 class="mt-3 text-white student-brand">

                Student Portal</h3>
            <p class="text-white small-note">Sign in with your Student ID to access your account and event attendance.</p>
        </div>
    </div>

    <div class="student-form col-12 col-md-6">
        <div class="d-flex align-items-center mb-3" style="gap:12px">
            <div class="student-avatar">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5z" fill="#06b6d4"/>
                    <path d="M3 20c0-3.866 3.582-7 9-7s9 3.134 9 7v1H3v-1z" fill="#06b6d4"/>
                </svg>
            </div>
            <div>
                <div style="font-weight:700; font-size:1.05rem;">Student Login</div>
                <div class="student-sub">Not the staff login — use your Student credentials.</div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="studentLoginForm" method="POST" action="{{ route('studentLogin') }}">
            @csrf
            <input type="hidden" name="role" value="student">

            <div class="form-group mb-3">
                <label class="form-label">Student ID</label>
                <input name="student_id" type="text" class="form-control" placeholder="e.g. 2023-0001" required value="{{ old('student_id') }}">
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small-note" for="remember">Remember me</label>
                </div>
                <a href="{{ route('studentLogin') }}" class="small-note">Need help?</a>
            </div>

            <div class="mb-2">
                <button id="studentSubmit" type="submit" class="btn btn-student btn-block w-100">Sign in as Student</button>
            </div>
            <div class="text-center mt-2">
                <a href="{{ route('usersLogin') }}" class="small-note">Forgot Password</a>
            </div>
        </form>
    </div>
</div>

<!-- Minimal JS: show spinner on submit -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('studentLoginForm');
    if (!form) return;
    var btn = document.getElementById('studentSubmit');
    form.addEventListener('submit', function () {
        if (btn.disabled) return;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Signing in...';
    });
});
</script>

</body>
</html>

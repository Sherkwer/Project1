<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login — IFSU Ontime</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <style>
        body { background: linear-gradient(135deg,#e1e2e1 0%, #f3faf7 100%); min-height:100vh; }
        .student-card { max-width:920px; margin:6vh auto; border-radius:14px; overflow:hidden; box-shadow:0 20px 50px rgba(2,6,23,0.15); background:#fff; }
        .student-illustration { background:linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02)); padding:30px; display:flex; align-items:center; justify-content:center; }
        .student-form { padding:34px; }
        .student-brand { font-weight:700; letter-spacing:0.2px; }
        .student-sub { color:#6b7280; font-size:0.95rem; }
        .student-avatar { width:72px; height:72px; border-radius:12px; background:#f3f4f6; display:inline-flex; align-items:center; justify-content:center; }
        .btn-student { background:#06b6d4; color:#fff; border-radius:8px; }
        .btn-student:disabled { opacity:0.7; }
        .small-note { font-size:0.9rem; color:#6b7280; }
        .form-control { border-radius:10px; }
        .back-link { text-decoration:none; color:#0d6efd; }
    </style>
</head>
<body>
<div class="student-card d-flex flex-column flex-md-row">
    <div class="student-illustration col-md-6 d-none d-md-flex">
        <div class="text-center">
            <img src="/images/landing/ifsu-logo.png" alt="IFSU Logo" style="max-width:160px; margin-bottom:24px;">
            <h3 class="text-dark student-brand">Student Portal</h3>
            <p class="small-note">Sign in with your Student ID to access your account and attendance details.</p>
        </div>
    </div>
    <div class="student-form col-12 col-md-6">
        <div class="mb-4"><a href="/index" class="back-link">← Back to Home</a></div>
        <h2 class="mb-3">Student Login</h2>
        <form method="POST" action="/home.php">
            <div class="form-group mb-3">
                <label class="form-label">Student ID</label>
                <input name="student_id" type="text" class="form-control" placeholder="e.g. 2023-0001" required>
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
                <a href="#" class="small-note">Need help?</a>
            </div>
            <div class="mb-2">
                <button type="submit" class="btn btn-student btn-block w-100">Sign in as Student</button>
            </div>
            <div class="text-center mt-2">
                <a href="/usersLogin.php?role=admin" class="small-note">Forgot Password</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>

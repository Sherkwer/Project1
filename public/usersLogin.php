<?php
$role = isset($_GET['role']) ? $_GET['role'] : '';
$roleLabels = [
    'super_admin' => 'Super Admin Login',
    'admin' => 'Admin Login',
];
$roleLabel = $roleLabels[$role] ?? 'Staff Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($roleLabel); ?> — IFSU Ontime</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="row container-card g-0 w-100" style="max-width:960px;">
        <div class="col-lg-5 left-panel p-4" style="background:#f5f8fb;">
            <div class="system-title mb-4">
                <img src="/images/landing/ifsu-logo.png" alt="IFSU Logo" class="logo" style="width:60px; height:60px;"> Ifugao State University
            </div>
            <div class="system-subtitle mb-3">
                <strong>IFSU Ontime:<br>Student Real-Time Event Attendance and Fee Monitoring System</strong>
            </div>
            <p style="font-size:14px;">
                Manage student records, manage payments, monitor attendance, and streamline
                college operations all in one place.
            </p>
            <ul class="feature-list">
                <li>Real-time attendance monitoring</li>
                <li>Automated attendance checking</li>
                <li>Student fees tracking</li>
                <li>Secure data management</li>
            </ul>
        </div>
        <div class="col-lg-7 right-panel p-4 bg-white" style="border:1px solid #e3e8ef;">
            <div class="mb-4"><a href="/index" class="small-note" style="text-decoration:none; color:#0d6efd;">← Back to Home</a></div>
            <h2 class="mb-3"><?php echo htmlspecialchars($roleLabel); ?></h2>
            <p style="margin-bottom:1.5rem; color:#6c757d;">Sign in with your staff credentials to access the IFSU Ontime system.</p>
            <form method="POST" action="/home.php">
                <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>">
                <div class="mb-3">
                    <label class="form-label">Email / Username</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email or username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

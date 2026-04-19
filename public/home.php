<?php
session_start();

// In a static PHP version, you can set these values from session or keep them as guest.
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$displayName = $user ? ($user['name'] ?? $user['username'] ?? 'User') : 'Guest';
$roleName = $user ? ($user['role'] ?? 'User') : 'Guest';
$roleTasks = [
    'Super Administrator' => [
        'Manage Users, Campus, Colleges, Organizations, Programs, Periods and ect.. roles',
        'Configure system settings',
        'View Profile information',
    ],
    'Administrator' => [
        'Manage departments and staff',
        'Approve registrations and requests',
        'Manage events and attendance',
    ],
    'Student' => [
        'Scan QR codes for attendance',
        'View personal attendance records',
        'Register for events',
    ],
    'Staff' => [
        'Manage classes and schedules',
        'Take and verify attendance',
        'Publish announcements and notices',
    ],
];
$tasks = $roleTasks[$roleName] ?? ['Access your dashboard', 'Update your profile', 'View notifications'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - IFSU Ontime</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        .lead { font-size: 1rem; }
        body { font-family: 'Source Sans Pro', sans-serif; }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/home.php" class="nav-link">Home</a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/home.php" class="brand-link">
                <img src="/images/landing/ifsu-logo.png" alt="IFSU Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">IFSU Ontime</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="/home.php" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Welcome, <?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?></h1>
                            <p class="text-muted">Role: <strong><?php echo htmlspecialchars($roleName, ENT_QUOTES, 'UTF-8'); ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Getting started</h3>
                                </div>
                                <div class="card-body">
                                    <p class="lead">As a <strong><?php echo htmlspecialchars($roleName, ENT_QUOTES, 'UTF-8'); ?></strong>, here are the common tasks you can perform:</p>
                                    <ul>
                                        <?php foreach ($tasks as $task): ?>
                                            <li><?php echo htmlspecialchars($task, ENT_QUOTES, 'UTF-8'); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php if (!$user): ?>
                                        <a href="/usersLogin.php" class="btn btn-primary">Sign in</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Quick tips</h3>
                                </div>
                                <div class="card-body">
                                    <p>Use the navigation to access features related to your role.</p>
                                    <p class="mb-0">Need help? <a href="#">Contact support service providers</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">IFSU Ontime System</div>
            <strong>&copy; 2026 <a href="#">IFSU</a>.</strong> All rights reserved.
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
        $(document).on('click', '.edit-modal-record', function() {
            $('.modal-title').text('Edit Record');
            $('#ea_id').val($(this).data('id'));
            $('#ea_title').val($(this).data('title'));
            $('#ea_content').val($(this).data('content'));
            $('#EditForm').modal('show');
        });

        $(document).on('click', '.delete-modal-record', function() {
            $('.modal-title').text('Remove Record');
            $('#delete_message').html('<p>Do you want to remove this record with the title <strong>' + ' - ' + $(this).data('title') + '</strong>?</p>');
            $('#da_id').val($(this).data('id'));
            $('#DeleteForm').modal('show');
        });

        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
</body>
</html>

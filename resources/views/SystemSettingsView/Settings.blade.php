@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <div>
        <h1 class="mt-3">System Settings</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item ">Settings</li>
        </ol>
    </div>
@stop

@section('content')

    @php
        $activePanel = $activePanel ?? \App\Support\SettingsPanel::DEFAULT;
        $userRoleName = auth()->check() ? auth()->user()->getRoleName() : null;
        $isSuperAdmin = $userRoleName === 'Super Administrator';
        $isAdmin = $userRoleName === 'Administrator';
        // Make Notifications / Activity visible to any authenticated user
        $canViewActivityNotification = auth()->check();
    @endphp

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">

        <!-- LEFT SIDEBAR -->
        <div class="col-md-3 mb-3 col-sm-3 col-xs-1">
            <div class="card shadow-sm">
                <div class="list-group list-group-flush">

                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'ManageMyAccountPanel']) }}"
                       class="list-group-item menu-link {{ $activePanel === 'ManageMyAccountPanel' ? 'active' : '' }}">
                        <i class="far fa-user mr-2"></i>
                        <strong>Manage My Account</strong>
                        <small>Profile & preferences</small>
                    </a>

                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'ManageDataPanel']) }}"
                       class="list-group-item menu-link {{ $activePanel === 'ManageDataPanel' ? 'active' : '' }}">
                        <i class="fa fa-database mr-2"></i>
                        <strong>Manage Data</strong>
                        <small></small>
                    </a>

                    <a hidden href="{{ route('support.index') }}"
                       class="list-group-item menu-link {{ request()->is('support*') ? 'active' : '' }}">
                        <i class="fas fa-life-ring mr-2"></i>
                        <strong>Support Center</strong>
                        <small>Help & tickets</small>
                    </a>

                    @if($isSuperAdmin)

                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'ManageUsersAccountsPanel']) }}"
                    class="list-group-item menu-link {{ $activePanel === 'ManageUsersAccountsPanel' ? 'active' : '' }}">
                        <i class="fa fa-users mr-2"></i>
                        <strong>Manage Users Accounts</strong>
                        <small></small>
                    </a>

                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'ManageCampusPanel']) }}"
                       class="list-group-item menu-link {{ $activePanel === 'ManageCampusPanel' ? 'active' : '' }}">
                        <i class="far fa-building mr-2"></i>
                        <strong>Manage Campus</strong>
                        <small></small>
                    </a>

                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'ManageCollegePanel']) }}"
                       class="list-group-item menu-link {{ $activePanel === 'ManageCollegePanel' ? 'active' : '' }}">
                        <i class="fa fa-university mr-2"></i>
                        <strong>Manage College</strong>
                        <small></small>
                    </a>

                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'ManageOrganizationPanel']) }}"
                       class="list-group-item menu-link {{ $activePanel === 'ManageOrganizationPanel' ? 'active' : '' }}">
                        <i class="fa fa-users mr-2"></i>
                        <strong>Manage Organization</strong>
                    </a>

                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'ManageProgramsPanel']) }}"
                       class="list-group-item menu-link {{ $activePanel === 'ManageProgramsPanel' ? 'active' : '' }}">
                        <i class="fa fa-graduation-cap mr-2"></i>
                        <strong>Manage Programs</strong>
                    </a>

                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'ManageSemesterPanel']) }}"
                       class="list-group-item menu-link {{ $activePanel === 'ManageSemesterPanel' ? 'active' : '' }}">
                        <i class="far fa-calendar mr-2"></i>
                        <strong>Manage Semester</strong>
                        <small></small>
                    </a>

                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'ManageRolesPanel']) }}"
                    class="list-group-item menu-link {{ $activePanel === 'ManageRolesPanel' ? 'active' : '' }}">
                        <i class="fa fa-user-shield mr-2"></i>
                        <strong>Manage Roles</strong>
                        <small></small>
                    </a>
                    @endif


                    @if($canViewActivityNotification)
                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'notificationPanel']) }}"
                       class="list-group-item menu-link {{ $activePanel === 'notificationPanel' ? 'active' : '' }}" >
                        <i class="far fa-bell mr-2" ></i>
                        <strong>Notifications</strong>
                        <small>Alerts & emails</small>
                    </a>

                    <a href="{{ route('SystemSettings_pagination', ['panel' => 'activityPanel']) }}"
                       class="list-group-item menu-link {{ $activePanel === 'activityPanel' ? 'active' : '' }}" >
                        <i class="far fa-clock mr-2"></i>
                        <strong>Activity Log</strong>
                        <small>Recent actions</small>
                    </a>
                    @endif

                </div>
            </div>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="col-md-9">

                <!----------------------------------------------- Manage Panels-->
                @include('SystemSettingsView.ManageMyAccount')
                @if($isSuperAdmin)
                @include('SystemSettingsView.ManageCampus')
                @include('SystemSettingsView.ManageCollege')
                @include('SystemSettingsView.ManageSemester')
                @include('SystemSettingsView.ManageOrganization')
                @include('SystemSettingsView.ManagePrograms')
                @include('SystemSettingsView.ManageRoles')
                @include('SystemSettingsView.ManageUsersAccounts')
                @endif
                <!-- Manage Data: Backup / Restore / Delete tools -->
                <div id="ManageDataPanel" class="settings-panel @unless($activePanel === 'ManageDataPanel') d-none @endunless">
                    <div class="card shadow-sm">
                        <div class="card-header"><h5 class="mb-0">Manage Data</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border-success h-100">
                                        <div class="card-body text-center">
                                            <h6 class="mb-2">Backup</h6>
                                            <p class="text-muted">Create and download a full database backup. It's recommended to backup before any destructive operations.</p>
                                            <form method="POST" action="#">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-block">Create Backup</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border-info h-100">
                                        <div class="card-body text-center">
                                            <h6 class="mb-2">Restore</h6>
                                            <p class="text-muted">Upload a previously exported backup file to restore the database.</p>
                                            <form id="restoreForm" method="POST" action="" enctype="multipart/form-data">
                                                @csrf
                                                <div class="custom-file mb-2">
                                                    <input type="file" name="backup_file" class="custom-file-input" id="backupFile" accept=".sql,.zip,.gz">
                                                    <label class="custom-file-label" for="backupFile">Choose backup file</label>
                                                </div>
                                                <button type="submit" class="btn btn-info btn-block">Restore Backup</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border-danger h-100">
                                        <div class="card-body text-center">
                                            <h6 class="mb-2">Delete Data</h6>
                                            <p class="text-muted">Permanently delete selected datasets. This action is irreversible — ensure you have a backup.</p>
                                            <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#confirmDeleteModal">Delete Data</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="text-muted small">Backups are recommended before restoring or deleting data. Use these tools with caution.</div>
                        </div>
                    </div>

                    <!-- Confirm Delete Modal -->
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-0">Are you sure you want to permanently delete selected data?</p>
                                    <small class="text-muted">This operation cannot be undone.</small>
                                </div>
                                <div class="modal-footer">
                                    <form method="POST" action="">
                                        @csrf
                                        <input type="hidden" name="scope" id="deleteScope" value="all">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($canViewActivityNotification)
                <!-- 🔵 ACTIVITY LOG PANEL -->
                <div id="activityPanel" class="settings-panel @unless($activePanel === 'activityPanel') d-none @endunless">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between">
                            <h5>Recent Activity</h5>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>

                        <div class="card-body">

                            <small class="text-muted">TODAY</small>

                            <div class="activity-item">
                                <div>
                                    <strong>Password changed successfully</strong>
                                    <p class="text-muted mb-1">Your account password was updated</p>
                                </div>
                                <div class="text-right">
                                    <small>2 hours ago</small><br>
                                    <span class="badge badge-warning">Security</span>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div>
                                    <strong>Logged in from new device</strong>
                                    <p class="text-muted mb-1">Chrome on Windows 11 - New York</p>   </div>
                                <div class="text-right">
                                    <small>5 hours ago</small><br>
                                    <span class="badge badge-primary">Login</span>
                                </div>
                            </div>

                            <hr>

                            <small class="text-muted">YESTERDAY</small>

                            <div class="activity-item">
                                <div>
                                    <strong>Two-factor authentication enabled</strong>
                                    <p class="text-muted mb-1">Extra security enabled</p>
                                </div>
                                <div class="text-right">
                                    <small>Yesterday</small><br>
                                    <span class="badge badge-warning">Security</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- 🟣 NOTIFICATIONS PANEL -->
                <div id="notificationPanel" class="settings-panel @unless($activePanel === 'notificationPanel') d-none @endunless">

                    <!-- SETTINGS -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-header"><h5>Notification Settings</h5></div>
                        <div class="card-body">

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" checked>
                                <label>Email Notifications</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" checked>
                                <label>System Alerts</label>
                            </div>

                        </div>
                    </div>

                    <!-- NOTIFICATION LIST -->
                    <div class="card shadow-sm">
                        <div class="card-header"><h5>Recent Notifications</h5></div>

                        <div class="card-body">

                            <small class="text-muted">Today</small>

                            <div class="notify-item" hidden>
                                <strong>Order #12345 Completed</strong>
                                <p class="text-muted">Your order has been delivered successfully.</p>
                                <small>5 minutes ago • Orders</small>
                            </div>

                            <div class="notify-item" hidden>
                                <strong>Storage Warning</strong>
                                <p class="text-muted">Server storage is running low (85%).</p>
                                <small>1 hour ago • System</small>
                            </div>

                            <hr>

                            <small class="text-muted">Yesterday</small>

                            <div class="notify-item">
                                <strong>New Member</strong>
                                <p class="text-muted">Sarah Johnson joined your team.</p>
                                <small>4:30 PM • Team</small>
                            </div>

                            <div class="notify-item">
                                <strong>Security Alert</strong>
                                <p class="text-muted">New login detected.</p>
                                <small>11:15 AM • Security</small>
                            </div>

                        </div>
                    </div>
                </div>
                @endif

            </div>
    </div>


@stop

@section('css')
<style src="{{ asset('css/Profile/my-account.css') }}"></style>
<style>
    .card {
        border-radius: 12px;
    }

    .list-group-item.active {
        background-color: #a2c3a5;
        border-color: #f6eba2;
        color: #012b03
    }

    .list-group-item small {
        display: block;
        color: #737d72;
    }

    .list-group-item.active small {
        color: #e0d4ff;
    }

    .nav-tabs .nav-link.active {
        color: #000000;
        font-weight: 600;
        border-bottom: 2px solid #000000;
    }
</style>

<style>
    .activity-item, .notify-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .settings-panel {
        transition: 0.3s ease;
    }

    .list-group-item.active {
        background: #379c53;
        color: white;
    }
</style>


<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons-text-hover-effect.css') }}">


@stop

@section('js')

<script>
    // VIEW CAMPUS
    $(document).on('click', '.view-campus', function() {
        $('#view_area_code').text($(this).data('area_code'));
        $('#view_area_address').text($(this).data('area_address'));
        $('#view_report').text($(this).data('report'));
        $('#view_template').text($(this).data('template'));
        $('#view_print_option').text($(this).data('print'));
    });

    // EDIT CAMPUS
    $(document).on('click', '.edit-campus', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var area_code = $(this).data('area_code');
        var area_address = $(this).data('area_address');
        var report = $(this).data('report');
        var template = $(this).data('template');
        var print_option = $(this).data('print');
        $('#edit_id').val(id);
        $('#edit_area_code').val(area_code);
        $('#edit_area_address').val(area_address);
        $('#edit_area_report_header_path').val(report);
        $('#edit_receipt_template').val(template);
        $('#edit_receipt_print_option').val(print_option);
        $('#EditCampusModal').modal('show');
    });

    // DELETE CAMPUS
    $(document).on('click', '.delete-campus', function() {
        var id = $(this).data('id');
        var area_code = $(this).data('area_code');
        $('#delete_message').html(
            '<p>Do you want to remove this campus:<br><strong>' + area_code + '</strong>?</p>'
        );
        $('#delete_id').val(id);
        $('#DeleteCampusModal').modal('show');
    });
</script>
<script>
    // VIEW COLLEGE
    $(document).on('click', '.view-college', function() {
        $('#view_college_area_code').text($(this).data('area_code'));
        $('#view_college_name').text($(this).data('name'));
        $('#view_college_prefix').text($(this).data('prefix'));
        $('#view_college_head_officer').text($(this).data('head_officer'));
    });

    // EDIT COLLEGE
    $(document).on('click', '.edit-college', function(e) {
        e.preventDefault();
        $('#edit_college_id').val($(this).data('id'));
        $('#edit_college_area_code').val($(this).data('area_code'));
        $('#edit_college_name').val($(this).data('name'));
        $('#edit_college_prefix').val($(this).data('prefix'));
        $('#edit_college_head_officer').val($(this).data('head_officer'));
        $('#EditCollegeModal').modal('show');
    });

    // DELETE COLLEGE
    $(document).on('click', '.delete-college', function() {
        $('#delete_college_id').val($(this).data('id'));
        $('#delete_college_message').html(
            `<p>Do you want to remove this college:<br><strong>${$(this).data('name')}</strong>?</p>`
        );
    });
</script>
<script>
    // VIEW ORGANIZATION
    $(document).on('click', '.view-org', function() {
        $('#view_org_name').text($(this).data('name'));
        $('#view_org_description').text($(this).data('description'));
            $('#view_org_campus').text($(this).data('area_code')); // Assuming campus is stored as area_code
            $('#view_org_college').text($(this).data('college_id')); // Assuming college is stored as college_id
    });

    // EDIT ORGANIZATION
    $(document).on('click', '.edit-org', function() {
        $('#edit_org_id').val($(this).data('id'));
        $('#edit_org_name').val($(this).data('name'));
        $('#edit_org_description').val($(this).data('description'));
        $('#edit_org_campus').val($(this).data('area_code')); // Assuming campus is stored as area_code
        $('#edit_org_college').val($(this).data('college_id')); // Assuming college is stored as college_id
        $('#EditOrganizationModal').modal('show');
    });

    // DELETE ORGANIZATION
    $(document).on('click', '.delete-org', function() {
        $('#delete_org_id').val($(this).data('id'));
        $('#delete_org_message').html(
            `<p>Are you sure you want to delete <strong>${$(this).data('name')}</strong>?</p>`
        );
    });
</script>
<script>
    // VIEW SEMESTER
    $(document).on('click', '.view-semester', function() {
        $('#view_semester_id').val($(this).data('id'));
        $('#view_semester_code').val($(this).data('code'));
        $('#view_semester_name').val($(this).data('name'));
        $('#view_semester_year').val($(this).data('year'));
        $('#view_semester_term').val($(this).data('term'));
        $('#view_semester_is_external').val($(this).data('is_external'));
    });

    // EDIT SEMESTER (term + id_ay required by ManageSemesterController@update_semester)
    $(document).on('click', '.edit-semester', function(e) {
        e.preventDefault();
        var $btn = $(this);
        $('#edit_semester_id').val($btn.data('id'));
        $('#edit_semester_code').val($btn.data('code'));
        $('#edit_semester_name').val($btn.data('name'));
        $('#edit_semester_year').val($btn.data('year'));
        $('#edit_semester_term').val($btn.data('term'));
        $('#EditSemesterModal').modal('show');
    });

    // DELETE SEMESTER
    $(document).on('click', '.delete-semester', function() {
        $('#delete_semester_id').val($(this).data('id'));
        $('#delete_semester_message').html(
            `<p>Do you want to remove this semester:<br><strong>${$(this).data('name')}</strong>?</p>`
        );
    });
</script>
<script>
    // VIEW PROGRAM
    $(document).on('click', '.view-program', function() {
        $('#view_program_id').val($(this).data('id'));
        $('#view_program_area_code').val($(this).data('area_code'));
        $('#view_program_code').val($(this).data('code'));
        $('#view_program_name').val($(this).data('name'));
        $('#view_program_college_id').val($(this).data('college_id'));
        $('#view_program_status').val($(this).data('status') == 1 ? 'Active' : 'Inactive');
    });

    // EDIT PROGRAM
    $(document).on('click', '.edit-program', function(e) {
        e.preventDefault();
        $('#edit_program_id').val($(this).data('id'));
        $('#edit_program_area_code').val($(this).data('area_code'));
        $('#edit_program_code').val($(this).data('code'));
        $('#edit_program_name').val($(this).data('name'));
        $('#edit_program_college_id').val($(this).data('college_id'));
        $('#edit_program_status').val($(this).data('status'));
        $('#EditProgramModal').modal('show');
    });

    // DELETE PROGRAM
    $(document).on('click', '.delete-program', function() {
        $('#delete_program_id').val($(this).data('id'));
        $('#delete_program_message').html(
            `<p>Do you want to remove this program:<br><strong>${$(this).data('name')}</strong>?</p>`
        );
    });
</script>
<script>
    // VIEW ROLE
    $(document).on('click', '.view-role', function() {
        $('#view_role_name').text($(this).data('name'));
        $('#view_role_description').text($(this).data('description'));
    });

    // EDIT ROLE
    $(document).on('click', '.edit-role', function(e) {
        e.preventDefault();
        $('#edit_role_id').val($(this).data('id'));
        $('#edit_role_name').val($(this).data('name'));
        $('#edit_role_description').val($(this).data('description'));
        $('#EditRoleModal').modal('show');
    });

    // DELETE ROLE
    $(document).on('click', '.delete-role', function() {
        $('#delete_role_id').val($(this).data('id'));
        $('#delete_role_message').html(`
            <p>Do you want to remove this role:<br><strong>${$(this).data('name')}</strong>?</p>
        `);
    });
</script>
<script>
    // VIEW USER
    $(document).on('click', '.view-user', function() {
        $('#view_user_fname').text($(this).data('fname') || '');
        $('#view_user_mname').text($(this).data('mname') || '');
        $('#view_user_lname').text($(this).data('lname') || '');
        $('#view_user_email').text($(this).data('email'));
        $('#view_user_role').text($(this).data('user_role'));
        $('#view_user_area_code').text($(this).data('area_code') || 'N/A');
        $('#view_user_department_id').text($(this).data('department_id') || 'N/A');
        $('#view_user_organization_id').text($(this).data('organization_id') || 'N/A');
        $('#view_user_is_approved').text($(this).data('is_approved') == 1 ? 'Yes' : 'No');
    });

    // EDIT USER
    $(document).on('click', '.edit-user', function(e) {
        e.preventDefault();
        $('#edit_user_id').val($(this).data('id'));
        $('#edit_user_fname').val($(this).data('fname'));
        $('#edit_user_mname').val($(this).data('mname'));
        $('#edit_user_lname').val($(this).data('lname'));
        $('#edit_user_email').val($(this).data('email'));
        $('#edit_user_role').val($(this).data('user_role'));
        $('#edit_user_area_code').val($(this).data('area_code'));
        $('#edit_user_department_id').val($(this).data('department_id'));
        $('#edit_user_organization_id').val($(this).data('organization_id'));
        $('#edit_user_is_approved').val($(this).data('is_approved'));
        $('#edit_user_is_admin').val($(this).data('is_admin'));
        $('#EditUserModal').modal('show');
    });

    // DELETE USER
    $(document).on('click', '.delete-user', function() {
        $('#delete_user_id').val($(this).data('id'));
        $('#delete_user_message').html(
            `<p>Are you sure you want to delete <strong>${$(this).data('fullname')}</strong>?</p>`
        );
    });
</script>
<script>
    console.log("Settings Tabs Loaded");
</script>
@stop

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\WelcomeController;

use App\Http\Controllers\Auth\UsersLoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UsersRegistrationController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\VerificationController;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\HomeDashboardController;
use App\Http\Controllers\StudentsManagementController;
use App\Http\Controllers\ManageOfficersController;
use App\Http\Controllers\AttendanceManagementController;
use App\Http\Controllers\EventsManagementController;
use App\Http\Controllers\ViolationManagementController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\StudentsPayBillsController;
use App\Http\Controllers\ReportController\UserReportController;
use App\Http\Controllers\ReportController\PaymentHistoryController;
use App\Http\Controllers\UsersManagementController;

use App\Http\Controllers\MyAccountController;

use App\Http\Controllers\SystemSettingsController\SettingsController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\FeeTypesController;
use App\Http\Controllers\SystemSettingsController\ManageCollegeController;
use App\Http\Controllers\SystemSettingsController\ManageCampusController;
use App\Http\Controllers\SystemSettingsController\ManageProgramsController;
use App\Http\Controllers\SystemSettingsController\ManageOrganizationController;
use App\Http\Controllers\SystemSettingsController\ManageSemesterController;
use App\Http\Controllers\SystemSettingsController\ManageMyAccountController;
use App\Http\Controllers\SupportController;

Route::get('/AdminHomeDashboard_pagination', [AdminDashboardController::class, 'index'])->middleware('role:superadmin,admin,officer')->name('AdminHomeDashboard_pagination');


// Landing page
Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

// Login routes
Route::get('/', function () {
	return view('/welcome');
});
     // Student login and registration routes
Route::get('/studentLogin', [App\Http\Controllers\Auth\Student_Auth\StudentLoginController::class, 'index'])->name('studentLogin');

// <{--------------------------------------------> |
//                Authentication                   |
// <---------------------------------------------> |
// Login routes with throttling
Route::middleware([ 'throttle:10,1'])->group(function () {



    Route::get('/usersLogin', [UsersLoginController::class, 'showLoginForm'])->name('usersLogin');
    // submission of login form
    Route::post('/usersLogin', [UsersLoginController::class, 'userslogin'])->name('usersLogin.submit');
    Route::post('/logout', [UsersLoginController::class, 'logout'])->name('logout');

    // Forgot password via OTP
     Route::options('/password/forgot/send-otp', function () {
        return response()->json([], 200);
    });

    Route::post('/password/forgot/send-otp', [UsersLoginController::class, 'sendPasswordOtp'])->name('password.forgot.sendOtp');
    Route::post('/password/forgot/reset', [UsersLoginController::class, 'resetPasswordWithOtp'])->name('password.forgot.reset');
});

    // Confirm password routes
    Route::get('/confirm-password', [ConfirmPasswordController::class, 'show'])->middleware('auth')->name('password.confirm');
    Route::post('/confirm-password', [ConfirmPasswordController::class, 'store'])->middleware('auth')->name('password.confirm');

    // Email verification routes
    Route::get('/email/verify', [VerificationController::class, 'show'])->middleware('auth')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('auth', 'signed')->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->middleware('auth')->name('verification.resend');
    Route::get('/api/check-email-verification', [VerificationController::class, 'checkVerification'])->middleware('auth')->name('api.check-email-verification');
    // -------------------------------------------------}>


Route::middleware(['auth', 'verified'])->group(function () {
// <{--------------------------------------------> |
//                   Dashboard                     |
// <-------------------------------------------->  |
Route::get('/home', [HomeDashboardController::class, 'index'])->middleware('auth')->name('home');

Route::get('/userhelp&support', [HomeDashboardController::class, 'showUserHelp'])->name('userhelp&support');

Route::get('/AdminHomeDashboard_pagination', [AdminDashboardController::class, 'index'])->middleware('role:superadmin,admin,officer')->name('AdminHomeDashboard_pagination');

// -------------------------------------------------}>


// <{--------------------------------------------> |
//                 Students Management             |
// <-------------------------------------------->  |
Route::middleware(['role:admin'])->group(function () {
    Route::get('/StudentsManagement_pagination', [StudentsManagementController::class, 'manageStudents'])->name('StudentsManagement_pagination');
    Route::post('/store_student', [StudentsManagementController::class, 'store_student'])->name('store_student');
    Route::put('/update_student', [StudentsManagementController::class, 'update_student'])->name('update_student');
    Route::post('/delete_student', [StudentsManagementController::class, 'delete_student'])->name('delete_student');
    Route::post('/students/import', [StudentsManagementController::class, 'importStudents'])->name('students.import');
    Route::post('/students/save-import', [StudentsManagementController::class, 'saveImport'])->name('students.saveImport');
    Route::post('/students/cancel-import', [StudentsManagementController::class, 'cancelImport'])->name('students.cancelImport');

    // Export and Import routes for Students Management
    Route::get('students-export', [StudentsManagementController::class, 'exportStudents'])->name('students.export');
    Route::get('download-student-template', [StudentsManagementController::class, 'downloadTemplate'])->name('students.downloadTemplate');
    Route::get('/StudentsManagement_View/ImportStudents', [StudentsManagementController::class, 'showImportStudents'])->name('/StudentsManagement_View/ImportStudents'); // to display the view

    // assign student QR code & RfID
    Route::get('/StudentsManagement_View/AssignQr_Rfid', [StudentsManagementController::class, 'showAssignQrRfid'])->name('/StudentsManagement_View/AssignQr_Rfid'); // to display the view
    Route::post('/search_students', [StudentsManagementController::class, 'searchStudents'])->name('search_students');
    Route::post('/assign_qr_rfid', [StudentsManagementController::class, 'assignQrRfid'])->name('assign_qr_rfid');

    // View student profile
    Route::get('/StudentsManagement_View/StudentProfile/{id}', [StudentsManagementController::class, 'showStudentProfile'])->name('/StudentsManagement_View/StudentProfile');
});
// -------------------------------------------------}>

// <{--------------------------------------------> |
//                Attendance Management            |
// <-------------------------------------------->  |
Route::middleware(['role:admin,officer'])->group(function () {
    Route::get('/AttendanceManagement_pagination', [AttendanceManagementController::class, 'ShowEventAndAttendance'])->name('AttendanceManagement_pagination');
    Route::post('/store_attendance', [AttendanceManagementController::class, 'store_attendance'])->name('store_attendance');

    Route::post('/update_event/{id}', [App\Http\Controllers\AttendanceManagementController::class, 'update_event'])->name('update_event');

    Route::post('/attendance/validate-import', [App\Http\Controllers\AttendanceManagementController::class, 'validate_import'])->name('attendance.validate_import');
    Route::post('/attendance/import-csv', [AttendanceManagementController::class, 'import_csv_attendance'])->name('attendance.import.csv');

    //Checking of Attendance View
    Route::get('/AttendanceManagementView/CheckingOfAttendance', [AttendanceManagementController::class, 'ShowCheckingOfAttendance'])->name('/AttendanceManagementView/CheckingOfAttendance');
});
// -------------------------------------------------}>

// <{--------------------------------------------> |
//                Events Management                |
// <-------------------------------------------->  |
Route::middleware(['role:admin'])->group(function () {
    Route::get('/EventsManagement_pagination', [EventsManagementController::class, 'ShowEvents'])->name('EventsManagement_pagination');
    Route::get('/get-default-fee', [EventsManagementController::class, 'getDefaultFee'])->name('getDefaultFee');

    Route::post('/store_event', [EventsManagementController::class, 'store_event'])->name('store_event');
    Route::post('/update_event', [EventsManagementController::class, 'update_event'])->name('update_event');
    Route::post('/delete_event', [EventsManagementController::class, 'delete_event'])->name('delete_event');
});
// -------------------------------------------------}>

// <{-------------------------------------------->  |
//                Violation Management              |
// <-------------------------------------------->   |
Route::middleware(['role:admin'])->group(function () {
    Route::get('/ViolationsManagement_pagination', [App\Http\Controllers\ViolationManagementController::class, 'ShowViolationManagementView'])->name('ViolationsManagement_pagination');
        Route::post('/store_student_violation', [ViolationManagementController::class, 'store_student_violation'])->name('store_student_violation');
        Route::post('/update_student_violation', [ViolationManagementController::class, 'update_student_violation'])->name('update_student_violation');
        Route::post('/delete_student_violation', [ViolationManagementController::class, 'delete_student_violation'])->name('delete_student_violation');
});

// -------------------------------------------------}>

// <{--------------------------------------------> /
//                 Fees             |
// <-------------------------------------------->  |
Route::middleware(['role:admin'])->group(function () {
    Route::get('/Fees_pagination', [FeesController::class, 'ShowFees'])->name('Fees_pagination');
        Route::post('/store_violation', [FeesController::class, 'store_violation'])->name('store_violation');
        Route::post('/update_violation', [FeesController::class, 'update_violation'])->name('update_violation');
        Route::post('/delete_violation', [FeesController::class, 'delete_violation'])->name('delete_violation');
});
// ------------------------------------------------\

// ----------------------------------------------> /
//                 Announcements                   |
// ----------------------------------------------> |
//
Route::middleware(['role:admin'])->group(function () {
    Route::get('Announcement_pagination', [AnnouncementsController::class, 'ShowAnnouncements'])->name('Announcement_pagination');
        Route::post('/store_announcement', [AnnouncementsController::class, 'store_announcement'])->name('store_announcement');
        Route::post('/update_announcement', [AnnouncementsController::class, 'update_announcement'])->name('update_announcement');
        Route::post('/delete_announcement', [AnnouncementsController::class, 'delete_announcement'])->name('delete_announcement');
});
// ------------------------------------------------\

// ----------------------------------------------> /
//                 Students Pay Bills                   |
// ----------------------------------------------> |
Route::middleware(['role:admin,officer'])->group(function () {
    Route::get('StudentsPayments_pagination', [StudentsPayBillsController::class, 'ShowStudentsPayBills'])->name('StudentsPayments_pagination');
        Route::post('/store_payment', [StudentsPayBillsController::class, 'store_payment'])->name('store_payment');
        Route::post('/update_payment', [StudentsPayBillsController::class, 'update_payment'])->name('update_payment');
        Route::post('/delete_payment', [StudentsPayBillsController::class, 'delete_payment'])->name('delete_payment');
});

// ------------------------------------------------\

// ----------------------------------------------> /
//                 Reports                   |
// ----------------------------------------------> |
Route::middleware(['role:admin,officer'])->group(function () {
    //User Report
    Route::get('UserReport_pagination', [UserReportController::class, 'ShowUserReport'])->name('UserReport_pagination');

    // Payment History Report
    Route::get('PaymentHistory_pagination', [PaymentHistoryController::class, 'ShowPaymentHistory'])->name('PaymentHistory_pagination');
});
// ------------------------------------------------\



// ----------------------------------------------- /
//                 My Account                      |
// ----------------------------------------------- |
Route::get('/MyAccount_pagination', [MyAccountController::class, 'viewProfile'])->name('MyAccount_pagination');
Route::get('/MyAccount_Views/UpdateProfilePage', [MyAccountController::class, 'viewUpdateProfilePage'])->name('/MyAccount_Views/UpdateProfilePage');
// ------------------------------------------------\


// -------------------------------------------------}>

// Support routes (auth required)
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::get('/support/create', [SupportController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
    Route::get('/support/{ticket}', [SupportController::class, 'show'])->name('support.show');
    Route::post('/support/{ticket}/reply', [SupportController::class, 'reply'])->name('support.reply');
    Route::post('/support/{ticket}/close', [SupportController::class, 'close'])->name('support.close');
});

// <{--------------------------------------------> |
//                 System Setting                 |
// <--------------------------------------------> |
// My Account (within Settings) — allow authenticated users to update their own profile
Route::middleware('auth')->group(function () {
    Route::post('/settings/my-account/profile', [ManageMyAccountController::class, 'updateProfile'])->name('settings.my_account.profile');
    Route::post('/settings/my-account/password', [ManageMyAccountController::class, 'updatePassword'])->name('settings.my_account.password');
    Route::post('/settings/my-account/terminate', [ManageMyAccountController::class, 'terminateAccount'])->name('settings.my_account.terminate');
    // Notifications — mark read (auth only)
    Route::post('/notifications/read/{id}', [SettingsController::class, 'markRead']);
});

// Settings page: allow any authenticated user to view selectable panels (UI controls limit panel access)
Route::get('/SystemSettings_pagination', [SettingsController::class, 'showSettings'])->name('SystemSettings_pagination');

Route::middleware(['role:superadmin,admin,officer'])->group(function () {
    // Manage Data routes (backup / restore / delete)
    Route::post('/settings/data/backup', [SettingsController::class, 'backupData'])->name('settings.data.backup');
    Route::post('/settings/data/restore', [SettingsController::class, 'restoreData'])->name('settings.data.restore');
    Route::post('/settings/data/delete', [SettingsController::class, 'deleteData'])->name('settings.data.delete');
    // Fees Setting
    Route::get('/FeesSetting_pagination', [FeesController::class, 'ShowFeesView'])->name('FeesSetting_pagination');
    Route::post('/store_fee', [FeesController::class, 'store_fee'])->name('store_fee');
    Route::post('/update_fee', [FeesController::class, 'update_fee'])->name('update_fee');
    Route::post('/delete_fee', [FeesController::class, 'delete_fee'])->name('delete_fee');
    // Fee Types
    Route::post('/store_fee_type', [FeeTypesController::class, 'store_fee_type'])->name('store_fee_type');
    Route::post('/update_fee_type', [FeeTypesController::class, 'update_fee_type'])->name('update_fee_type');
    Route::post('/delete_fee_type', [FeeTypesController::class, 'delete_fee_type'])->name('delete_fee_type');

        // Manage College
        Route::post('/store_college', [ManageCollegeController::class, 'store_college'])->name('store_college');
        Route::post('/update_college', [ManageCollegeController::class, 'update_college'])->name('update_college');
        Route::post('/delete_college', [ManageCollegeController::class, 'delete_college'])->name('delete_college');

        // Manage Campus
        Route::post('/store_campus', [ManageCampusController::class, 'store_campus'])->name('store_campus');
        Route::post('/update_campus', [ManageCampusController::class, 'update_campus'])->name('update_campus');
        Route::post('/delete_campus', [ManageCampusController::class, 'delete_campus'])->name('delete_campus');

        // Manage Semester
        Route::post('/store_semester', [ManageSemesterController::class, 'store_semester']);
        Route::post('/update_semester', [ManageSemesterController::class, 'update_semester']);
        Route::post('/delete_semester', [ManageSemesterController::class, 'delete_semester']);

        // Manage Organization
        Route::post('/store_organization', [ManageOrganizationController::class, 'store_organization']);
        Route::post('/update_organization', [ManageOrganizationController::class, 'update_organization']);
        Route::post('/delete_organization', [ManageOrganizationController::class, 'delete_organization']);

        // Manage Roles
        Route::post('/store_role', [App\Http\Controllers\SystemSettingsController\ManageRolesController::class, 'store_role'])->name('store_role');
        Route::post('/update_role', [App\Http\Controllers\SystemSettingsController\ManageRolesController::class, 'update_role'])->name('update_role');
        Route::post('/delete_role', [App\Http\Controllers\SystemSettingsController\ManageRolesController::class, 'delete_role'])->name('delete_role');

        // Manage Users
        Route::post('/store_user', [UsersManagementController::class, 'store_user'])->name('store_user');
        Route::post('/update_user', [UsersManagementController::class, 'update_user'])->name('update_user');
        Route::post('/delete_user', [UsersManagementController::class, 'delete_user'])->name('delete_user');

        // Manage Programs
        Route::post('/store_program', [ManageProgramsController::class, 'store'])->name('store_program');
        Route::post('/update_program', [ManageProgramsController::class, 'update'])->name('update_program');
        Route::post('/delete_program', [ManageProgramsController::class, 'delete_program'])->name('delete_program');
    });
});





// Registration routes
Route::get('/usersRegistration', [UsersRegistrationController::class, 'showRegistrationForm'])->name('usersRegistration');
Route::post('/register', [UsersRegistrationController::class, 'register'])->name('register');

// ── Debug: Login Issue Diagnostic ────────────────────────────────────────────
// Protected by auth — only accessible to logged-in users.
// Visit /debug/login-issue to run the diagnostic and view results in the browser.
// Remove or restrict this route once the issue is resolved.
Route::get('/debug/login-issue', function () {
    $email    = request('email', 'developerdev631@gmail.com');
    $password = request('password', '12345678');

    $command = new \App\Console\Commands\DebugLoginIssue();

    // Capture Artisan output into a string buffer
    $output = new \Symfony\Component\Console\Output\BufferedOutput();
    $input  = new \Symfony\Component\Console\Input\ArrayInput([
        '--email'    => $email,
        '--password' => $password,
    ]);

    $command->setLaravel(app());
    $command->run($input, $output);

    $result = $output->fetch();

    // Strip ANSI colour codes so the browser renders plain text cleanly
    $result = preg_replace('/\x1B\[[0-9;]*[mGKHF]/u', '', $result);

    return response(
        '<html><head><title>Login Debug</title>'
        . '<style>body{background:#1e1e1e;color:#d4d4d4;font-family:monospace;padding:2rem;white-space:pre-wrap;font-size:14px;line-height:1.6;}</style>'
        . '</head><body>'
        . htmlspecialchars($result, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . '</body></html>',
        200,
        ['Content-Type' => 'text/html']
    );
})->middleware('auth')->name('debug.login-issue');


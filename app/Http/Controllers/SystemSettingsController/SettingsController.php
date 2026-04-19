<?php

namespace App\Http\Controllers\SystemSettingsController;

use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Models\SystemSettingsModel\ManageCollegeModel;
use App\Models\SystemSettingsModel\ManageCampusModel;
use App\Models\SystemSettingsModel\ManageProgramsModel;
use App\Models\SystemSettingsModel\ManageOrganizationModel;
use App\Models\SystemSettingsModel\ManageSemesterModel;
use App\Models\SystemSettingsModel\ManageRolesModel;
use App\Models\FeesModel;
use App\Models\User;
use App\Support\SettingsPanel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function showSettings(Request $request)
    {
        $activePanel = SettingsPanel::resolve($request->query('panel'));

        // Fetch dropdown data
        $areas = ManageCampusModel::whereNull('deleted_at')->get();
        $colleges = ManageCollegeModel::whereNull('deleted_at')->get();
        $organizations = ManageOrganizationModel::whereNull('deleted_at')->get();
        $semesters = ManageSemesterModel::whereNull('deleted_at')->get();
        $programs = ManageProgramsModel::whereNull('deleted_at')->get();
        $roles = ManageRolesModel::whereNull('deleted_at')->get();

        // Fetch all records (for backward compatibility)
        $campus = ManageCampusModel::all();
        $college = ManageCollegeModel::all();
        $programs = ManageProgramsModel::all();
        $organizations = ManageOrganizationModel::all();
        $myaccount = User::all();
        $semesters = ManageSemesterModel::all();


        $fee = FeesModel::query()->whereNull('deleted_at')->orderBy('id')->first();
        $membershipFee = FeesModel::where('fee_name', 'like', '%Membership%')->whereNull('deleted_at')->first();
        $attendanceFee = FeesModel::where('fee_name', 'like', '%Attendance%')->whereNull('deleted_at')->first();

        return view('SystemSettingsView.Settings', compact(
            'campus',
            'college',
            'semesters',
            'organizations',
            'programs',
            'roles',
            'activePanel',
            'fee',
            'membershipFee',
            'attendanceFee',
            'areas',
            'colleges',
            'myaccount'
        ));
    }



    public function index()
    {
        $activities = Activity::latest()->get();
        $notifications = Notification::latest()->get();

        return view('settings', compact('activities', 'notifications','campus' ));
    }

    public function markRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = 1;
        $notification->save();

        return response()->json(['success' => true]);
    }

    /**
     * Create a lightweight placeholder backup (stores metadata file).
     */
    public function backupData(Request $request)
    {
        $timestamp = now()->format('Ymd_His');
        $filename = "backup_{$timestamp}.json";
        $data = [
            'created_at' => now()->toDateTimeString(),
            'user_id' => auth()->id(),
            'note' => 'Placeholder backup — implement full DB dump for production.',
        ];

        Storage::put('backups/'.$filename, json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Backup created: '.$filename);
    }

    /**
     * Accept an uploaded backup file and store it in storage/app/backups.
     */
    public function restoreData(Request $request)
    {
        $request->validate(['backup_file' => 'required|file']);
        $path = $request->file('backup_file')->store('backups');

        return redirect()->back()->with('success', 'Backup uploaded: '.basename($path));
    }

    /**
     * Placeholder delete operation: does not remove DB but accepts scope and acknowledges.
     */
    public function deleteData(Request $request)
    {
        $scope = $request->input('scope', 'all');

        // NOTE: Destructive operations must be implemented carefully. This is a placeholder.
        return redirect()->back()->with('success', 'Delete requested (scope: '.$scope.'). No action taken in stub.');
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ViolationManagementModel;
use App\Models\ViolationManagementModels\StudentsViolationsModel;
use App\Models\FeesModel;
use App\Models\SystemSettingsModel\ManageCampusModel;
use App\Models\SystemSettingsModel\ManageCollegeModel;
use App\Models\SystemSettingsModel\ManageOrganizationModel;


class ViolationManagementController extends Controller
{
         function ShowViolationManagementView()
    {
        $user = Auth::user();
        $students_violations = StudentsViolationsModel::where('deleted_at', '0000-00-00 00:00:00')->get();
        $violation = ViolationManagementModel::whereNull('deleted_at')->get();
        $fees = FeesModel::where('status', 'A')->get();
        $violations = ViolationManagementModel::where('status', 'A')->get();
        $areas = ManageCampusModel::all();
        $colleges = ManageCollegeModel::all();
        $organizations = ManageOrganizationModel::all();

        return view('ViolationsManagementView.StudentsViolationsManagement', compact('user', 'violation', 'students_violations', 'fees', 'violations', 'areas', 'colleges', 'organizations'));
    }


    function store_student_violation(Request $request)
    {
        $studentViolation = new StudentsViolationsModel();
        $studentViolation->id = $request->sv_id;
        $studentViolation->area_code = $request->sv_area_code;
        $studentViolation->college_id = $request->sv_college_id;
        $studentViolation->course_id = $request->sv_course_id;
        $studentViolation->organization_id = $request->sv_organization_id;
        $studentViolation->sid = $request->sv_student_id;
        $studentViolation->vid = $request->sv_vid;
        $studentViolation->date_issued = $request->sv_date_issued;
        $studentViolation->fee = $request->sv_fee;
        $studentViolation->status = 'A'; // Set status to A (active) by default

        $studentViolation->save();

        return redirect()->back()->with('success', 'Student violation added successfully!');
    }

    function update_student_violation(Request $request)
    {
        $studentViolation = StudentsViolationsModel::where('id', $request->esv_id)->first();
        $studentViolation->area_code = $request->esv_area_code;
        $studentViolation->college_id = $request->esv_college_id;
        $studentViolation->course_id = $request->esv_course_id;
        $studentViolation->organization_id = $request->esv_organization_id;
        $studentViolation->sid = $request->esv_student_id;
        $studentViolation->vid = $request->esv_vid;
        $studentViolation->date_issued = $request->esv_date_issued;
        $studentViolation->fee = $request->esv_fee;
        $studentViolation->status = $request->esv_status;

        $studentViolation->save();

        return redirect()->back()->with('success', 'Student violation updated successfully!');
    }

    function delete_student_violation(Request $request)
    {
        $studentViolation = StudentsViolationsModel::where('id', $request->dasv_id)->first();
        $studentViolation->delete();

        return redirect()->back()->with('success', 'Student violation deleted successfully!');
    }
}


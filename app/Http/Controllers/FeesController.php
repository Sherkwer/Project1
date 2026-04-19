<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FeesModel;
use App\Models\ViolationManagementModel;
use App\Models\FeeTypesModel;
use App\Models\SystemSettingsModel\ManageCampusModel;
use App\Models\SystemSettingsModel\ManageCollegeModel;
use App\Models\SystemSettingsModel\ManageOrganizationModel;

class FeesController extends Controller
{
    function ShowFees()
    {
        $user = Auth::user();
        $fees = FeesModel::all();
        $violations = ViolationManagementModel::all();
        $areas = ManageCampusModel::whereNull('deleted_at')->get();
        $colleges = ManageCollegeModel::all();
        $feeTypes = FeeTypesModel::whereNull('deleted_at')->get();
        $organizations = ManageOrganizationModel::whereNull('deleted_at')->get();
        $membershipFee = FeesModel::where('fee_name', 'like', '%Membership%')->whereNull('deleted_at')->first();
        $attendanceFee = FeesModel::where('fee_name', 'like', '%Attendance%')->whereNull('deleted_at')->first();
        return view('FeesView.Fees', compact('user','fees', 'violations', 'areas', 'colleges', 'feeTypes', 'organizations', 'membershipFee', 'attendanceFee'));
    }

    function store_violation(Request $request )
    {

        $violation = new ViolationManagementModel();
        $violation->id = $request->id;
        $violation->vname = $request->vname;
        $violation->date_implemented = $request->date_implemented;
        $violation->fee = $request->fee;
        $violation->description = $request->description;
        $violation->status = 'A'; // Set status to A (active) by default

        $violation->save();

        return redirect()->back()->with('success', 'Violation added successfully!');
    }

    function update_violation(Request $request)
    {
        $violation = ViolationManagementModel::where('id', $request->e_id)->first();
        $violation->vname = $request->e_vname;
        $violation->date_implemented = $request->e_date_implemented;
        $violation->fee = $request->e_fee;
        $violation->description = $request->e_description;
        $violation->status = $request->e_status;

        $violation->save();

        return redirect()->back()->with('success', 'Violation updated successfully!');
    }

    function delete_violation(Request $request)
    {
        $violation = ViolationManagementModel::where('id', $request->da_id)->first();
        $violation->delete();

        return redirect()->back()->with('success', 'Violation deleted successfully!');
    }

    function store_fee(Request $request)
    {
        $request->validate([
            'area_code' => 'required|string|max:191',
            'college_id' => 'required|integer',
            'organization_id' => 'nullable|integer',
            'fee_name' => 'required|string|max:191',
            'fee_type_id' => 'nullable|integer',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:A,I', // Active or Inactive
        ]);

        $fee = new FeesModel();
        $fee->area_code = $request->area_code;
        $fee->college_id = $request->college_id;
        $fee->organization_id = $request->organization_id;
        $fee->fee_name = $request->fee_name;
        $fee->fee_type_id = $request->fee_type_id;
        $fee->amount = $request->amount;
        $fee->description = $request->description;
        $fee->status = $request->status ?? 'A';
        $fee->save();

        return redirect()->back()->with('success', 'Fee added successfully!');
    }

    function update_fee(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tbl_fees,id',
            'area_code' => 'required|string|max:191',
            'college_id' => 'required|integer',
            'organization_id' => 'nullable|integer',
            'fee_name' => 'required|string|max:191',
            'fee_type_id' => 'nullable|integer',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:A,I',
        ]);

        $fee = FeesModel::find($request->id);
        $fee->area_code = $request->area_code;
        $fee->college_id = $request->college_id;
        $fee->organization_id = $request->organization_id;
        $fee->fee_name = $request->fee_name;
        $fee->fee_type_id = $request->fee_type_id;
        $fee->amount = $request->amount;
        $fee->description = $request->description;
        $fee->status = $request->status;
        $fee->save();

        return redirect()->back()->with('success', 'Fee updated successfully!');
    }

    function delete_fee(Request $request)
    {
        $fee = FeesModel::find($request->id);
        if ($fee) {
            $fee->delete(); // Soft delete
        }

        return redirect()->back()->with('success', 'Fee deleted successfully!');
    }
}

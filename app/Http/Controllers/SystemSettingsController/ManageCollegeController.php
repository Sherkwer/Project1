<?php

namespace App\Http\Controllers\SystemSettingsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SystemSettingsModel\ManageCollegeModel;
use App\Support\SettingsPanel;

class ManageCollegeController extends Controller
{



    public function store_college(Request $request)
    {
        $request->validate([
            'c_area_code' => 'required|exists:areas,area_code',
            'c_name' => 'required'
        ]);

        if (!$request->c_area_code || $request->c_area_code == 'N/A') {
            return back()->withErrors(['c_area_code' => 'Please select a valid area code.']);
        }

        $college = new ManageCollegeModel();
        $college->area_code = $request->c_area_code;
        $college->name = $request->c_name;
        $college->prefix = $request->c_prefix;
        $college->head_officer = $request->c_head_officer;

        $college->save();

        return SettingsPanel::backOrSettings($request, ['success' => 'College added successfully.']);
    }

    public function update_college(Request $request)
    {
        $request->validate([
            'c_id' => 'required|exists:db_colleges,id',
            'edit_area_code' => 'required|exists:areas,area_code',
            'edit_name' => 'required',
        ]);

        if (!$request->edit_area_code || $request->edit_area_code == 'N/A') {
            return back()->withErrors(['edit_area_code' => 'Please select a valid area code.']);
        }

        $college = ManageCollegeModel::find($request->c_id);

        if (!$college) {
            return SettingsPanel::backOrSettings($request, ['error' => 'College not found.']);
        }

        $college->area_code = $request->edit_area_code;
        $college->name = $request->edit_name;
        $college->prefix = $request->edit_prefix;
        $college->head_officer = $request->edit_head_officer;

        $college->save();

        return SettingsPanel::backOrSettings($request, ['success' => 'College updated successfully.']);
    }

    public function delete_college(Request $request)
    {
        $college = ManageCollegeModel::where('id', $request->c_id)->first();

        if (!$college) {
            return SettingsPanel::backOrSettings($request, ['error' => 'College not found.']);
        }

        $college->delete();

        return SettingsPanel::backOrSettings($request, ['success' => 'College deleted successfully.']);
    }

}

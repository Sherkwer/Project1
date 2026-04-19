<?php

namespace App\Http\Controllers\SystemSettingsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SystemSettingsModel\ManageCampusModel;
use App\Support\SettingsPanel;

class ManageCampusController extends Controller
{

    public function store_campus(Request $request)
    {
        $request->validate([
            'c_area_code' => 'required',
            'c_area_address' => 'required'
        ]);

        $campus = new ManageCampusModel();
        $campus->area_code = $request->c_area_code;
        $campus->area_address = $request->c_area_address;
        $campus->area_report_header_path = $request->c_area_report_header_path;
        $campus->receipt_template = $request->c_receipt_template;
        $campus->receipt_print_option = $request->c_receipt_print_option;

        $campus->save();

        return SettingsPanel::backOrSettings($request, ['success' => 'Campus added successfully.']);
    }

    public function update_campus(Request $request)
    {
        $request->validate([
            'c_id' => 'required|exists:areas,id',
            'edit_area_code' => 'required',
            'edit_area_address' => 'required',
        ]);

        $campus = ManageCampusModel::find($request->c_id);

        if (!$campus) {
            return SettingsPanel::backOrSettings($request, ['error' => 'Campus not found.']);
        }

        $campus->area_code = $request->edit_area_code;
        $campus->area_address = $request->edit_area_address;
        $campus->area_report_header_path = $request->edit_area_report_header_path;
        $campus->receipt_template = $request->edit_receipt_template;
        $campus->receipt_print_option = $request->edit_receipt_print_option;

        $campus->save();

        return SettingsPanel::backOrSettings($request, ['success' => 'Campus updated successfully.']);
    }

    public function delete_campus(Request $request)
    {
        $campus = ManageCampusModel::where('id', $request->c_id)->first();

        if (!$campus) {
            return SettingsPanel::backOrSettings($request, ['error' => 'Campus not found.']);
        }

        $campus->delete();

        return SettingsPanel::backOrSettings($request, ['success' => 'Campus deleted successfully.']);
    }

}

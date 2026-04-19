<?php

namespace App\Http\Controllers\SystemSettingsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SystemSettingsModel\ManageOrganizationModel;
use App\Support\SettingsPanel;

class ManageOrganizationController extends Controller
{
    public function store_organization(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string'
        ]);

        $organization = new ManageOrganizationModel();
        $organization->name = $request->name;
        $organization->description = $request->description;
        $organization->area_code = $request->campus_id; // Assuming campus is stored as area_code
        $organization->college_id = $request->college_id; // Assuming college is stored as college_id

        $organization->save();

        return SettingsPanel::backOrSettings($request, ['success' => 'Organization added successfully.']);
    }

    public function update_organization(Request $request)
{
    $request->validate([
        'id' => 'required|exists:tbl_organizations,id',
        'edit_name' => 'required|string|max:50',
        'edit_description' => 'nullable|string'
    ]);

    $organization = ManageOrganizationModel::find($request->id);

    if (!$organization) {
        return SettingsPanel::backOrSettings($request, ['error' => 'Organization not found.']);
    }

    $organization->name = $request->edit_name;
    $organization->description = $request->edit_description;
    $organization->area_code = $request->edit_campus; // Assuming campus is stored as area_code
    $organization->college_id = $request->edit_college; // Assuming college is stored

    $organization->save();

    return SettingsPanel::backOrSettings($request, ['success' => 'Organization updated successfully.']);
}

    public function delete_organization(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tbl_organizations,id'
        ]);

        $organization = ManageOrganizationModel::find($request->id);

        if (!$organization) {
            return SettingsPanel::backOrSettings($request, ['error' => 'Organization not found.']);
        }

        $organization->delete();

        return SettingsPanel::backOrSettings($request, ['success' => 'Organization deleted successfully.']);
    }
}

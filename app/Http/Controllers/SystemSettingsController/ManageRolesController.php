<?php

namespace App\Http\Controllers\SystemSettingsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SystemSettingsModel\ManageRolesModel;
use App\Support\SettingsPanel;
use Illuminate\Support\Facades\Auth;

class ManageRolesController extends Controller
{
    public function store_role(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        \App\Models\SystemSettingsModel\ManageRolesModel::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return SettingsPanel::backOrSettings($request, ['success' => 'Role added successfully.']);
    }

    public function update_role(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tbl_roles,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $role = ManageRolesModel::find($request->id);
        if (!$role) {
            return SettingsPanel::backOrSettings($request, ['error' => 'Role not found.']);
        }

        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        return SettingsPanel::backOrSettings($request, ['success' => 'Role updated successfully.']);
    }

    public function delete_role(Request $request)
    {
        $role = ManageRolesModel::where('id', $request->id)->first();
        if (!$role) {
            return SettingsPanel::backOrSettings($request, ['error' => 'Role not found.']);
        }

        $role->delete();

        return SettingsPanel::backOrSettings($request, ['success' => 'Role deleted successfully.']);
    }
}


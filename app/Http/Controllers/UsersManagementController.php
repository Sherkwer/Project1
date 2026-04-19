<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\SettingsPanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersManagementController extends Controller
{
    public function store_user(Request $request)
    {
        $validated = $request->validate([
            'u_fname' => 'required|string|max:255',
            'u_mname' => 'nullable|string|max:255',
            'u_lname' => 'required|string|max:255',
            'u_email' => 'required|email|unique:users,email',
            'u_password' => 'required|string|min:6',
            'u_user_role' => 'required|string|max:255',
            'u_area_code' => 'nullable|string|max:255',
            'u_department_id' => 'nullable|integer|exists:db_colleges,id',
            'u_organization_id' => 'nullable|integer|exists:tbl_organizations,id',
            'u_is_approved' => 'required|boolean',
            'u_is_admin' => 'required|boolean',
        ]);

        $fullname = trim($validated['u_fname'] . ' ' . ($validated['u_mname'] ?? '') . ' ' . $validated['u_lname']);

        User::create([
            'fname' => $validated['u_fname'],
            'mname' => $validated['u_mname'] ?? null,
            'lname' => $validated['u_lname'],
            'fullname' => preg_replace('/\s+/', ' ', $fullname),
            'email' => $validated['u_email'],
            'password' => Hash::make($validated['u_password']),
            'user_role' => $validated['u_user_role'],
            'area_code' => $validated['u_area_code'] ?? null,
            'department_id' => $validated['u_department_id'] ?? null,
            'organization_id' => $validated['u_organization_id'] ?? null,
            'is_approved' => $validated['u_is_approved'],
            'is_admin' => $validated['u_is_admin'],
        ]);

        return SettingsPanel::redirectWith($request, ['success' => 'User created successfully.']);
    }

    public function update_user(Request $request)
    {
        $validated = $request->validate([
            'u_id' => 'required|integer|exists:users,id',
            'edit_fname' => 'required|string|max:255',
            'edit_mname' => 'nullable|string|max:255',
            'edit_lname' => 'required|string|max:255',
            'edit_email' => 'required|email|unique:users,email,' . $request->input('u_id'),
            'edit_user_role' => 'required|string|max:255',
            'edit_area_code' => 'nullable|string|max:255',
            'edit_department_id' => 'nullable|integer|exists:db_colleges,id',
            'edit_organization_id' => 'nullable|integer|exists:tbl_organizations,id',
            'edit_is_approved' => 'required|boolean',
            'edit_is_admin' => 'required|boolean',
        ]);

        $user = User::findOrFail($validated['u_id']);

        $fullname = trim($validated['edit_fname'] . ' ' . ($validated['edit_mname'] ?? '') . ' ' . $validated['edit_lname']);

        $user->update([
            'fname' => $validated['edit_fname'],
            'mname' => $validated['edit_mname'] ?? null,
            'lname' => $validated['edit_lname'],
            'fullname' => preg_replace('/\s+/', ' ', $fullname),
            'email' => $validated['edit_email'],
            'user_role' => $validated['edit_user_role'],
            'area_code' => $validated['edit_area_code'] ?? null,
            'department_id' => $validated['edit_department_id'] ?? null,
            'organization_id' => $validated['edit_organization_id'] ?? null,
            'is_approved' => $validated['edit_is_approved'],
            'is_admin' => $validated['edit_is_admin'],
        ]);

        return SettingsPanel::redirectWith($request, ['success' => 'User updated successfully.']);
    }

    public function delete_user(Request $request)
    {
        $validated = $request->validate([
            'u_id' => 'required|integer|exists:users,id',
        ]);

        User::findOrFail($validated['u_id'])->delete();

        return SettingsPanel::redirectWith($request, ['success' => 'User deleted successfully.']);
    }
}

<?php

namespace App\Http\Controllers\SystemSettingsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SystemSettingsModel\ManageProgramsModel;
use App\Support\SettingsPanel;
use Illuminate\Support\Facades\Auth;

class ManageProgramsController extends Controller
{
    public function index()
    {
        $programs = ManageProgramsModel::all();
        return view('SystemSettingsView.ManagePrograms', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'area_code' => 'required|exists:areas,area_code',
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'college_id' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        if (!$request->area_code || $request->area_code == 'N/A') {
            return back()->withErrors(['area_code' => 'Please select a valid area code.']);
        }

        ManageProgramsModel::create([
            'area_code' => $request->area_code,
            'code' => $request->code,
            'name' => $request->name,
            'college_id' => $request->college_id,
            'status' => $request->status,
            'created_user_id' => Auth::id(),
        ]);

        return SettingsPanel::backOrSettings($request, ['success' => 'Program created successfully.']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:db_courses,id',
            'area_code' => 'required|exists:areas,area_code',
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'college_id' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        if (!$request->area_code || $request->area_code == 'N/A') {
            return back()->withErrors(['area_code' => 'Please select a valid area code.']);
        }

        $program = ManageProgramsModel::findOrFail($request->id);
        $program->update([
            'area_code' => $request->area_code,
            'code' => $request->code,
            'name' => $request->name,
            'college_id' => $request->college_id,
            'status' => $request->status,
            'updated_user_id' => Auth::id(),
        ]);

        return SettingsPanel::backOrSettings($request, ['success' => 'Program updated successfully.']);
    }

    public function delete_program(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:db_courses,id',
        ]);

        $program = ManageProgramsModel::findOrFail($request->id);
        $program->update(['deleted_user_id' => Auth::id()]);
        $program->delete(); // Soft delete

        return SettingsPanel::backOrSettings($request, ['success' => 'Program deleted successfully.']);
    }
}

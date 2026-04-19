<?php

namespace App\Http\Controllers\SystemSettingsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SystemSettingsModel\ManageSemesterModel;
use App\Support\SettingsPanel;

class ManageSemesterController extends Controller
{

    public function store_semester(Request $request)
        {
            $request->validate([
                's_code' => 'required',
                's_name' => 'required',
                's_year' => 'required',
                's_term' => 'required'
            ]);

            $semester = new ManageSemesterModel();
            $semester->code = $request->s_code;
            $semester->name = $request->s_name;
            $semester->year = $request->s_year;
            $semester->term = $request->s_term;

            $semester->save();

            return SettingsPanel::backOrSettings($request, ['success' => 'Semester added successfully.']);
        }

    public function update_semester(Request $request)
        {
            $request->validate([
                's_id' => 'required|exists:db_periods,id',
                'edit_code' => 'required',
                'edit_name' => 'required',
                'edit_year' => 'required',
                'edit_term' => 'required'
            ]);

            $semester = ManageSemesterModel::find($request->s_id);

            if (!$semester) {
                return SettingsPanel::backOrSettings($request, ['error' => 'Semester not found.']);
            }

            $semester->code = $request->edit_code;
            $semester->name = $request->edit_name;
            $semester->year = $request->edit_year;
            $semester->term = $request->edit_term;

            $semester->save();

            return SettingsPanel::backOrSettings($request, ['success' => 'Semester updated successfully.']);
        }

    public function delete_semester(Request $request)
        {
            $semester = ManageSemesterModel::where('id', $request->s_id)->first();

            if (!$semester) {
                return SettingsPanel::backOrSettings($request, ['error' => 'Semester not found.']);
            }

            $semester->delete();

            return SettingsPanel::backOrSettings($request, ['success' => 'Semester deleted successfully.']);
        }
}

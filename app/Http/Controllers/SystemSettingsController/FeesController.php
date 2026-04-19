<?php

namespace App\Http\Controllers\SystemSettingsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FeesModel;
use App\Support\SettingsPanel;


class FeesController extends Controller
{
    function ShowFeesView()
    {
        $fees = FeesModel::whereNull('deleted_at')->get();
        $student = FeesModel::all();
        return view('SystemSettingsView.FeesSettingView.FeesSetting', compact('fees'));
    }

    function store_fee(Request $request )
    {

        $fee = new FeesModel();
        $fee->id = $request->id;
        $fee->area_code = $request->area_code;
        $fee->college_id = $request->college_id;
        $fee->fee_name = $request->fee_name;
        $fee->fee_type_id = $request->fee_type_id;
        $fee->amount = $request->amount;
        $fee->description = $request->description;
        $fee->status = 'A'; // Set status to A (active) by default

        $fee->save();

        return SettingsPanel::backOrSettings($request, ['success' => 'Fee added successfully!']);
    }

    function update_fee(Request $request)
    {
        $fee = FeesModel::where('id', $request->e_id)->first();
        $fee->area_code = $request->e_area_code;
        $fee->college_code = $request->e_college_code;
        $fee->fee_name = $request->e_fee_name;
        $fee->fee_type_id = $request->e_fee_type_id;
        $fee->amount = $request->e_amount;
        $fee->description = $request->e_description;
        $fee->status = $request->e_status;

        $fee->save();

        return SettingsPanel::backOrSettings($request, ['success' => 'Fee updated successfully!']);
    }

}

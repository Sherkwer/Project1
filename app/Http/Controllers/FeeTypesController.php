<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeTypesModel;

class FeeTypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store_fee_type(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:tbl_fee_types,name',
            'status' => 'required|in:A,I',
        ]);

        $feeType = new FeeTypesModel();
        $feeType->name = $request->name;
        $feeType->status = $request->status ?? 'A';
        $feeType->save();

        return redirect()->back()->with('success', 'Fee Type added successfully!');
    }

    public function update_fee_type(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tbl_fee_types,id',
            'name' => 'required|string|max:191|unique:tbl_fee_types,name,' . $request->id,
            'status' => 'required|in:A,I',
        ]);

        $feeType = FeeTypesModel::find($request->id);
        $feeType->name = $request->name;
        $feeType->status = $request->status;
        $feeType->save();

        return redirect()->back()->with('success', 'Fee Type updated successfully!');
    }

    public function delete_fee_type(Request $request)
    {
        $feeType = FeeTypesModel::find($request->id);
        if ($feeType) {
            $feeType->delete(); // Soft delete
        }

        return redirect()->back()->with('success', 'Fee Type deleted successfully!');
    }
}

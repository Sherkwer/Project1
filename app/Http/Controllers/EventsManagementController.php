<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventsManagementModel;
use App\Models\FeesModel;
use App\Http\Controllers\Controller;


class EventsManagementController extends Controller
{
    function ShowEvents()
    {
        $event = EventsManagementModel::all();
        $fees = FeesModel::all();
        $defaultFee = FeesModel::where('status', 'A')->first();
        $attendanceFee = FeesModel::where('fee_name', 'like', '%Attendance%')->whereNull('deleted_at')->first();

        return view('EventsManagement_View.EventsManagement', compact('event', 'fees', 'defaultFee', 'attendanceFee'));
    }

    function store_event(Request $request)
    {
        $event = new EventsManagementModel();
        $event->id= $request->e_id;
        $event->event_name= $request->e_event_name;
        $event->schedule= $request->e_schedule;
        $event->sy= $request->e_sy;
        $event->term= $request->e_term;
        $event->venue= $request->e_venue;
        $event->am_in= $request->has('e_am_in') ? $request->e_am_in : 'N/A';
        $event->am_out= $request->has('e_am_out') ? $request->e_am_out : 'N/A';
        $event->pm_in= $request->has('e_pm_in') ? $request->e_pm_in : 'N/A';
        $event->pm_out= $request->has('e_pm_out') ? $request->e_pm_out : 'N/A';
        $event->description= $request->e_description;
        $event->fee_perSession= $request->e_fee_perSession;
        $event->status= 'A'; // Set status to A (active) by default

        $event->save();

        return back()->with('success', 'Event saved successfully.');
    }

    function getDefaultFee()
    {
        $defaultFee = FeesModel::where('status', 'A')->first();
        return response()->json([
            'amount' => $defaultFee ? $defaultFee->amount : 0.00
        ]);
    }

    public function update_event(Request $request)
    {
        // Find the existing event by ID
        $event = EventsManagementModel::where('id', $request->edit_e_id)->first();

        // Update fields
        $event->event_name = $request->edit_e_event_name;
        $event->schedule = $request->edit_e_schedule;
        $event->sy = $request->edit_e_sy;
        $event->term = $request->edit_e_term;
        $event->venue = $request->edit_e_venue;
        $event->am_in = $request->has('edit_e_am_in') ? $request->edit_e_am_in : 'N/A';
        $event->am_out = $request->has('edit_e_am_out') ? $request->edit_e_am_out : 'N/A';
        $event->pm_in = $request->has('edit_e_pm_in') ? $request->edit_e_pm_in : 'N/A';
        $event->pm_out = $request->has('edit_e_pm_out') ? $request->edit_e_pm_out : 'N/A';
        $event->description = $request->edit_e_description;
        $event->status = $request->edit_status;
        $event->fee_perSession = $request->edit_e_fee_perSession;

        // Optional: update status if needed
        // $event->status = $request->edit_e_status;

        // Save changes
        $event->save();

        return back()->with('success', 'Event updated successfully.');
    }

    public function delete_event(Request $request)
    {
        $event = EventsManagementModel::where('id', $request->da_id)->first();
        $event->delete();

        return back()->with('success', 'Event deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentsPayBillsController extends Controller
{
    function ShowStudentsPayBills()
    {
        return view('StudentsPayBillsView.StudentsPayBills');
    }
}

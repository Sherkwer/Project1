<?php

namespace App\Http\Controllers\ReportController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserReportController extends Controller
{
    function ShowUserReport()
    {
        return view('ReportsView.UserReportView.UserReport');
    }
}

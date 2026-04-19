<?php

namespace App\Http\Controllers\ReportController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function ShowPaymentHistory()
    {
        return view('ReportsView.PaymentHistory');
    }
}

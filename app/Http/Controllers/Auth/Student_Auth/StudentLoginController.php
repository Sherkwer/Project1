<?php

namespace App\Http\Controllers\Auth\Student_Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class StudentLoginController extends Controller
{
    /**
     * Show the student login form
     */
    public function index()
    {
        return view('auth.Students.studentLogin');
    }
}

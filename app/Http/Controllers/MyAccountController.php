<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class MyAccountController extends Controller
{
    public function viewProfile()
    {
        $myaccount = User::all();
        return view('MyAccount_View.Profile', compact('myaccount'));
    }

    public function viewUpdateProfilePage()
    {
        $myaccount = User::all();
        return view('MyAccount_View.UpdateProfilePage', compact('myaccount'));
    }

    function store_myaccount(Request $request)
    {
        $myaccount = new User();
        $myaccount->id= $request->s_id;
        $myaccount->fname= $request->s_fname;
        $myaccount->mname= $request->s_mname;
        $myaccount->lname= $request->s_lname;
        $myaccount->fullname= $request->s_fullname;
        $myaccount->rid= $request->s_rid;
        $myaccount->department_id= $request->s_department_id;
        $myaccount->user_role= $request->s_user_role;
        $myaccount->department_id= $request->s_department_id;
        $myaccount->save();

        return response()->json($myaccount);
    }
}

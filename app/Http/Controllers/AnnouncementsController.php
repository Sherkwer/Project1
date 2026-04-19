<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    function ShowAnnouncements()
    {

        return view('Announcements_View.Announcements');
    }

}

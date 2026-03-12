<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    function dashboard()
    {
        return view('manager.dashboard');
    }

    function monitoring()
    {
        return view('manager.monitoring');
    }
    function report()
    {
        return view('manager.report');
    }
}

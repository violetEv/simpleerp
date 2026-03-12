<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
{
    public function dashboard()
    {
        return view('produksi.dashboard');
    }
    public function dataIn()
    {
        return view('produksi.datain');
        // $department = Auth::user()->department;

        // return view("produksi.datain.{$department->slug}", compact('department'));
    }
    public function dataOut()
    {
        return view('produksi.dataout');
    }
    public function listapprove()
    {
        return view('produksi.listapprove');
    }
    public function listproblem()
    {
        return view('produksi.listproblem');
    }
    public function log()
    {
        return view('produksi.log');
    }
}

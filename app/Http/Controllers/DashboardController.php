<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'super_admin' => redirect()->route('superadmin.dashboard'),
            'manager' => redirect()->route('manager.dashboard'),
            'ppic' => redirect()->route('ppic.dashboard'),
            'produksi' => redirect()->route('produksi.dashboard'),
            'warehouse' => redirect()->route('warehouse.dashboard'),
            default => view('dashboard')
        };
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Kkpo;
use App\Models\TravelerMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    function dashboard()
    {
        return view('manager.dashboard');
    }

    public function monitoring(Request $request)
    {
        $query = TravelerMovement::with('traveler', 'department')
            ->whereHas('traveler', function ($q) use ($request) {
                if ($request->filled('search')) {
                    $search = $request->search;
                    $q->where('no_traveler', 'like', "%{$search}%");
                }
            });
        $movements = $query->paginate(10)->withQueryString();
        return view('manager.monitoring', compact('movements'));
    }

    public function detailMonitoring($id)
    {
        $movement = TravelerMovement::with('traveler', 'deptTujuan')->findOrFail($id);
        return view('manager.detailmonitoring', compact('movement'));
    }

    public function report(Request $request)
    {
        //menampilkan data report dan hanya menampilkan satu data per kkpo
        // untuk search dan filter terus menampilkan data surat jalan, kkpo, qty awal dan akhir pergerakan traveler
        $query = TravelerMovement::with('traveler', 'department')
            ->whereHas('traveler', function ($q) use ($request) {
                if ($request->filled('search')) {
                    $search = $request->search;
                    $q->where('no_traveler', 'like', "%{$search}%");
                }
            });
        // menampilkan data kkpo dan qty awal akhir pergerakan traveler
        $query->with(['traveler.suratJalan.kkpoManagement', 'traveler.movements' => function ($q) {
            $q->orderBy('created_at', 'asc');
        }]);
        $movements = $query->paginate(10)->withQueryString();
        return view('manager.report', compact('movements'));
    }

    public function detailReport($id)
    {
        // $movement = TravelerMovement::with('traveler', 'department')->findOrFail($id);
        // return view('manager.detailreport', compact('movement'));
        $movement = TravelerMovement::with('traveler.suratJalan.kkpoManagement.customer', 'traveler.suratJalan.kkpoManagement.category', 'traveler.suratJalan.kkpoManagement.style')
            ->where('traveler_id', $id)
            ->get();
        return view('manager.detailreport', compact('movement'));
    }
}

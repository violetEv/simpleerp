<?php

namespace App\Http\Controllers;

use App\Exports\TravelerMovementExport;
use App\Models\Customer;
use App\Models\Kkpo;
use App\Models\KkpoManagement;
use App\Models\Style;
use App\Models\SuratJalan;
use App\Models\TravelerMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ManagerController extends Controller
{
    function dashboard()
    {
        return view('manager.dashboard');
    }

    public function monitoring(Request $request)
    {
        $query = TravelerMovement::with('traveler', 'currentDepartment')
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
        $movement = TravelerMovement::with('traveler', 'currentDepartment')->findOrFail($id);
        return view('manager.detailmonitoring', compact('movement'));
    }

    public function report(Request $request)
    {
        $suratJalan = SuratJalan::select('no_surat_jalan')->distinct()->pluck('no_surat_jalan');
        $kkpo = KkpoManagement::select('no_kkpo')->distinct()->pluck('no_kkpo');
        $customer = Customer::select('name')->distinct()->pluck('name');
        $style = Style::select('name')->distinct()->pluck('name');

        $query = TravelerMovement::query()
            ->with([
                'traveler.suratJalan.kkpoManagement.customer',
                'traveler.suratJalan.kkpoManagement.category',
                'traveler.suratJalan.kkpoManagement.style',
            ])
            ->when($request->search, function ($q, $search) {
                $q->whereHas('traveler', function ($t) use ($search) {
                    $t->where('no_traveler', 'like', "%$search%");
                });
            })
            ->when($request->kkpo, function ($q, $kkpo) {
                $q->whereHas('traveler.suratJalan.kkpoManagement', function ($k) use ($kkpo) {
                    $k->where('no_kkpo', $kkpo);
                });
            })
            ->when($request->no_surat_jalan, function ($q, $sj) {
                $q->whereHas('traveler.suratJalan', function ($s) use ($sj) {
                    $s->where('no_surat_jalan', $sj);
                });
            })
            ->when($request->customer, function ($q, $customer) {
                $q->whereHas('traveler.suratJalan.kkpoManagement.customer', function ($c) use ($customer) {
                    $c->where('name', $customer);
                });
            })
            ->when($request->style, function ($q, $style) {
                $q->whereHas('traveler.suratJalan.kkpoManagement.style', function ($s) use ($style) {
                    $s->where('name', $style);
                });
            })
            ->when($request->date_from, function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })

            ->when($request->date_to, function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            });

        $movements = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('manager.report', compact(
            'movements',
            'suratJalan',
            'kkpo',
            'customer',
            'style'
        ));
    }

    public function show($kkpoId)
    {
        $movement = TravelerMovement::with([
            'traveler.suratJalan.kkpoManagement.customer',
            'traveler.suratJalan.kkpoManagement.category',
            'traveler.suratJalan.kkpoManagement.style',
        ])->findOrFail($kkpoId);

        return view('manager.detailreport', compact('movement'));
    }

    public function detailReport($id)
    {
        // $movement = TravelerMovement::with('traveler', 'department')->findOrFail($id);
        // return view('manager.detailreport', compact('movement'));
        $movement = TravelerMovement::with('traveler.suratJalan.kkpoManagement.customer', 'traveler.suratJalan.kkpoManagement.category', 'traveler.suratJalan.kkpoManagement.style', 'currentDepartment')
            ->where('traveler_id', $id)
            ->get();
        return view('manager.detailreport', compact('movement'));
    }
    public function exportReport(Request $request)
    {
        return Excel::download(
            new TravelerMovementExport($request),
            'report-traveler.xlsx'
        );
    }
}

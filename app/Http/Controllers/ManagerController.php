<?php

namespace App\Http\Controllers;

use App\Exports\TravelerMovementExport;
use App\Models\Category;
use App\Models\Color;
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
        $suratJalan = SuratJalan::whereHas('travelers.movements')->select('no_surat_jalan')->distinct()->pluck('no_surat_jalan');
        $kkpo = KkpoManagement::whereHas('travelers.movements')->select('no_kkpo')->distinct()->pluck('no_kkpo');
        $customer = Customer::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $style = Style::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $category = Category::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $color = Color::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');

        $query = SuratJalan::with([
            'kkpoManagements',
            'kkpoManagements.customer',
            'kkpoManagements.category',
            'kkpoManagements.style',
            'kkpoManagements.color',
            'travelers.movements' // relasi ke traveler movements
        ])
            // search
            ->when($request->search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->whereHas('kkpoManagements', function ($k) use ($search) {
                        $k->where('no_kkpo', 'like', "%{$search}%");
                    })
                        ->orWhere('no_surat_jalan', 'like', "%{$search}%")
                        ->orWhereHas('kkpoManagements.customer', function ($c) use ($search) {
                            $c->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kkpoManagements.category', function ($c) use ($search) {
                            $c->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kkpoManagements.style', function ($s) use ($search) {
                            $s->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kkpoManagements.color', function ($c) use ($search) {
                            $c->where('name', 'like', "%{$search}%");
                        });
                });
            })

            // harusnya kkpo yg muncul hanya yg punya surat jalan out/sampai warehouse send, jadi filter berdasarkan surat jalan dulu baru filter kkpo, customer, style, category, color

            ->when($request->kkpo, function ($q, $kkpo) {
                $q->whereHas('kkpoManagements', function ($k) use ($kkpo) {
                    $k->where('no_kkpo', $kkpo);
                });
            })

            ->when($request->no_surat_jalan, function ($q, $sj) {
                $q->where('no_surat_jalan', $sj);
            })

            ->when($request->customer, function ($q, $customer) {
                $q->whereHas('kkpoManagements.customer', function ($c) use ($customer) {
                    $c->where('name', $customer);
                });
            })

            ->when($request->style, function ($q, $style) {
                $q->whereHas('kkpoManagements.style', function ($s) use ($style) {
                    $s->where('name', $style);
                });
            })

            ->when($request->category, function ($q, $category) {
                $q->whereHas('kkpoManagements.category', function ($c) use ($category) {
                    $c->where('name', $category);
                });
            })

            ->when($request->color, function ($q, $color) {
                $q->whereHas('kkpoManagements.color', function ($c) use ($color) {
                    $c->where('name', $color);
                });
            });

        $data = $query->paginate(10);

        return view('manager.report', compact(
            'data',
            'suratJalan',
            'kkpo',
            'customer',
            'style',
            'category',
            'color'
        ));
    }

    public function show($id)
    {
        $sj = SuratJalan::with([
            'kkpoManagements.customer',
            'kkpoManagements.category',
            'kkpoManagements.style',
            'kkpoManagements.color',
            'kkpoManagements.item',
            'kkpoManagements.brand',
            'kkpoManagements.unit',
            'travelers.movements.currentDepartment'
        ])->findOrFail($id);

        return view('manager.detailreport', compact('sj'));
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

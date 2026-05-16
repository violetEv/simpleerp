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
use App\Models\Traveler;
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

    public function travelerMonitoring(Request $request)
    {
        $departments = [
            'Warehouse Bongkar',
            'QC Before',
            'Manual Process',
            'Washing',
            'Dyeing',
            'Dryer',
            'QC After',
            'Warehouse Folding',
            'Warehouse Packing',
            'Warehouse Send',
        ];

        $query = Traveler::with([
            'suratJalan',
            'movements.deptTujuan',
            'currentDepartment'
        ]);

        // SEARCH
        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->where('no_traveler', 'like', '%' . $request->search . '%')

                    ->orWhereHas('suratJalan', function ($sj) use ($request) {

                        $sj->where(
                            'no_surat_jalan',
                            'like',
                            '%' . $request->search . '%'
                        );
                    });
            });
        }

        $travelers = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $data = $travelers->getCollection()->map(function ($traveler) {

            $row = [
                'traveler' => $traveler,
                'departments' => [],
                'wip' => 0,
                'current_dept' => null,
            ];

            // urut movement
            $movements = $traveler->movements
                ->sortBy('date_in')
                ->values();

            foreach ($movements as $movement) {

                // HISTORI PROCESS
                $dept = optional($movement->deptTujuan)->name;

                if (!$dept) continue;

                $qtyIn = $movement->qty_in ?? 0;
                $qtyOut = $movement->qty_out ?? 0;
                $qtyReject = $movement->qty_reject ?? 0;

                // DURATION
                $duration = '-';

                if ($movement->date_in && $movement->date_out) {

                    $in = \Carbon\Carbon::parse($movement->date_in);
                    $out = \Carbon\Carbon::parse($movement->date_out);

                    $duration = $in->diffForHumans($out, true);
                }

                // INIT
                if (!isset($row['departments'][$dept])) {

                    $row['departments'][$dept] = [
                        'date_in' => null,
                        'date_out' => null,
                        'qty_in' => 0,
                        'qty_out' => 0,
                        'qty_reject' => 0,
                        'duration' => '-',
                        'count_process' => 0,
                    ];
                }

                // AKUMULASI
                $row['departments'][$dept]['qty_in'] += $qtyIn;

                $row['departments'][$dept]['qty_out'] += $qtyOut;

                $row['departments'][$dept]['qty_reject'] += $qtyReject;

                $row['departments'][$dept]['date_in'] = $movement->date_in;

                $row['departments'][$dept]['date_out'] = $movement->date_out;

                $row['departments'][$dept]['duration'] = $duration;

                // kalau traveler balik dept
                $row['departments'][$dept]['count_process'] += 1;
            }

            // LAST MOVEMENT REAL
            $lastMovement = $movements
                ->sortByDesc('created_at')
                ->first();

            if ($lastMovement) {

                // CURRENT POSITION
                $row['current_dept'] =
                    optional($lastMovement->deptTujuan)->name;

                // REAL BALANCE
                $row['wip'] = max(
                    $lastMovement->balance ?? 0,
                    0
                );

                // kalau sudah keluar warehouse send
                if (
                    optional($lastMovement->deptTujuan)->name
                    === 'Warehouse Send'
                    &&
                    ($lastMovement->balance ?? 0) <= 0
                ) {

                    $row['current_dept'] = 'Finished';
                }
            }

            return $row;
        });

        return view('manager.monitoring', [
            'data' => $data,
            'travelers' => $travelers,
            'departments' => $departments,
        ]);
    }

    public function report(Request $request)
    {
        $query = SuratJalan::with([

            // KKPO
            'kkpoManagement.customer',
            'kkpoManagement.details.style',
            'kkpoManagement.details.color',
            'kkpoManagement.details.category',

            // traveler
            'travelers.currentDepartment',
            'travelers.suratJalanOuts',

            // movement
            'travelers.movements.currentDepartment',
        ])

            /*
    |--------------------------------------------------------------------------
    | HANYA YANG SUDAH ADA HASIL PRODUKSI KELUAR
    |--------------------------------------------------------------------------
    */
            ->whereHas('travelers', function ($traveler) {

                $traveler->whereHas('suratJalanOuts')
                    ->whereHas('movements.currentDepartment', function ($dept) {

                        $dept->where('name', 'Warehouse Send');
                    });
            })

            /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */
            ->when($request->search, function ($q, $search) {

                $q->where(function ($query) use ($search) {

                    $query->where('no_surat_jalan', 'like', "%{$search}%")

                        ->orWhereHas('kkpoManagement', function ($k) use ($search) {

                            $k->where('no_kkpo', 'like', "%{$search}%");
                        })

                        ->orWhereHas('kkpoManagement.customer', function ($c) use ($search) {

                            $c->where('name', 'like', "%{$search}%");
                        })

                        ->orWhereHas('travelers', function ($t) use ($search) {

                            $t->where('no_traveler', 'like', "%{$search}%");
                        });
                });
            })

            /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */
            ->when($request->kkpo, function ($q, $kkpo) {

                $q->whereHas('kkpoManagement', function ($k) use ($kkpo) {

                    $k->where('no_kkpo', $kkpo);
                });
            })

            ->when($request->no_surat_jalan, function ($q, $sj) {

                $q->where('id', $sj);
            })

            ->when($request->customer, function ($q, $customer) {

                $q->whereHas('kkpoManagement.customer', function ($c) use ($customer) {

                    $c->where('id', $customer);
                });
            })

            ->when($request->style, function ($q, $style) {

                $q->whereHas('kkpoManagement.details.style', function ($s) use ($style) {

                    $s->where('id', $style);
                });
            })

            ->when($request->category, function ($q, $category) {

                $q->whereHas('kkpoManagement.details.category', function ($c) use ($category) {

                    $c->where('id', $category);
                });
            })

            ->when($request->color, function ($q, $color) {

                $q->whereHas('kkpoManagement.details.color', function ($c) use ($color) {

                    $c->where('id', $color);
                });
            })

            /*
    |--------------------------------------------------------------------------
    | DATE FILTER
    |--------------------------------------------------------------------------
    */
            ->when($request->date_from, function ($q, $date) {

                $q->whereDate('created_at', '>=', $date);
            })

            ->when($request->date_to, function ($q, $date) {

                $q->whereDate('created_at', '<=', $date);
            });

        $data = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
    |--------------------------------------------------------------------------
    | FILTER DATA
    |--------------------------------------------------------------------------
    */
        $filterSuratJalan = SuratJalan::select('id', 'no_surat_jalan')->get();

        $filterKkpo = KkpoManagement::select('no_kkpo')
            ->distinct()
            ->pluck('no_kkpo');

        $filterCustomer = Customer::select('id', 'name')->get();

        $filterStyle = Style::select('id', 'name')->get();

        $filterCategory = Category::select('id', 'name')->get();

        $filterColor = Color::select('id', 'name')->get();

        return view('manager.report', compact(
            'data',
            'filterSuratJalan',
            'filterKkpo',
            'filterCustomer',
            'filterStyle',
            'filterCategory',
            'filterColor'
        ));
    }
    public function show(int $id)
    {
        $sj = SuratJalan::with([

            // KKPO
            'kkpoManagement.customer',
            'kkpoManagement.details.style',
            'kkpoManagement.details.color',
            'kkpoManagement.details.category',

            // traveler
            'travelers.currentDepartment',
            'travelers.suratJalanOuts',

            // movement
            'travelers.movements.currentDepartment',
            'travelers.movements.machine',
            'travelers.movements.createdBy',

        ])->findOrFail($id);

        return view('manager.detailreport', compact('sj'));
    }
    public function exportReport(Request $request)
    {
        return Excel::download(
            new TravelerMovementExport($request->all()),
            'report.xlsx'
        );
    }
  
}

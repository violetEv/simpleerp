<?php

namespace App\Http\Controllers;

use App\Exports\TravelerMovementExport;
use App\Imports\CustomerImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Kkpo;
use App\Models\KkpoManagement;
use App\Models\Style;
use App\Models\Unit;
use App\Models\Currency;
use App\Models\Departments;
use App\Models\KkpoDetail;
use App\Models\SuratJalan;
use App\Models\Traveler;
use App\Models\TravelerMovement;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class PpicController extends Controller
{
    public function dashboard()
    {
        // TOTAL
        $totalKKPO = KkpoManagement::count();
        $totalKKPODetails = KkpoDetail::count();

        $totalColors = Color::count();
        $totalStyles = Style::count();
        $totalCategories = Category::count();
        $totalCustomers = Customer::whereHas('kkpos', function ($q) {
            $q->doesntHave('suratJalan.suratJalanOut');
        })->count();
        $totalProductionQty = KkpoDetail::sum('qty');

        // LATEST KKPO (HEADER)
        $latestKKPO = KkpoDetail::with([
            'kkpo.customer',
            // 'details.category',
            // 'details.style',
            // 'details.color'
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('ppic.dashboard', compact(
            'totalKKPO',
            'totalColors',
            'totalStyles',
            'totalCategories',
            'totalCustomers',
            'totalKKPODetails',
            'totalProductionQty',
            'latestKKPO'
        ));
    }
    public function customer(Request $request)
    {
        $query = Customer::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('ppic.customer', compact('customers'));
    }
    // kolom selain name tidak harus required, jadi bisa nullable, dan di view ditampilkan '-' jika null
    public function customerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'string|max:255|nullable',
            'phone' => 'string|max:255|nullable',
            // 'attention' => 'string|max:255|nullable',
            'payment_terms' => 'required|string|max:255',
            'npwp' => 'required|string|max:255',
        ]);

        try {
            Customer::create($request->all());

            return redirect()
                ->route('ppic.customer')
                ->with('success', 'Customer successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Customer name already exists');
            }
            return back()->with('error', 'Failed to add customer: ' . $e->getMessage());
        }
    }
    public function customerUpdate(Request $request, int $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'string|max:255|nullable',
            'phone' => 'string|max:255|nullable',
            // 'attention' => 'string|max:255|nullable',
            'payment_terms' => 'required|string|max:255',
            'npwp' => 'required|string|max:255',
        ]);

        try {
            $customer->update($request->all());

            return redirect()
                ->route('ppic.customer')
                ->with('success', 'Customer successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update customer');
        }
    }

    public function customerDelete(int $id)
    {
        $customer = Customer::findOrFail($id);
        try {
            $customer->delete();

            return redirect()
                ->route('ppic.customer')
                ->with('success', 'Customer successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete customer because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete customer');
        }
    }

    public function import(Request $request)
    {
        $import = new CustomerImport();

        try {
            Excel::import($import, $request->file('file'));

            return back()->with(
                'success',
                "Import {$import->successRows} rows successfully."
            );
        } catch (ValidationException $e) {

            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
            }

            return back()->with('error', implode(' | ', $errorMessages));
        } catch (QueryException $e) {

            // CEK duplicate entry
            if ($e->getCode() == 23000) {
                return back()->with('error', 'Duplicate entry: ' . $e->errorInfo[2]);
            }

            return back()->with('error', 'Failed to import: ' . $e->getMessage());
        }
    }
    public function category(Request $request)
    {
        $query = Category::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->paginate(10)->withQueryString();
        return view('ppic.category-process', compact('categories'));
    }
    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            Category::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.category')
                ->with('success', 'Category Process successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Category Process name already exists');
            }
            return back()->with('error', 'Failed to add Category Process: ' . $e->getMessage());
        }
    }
    public function categoryUpdate(Request $request, int $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $category->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.category')
                ->with('success', 'Category Process successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Category Process');
        }
    }
    public function categoryDelete(int $id)
    {
        $category = Category::findOrFail($id);
        try {
            $category->delete();

            return redirect()
                ->route('ppic.category')
                ->with('success', 'Category Process successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Category Process because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Category Process');
        }
    }
    public function style(Request $request)
    {
        $query = Style::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $styles = $query->paginate(10)->withQueryString();
        return view('ppic.style', compact('styles'));
    }
    public function styleStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Style::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.style')
                ->with('success', 'Style successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Style name already exists');
            }
            return back()->with('error', 'Failed to add Style: ' . $e->getMessage());
        }
    }
    public function styleUpdate(Request $request, int $id)
    {
        $style = Style::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $style->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.style')
                ->with('success', 'Style successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Style');
        }
    }
    public function styleDelete(int $id)
    {
        $style = Style::findOrFail($id);
        try {
            $style->delete();

            return redirect()
                ->route('ppic.style')
                ->with('success', 'Style successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Style because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Style');
        }
    }
    public function color(Request $request)
    {
        $query = Color::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $colors = $query->paginate(10)->withQueryString();
        return view('ppic.color', compact('colors'));
    }
    public function colorStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Color::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.color')
                ->with('success', 'Color successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Color name already exists');
            }
            return back()->with('error', 'Failed to add Color: ' . $e->getMessage());
        }
    }
    public function colorUpdate(Request $request, int $id)
    {
        $color = Color::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $color->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.color')
                ->with('success', 'Color successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Color');
        }
    }
    public function colorDelete(int $id)
    {
        $color = Color::findOrFail($id);
        try {
            $color->delete();

            return redirect()
                ->route('ppic.color')
                ->with('success', 'Color berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Color because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Color');
        }
    }

    public function item(Request $request)
    {
        $query = Item::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $items = $query->paginate(10)->withQueryString();
        return view('ppic.item', compact('items'));
    }
    public function itemStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            Item::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.item')
                ->with('success', 'Item successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Item name already exists');
            }
            return back()->with('error', 'Failed to add Item: ' . $e->getMessage());
        }
    }
    public function itemUpdate(Request $request, int $id)
    {
        $item = Item::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $item->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.item')
                ->with('success', 'Item successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Item');
        }
    }
    public function itemDelete(int $id)
    {
        $item = Item::findOrFail($id);
        try {
            $item->delete();

            return redirect()
                ->route('ppic.item')
                ->with('success', 'Item successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Item because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Item');
        }
    }
    public function brand(Request $request)
    {
        $query = Brand::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $brands = $query->paginate(10)->withQueryString();
        return view('ppic.brand', compact('brands'));
    }
    public function brandStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Brand::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.brand')
                ->with('success', 'Brand successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Brand name already exists');
            }
            return back()->with('error', 'Failed to add Brand: ' . $e->getMessage());
        }
    }
    public function brandUpdate(Request $request, int $id)
    {
        $brand = Brand::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $brand->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.brand')
                ->with('success', 'Brand successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Brand');
        }
    }
    public function brandDelete(int $id)
    {
        $brand = Brand::findOrFail($id);
        try {
            $brand->delete();

            return redirect()
                ->route('ppic.brand')
                ->with('success', 'Brand successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Brand because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Brand');
        }
    }

    public function unit(Request $request)
    {
        $query = Unit::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $units = $query->paginate(10)->withQueryString();
        return view('ppic.unit', compact('units'));
    }
    public function unitStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            Unit::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.unit')
                ->with('success', 'Unit successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Unit name already exists');
            }
            return back()->with('error', 'Failed to add Unit: ' . $e->getMessage());
        }
    }
    public function unitUpdate(Request $request, int $id)
    {
        $unit = Unit::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $unit->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.unit')
                ->with('success', 'Unit successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Unit');
        }
    }
    public function unitDelete(int $id)
    {
        $unit = Unit::findOrFail($id);
        try {
            $unit->delete();

            return redirect()
                ->route('ppic.unit')
                ->with('success', 'Unit berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Unit because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Unit');
        }
    }

    public function currency(Request $request)
    {
        $query = Currency::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $currencies = $query->paginate(10)->withQueryString();
        return view('ppic.currency', compact('currencies'));
    }
    public function currencyStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code',
        ]);

        try {
            Currency::create([
                'name' => $request->name,
                'code' => $request->code,
            ]);

            return redirect()
                ->route('ppic.currency')
                ->with('success', 'Currency successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Currency code already exists');
            }
            return back()->with('error', 'Failed to add Currency: ' . $e->getMessage());
        }
    }
    public function currencyUpdate(Request $request, int $id)
    {
        $currency = Currency::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
        ]);
        try {
            $currency->update([
                'name' => $request->name,
                'code' => $request->code,
            ]);

            return redirect()
                ->route('ppic.currency')
                ->with('success', 'Currency successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Currency');
        }
    }
    public function currencyDelete(int $id)
    {
        $currency = Currency::findOrFail($id);
        try {
            $currency->delete();

            return redirect()
                ->route('ppic.currency')
                ->with('success', 'Currency successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Currency because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Currency');
        }
    }

    public function report(Request $request)
    {
        $query = SuratJalan::with([

            // KKPO
            'kkpo.customer',
            'kkpo.details.style',
            'kkpo.details.color',
            'kkpo.details.category',

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

                        ->orWhereHas('kkpo', function ($k) use ($search) {

                            $k->where('no_kkpo', 'like', "%{$search}%");
                        })

                        ->orWhereHas('kkpo.customer', function ($c) use ($search) {

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

                $q->whereHas('kkpo', function ($k) use ($kkpo) {

                    $k->where('no_kkpo', $kkpo);
                });
            })

            ->when($request->no_surat_jalan, function ($q, $sj) {

                $q->where('id', $sj);
            })

            ->when($request->customer, function ($q, $customer) {

                $q->whereHas('kkpo.customer', function ($c) use ($customer) {

                    $c->where('id', $customer);
                });
            })

            ->when($request->style, function ($q, $style) {

                $q->whereHas('kkpo.details.style', function ($s) use ($style) {

                    $s->where('id', $style);
                });
            })

            ->when($request->category, function ($q, $category) {

                $q->whereHas('kkpo.details.category', function ($c) use ($category) {

                    $c->where('id', $category);
                });
            })

            ->when($request->color, function ($q, $color) {

                $q->whereHas('kkpo.details.color', function ($c) use ($color) {

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

        return view('ppic.report', compact(
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
            'kkpo.customer',
            'kkpo.details.style',
            'kkpo.details.color',
            'kkpo.details.category',

            // traveler
            'travelers.currentDepartment',
            'travelers.suratJalanOuts',

            // movement
            'travelers.movements.currentDepartment',
            'travelers.movements.machine',
            'travelers.movements.createdBy',

        ])->findOrFail($id);

        return view('ppic.detailreport', compact('sj'));
    }
    public function exportReport(Request $request)
    {
        return Excel::download(
            new TravelerMovementExport($request->all()),
            'report.xlsx'
        );
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

        return view('ppic.monitoring', [
            'data' => $data,
            'travelers' => $travelers,
            'departments' => $departments,
        ]);
    }
}

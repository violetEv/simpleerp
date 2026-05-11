<?php

namespace App\Http\Controllers;

use App\Exports\TravelerMovementExport;
use App\Http\Requests\StoreUserRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Departments;
use App\Models\KkpoManagement;
use App\Models\Machine;
use App\Models\Style;
use App\Models\SuratJalan;
use App\Models\TravelerMovement;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDepartments = Departments::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        // menampilkan aktivitas user login terbaru
        $recentActivities = TravelerMovement::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('superadmin.dashboard', compact('totalUsers', 'totalDepartments', 'activeUsers', 'inactiveUsers', 'recentActivities'));
    }

    public function users(Request $request)
    {
        $query = User::with('department');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('department', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = ['super_admin' => 'Super Admin', 'produksi' => 'Produksi', 'warehouse' => 'Warehouse', 'ppic' => 'PPIC'];

        return view('superadmin.user', compact('users', 'roles'));
    }

    public function storeUser(StoreUserRequest $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'department_id' => $request->department_id ?? null,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('superadmin.user')
                ->with('success', 'User successfully added');
        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Email already in use');
            }

            return back()->with('error', 'Failed to add user');
        }
    }

    function delete(int $id)
    {
        $user = User::findOrFail($id);
        try {
            $user->delete();

            return redirect()
                ->route('superadmin.user')
                ->with('success', 'User successfully deleted');
        } catch (QueryException $e) {
            return redirect()
                ->route('superadmin.user')
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'department_id' => $request->department_id ?? null,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('superadmin.user')
                ->with('success', 'User successfully updated');
        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Email already in use');
            }

            return back()->with('error', 'Failed to update user');
        }
    }

    public function departments(Request $request)
    {
        //department urut nama A-Z
        $query = Departments::query()->orderBy('name', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $departments = $query->paginate(10)->withQueryString();

        return view('superadmin.department', compact('departments'));
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            Departments::create([
                'name' => $request->name
            ]);

            return redirect()
                ->route('superadmin.department')
                ->with('success', 'Department successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Department name already in use');
            }

            return back()->with('error', 'Failed to add department');
        }
    }

    public function updateDepartment(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $department = Departments::findOrFail($id);
        try {
            $department->update([
                'name' => $request->name
            ]);

            return redirect()
                ->route('superadmin.department')
                ->with('success', 'Department successfully updated');
        } catch (QueryException $e) {
            // if ($e->errorInfo[1] == 1062) {
            return back()->with('error', 'Department name already in use');
            // }

            // return back()->with('error', 'Failed to update department');
        }
    }
    public function deleteDepartment(int $id)
    {
        $department = Departments::findOrFail($id);
        // $department->name = request('name');
        try {
            $department->delete();

            return redirect()
                ->route('superadmin.department')
                ->with('success', 'Department successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Department cannot be deleted because it is still in use');
            }

            return back()->with('error', 'Failed to delete department');
        }

        return redirect()->route('superadmin.department')->with('success', 'Department successfully deleted');
    }

    public function machines(Request $request)
    {
        $query = Machine::query()->orderBy('name', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $machines = $query->paginate(10)->withQueryString();
        // nama departemen washing dan dyeing saja
        $departments = Departments::whereIn('name', ['Washing', 'Dyeing'])->get();

        return view('superadmin.machine', compact('machines', 'departments'));
    }
    public function storeMachine(Request $request)
    {
        $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'name' => 'required|string|max:255',
        ]);
        try {
            Machine::create([
                'name' => $request->name,
                'department_id' => $request->department_id,
            ]);

            return redirect()
                ->route('superadmin.machine')
                ->with('success', 'Machine successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Machine name already in use');
            }

            return back()->with('error', 'Failed to add machine');
        }
    }
    public function updateMachine(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $machine = Machine::findOrFail($id);
        try {
            $machine->update([
                'name' => $request->name,
                'department_id' => $request->department_id,
            ]);

            return redirect()
                ->route('superadmin.machine')
                ->with('success', 'Machine successfully updated');
        } catch (QueryException $e) {
            // if ($e->errorInfo[1] == 1062) {
            return back()->with('error', 'Machine name already in use');
            // }

            // return back()->with('error', 'Failed to update machine');
        }
    }
    public function deleteMachine(int $id)
    {
        $machine = Machine::findOrFail($id);
        // $machine->name = request('name');
        try {
            $machine->delete();

            return redirect()
                ->route('superadmin.machine')
                ->with('success', 'Machine successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Machine cannot be deleted because it is still in use');
            }

            return back()->with('error', 'Failed to delete machine');
        }

        return redirect()->route('superadmin.machine')->with('success', 'Machine successfully deleted');
    }

    public function approval(Request $request)
    {
        $query = SuratJalan::with('kkpoManagements', 'kkpoManagements.customer', 'kkpoManagements.category', 'kkpoManagements.style', 'kkpoManagements.color')
            ->whereHas('travelers.movements', function ($q) {
                $q->where('status', 'selisih');//tambah status pending untuk approval, jadi yg muncul di approval hanya movement dengan status pending, nanti kalau approved baru statusnya berubah jadi approved dan tidak muncul di approval lagi
            });
        try {
            $suratJalans = $query->paginate(10)->withQueryString();

            return view('superadmin.approval', compact('suratJalans'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load approval data: ' . $e->getMessage());
        }
    }
public function travelerMonitoring(Request $request)
{
    $movements = TravelerMovement::with([
        'traveler.suratJalan',
        'deptTujuan'
    ])
    ->orderBy('date_in')
    ->get();

    $data = $movements->groupBy('traveler_id')->map(function ($items) {

        $traveler = $items->first()->traveler;

        $row = [
            'traveler' => $traveler,
            'departments' => []
        ];

        // ambil movement terakhir
        $last = $items->sortByDesc('date_in')->first();
        $row['current_dept'] = optional($last->deptTujuan)->name;

        $totalIn = 0;
        $totalOut = 0;

        foreach ($items as $movement) {

            if (!$movement->deptTujuan) continue;

            $deptName = $movement->deptTujuan->name;

            if (!isset($row['departments'][$deptName])) {
                $row['departments'][$deptName] = [
                    'tanggal' => $movement->date_in,
                    'qty_in' => 0,
                    'qty_out' => 0,
                ];
            }

            $row['departments'][$deptName]['tanggal'] = $movement->date_in;
            $row['departments'][$deptName]['qty_in'] += $movement->qty_in ?? 0;
            $row['departments'][$deptName]['qty_out'] += $movement->qty_out ?? 0;

            $totalIn += $movement->qty_in ?? 0;
            $totalOut += $movement->qty_out ?? 0;
        }

        //  WIP REAL (AMAN)
        $row['wip'] = max($totalIn - $totalOut, 0);

        //  OPTIONAL: HILANGKAN YANG SUDAH SELESAI
        $row['is_finished'] = $row['wip'] == 0;

        return $row;
    })

    // 
    ->filter(function ($row) {
        return !$row['is_finished']; // hanya tampil yg masih WIP
    });

    return view('ppic.monitoring', compact('data'));
}

    public function report(Request $request)
    {
        $query = SuratJalan::with([
            'kkpoManagement.customer',
            'kkpoManagement.categories',
            'kkpoManagement.styles',
            'kkpoManagement.colors',
            'travelers.movements'
        ])

            //  WAJIB: hanya yg sudah ada SJ OUT (status send)
            ->whereHas('travelers.movements', function ($q) {
                $q->where('status', 'send');
            })

            // SEARCH
            ->when($request->search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->whereHas('kkpoManagement', function ($k) use ($search) {
                        $k->where('no_kkpo', 'like', "%{$search}%");
                    })
                        ->orWhere('no_surat_jalan', 'like', "%{$search}%")
                        ->orWhereHas('kkpoManagement.customer', function ($c) use ($search) {
                            $c->where('name', 'like', "%{$search}%");
                        });
                });
            })

            // FILTER ID BASED (FIX SEMUA)
            ->when($request->kkpo, function ($q, $kkpo) {
                $q->whereHas('kkpoManagement', fn($k) => $k->where('no_kkpo', $kkpo));
            })

            ->when($request->no_surat_jalan, function ($q, $sj) {
                $q->where('id', $sj);
            })

            ->when($request->customer, function ($q, $customer) {
                $q->whereHas('kkpoManagement.customer', fn($c) => $c->where('id', $customer));
            })

            ->when($request->style, function ($q, $style) {
                $q->whereHas('kkpoManagement.styles', fn($s) => $s->where('id', $style));
            })

            ->when($request->category, function ($q, $category) {
                $q->whereHas('kkpoManagement.categories', fn($c) => $c->where('id', $category));
            })

            ->when($request->color, function ($q, $color) {
                $q->whereHas('kkpoManagement.colors', fn($c) => $c->where('id', $color));
            });

        $data = $query->paginate(10)->withQueryString();

        //  FILTER DATA (HARUS ADA ID + NAME)
        $filterSuratJalan = SuratJalan::select('id', 'no_surat_jalan')->get();

        $filterKkpo = KkpoManagement::select('no_kkpo')->distinct()->pluck('no_kkpo');

        $filterCustomer = Customer::select('id', 'name')->get();
        $filterStyle = Style::select('id', 'name')->get();
        $filterCategory = Category::select('id', 'name')->get();
        $filterColor = Color::select('id', 'name')->get();

        return view('superadmin.report', compact(
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
            'kkpoManagement.customer',
            'kkpoManagement.categories',
            'kkpoManagement.styles',
            'kkpoManagement.colors',
            'kkpoManagement.items',
            'kkpoManagement.brands',
            'kkpoManagement.unit',
            'travelers.movements.currentDepartment'
        ])->findOrFail($id);

        return view('superadmin.detailreport', compact('sj'));
    }
    public function exportReport(Request $request)
    {
        return Excel::download(
            new TravelerMovementExport($request->all()),
            'report-traveler.xlsx'
        );
    }
}

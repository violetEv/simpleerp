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
use App\Models\Traveler;
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

    private function permissionDefinitions()
    {
        return [
            'ppic' => 'PPIC',
            'manager' => 'Manager',
            'produksi' => 'Produksi',
            'warehouse' => 'Warehouse',
        ];
    }

    private function permissionActions()
    {
        return [
            'create' => 'Create',
            'read' => 'Read',
            'update' => 'Update',
            'delete' => 'Delete',
        ];
    }

    private function permissionFilePath()
    {
        return storage_path('app/permissions.json');
    }

    private function readPermissionSettings()
    {
        $defaults = array_map(function () {
            return array_fill_keys(array_keys($this->permissionActions()), false);
        }, $this->permissionDefinitions());

        $path = $this->permissionFilePath();
        if (!file_exists($path)) {
            return $defaults;
        }

        $json = file_get_contents($path);
        $stored = json_decode($json, true);
        if (!is_array($stored)) {
            return $defaults;
        }

        foreach ($defaults as $role => $actions) {
            if (!isset($stored[$role]) || !is_array($stored[$role])) {
                continue;
            }

            foreach ($actions as $action => $value) {
                if (array_key_exists($action, $stored[$role])) {
                    $defaults[$role][$action] = (bool) $stored[$role][$action];
                }
            }
        }

        return $defaults;
    }

    public function permission()
    {
        $roles = $this->permissionDefinitions();
        $actions = $this->permissionActions();
        $permissions = $this->readPermissionSettings();

        return view('superadmin.permission', compact('roles', 'actions', 'permissions'));
    }

    public function updatePermission(Request $request)
    {
        $permissionsInput = $request->input('permissions', []);
        $permissions = [];

        foreach ($this->permissionDefinitions() as $role => $label) {
            foreach ($this->permissionActions() as $action => $actionLabel) {
                $permissions[$role][$action] = isset($permissionsInput[$role][$action]) && $permissionsInput[$role][$action];
            }
        }

        file_put_contents($this->permissionFilePath(), json_encode($permissions, JSON_PRETTY_PRINT));

        return redirect()
            ->route('superadmin.permission')
            ->with('success', 'Permission settings successfully updated');
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

    // public function approval(Request $request)
    // {
    //     $query = SuratJalan::with('kkpoManagements', 'kkpoManagements.customer', 'kkpoManagements.category', 'kkpoManagements.style', 'kkpoManagements.color')
    //         ->whereHas('travelers.movements', function ($q) {
    //             $q->where('status', 'selisih'); //tambah status pending untuk approval, jadi yg muncul di approval hanya movement dengan status pending, nanti kalau approved baru statusnya berubah jadi approved dan tidak muncul di approval lagi
    //         });
    //     try {
    //         $suratJalans = $query->paginate(10)->withQueryString();

    //         return view('superadmin.approval', compact('suratJalans'));
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Failed to load approval data: ' . $e->getMessage());
    //     }
    // }
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

        return view('superadmin.monitoring', [
            'data' => $data,
            'travelers' => $travelers,
            'departments' => $departments,
        ]);
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

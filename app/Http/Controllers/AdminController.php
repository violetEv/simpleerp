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

        return view('superadmin.dashboard', compact('totalUsers', 'totalDepartments', 'activeUsers', 'inactiveUsers'));
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
                ->with('success', 'User berhasil ditambahkan');
        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Email sudah digunakan');
            }

            return back()->with('error', 'Gagal menambahkan user');
        }
    }

    function delete($id)
    {
        $user = User::findOrFail($id);
        try {
            $user->delete();

            return redirect()
                ->route('superadmin.user')
                ->with('success', 'User berhasil dihapus');
        } catch (QueryException $e) {
            return redirect()
                ->route('superadmin.user')
                ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
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
                ->with('success', 'User berhasil diperbarui');
        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Email sudah digunakan');
            }

            return back()->with('error', 'Gagal memperbarui user');
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
                ->with('success', 'Department berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama department sudah digunakan');
            }

            return back()->with('error', 'Gagal menambahkan department');
        }
    }

    public function updateDepartment(Request $request, $id)
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
                ->with('success', 'Department berhasil diperbarui');
        } catch (QueryException $e) {
            // if ($e->errorInfo[1] == 1062) {
            return back()->with('error', 'Nama department sudah digunakan');
            // }

            // return back()->with('error', 'Gagal memperbarui department');
        }
    }
    public function deleteDepartment($id)
    {
        $department = Departments::findOrFail($id);
        // $department->name = request('name');
        try {
            $department->delete();

            return redirect()
                ->route('superadmin.department')
                ->with('success', 'Department berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Department tidak dapat dihapus karena masih digunakan');
            }

            return back()->with('error', 'Gagal menghapus department');
        }

        return redirect()->route('superadmin.department')->with('success', 'Department berhasil dihapus');
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
                ->with('success', 'Mesin berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama mesin sudah digunakan');
            }

            return back()->with('error', 'Gagal menambahkan mesin');
        }
    }
    public function updateMachine(Request $request, $id)
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
                ->with('success', 'Mesin berhasil diperbarui');
        } catch (QueryException $e) {
            // if ($e->errorInfo[1] == 1062) {
            return back()->with('error', 'Nama mesin sudah digunakan');
            // }

            // return back()->with('error', 'Gagal memperbarui mesin');
        }
    }
    public function deleteMachine($id)
    {
        $machine = Machine::findOrFail($id);
        // $machine->name = request('name');
        try {
            $machine->delete();

            return redirect()
                ->route('superadmin.machine')
                ->with('success', 'Mesin berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Mesin tidak dapat dihapus karena masih digunakan');
            }

            return back()->with('error', 'Gagal menghapus mesin');
        }

        return redirect()->route('superadmin.machine')->with('success', 'Mesin berhasil dihapus');
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
            return back()->with('error', 'Gagal memuat data approval: ' . $e->getMessage());
        }
    }

    public function monitoring()
    {
        return view('superadmin.monitoring');
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

        return view('ppic.report', compact(
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

        return view('ppic.detailreport', compact('sj'));
    }
    public function exportReport(Request $request)
    {
        return Excel::download(
            new TravelerMovementExport($request),
            'report-traveler.xlsx'
        );
    }
}

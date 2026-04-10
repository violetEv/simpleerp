<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\Machine;
use App\Models\Traveler;
use App\Models\TravelerMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
{
    public function dashboard()
    {
        return view('produksi.dashboard');
    }

    public function index(Request $request)
    {
        $query = Traveler::with('deptAsal', 'deptTujuan', 'currentDept')
            ->where('current_dept_id', Auth::user()->department_id);

        // menampilkan traveler yang berasal dari dept user yang sedang login, atau yang tujuan dept nya user yang sedang login
        $query->whereHas('deptAsal', function ($q) {
            $q->where('dept_asal_id', Auth::user()->department_id);
        })->orWhereHas('deptTujuan', function ($q) {
            $q->where('dept_tujuan_id', Auth::user()->department_id);
        });

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('no_traveler', 'like', "%{$search}%")
                    ->orWhereHas('currentDept', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('deptAsal', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('deptTujuan', function ($q4) use ($search) {
                        $q4->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $travelers = $query->paginate(10)->withQueryString();

        return view('produksi.index', compact('travelers'));
    }


    public function process($id)
    {
        $traveler = Traveler::findOrFail($id);
        $movement = TravelerMovement::where('traveler_id', $id)
            ->where('dept_id', Auth::user()->department_id)
            ->latest()->first();

        $machines = Machine::where('department_id', Auth::user()->department_id)->get();
        $departments = Departments::all();
        return view('produksi.process', compact('traveler', 'movement', 'machines', 'departments'));
    }

    public function storeIn(Request $request)
    {
        $request->validate([
            'traveler_id' => 'required',
            'qty_in' => 'required|integer|min:1',
            'machine_id' => 'nullable|exists:machines,id',
            'notes' => 'nullable|string'
        ]);

        TravelerMovement::create([
            'traveler_id' => $request->traveler_id,
            'dept_id' => Auth::user()->department_id,
            'qty_in' => $request->qty_in,
            'date_in' => now(),
            'created_by' => Auth::id(),
            'machine_id' => $request->machine_id,
            'notes' => $request->notes,
        ]);
        Traveler::where('id', $request->traveler_id)
            ->update([
                'status' => 'in_progress'
            ]);
        return back()->with('success', 'Qty IN berhasil disimpan');
    }

    public function storeOut(Request $request)
    {
        $request->validate([
            'traveler_id' => 'required',
            'qty_out' => 'required|integer|min:0',
            'dept_tujuan_id' => 'nullable|exists:departments,id',
            'type_reject' => 'nullable|string',
            'qty_reject' => 'nullable|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        $dept = Auth::user()->department->name;

        $movement = TravelerMovement::where('traveler_id', $request->traveler_id)
            ->where('dept_id', Auth::user()->department_id)
            ->latest()
            ->first();

        if (!$movement || !$movement->qty_in) {
            return back()->with('error', 'Harus input IN dulu');
        }

        // HITUNG SELISIH
        $qty_in = $movement->qty_in;
        $qty_out = $request->qty_out;
        $qty_reject = $request->qty_reject ?? 0;

        $qty_loss = $qty_in - ($qty_out + $qty_reject);

        // UPDATE movement: departmen tujuan yg diinput akan jadi departmen tujuan di movement, dan qty_out, qty_reject, qty_loss diupdate
        $deptTujuan = $request->dept_tujuan_id ?? $movement->dept_tujuan_id;
        $movement->update([
            'qty_out' => $qty_out,
            'date_out' => now(),
            'qty_reject' => $qty_reject,
            'type_reject' => $request->type_reject,
            'qty_loss' => $qty_loss,
            'dept_tujuan_id' => $deptTujuan,
            'notes' => $request->notes,
        ]);

        // 🔥 UPDATE TRAVELER PINDAH DEPT
        if ($dept != 'Send') {
            Traveler::where('id', $request->traveler_id)
                ->update([
                    'dept_tujuan_id' => $deptTujuan,
                    'dept_asal_id' => Auth::user()->department_id,
                    'status' => 'in_progress'
                ]);
        } else {
            Traveler::where('id', $request->traveler_id)
                ->update([
                    'status' => 'done'
                ]);
        }

        return redirect()->route('produksi.index')
            ->with('success', 'Qty OUT berhasil disimpan');
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
    public function logProduction(Request $request)
    {
        // return view('produksi.logproduksi');
        $query = TravelerMovement::with([
            'traveler',
            'department',
            'machine'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('traveler', function ($q2) use ($search) {
                    $q2->where('code', 'like', "%{$search}%");
                })->orWhereHas('department', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })->orWhereHas('machine', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        // hanya menampilkakan movement dari department user yang sedang login
        $query->whereHas('department', function ($q) {
            $q->where('id', Auth::user()->department_id);
        });
        $dept = Auth::user()->department->name;

        $movements = $query->latest()->paginate(10)->withQueryString();

        return view('produksi.logproduksi', compact('movements', 'dept'));
    }

    public function logDetail($id)
    {
        $movement = TravelerMovement::with([
            'traveler',
            'department',
            'machine'
        ])->findOrFail($id);

        return view('produksi.logdetail', compact('movement'));
    }
}

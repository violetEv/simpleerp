<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\KkpoManagement;
use App\Models\Machine;
use App\Models\SuratJalan;
use App\Models\SuratJalanOut;
use App\Models\Traveler;
use App\Models\TravelerMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    public function dashboard()
    {
        return view('produksi.dashboard');
    }
    public function suratjalanout(Request $request)
    {
        $query = SuratJalanOut::with(['suratJalanIn', 'kkpoManagement.customer', 'kkpoManagement.style', 'kkpoManagement.color', 'kkpoManagement.item', 'kkpoManagement.category']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('no_surat_jalan', 'like', "%{$search}%");
        }

        $orders = $query->paginate(10)->withQueryString();
        $kkpoManagements = KkpoManagement::with(['categories', 'customer', 'styles', 'colors', 'items'])->get();
        $suratJalanIns = SuratJalan::with('kkpoManagement')->get();
        $travelers = Traveler::with('suratJalan')->get();

        return view('produksi.suratjalanout.index', compact('orders', 'kkpoManagements', 'suratJalanIns', 'travelers'));
    }
    public function suratJalanOutStore(Request $request)
    {
        $request->validate([
            'kkpo_management_id' => 'required|exists:kkpo_managements,id',
            'surat_jalan_in_id' => 'required|exists:surat_jalans,id',
            'no_surat_jalan' => 'required|string|max:255',
            'qty' => 'required|integer',
            'tanggal' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        $status = $request->qty <= 0 ? 'closed' : 'open';
        SuratJalanOut::create([
            'kkpo_management_id' => $request->kkpo_management_id,
            'surat_jalan_in_id' => $request->surat_jalan_in_id,
            'no_surat_jalan' => $request->no_surat_jalan,
            'qty' => $request->qty,
            'tanggal' => $request->tanggal,
            'notes' => $request->notes,
            'status' => $status
        ]);

        return redirect()
            ->route('produksi.suratjalanout.index')
            ->with('success', 'Order berhasil ditambahkan');
    }

    public function createSuratJalanOut($id)
    {
        $traveler = Traveler::findOrFail($id);
        $kkpoManagements = KkpoManagement::with(['category', 'customer', 'style', 'color', 'item'])->get();
        $suratJalanIns = SuratJalan::with('kkpoManagement')->get();
        return view('produksi.suratjalanout.create', compact('traveler', 'kkpoManagements', 'suratJalanIns'));
    }

    public function index(Request $request)
    {

        $query = Traveler::with([
            'latestMovement.deptAsal',
            'deptTujuan',
            'currentDepartment'
        ])
            ->where('status', '!=', 'done')
            ->where('current_dept_id', Auth::user()->department_id);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('no_traveler', 'like', "%{$search}%")
                    ->orWhereHas('currentDepartment', function ($q2) use ($search) {
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

        return view('produksi.proses.index', compact('travelers'));
    }

    public function process($id)
    {
        $traveler = Traveler::findOrFail($id);
        // 🔹 movement yang BELUM OUT (aktif)
        $movementActive = TravelerMovement::where('traveler_id', $id)
            ->where('current_dept_id', Auth::user()->department_id)
            ->whereNull('date_out')
            ->latest()
            ->first();

        // 🔹 movement terakhir (untuk ambil expected qty)
        $lastMovement = TravelerMovement::where('traveler_id', $id)
            ->whereNotNull('date_out')
            ->latest()
            ->first();

        $machines = Machine::where('department_id', Auth::user()->department_id)->get();
        $departments = Departments::all();
        return view('produksi.proses.process', compact('traveler', 'movementActive', 'lastMovement', 'machines', 'departments'));
    }

    public function storeIn(Request $request)
    {
        $request->validate([
            'traveler_id' => 'required|exists:travelers,id',
            'created_by' => 'nullable|string|max:255',
            'qty_in' => 'required|integer|min:1',
            'machine_id' => 'nullable|exists:machines,id',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {

            $traveler = Traveler::lockForUpdate()->findOrFail($request->traveler_id);

            // ambil movement terakhir yang OUT
            $lastMovement = TravelerMovement::where('traveler_id', $traveler->id)
                ->whereNotNull('date_out')
                ->latest()
                ->first();

            $expected = $lastMovement?->qty_out ?? 0;
            $actual = (int) $request->qty_in;

            $selisih = $expected - $actual;

            // status lebih clean
            $statusCase = $selisih == 0 ? 'normal' : 'selisih';

            // asal dept aman fallback
            $deptAsal = $lastMovement?->dept_tujuan_id ?? $traveler->current_dept_id;

            TravelerMovement::create([
                'traveler_id' => $traveler->id,
                'created_by' => $request->created_by,
                'dept_asal_id' => $deptAsal,
                'current_dept_id' => Auth::user()->department_id,
                'dept_tujuan_id' => null,
                'qty_in' => $actual,
                'date_in' => now(),
                'machine_id' => $request->machine_id,
                'notes' => $request->notes,
                'qty_loss' => abs($selisih),
                'status_case' => $statusCase,
            ]);

            $traveler->update([
                'status' => 'in_progress',
                'current_dept_id' => Auth::user()->department_id
            ]);
        });

        return back()->with('success', 'Qty IN berhasil disimpan');
    }

    public function storeOut(Request $request)
    {
        $request->validate([
            'traveler_id' => 'required|exists:travelers,id',
            'updated_by' => 'required|string|max:255',
            'qty_out' => 'required|integer|min:0',
            'dept_tujuan_id' => 'required|exists:departments,id',
            'type_reject' => 'nullable|string',
            'qty_reject' => 'nullable|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $traveler = Traveler::lockForUpdate()->findOrFail($request->traveler_id);

            // 🔹 ambil movement aktif (yang belum OUT)
            $movement = TravelerMovement::where('traveler_id', $traveler->id)
                ->where('current_dept_id', Auth::user()->department_id)
                ->whereNull('date_out')
                ->latest()
                ->first();

            if (!$movement) {
                DB::rollBack();
                return back()->with('error', 'Harus input IN dulu');
            }

            $qty_in = (int) $movement->qty_in;
            $qty_out = (int) $request->qty_out;
            $qty_reject = (int) ($request->qty_reject ?? 0);

            $total = $qty_out + $qty_reject;

            // tidak boleh kosong semua
            if ($qty_out === 0 && $qty_reject === 0) {
                DB::rollBack();
                return back()->with('error', 'Qty OUT dan Reject tidak boleh kosong semua');
            }

            if ($total > $qty_in) {
                DB::rollBack();
                return back()->with('error', 'Qty OUT + Reject melebihi Qty IN');
            }


            $qty_loss = $qty_in - $total;

            // status
            $statusCase = ($qty_loss > 0) ? 'selisih' : 'normal';

            if ($qty_loss > 0 && trim($request->notes) === '') {
                DB::rollBack();
                return back()->with('error', 'Ada selisih qty, wajib isi keterangan!');
            }

            //  UPDATE movement
            $movement->update([
                'updated_by' => $request->updated_by,
                'qty_out' => $qty_out,
                'qty_reject' => $qty_reject,
                'type_reject' => $request->type_reject,
                'qty_loss' => $qty_loss,
                'status_case' => $statusCase,
                'dept_tujuan_id' => $request->dept_tujuan_id,
                'date_out' => now(),
                'notes' => $request->notes
            ]);

            //  UPDATE traveler
            if (Auth::user()->department->name !== 'Warehouse Send') {
                $traveler->update([
                    'current_dept_id' => $request->dept_tujuan_id,
                    'dept_tujuan_id' => $request->dept_tujuan_id,
                    'status' => 'in_progress'
                ]);
            } else {
                $traveler->update([
                    'status' => 'done'
                ]);
            }

            DB::commit();

            return redirect()
                ->route('produksi.proses.index')
                ->with(
                    $qty_loss > 0 ? 'warning' : 'success',
                    $qty_loss > 0
                        ? "Terdapat selisih $qty_loss pcs"
                        : 'Qty OUT berhasil disimpan'
                );
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
            'currentDepartment',
            'deptAsal',
            'deptTujuan',
            'machine'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('traveler', function ($q2) use ($search) {
                    $q2->where('code', 'like', "%{$search}%");
                })->orWhereHas('currentDepartment', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })->orWhereHas('machine', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        // hanya menampilkakan movement dari department user yang sedang login
        $query->whereHas('currentDepartment', function ($q) {
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
            'currentDepartment',
            'deptAsal',
            'deptTujuan',
            'machine',
            'createdBy'
        ])->findOrFail($id);

        return view('produksi.logdetail', compact('movement'));
    }
}

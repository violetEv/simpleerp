<?php

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\Traveler;
use App\Models\TravelerMovement;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use SebastianBergmann\FileIterator\Facade;

class WarehouseController extends Controller
{
    public function dashboard()
    {
        return view('warehouse.dashboard');
    }
    public function order(Request $request)
    {
        $query = SuratJalan::with(['kkpoManagement.kkpo', 'kkpoManagement.customer', 'kkpoManagement.style', 'kkpoManagement.color', 'kkpoManagement.category']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('no_surat_jalan', 'like', "%{$search}%");
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('warehouse.order-management', compact('orders'));
    }
    public function orderStore(Request $request)
    {
        $request->validate([
            'kkpo_management_id' => 'required|exists:kkpo_managements,id',
            'no_surat_jalan' => 'required|string|max:255',
            'qty' => 'required|integer',
            'tanggal' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        $status = $request->qty <= 0 ? 'closed' : 'open';
        SuratJalan::create([
            'kkpo_management_id' => $request->kkpo_management_id,
            'no_surat_jalan' => $request->no_surat_jalan,
            'qty' => $request->qty,
            'tanggal' => $request->tanggal,
            'notes' => $request->notes,
            'status' => $status
        ]);

        return redirect()
            ->route('warehouse.order')
            ->with('success', 'Order berhasil ditambahkan');
    }
    public function orderUpdate(Request $request, $id)
    {
        $surat_jalan = SuratJalan::findOrFail($id);

        $request->validate([
            'kkpo_management_id' => 'required|exists:kkpo_managements,id',
            'no_surat_jalan' => 'required|string|max:255',
            'qty' => 'required|integer',
            'tanggal' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $surat_jalan->update([
            'kkpo_management_id' => $request->kkpo_management_id,
            'no_surat_jalan' => $request->no_surat_jalan,
            'qty' => $request->qty,
            'tanggal' => $request->tanggal,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('warehouse.order')
            ->with('success', 'Order berhasil diperbarui');
    }
    public function orderDelete($id)
    {
        $surat_jalan = SuratJalan::findOrFail($id);
        $surat_jalan->delete();

        // return view('warehouse.delete', compact('surat_jalan'))->with('success', 'Order berhasil dihapus');
        return redirect()
            ->route('warehouse.order')
            ->with('success', 'Order berhasil dihapus');
    }
    public function pecah(Request $request)
    {
        $query = SuratJalan::with(['kkpoManagement.customer', 'travelers']);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('no_surat_jalan', 'like', "%{$search}%")
                    ->orWhereHas('kkpoManagement.customer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $pecahTravelers = $query->paginate(10)->withQueryString();

        return view('warehouse.pecah', compact('pecahTravelers'));
    }
    public function pecahStore(Request $request)
    {
        $request->validate([
            'surat_jalan_id' => 'required|exists:surat_jalans,id',
            'tanggal' => 'required|date',

            'no_traveler' => 'required|array',
            'no_traveler.*' => 'required|string',

            'qty_split' => 'required|array',
            'qty_split.*' => 'required|integer|min:1',

            'dept_tujuan_id' => 'required|array',
            'dept_tujuan_id.*' => 'required|exists:departments,id',

            'notes' => 'nullable|string'
        ]);
        $status = $request->qty <= 0 ? 'closed' : 'open';

        foreach ($request->no_traveler as $index => $traveler) {

            $deptTujuan = $request->dept_tujuan_id[$index] ?? null;

            Traveler::create([
                'no_traveler' => $traveler,
                'qty' => $request->qty_split[$index],

                'surat_jalan_id' => $request->surat_jalan_id,

                'dept_asal_id' => FacadesAuth::user()->department_id,
                'dept_tujuan_id' => $deptTujuan,

                'current_dept_id' => $deptTujuan,

                'parent_traveler_id' => null,

                'tanggal' => $request->tanggal,
                'notes' => $request->notes,
                'status' => $status
            ]);
        }

        return redirect()
            ->route('warehouse.pecah')
            ->with('success', 'Traveler berhasil dipecah');
    }

    public function rework(Request $request)
    {
        $query = TravelerMovement::with([
            'suratJalan',
            'deptAsal',
            'deptTujuan'
        ]);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('type', 'rework')
                    ->whereHas('traveler.suratJalan.kkpoManagement.customer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }
        $reworkTravelers = $query->paginate(10)->withQueryString();
        return view('warehouse.rework', compact('reworkTravelers'));
    }

    public function reworkStore(Request $request){
        $request->validate([
            'traveler_id' => 'required|exists:travelers,id',
            'dept_asal_id' => 'required|exists:departments,id',
            'dept_tujuan_id' => 'required|exists:departments,id',
            'qty_in' => 'required|integer|min:1',
            'qty_out' => 'required|integer|min:0',
            'date_in' => 'required|date',
            'date_out' => 'nullable|date|after_or_equal:date_in',
            'notes' => 'nullable|string',
            'machine_id' => 'nullable|exists:machines,id'
        ]);

        TravelerMovement::create([
            'traveler_id' => $request->traveler_id,
            'dept_asal_id' => $request->dept_asal_id,
            'dept_tujuan_id' => $request->dept_tujuan_id,
            'qty_in' => $request->qty_in,
            'qty_out' => $request->qty_out,
            'date_in' => $request->date_in,
            'date_out' => $request->date_out,
            'notes' => $request->notes,
            'machine_id' => $request->machine_id,
            'type' => 'rework'
        ]);

        return redirect()
            ->route('warehouse.rework')
            ->with('success', 'Rework traveler berhasil ditambahkan');
    }

    public function list(Request $request)
    {
        $query = Traveler::with([
            'suratJalan',
            'deptAsal',
            'deptTujuan'
        ]);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('no_traveler', 'like', "%{$search}%")
                    ->orWhereHas('suratJalan.kkpoManagement.customer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $travelers = $query->paginate(10)->withQueryString();

        return view('warehouse.list', compact('travelers'));
    }
}

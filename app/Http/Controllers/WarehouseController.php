<?php

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\Traveler;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function dashboard()
    {
        return view('warehouse.dashboard');
    }
    public function order(Request $request)
    {
        $query = SuratJalan::query();

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
            'kkpo_id' => 'required|exists:kkpos,id',
            'no_surat_jalan' => 'required|string|max:255',
            'qty' => 'required|integer',
            'tanggal' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        SuratJalan::create([
            'kkpo_id' => $request->kkpo_id,
            'no_surat_jalan' => $request->no_surat_jalan,
            'qty' => $request->qty,
            'tanggal' => $request->tanggal,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('warehouse.order')
            ->with('success', 'Order berhasil ditambahkan');
    }
    public function orderUpdate(Request $request, $id)
    {
        $surat_jalan = SuratJalan::findOrFail($id);

        $request->validate([
            'kkpo_id' => 'required|exists:kkpos,id',
            'no_surat_jalan' => 'required|string|max:255',
            'qty' => 'required|integer',
            'tanggal' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $surat_jalan->update([
            'kkpo_id' => $request->kkpo_id,
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

        return redirect()
            ->route('warehouse.order')
            ->with('success', 'Order berhasil dihapus');
    }
    public function pecah(Request $request)
    {
        $query = SuratJalan::with(['kkpo.customer', 'travelers']);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('no_surat_jalan', 'like', "%{$search}%")
                    ->orWhereHas('kkpo.customer', function ($q2) use ($search) {
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

        foreach ($request->no_traveler as $index => $traveler) {

            $deptTujuan = $request->dept_tujuan_id[$index] ?? null;

            Traveler::create([
                'no_traveler' => $traveler,
                'qty' => $request->qty_split[$index],

                'surat_jalan_id' => $request->surat_jalan_id,

                'dept_asal_id' => $request->dept_asal_id ?? null,
                'dept_tujuan_id' => $deptTujuan,

                'current_dept_id' => $deptTujuan,

                'parent_traveler_id' => null,

                'tanggal' => $request->tanggal,
                'notes' => $request->notes
            ]);
        }

        return redirect()
            ->route('warehouse.pecah')
            ->with('success', 'Traveler berhasil dipecah');
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
                    ->orWhereHas('suratJalan.kkpo.customer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $travelers = $query->paginate(10)->withQueryString();

        return view('warehouse.list', compact('travelers'));
    }
}

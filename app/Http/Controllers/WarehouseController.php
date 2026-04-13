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
        $query = TravelerMovement::with(['traveler', 'deptAsal', 'deptTujuan'])
            ->where('qty_reject', '>', 0)
            ->orderBy('date_in', 'desc');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas('traveler', function ($q2) use ($search) {
                    $q2->where('no_traveler', 'like', "%{$search}%");
                })
                    ->orWhereHas('deptAsal', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('deptTujuan', function ($q4) use ($search) {
                        $q4->where('name', 'like', "%{$search}%");
                    });
            });
        }   
        $reworkTravelers = $query->paginate(10)->withQueryString(); 
        return view('warehouse.list', compact('reworkTravelers'));
    }   

    // untuk membuat traveler turunan dari traveler yang dirework, dengan no_traveler_turunan yang diinputkan oleh user
    public function reworkStore(Request $request, $id)
    {
        $request->validate([
            'no_traveler_turunan' => 'required|string|unique:travelers,no_traveler',
            'dept_tujuan_id' => 'required|exists:departments,id',
        ]);

        $travelerMovement = TravelerMovement::findOrFail($id);

        // nomor traveler turunan akan dibuat dengan format: no_traveler_ + no_traveler_turunan yang diinputkan user dipisahkan dengan - . contoh jika no_traveler yang dirework adalah TRV-001 dan user menginputkan no_traveler_turunan TRV-001-A, maka no_traveler turunan yang akan dibuat adalah TRV-001-A-1. jika user menginputkan no_traveler_turunan yang sama untuk traveler yang sama, maka nomor turunan akan bertambah 1. contoh jika user menginputkan no_traveler_turunan TRV-001-A untuk traveler yang sama, maka nomor turunan yang akan dibuat adalah TRV-001-A-2.
        if ($travelerMovement->qty_reject > 0) {
            Traveler::create([
                'no_traveler' => $travelerMovement->traveler->no_traveler . '-' . $request->no_traveler_turunan,
                'qty' => $travelerMovement->qty_reject,
                'surat_jalan_id' => $travelerMovement->traveler->surat_jalan_id,
                'dept_asal_id' => $travelerMovement->dept_id,
                'dept_tujuan_id' => $request->dept_tujuan_id,
                'current_dept_id' => $request->dept_tujuan_id,
                'parent_traveler_id' => $travelerMovement->traveler_id,
                'tanggal' => now(),
                'notes' => 'Traveler hasil rework dari traveler ' . $travelerMovement->traveler->no_traveler,
                'status' => 'open'
            ]);
            $travelerMovement->update([
                'qty_reject' => 0,
                'type_reject' => null,
                'notes' => $travelerMovement->notes . ' | Traveler dirework dan dibuat traveler turunan dengan no_traveler ' . $request->no_traveler_turunan
            ]);
            return redirect()
                ->route('warehouse.list')
                ->with('success', 'Traveler turunan berhasil dibuat');
         } else {
            return redirect()
                ->route('warehouse.list')
                ->with('error', 'Traveler ini bukan hasil rework');
         }
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

        $travelers = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $reworkTravelers = TravelerMovement::with('traveler')->where('qty_reject', '>', 0)->orderBy('date_in', 'desc')->
            paginate(10)->withQueryString();
        return view('warehouse.list', compact('travelers', 'reworkTravelers'));
    }
}

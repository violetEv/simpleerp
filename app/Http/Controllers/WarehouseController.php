<?php

namespace App\Http\Controllers;

use App\Models\KkpoManagement;
use App\Models\SuratJalan;
use App\Models\Traveler;
use App\Models\TravelerMovement;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use SebastianBergmann\FileIterator\Facade;

class WarehouseController extends Controller
{
    public function dashboard()
    {
        $totalQtyTraveler = Traveler::sum('qty');
        $totalQtyKeluar = TravelerMovement::sum('qty_out');
        $balanceBongkar = $totalQtyTraveler - $totalQtyKeluar;

        return view('warehouse.dashboard', compact('totalQtyTraveler', 'totalQtyKeluar', 'balanceBongkar'));
    }
    public function order(Request $request)
    {
        // ambil data surat jalan dengan relasi kkpoManagement, customer, style, color, category, dan filter berdasarkan no_surat_jalan atau nama customer jika ada query search
        $query = SuratJalan::with(['kkpoManagement.customer', 'kkpoManagement.styles', 'kkpoManagement.colors', 'kkpoManagement.categories']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('no_surat_jalan', 'like', "%{$search}%");
        }

        $orders = $query->paginate(10)->withQueryString();
        $kkpoManagements = KkpoManagement::with(['categories', 'customer', 'styles', 'colors', 'suratJalan'])->get();

        return view('warehouse.suratjalan', compact('orders', 'kkpoManagements'));
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
        try {
            SuratJalan::create([
                'kkpo_management_id' => $request->kkpo_management_id,
                'no_surat_jalan' => $request->no_surat_jalan,
                'qty' => $request->qty,
                'tanggal' => $request->tanggal,
                'notes' => $request->notes,
                'status' => $status
            ]);

            return redirect()
                ->route('warehouse.suratjalan')
                ->with('success', 'Order berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()
                ->route('warehouse.suratjalan')
                ->with('error', 'Gagal membuat surat jalan: ' . $e->getMessage());
        }
    }

    public function orderUpdate(Request $request, int $id)
    {
        $surat_jalan = SuratJalan::findOrFail($id);

        $request->validate([
            'kkpo_management_id' => 'required|exists:kkpo_managements,id',
            'no_surat_jalan' => 'required|string|max:255',
            'qty' => 'required|integer',
            'tanggal' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            $status = $request->qty <= 0 ? 'closed' : 'open';

            $surat_jalan->update([
                'kkpo_management_id' => $request->kkpo_management_id,
                'no_surat_jalan' => $request->no_surat_jalan,
                'qty' => $request->qty,
                'tanggal' => $request->tanggal,
                'notes' => $request->notes,
                'status' => $status
            ]);

            return redirect()
                ->route('warehouse.suratjalan')
                ->with('success', 'Order berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->route('warehouse.suratjalan')
                ->with('error', 'Gagal memperbarui surat jalan: ' . $e->getMessage());
        }
    }

    public function orderDelete(int $id)
    {
        $surat_jalan = SuratJalan::findOrFail($id);
        try {
            $surat_jalan->delete();

            return redirect()
                ->route('warehouse.suratjalan')
                ->with('success', 'Order berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('warehouse.suratjalan')
                ->with('error', 'Gagal menghapus surat jalan: ' . $e->getMessage());
        }
    }

    public function pecah(Request $request)
    {
        $query = SuratJalan::with(['kkpoManagement.customer', 'kkpoManagement.styles', 'kkpoManagement.colors', 'kkpoManagement.categories', 'travelers']);

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
            // 'tanggal' => 'required|date',

            'no_traveler' => 'required|array',
            'no_traveler.*' => 'required|string',

            'qty_split' => 'required|array',
            'qty_split.*' => 'required|integer|min:1',

            'dept_tujuan_id' => 'required|array',
            'dept_tujuan_id.*' => 'required|exists:departments,id',
            'tanggal' => 'required|array',
            'tanggal.*' => 'required|date',
            

            'notes' => 'nullable|string'
        ]);
        $status = $request->qty <= 0 ? 'closed' : 'open';

        foreach ($request->no_traveler as $index => $traveler) {

            $deptTujuan = $request->dept_tujuan_id[$index] ?? null;

            try {
                $travelerBaru = Traveler::create([
                    'no_traveler' => $traveler,
                    'qty' => $request->qty_split[$index],
                    'surat_jalan_id' => $request->surat_jalan_id,
                    'dept_asal_id' => FacadesAuth::user()->department_id,
                    'dept_tujuan_id' => $deptTujuan,
                    'current_dept_id' => $deptTujuan,
                    // 'parent_traveler_id' => null,
                    'tanggal' => $request->tanggal[$index],
                    'notes' => $request->notes,
                    'status' => $status
                ]);
                
                TravelerMovement::create([
                    'traveler_id' => $travelerBaru->id,
                    'dept_asal_id' => FacadesAuth::user()->department_id,
                    'current_dept_id' => $deptTujuan,
                    'dept_tujuan_id' => $deptTujuan,
                    'qty_out' => $request->qty_split[$index],
                    'date_out' => $request->tanggal[$index],
                ]);
            } catch (QueryException $e) {
                if ($e->errorInfo[1] == 1062) {
                    return redirect()
                        ->route('warehouse.pecah')
                        ->with('error', 'No traveler sudah ada: ' . $traveler);
                } else {
                    return redirect()
                        ->route('warehouse.pecah')
                        ->with('error', 'Gagal membuat traveler: ' . $e->getMessage());
                }
            }
        }
        return redirect()
            ->route('warehouse.pecah')
            ->with('success', 'Traveler berhasil dibuat');
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
    public function reworkStore(Request $request, int $id)
    {
        $request->validate([
            'no_traveler_turunan' => 'required|string|unique:travelers,no_traveler',
            'dept_tujuan_id' => 'required|exists:departments,id',
        ]);
        try {
            $movement = TravelerMovement::findOrFail($id);
            $traveler = $movement->traveler;

            Traveler::create([
                'no_traveler' => $request->no_traveler_turunan,
                'qty' => $movement->qty_reject,
                'surat_jalan_id' => $traveler->surat_jalan_id,
                'dept_asal_id' => $movement->dept_tujuan_id,
                'dept_tujuan_id' => $request->dept_tujuan_id,
                'current_dept_id' => $request->dept_tujuan_id,
                'parent_traveler_id' => $traveler->id,
                'tanggal' => now(),
                'notes' => 'Rework dari traveler ' . $traveler->no_traveler . ' (Movement ID: ' . $movement->id . ')',
                'status' => 'open'
            ]);

            return redirect()
                ->route('warehouse.rework')
                ->with('success', 'Traveler rework berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()
                ->route('warehouse.rework')
                ->with('error', 'Gagal membuat traveler rework: ' . $e->getMessage());
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
        $reworkTravelers = TravelerMovement::with('traveler')->where('qty_reject', '>', 0)->orderBy('date_in', 'desc')->paginate(10)->withQueryString();
        return view('warehouse.list', compact('travelers', 'reworkTravelers'));
    }

    public function travelerDetail(int $id)
    {
        $traveler = Traveler::with(['suratJalan.kkpoManagement.customer', 'deptAsal', 'deptTujuan'])->findOrFail($id);
        $movements = TravelerMovement::with(['deptAsal', 'deptTujuan'])->where('traveler_id', $id)->orderBy('date_in', 'desc')->get();

        return view('warehouse.traveler_detail', compact('traveler', 'movements'));
    }
    public function travelerDelete(int $id)
    {
        $traveler = Traveler::findOrFail($id);
        try {
            $traveler->delete();

            return redirect()
                ->route('warehouse.list')
                ->with('success', 'Traveler berhasil dihapus');
        } catch (QueryException $e) {
            return redirect()
                ->route('warehouse.list')
                ->with('error', 'Gagal menghapus traveler: ' . $e->getMessage());
        }
    }
}

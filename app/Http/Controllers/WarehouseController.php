<?php

namespace App\Http\Controllers;

use App\Models\KkpoDetail;
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
        // total qty harusnya dari total qty suratjalan
        $totalQtyTraveler = SuratJalan::sum('qty');
        $totalQtyKeluar = Traveler::sum('qty');
        $balanceBongkar = $totalQtyTraveler - $totalQtyKeluar;
        //recent activities, ambil dari surat jalan yang belum dipecah, urutkan berdasarkan tanggal terbaru, ambil 5 data terbaru
        //
        $recentActivities = SuratJalan::whereRaw('qty - COALESCE((SELECT SUM(qty) FROM travelers WHERE travelers.surat_jalan_id = surat_jalans.id), 0) > 0')
            ->latest()
            ->take(5)
            ->get();

        return view('warehouse.dashboard', compact('totalQtyTraveler', 'totalQtyKeluar', 'balanceBongkar', 'recentActivities'));
    }
    public function order(Request $request)
    {
        $query = SuratJalan::with([

            'kkpo.customer',

            'kkpo.details.style',
            'kkpo.details.color',
            'kkpo.details.category',
        ]);

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(
                'no_surat_jalan',
                'like',
                "%{$search}%"
            );
        }

        $orders = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kkpo = KkpoManagement::with([

            'customer',

            'details.style',
            'details.color',
            'details.category',

            // penting untuk hitung qty terpakai
            'details.suratJalans',

        ])->get();

        return view(
            'warehouse.suratjalan',
            compact(
                'orders',
                'kkpo'
            )
        );
    }

    public function orderStore(Request $request)
    {
        $request->validate([

            'kkpo_management_id' =>
            'required|exists:kkpo_managements,id',

            'kkpo_detail_id' =>
            'required|exists:kkpo_details,id',

            'style_id' =>
            'required|exists:styles,id',

            'color_id' =>
            'required|exists:colors,id',

            'category_id' =>
            'required|exists:categories,id',

            'no_surat_jalan' =>
            'required|string|max:255',

            'qty' =>
            'required|integer|min:1',

            'tanggal' =>
            'required|date',

            'notes' =>
            'nullable|string',
        ]);

        try {

            // DETAIL KKPO
            $detail = KkpoDetail::with([
                'style',
                'color',
                'category',
                'suratJalans',
            ])->findOrFail(
                $request->kkpo_detail_id
            );

            // VALIDASI DETAIL HARUS SESUAI
            if (

                $detail->style_id != $request->style_id ||

                $detail->color_id != $request->color_id ||

                $detail->category_id != $request->category_id

            ) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Detail KKPO tidak sesuai'
                    );
            }

            // TOTAL TERPAKAI
            $usedQty = $detail
                ->suratJalans()
                ->sum('qty');

            // SISA
            $sisaQty = $detail->qty - $usedQty;

            // VALIDASI QTY
            if ($request->qty > $sisaQty) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Qty melebihi sisa qty KKPO'
                    );
            }

            // STATUS
            $status = 'open';

            // CREATE
            SuratJalan::create([

                'kkpo_management_id' =>
                $request->kkpo_management_id,

                'kkpo_detail_id' =>
                $request->kkpo_detail_id,

                'no_surat_jalan' =>
                $request->no_surat_jalan,

                'qty' =>
                $request->qty,

                'tanggal' =>
                $request->tanggal,

                'notes' =>
                $request->notes,

                'status' =>
                $status,
            ]);

            return redirect()
                ->route('warehouse.suratjalan')
                ->with(
                    'success',
                    'Surat Jalan berhasil dibuat'
                );
        } catch (\Exception $e) {

            return redirect()
                ->route('warehouse.suratjalan')
                ->with(
                    'error',
                    'Gagal membuat surat jalan : '
                        . $e->getMessage()
                );
        }
    }

    public function orderUpdate(Request $request, int $id)
    {
        $suratJalan = SuratJalan::findOrFail($id);

        $request->validate([

            'kkpo_management_id' =>
            'required|exists:kkpo_managements,id',

            'kkpo_detail_id' =>
            'required|exists:kkpo_details,id',

            'style_id' =>
            'required|exists:styles,id',

            'color_id' =>
            'required|exists:colors,id',

            'category_id' =>
            'required|exists:categories,id',

            'no_surat_jalan' =>
            'required|string|max:255',

            'qty' =>
            'required|integer|min:1',

            'tanggal' =>
            'required|date',

            'notes' =>
            'nullable|string',
        ]);

        try {

            // DETAIL
            $detail = KkpoDetail::with([
                'suratJalans'
            ])->findOrFail(
                $request->kkpo_detail_id
            );

            // VALIDASI DETAIL
            if (

                $detail->style_id != $request->style_id ||

                $detail->color_id != $request->color_id ||

                $detail->category_id != $request->category_id

            ) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Detail KKPO tidak sesuai'
                    );
            }

            // TOTAL TERPAKAI
            // kecuali data yg sedang diedit
            $usedQty = SuratJalan::where(
                'kkpo_detail_id',
                $detail->id
            )
                ->where('id', '!=', $id)
                ->sum('qty');

            // SISA
            $sisaQty = $detail->qty - $usedQty;

            // VALIDASI QTY
            if ($request->qty > $sisaQty) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Qty melebihi sisa qty KKPO'
                    );
            }

            // TRAVELER
            $totalTravelerQty = Traveler::where(
                'surat_jalan_id',
                $id
            )->sum('qty');

            // STATUS
            if ($request->qty <= $totalTravelerQty) {

                $status = 'closed';
            } elseif ($totalTravelerQty > 0) {

                $status = 'in_process';
            } else {

                $status = 'open';
            }

            // UPDATE
            $suratJalan->update([

                'kkpo_management_id' =>
                $request->kkpo_management_id,

                'kkpo_detail_id' =>
                $request->kkpo_detail_id,

                'no_surat_jalan' =>
                $request->no_surat_jalan,

                'qty' =>
                $request->qty,

                'tanggal' =>
                $request->tanggal,

                'notes' =>
                $request->notes,

                'status' =>
                $status,
            ]);

            return redirect()
                ->route('warehouse.suratjalan')
                ->with(
                    'success',
                    'Surat Jalan berhasil diperbarui'
                );
        } catch (\Exception $e) {

            return redirect()
                ->route('warehouse.suratjalan')
                ->with(
                    'error',
                    'Gagal update surat jalan : '
                        . $e->getMessage()
                );
        }
    }

    public function orderDelete(int $id)
    {
        $suratJalan = SuratJalan::findOrFail($id);

        try {

            $suratJalan->delete();

            return redirect()
                ->route('warehouse.suratjalan')
                ->with(
                    'success',
                    'Surat Jalan berhasil dihapus'
                );
        } catch (\Exception $e) {

            return redirect()
                ->route('warehouse.suratjalan')
                ->with(
                    'error',
                    'Gagal menghapus surat jalan : '
                        . $e->getMessage()
                );
        }
    }

    public function pecah(Request $request)
    {
        $query = SuratJalan::with([
            'kkpo.customer',
            'kkpo.details.style',
            'kkpo.details.color',
            'kkpo.details.category',
            'travelers'
        ])
            ->whereIn('status', ['open', 'in_process'])
            ->whereRaw('qty - COALESCE((SELECT SUM(qty) FROM travelers WHERE travelers.surat_jalan_id = surat_jalans.id), 0) > 0');
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

        $reworkQuery = TravelerMovement::with([
            'traveler.children',
            'deptAsal',
            'deptTujuan'
        ])
            ->where('qty_reject', '>', 0)
            ->get()
            ->filter(function ($movement) {

                $traveler = $movement->traveler;

                if (!$traveler) {
                    return false;
                }

                $totalReworkDiproses =
                    $traveler->children->sum('qty');

                $sisaRework =
                    $movement->qty_reject - $totalReworkDiproses;

                return $sisaRework > 0;
            });

        $page = request()->query('page', 1);
        $perPage = 10;

        $reworkTravelers = new \Illuminate\Pagination\LengthAwarePaginator(
            $reworkQuery->slice(($page - 1) * $perPage, $perPage)->values(),
            $reworkQuery->count(),
            $perPage,
            $page,
            [
                'path' => route('warehouse.pecah'),
                'query' => request()->query(),
            ]
        );


        return view('warehouse.pecah', compact('pecahTravelers', 'reworkTravelers'));
    }

    public function pecahStore(Request $request)
    {
        $request->validate([
            'surat_jalan_id' => 'required|exists:surat_jalans,id',
            // 'tanggal' => 'required|date',

            'no_traveler' => 'required|array',
            'no_traveler.*' => 'required|string',

            'pic' => 'required|string|max:255',

            'qty_split' => 'required|array',
            'qty_split.*' => 'required|integer|min:1',

            'dept_tujuan_id' => 'required|array',
            'dept_tujuan_id.*' => 'required|exists:departments,id',
            'tanggal' => 'required|array',
            'tanggal.*' => 'required|date',


            'notes' => 'nullable|string'
        ]);

        $suratJalan = SuratJalan::findOrFail($request->surat_jalan_id);

        $totalTravelerQty = Traveler::where('surat_jalan_id', $suratJalan->id)->sum('qty');

        $sisaQty = $suratJalan->qty - $totalTravelerQty;

        if ($sisaQty <= 0) {
            $status = 'closed';
        } elseif ($totalTravelerQty > 0) {
            $status = 'in_process';
        } else {
            $status = 'open';
        }

        $suratJalan->update([
            'status' => $status
        ]);

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
                    'status' => $status,
                    'pic' => $request->pic
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
        return view('warehouse.list-rework', compact('reworkTravelers'));
    }

    // untuk membuat traveler turunan dari traveler yang dirework, dengan no_traveler_turunan yang diinputkan oleh user
    public function reworkStore(Request $request, int $id)
    {
        $request->validate([

            'no_traveler' => 'required|array',
            'no_traveler.*' => 'required|string|unique:travelers,no_traveler',

            'qty_split' => 'required|array',

            'qty_split.*' => 'required|integer|min:1',

            'dept_tujuan_id' => 'required|array',

            'dept_tujuan_id.*' =>
            'required|exists:departments,id',
        ]);

        try {

            $movement = TravelerMovement::findOrFail($id);

            $traveler = $movement->traveler;

            $totalSplit = array_sum($request->qty_split);

            // VALIDASI TOTAL
            if ($totalSplit > $movement->qty_reject) {

                return back()->with(
                    'error',
                    'Qty split melebihi qty rework'
                );
            }

            foreach ($request->no_traveler as $index => $travelerNo) {

                Traveler::create([

                    'no_traveler' => $travelerNo,

                    'qty' => $request->qty_split[$index],

                    'surat_jalan_id' =>
                    $traveler->surat_jalan_id,

                    'dept_asal_id' =>
                    $movement->dept_tujuan_id,

                    'dept_tujuan_id' =>
                    $request->dept_tujuan_id[$index],

                    'current_dept_id' =>
                    $request->dept_tujuan_id[$index],

                    'parent_traveler_id' =>
                    $traveler->id,

                    'tanggal' => now(),

                    'notes' =>
                    'Rework split dari traveler '
                        . $traveler->no_traveler,

                    'status' => 'open',
                ]);
            }

            return redirect()
                ->route('warehouse.create-traveler')
                ->with(
                    'success',
                    'Traveler rework berhasil dibuat'
                );
        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
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
                    ->orWhereHas('suratJalan.kkpo.customer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $travelers = $query
            ->orderBy('created_at', 'desc')
            ->orderBy('no_traveler', 'asc')
            ->paginate(10)
            ->withQueryString();

        $reworkTravelers = TravelerMovement::with('traveler')
            ->where('qty_reject', '>', 0)
            ->orderBy('date_in', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('warehouse.list-new', compact('travelers', 'reworkTravelers'));
    }

    public function travelerDetail(int $id)
    {
        $traveler = Traveler::with(['suratJalan.kkpo.customer', 'suratJalan.kkpo.details.style', 'suratJalan.kkpo.category', 'suratJalan.kkpo.color', 'deptAsal', 'deptTujuan'])->findOrFail($id);
        $movements = TravelerMovement::with(['deptAsal', 'deptTujuan'])->where('traveler_id', $id)->orderBy('date_in', 'desc')->get();

        return view('warehouse.traveler_detail', compact('traveler', 'movements'));
    }
    public function travelerDelete(int $id)
    {
        $traveler = Traveler::findOrFail($id);
        try {
            $traveler->delete();

            return redirect()
                ->route('warehouse.list-new')
                ->with('success', 'Traveler berhasil dihapus');
        } catch (QueryException $e) {
            return redirect()
                ->route('warehouse.list-new')
                ->with('error', 'Gagal menghapus traveler: ' . $e->getMessage());
        }
    }
    // fungsi untuk mengubah data traveler, hanya no travelernya saja, tidak berpindah halaman , hanya pake modal
    public function editTraveler(int $id)
    {
        // edit no traveler dan catatan
        $traveler = Traveler::findOrFail($id);
        try {
            $newNoTraveler = request()->input('no_traveler');
            if (Traveler::where('no_traveler', $newNoTraveler)->where('id', '!=', $id)->exists()) {
                return redirect()
                    ->route('warehouse.list-new')
                    ->with('error', 'No traveler sudah ada: ' . $newNoTraveler);
            }
            $traveler->no_traveler = $newNoTraveler;
            $traveler->notes = request()->input('notes');
            $traveler->save();
        } catch (QueryException $e) {
            // return ke halaman list dengan pesan error jika terjadi error, misalnya no traveler sudah ada atau error lainnya
            return redirect()
                ->route('warehouse.list-new')
                ->with('error', 'Gagal mengubah traveler: ' . $e->getMessage());
        }
        return redirect()
            ->route('warehouse.list-new')
            ->with('success', 'No traveler berhasil diubah: ' . $newNoTraveler);
    }
    public function logWarehouse(Request $request)
    {
        $query = TravelerMovement::with(['traveler', 'deptAsal', 'deptTujuan']);

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
        $movements = $query->orderBy('date_out', 'desc')->paginate(10)->withQueryString();
        return view('warehouse.log-warehouse', compact('movements'));
    }
}

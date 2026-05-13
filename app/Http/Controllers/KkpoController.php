<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Item;
use App\Models\KkpoDetail;
use App\Models\KkpoManagement;
use App\Models\Style;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KkpoController extends Controller
{
    public function kkpo()
    {

        $query = KkpoDetail::with([
            'kkpo.details',
            'kkpo.customer',
            'category',
            'style',
            'color',
            'item',
            'brand',
            'unit',
            'kkpo.currency',
        ]);

        // SEARCH
        if (request()->filled('search')) {

            $search = request('search');

            $query->where(function ($q) use ($search) {

                $q->whereHas(
                    'kkpo',
                    fn($q) =>
                    $q->where('no_kkpo', 'like', "%{$search}%")
                        ->orWhere('kp_po', 'like', "%{$search}%")
                )

                    ->orWhereHas(
                        'kkpo.customer',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )

                    ->orWhereHas(
                        'category',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )

                    ->orWhereHas(
                        'style',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )

                    ->orWhereHas(
                        'color',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )

                    ->orWhereHas(
                        'item',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )

                    ->orWhereHas(
                        'brand',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    );
            });
        }

        // FILTER
        if (request('customer')) {
            $query->whereHas(
                'kkpo',
                fn($q) =>
                $q->where('customer_id', request('customer'))
            );
        }

        if (request('category')) {
            $query->where('category_id', request('category'));
        }

        if (request('style')) {
            $query->where('style_id', request('style'));
        }

        if (request('color')) {
            $query->where('color_id', request('color'));
        }

        if (request('item')) {
            $query->where('item_id', request('item'));
        }

        if (request('brand')) {
            $query->where('brand_id', request('brand'));
        }

        if (request('unit')) {
            $query->where('unit_id', request('unit'));
        }
        // qty
        // if (request('qty')) {
        //     $query->where('qty', request('qty'));
        // }

        if (request('currency')) {
            $query->whereHas(
                'kkpo',
                fn($q) =>
                $q->where('currency_id', request('currency'))
            );
        }

        // FILTER DATE
        if (request()->filled('date_from') || request()->filled('date_to')) {

            $query->whereHas('kkpo', function ($q) {

                if (request()->filled('date_from')) {
                    $q->whereDate('date', '>=', request('date_from'));
                }

                if (request()->filled('date_to')) {
                    $q->whereDate('date', '<=', request('date_to'));
                }
            });
        }

        $kkpoDetails = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        // FILTER OPTIONS
        $filterCustomers = Customer::whereIn(
            'id',
            KkpoManagement::select('customer_id')
                ->whereIn(
                    'id',
                    KkpoDetail::select('kkpo_management_id')->distinct()
                )
                ->distinct()
        )->get();

        $filterCategories = Category::whereIn(
            'id',
            KkpoDetail::select('category_id')->distinct()
        )->get();

        $filterStyles = Style::whereIn(
            'id',
            KkpoDetail::select('style_id')->distinct()
        )->get();

        $filterColors = Color::whereIn(
            'id',
            KkpoDetail::select('color_id')->distinct()
        )->get();

        $filterItems = Item::whereIn(
            'id',
            KkpoDetail::select('item_id')->distinct()
        )->get();

        $filterBrands = Brand::whereIn(
            'id',
            KkpoDetail::select('brand_id')->distinct()
        )->get();

        $filterUnits = Unit::whereIn(
            'id',
            KkpoDetail::select('unit_id')->distinct()
        )->get();

        $filterCurrencies = Currency::whereIn(
            'id',
            KkpoManagement::whereIn(
                'id',
                KkpoDetail::select('kkpo_management_id')->distinct()
            )->select('currency_id')->distinct()
        )->get();


        // MODAL DATA
        $customers = Customer::all();
        $categories = Category::all();
        $styles = Style::all();
        $colors = Color::all();
        $items = Item::all();
        $brands = Brand::all();
        $units = Unit::all();
        $currencies = Currency::all();

        return view('ppic.kkpo', compact(
            'kkpoDetails',
            'filterCustomers',
            'filterCategories',
            'filterStyles',
            'filterColors',
            'filterItems',
            'filterBrands',
            'filterUnits',
            'filterCurrencies',
            'customers',
            'categories',
            'styles',
            'colors',
            'items',
            'brands',
            'units',
            'currencies'
        ));
    }
    public function kkpoDetailShow(int $id)
    {
        $detail = KkpoDetail::with([
            'kkpo.customer',
            'kkpo.currency',
            'category',
            'style',
            'color',
            'item',
            'brand',
            'unit',
            'kkpo.travelers.suratJalan'
        ])->findOrFail($id);

        return view('ppic.detailkkpo', compact('detail'));
    }

    public function kkpoStore(Request $request)
    {
        $request->merge([
            'no_kkpo' => strtoupper(trim($request->no_kkpo))
        ]);

        $request->validate([
            'no_kkpo' => 'required|string|max:255',
            'customer_id' => 'required|exists:customers,id',
            'kp_po' => 'nullable|string|max:255',
            'currency_id' => 'required|exists:currencies,id',
            'date' => 'required|date',
            'npwp' => 'nullable|exists:customers,npwp',
            'payment_terms' => 'required|exists:customers,payment_terms',
            'details' => 'required|array|min:1',

            // 'details.*.date' => 'required|date',
            'details.*.category_id' => 'required|exists:categories,id',
            'details.*.style_id' => 'required|exists:styles,id',
            'details.*.color_id' => 'required|exists:colors,id',
            'details.*.item_id' => 'required|exists:items,id',
            'details.*.brand_id' => 'required|exists:brands,id',
            'details.*.qty' => 'required|numeric|min:0',
            'details.*.price' => 'required|numeric|min:0',
            'details.*.reject_allowance' => 'required|numeric|min:0',
            'details.*.pic' => 'required|string|max:255',
            'details.*.unit_id' => 'required|exists:units,id',
            // 'details.*.currency_id' => 'nullable|exists:currencies,id',
            'details.*.remark' => 'nullable|string|max:255'

        ]);

        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | CEK KKPO SUDAH DIGUNAKAN CUSTOMER LAIN
        |--------------------------------------------------------------------------
        */
            $conflict = KkpoManagement::where('no_kkpo', $request->no_kkpo)
                ->where('customer_id', '!=', $request->customer_id)
                ->exists();

            if ($conflict) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->with('error', 'KKPO number is already used by another customer!');
            }

            /*
        |--------------------------------------------------------------------------
        | AMBIL HEADER EXISTING
        |--------------------------------------------------------------------------
        */
            $kkpo = KkpoManagement::where('no_kkpo', $request->no_kkpo)
                ->where('customer_id', $request->customer_id)
                ->first();

            /*
        |--------------------------------------------------------------------------
        | CREATE HEADER JIKA BELUM ADA
        |--------------------------------------------------------------------------
        */
            if (!$kkpo) {

                $kkpo = KkpoManagement::create([
                    'no_kkpo' => $request->no_kkpo,
                    'customer_id' => $request->customer_id,
                    'kp_po' => $request->kp_po,
                    'payment_terms' => $request->payment_terms,
                    // 'notes' => $request->notes,
                    'npwp' => $request->npwp,
                    'currency_id' => $request->currency_id,
                    'date' => $request->date,
                ]);
            }

            /*
        |--------------------------------------------------------------------------
        | INSERT DETAIL
        |--------------------------------------------------------------------------
        */
            foreach ($request->details as $detail) {

                $kkpo->details()->create([
                    'category_id' => $detail['category_id'],
                    'style_id' => $detail['style_id'],
                    'color_id' => $detail['color_id'],
                    'item_id' => $detail['item_id'],
                    'brand_id' => $detail['brand_id'],
                    'qty' => $detail['qty'],
                    'unit_id' => $detail['unit_id'],
                    'price' => $detail['price'],
                    'remark' => $detail['remark'] ?? null,
                    // 'currency_id' => $detail['currency_id'] ?? null,
                    'reject_allowance' => $detail['reject_allowance'],
                    'pic' => $detail['pic'] ?? null,
                    // 'date' => $detail['date'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('ppic.kkpo')
                ->with('success', 'KKPO successfully created');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function kkpoUpdate(Request $request, int $id)
    {
        $request->merge([
            'no_kkpo' => strtoupper(trim($request->no_kkpo))
        ]);
        $kkpo = KkpoManagement::findOrFail($id);

        $request->validate([
            'no_kkpo' => 'required|string|max:255',
            'customer_id' => 'required|exists:customers,id',
            'kp_po' => 'nullable|string|max:255',
            'payment_terms' => 'nullable|exists:customers,payment_terms',
            'npwp' => 'required|exists:customers,npwp',
            'currency_id' => 'required|exists:currencies,id',
            'date' => 'required|date',
            'details' => 'required|array|min:1',

            // 'details.*.date' => 'required|date',
            'details.*.qty' => 'required|numeric|min:0',
            'details.*.unit_id' => 'required|exists:units,id',
            'details.*.price' => 'required|numeric|min:0',
            'details.*.reject_allowance' => 'required|numeric|min:0',
            'details.*.category_id' => 'required|exists:categories,id',
            'details.*.style_id' => 'required|exists:styles,id',
            'details.*.color_id' => 'required|exists:colors,id',
            'details.*.item_id' => 'required|exists:items,id',
            'details.*.brand_id' => 'required|exists:brands,id',
            'details.*.pic' => 'required|string|max:255',
            // 'details.*.currency_id' => 'nullable|exists:currencies,id',

        ]);

        DB::beginTransaction();

        try {

            $kkpo->update([
                'no_kkpo' => $request->no_kkpo,
                'customer_id' => $request->customer_id,
                'kp_po' => $request->kp_po,
                'payment_terms' => $request->payment_terms,
                // 'notes' => $request->notes,
                'npwp' => $request->npwp,
                'currency_id' => $request->currency_id,
                'date' => $request->date,
            ]);

            foreach ($request->details as $detail) {

                // UPDATE DETAIL LAMA
                if (!empty($detail['id'])) {

                    $existingDetail = KkpoDetail::find($detail['id']);

                    if ($existingDetail) {

                        $existingDetail->update([
                            'category_id' => $detail['category_id'],
                            'style_id' => $detail['style_id'],
                            'color_id' => $detail['color_id'],
                            'item_id' => $detail['item_id'],
                            'brand_id' => $detail['brand_id'],
                            'qty' => $detail['qty'],
                            'unit_id' => $detail['unit_id'],
                            'price' => $detail['price'] ?? null,
                            'remark' => $detail['remark'] ?? null,
                            // 'currency_id' => $detail['currency_id'] ?? null,
                            'reject_allowance' => $detail['reject_allowance'] ?? 0,
                            'pic' => $detail['pic'] ?? null,
                            // 'date' => $detail['date'] ?? null,
                        ]);
                    }
                }

                // CREATE DETAIL BARU
                else {

                    $kkpo->details()->create([
                        'category_id' => $detail['category_id'],
                        'style_id' => $detail['style_id'],
                        'color_id' => $detail['color_id'],
                        'item_id' => $detail['item_id'],
                        'brand_id' => $detail['brand_id'],
                        'qty' => $detail['qty'],
                        'unit_id' => $detail['unit_id'],
                        'price' => $detail['price'],
                        'remark' => $detail['remark'] ?? null,
                        // 'currency_id' => $detail['currency_id'] ?? null,
                        'reject_allowance' => $detail['reject_allowance'] ?? 0,
                        'pic' => $detail['pic'] ?? null,
                    ]);
                }
            }


            DB::commit();

            return redirect()->route('ppic.kkpo')
                ->with('success', 'KKPO successfully updated');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function kkpoDelete(int $id)
    {
        $detail = KkpoDetail::findOrFail($id);

        try {

            $kkpoId = $detail->kkpo_management_id;

            $detail->delete();

            // cek apakah header masih punya detail
            $remaining = KkpoDetail::where(
                'kkpo_management_id',
                $kkpoId
            )->exists();

            // kalau sudah tidak ada detail, hapus header
            if (!$remaining) {
                KkpoManagement::where('id', $kkpoId)->delete();
            }

            return back()->with(
                'success',
                'KKPO successfully deleted'
            );
        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Error: ' . $e->getMessage()
            );
        }
    }
    public function check(Request $request)
    {
        $kkpo = KkpoManagement::with('customer')
            ->firstWhere(
                'no_kkpo',
                strtoupper(trim($request->no_kkpo))
            );

        if (!$kkpo) {
            return response()->json([
                'exists' => false
            ]);
        }

        return response()->json([
            'exists' => true,
            'data' => [
                'customer_id' => $kkpo->customer_id,
                'kp_po' => $kkpo->kp_po,
                'currency_id' => $kkpo->currency_id,
                'date' => $kkpo->date,

                // tambahin ini
                'customer' => [
                    'npwp' => $kkpo->customer->npwp ?? '',
                    'payment_terms' => $kkpo->customer->payment_terms ?? '',
                ]
            ]
        ]);
    }

    public function kkpoDetail(int $id)
    {
        $kkpo = KkpoManagement::with('customer', 'styles', 'colors', 'categories')->findOrFail($id);
        return view('ppic.detailkkpo', compact('kkpo'));
    }
}

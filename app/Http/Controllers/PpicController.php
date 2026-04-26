<?php

namespace App\Http\Controllers;

use App\Exports\TravelerMovementExport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Kkpo;
use App\Models\KkpoManagement;
use App\Models\Style;
use App\Models\Unit;
use App\Models\Currency;
use App\Models\SuratJalan;
use App\Models\TravelerMovement;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PpicController extends Controller
{
    public function dashboard()
    {
        // $totalKKPO = Kkpo::count();
        $totalColors = Color::count();
        $totalSizes = Style::count();
        $totalMaterials = Category::count();

        return view('ppic.dashboard', compact('totalColors', 'totalSizes', 'totalMaterials'));
    }
    public function customer(Request $request)
    {
        $query = Customer::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('ppic.customer', compact('customers'));
    }
    // kolom selain name tidak harus required, jadi bisa nullable, dan di view ditampilkan '-' jika null
    public function customerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'string|max:255|nullable',
            'phone' => 'string|max:255|nullable',
            'attention' => 'string|max:255|nullable',
        ]);

        try {
            Customer::create($request->all());

            return redirect()
                ->route('ppic.customer')
                ->with('success', 'Customer berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama customer sudah digunakan');
            }
            return back()->with('error', 'Gagal menambahkan Customer:' . $e->getMessage());
        }
    }
    public function customerUpdate(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'string|max:255|nullable',
            'phone' => 'string|max:255|nullable',
            'attention' => 'string|max:255|nullable',
        ]);

        try {
            $customer->update($request->all());

            return redirect()
                ->route('ppic.customer')
                ->with('success', 'Customer berhasil diupdate');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal update customer');
        }
    }

    public function customerDelete($id)
    {
        $customer = Customer::findOrFail($id);
        try {
            $customer->delete();

            return redirect()
                ->route('ppic.customer')
                ->with('success', 'Customer berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal menghapus customer karena masih digunakan di KKPO');
            }
            return back()->with('error', 'Gagal menghapus customer');
        }
    }
    public function category()
    {
        $query = Category::query()->orderBy('name', 'asc');
        if (request()->filled('search')) {
            $search = request()->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->paginate(10)->withQueryString();
        return view('ppic.category-process', compact('categories'));
    }
    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            Category::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.category')
                ->with('success', 'Category Process berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama Category Process sudah digunakan');
            }
            return back()->with('error', 'Gagal menambahkan Category Process:' . $e->getMessage());
        }
    }
    public function categoryUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $category->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.category')
                ->with('success', 'Category Process berhasil diupdate');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal mengupdate Category Process');
        }
    }
    public function categoryDelete($id)
    {
        $category = Category::findOrFail($id);
        try {
            $category->delete();

            return redirect()
                ->route('ppic.category')
                ->with('success', 'Category Process berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal menghapus Category Process karena masih digunakan di KKPO');
            }
            return back()->with('error', 'Gagal menghapus Category Process');
        }
    }
    public function style()
    {
        $query = Style::query()->orderBy('name', 'asc');
        if (request()->filled('search')) {
            $search = request()->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $styles = $query->paginate(10)->withQueryString();
        return view('ppic.style', compact('styles'));
    }
    public function styleStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Style::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.style')
                ->with('success', 'Style berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama Style sudah digunakan');
            }
            return back()->with('error', 'Gagal menambahkan Style:' . $e->getMessage());
        }
    }
    public function styleUpdate(Request $request, $id)
    {
        $style = Style::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $style->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.style')
                ->with('success', 'Style berhasil diupdate');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal mengupdate Style');
        }
    }
    public function styleDelete($id)
    {
        $style = Style::findOrFail($id);
        try {
            $style->delete();

            return redirect()
                ->route('ppic.style')
                ->with('success', 'Style berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal menghapus Style karena masih digunakan di KKPO');
            }
            return back()->with('error', 'Gagal menghapus Style');
        }
    }
    public function color()
    {
        $query = Color::query()->orderBy('name', 'asc');
        if (request()->filled('search')) {
            $search = request()->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $colors = $query->paginate(10)->withQueryString();
        return view('ppic.color', compact('colors'));
    }
    public function colorStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Color::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.color')
                ->with('success', 'Color berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama Color sudah digunakan');
            }
            return back()->with('error', 'Gagal menambahkan Color:' . $e->getMessage());
        }
    }
    public function colorUpdate(Request $request, $id)
    {
        $color = Color::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $color->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.color')
                ->with('success', 'Color berhasil diupdate');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal mengupdate Color');
        }
    }
    public function colorDelete($id)
    {
        $color = Color::findOrFail($id);
        try {
            $color->delete();

            return redirect()
                ->route('ppic.color')
                ->with('success', 'Color berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal menghapus Color karena masih digunakan di KKPO');
            }
            return back()->with('error', 'Gagal menghapus Color');
        }
    }

    public function item()
    {
        $query = Item::query()->orderBy('name', 'asc');
        if (request()->filled('search')) {
            $search = request()->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $items = $query->paginate(10)->withQueryString();
        return view('ppic.item', compact('items'));
    }
    public function itemStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            Item::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.item')
                ->with('success', 'Item berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama Item sudah digunakan');
            }
            return back()->with('error', 'Gagal menambahkan Item:' . $e->getMessage());
        }
    }
    public function itemUpdate(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $item->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.item')
                ->with('success', 'Item berhasil diupdate');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal mengupdate Item');
        }
    }
    public function itemDelete($id)
    {
        $item = Item::findOrFail($id);
        try {
            $item->delete();

            return redirect()
                ->route('ppic.item')
                ->with('success', 'Item berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal menghapus Item karena masih digunakan di KKPO');
            }
            return back()->with('error', 'Gagal menghapus Item');
        }
    }
    public function brand()
    {
        $query = Brand::query()->orderBy('name', 'asc');
        if (request()->filled('search')) {
            $search = request()->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $brands = $query->paginate(10)->withQueryString();
        return view('ppic.brand', compact('brands'));
    }
    public function brandStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Brand::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.brand')
                ->with('success', 'Brand berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama Brand sudah digunakan');
            }
            return back()->with('error', 'Gagal menambahkan Brand:' . $e->getMessage());
        }
    }
    public function brandUpdate(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $brand->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.brand')
                ->with('success', 'Brand berhasil diupdate');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal mengupdate Brand');
        }
    }
    public function brandDelete($id)
    {
        $brand = Brand::findOrFail($id);
        try {
            $brand->delete();

            return redirect()
                ->route('ppic.brand')
                ->with('success', 'Brand berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal menghapus Brand karena masih digunakan di KKPO');
            }
            return back()->with('error', 'Gagal menghapus Brand');
        }
    }

    public function unit()
    {
        $query = Unit::query()->orderBy('name', 'asc');
        if (request()->filled('search')) {
            $search = request()->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $units = $query->paginate(10)->withQueryString();
        return view('ppic.unit', compact('units'));
    }
    public function unitStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            Unit::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.unit')
                ->with('success', 'Unit berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama unit sudah digunakan');
            }
            return back()->with('error', 'Gagal menambahkan Unit:' . $e->getMessage());
        }
    }
    public function unitUpdate(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $unit->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('ppic.unit')
                ->with('success', 'Unit berhasil diupdate');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal mengupdate Unit');
        }
    }
    public function unitDelete($id)
    {
        $unit = Unit::findOrFail($id);
        try {
            $unit->delete();

            return redirect()
                ->route('ppic.unit')
                ->with('success', 'Unit berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal menghapus Unit karena masih digunakan di KKPO');
            }
            return back()->with('error', 'Gagal menghapus Unit');
        }
    }

    public function currency()
    {
        $query = Currency::query()->orderBy('name', 'asc');
        if (request()->filled('search')) {
            $search = request()->search;

            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        $currencies = $query->paginate(10)->withQueryString();
        return view('ppic.currency', compact('currencies'));
    }
    public function currencyStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code',
        ]);

        try {
            Currency::create([
                'name' => $request->name,
                'code' => $request->code,
            ]);

            return redirect()
                ->route('ppic.currency')
                ->with('success', 'Currency berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Kode currency sudah digunakan');
            }
            return back()->with('error', 'Gagal menambahkan Currency:' . $e->getMessage());
        }
    }
    public function currencyUpdate(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
        ]);
        try {
            $currency->update([
                'name' => $request->name,
                'code' => $request->code,
            ]);

            return redirect()
                ->route('ppic.currency')
                ->with('success', 'Currency berhasil diupdate');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal mengupdate Currency');
        }
    }
    public function currencyDelete($id)
    {
        $currency = Currency::findOrFail($id);
        try {
            $currency->delete();

            return redirect()
                ->route('ppic.currency')
                ->with('success', 'Currency berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal menghapus Currency karena masih digunakan di KKPO');
            }
            return back()->with('error', 'Gagal menghapus Currency');
        }
    }

    public function kkpoManagement()
    {
        $query = KkpoManagement::with([
            'customer',
            'style',
            'color',
            'category',
            'item',
            'brand',
            'unit',
            'currency'
        ])->latest();

        // SEARCH
        if (request()->filled('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('no_kkpo', 'like', "%{$search}%")
                    ->orWhereHas('customer', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('style', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('color', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhere('kp_po', 'like', "%{$search}%")
                    ->orWhereHas('item', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('brand', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('unit', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('currency', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
            });
        }

        // FILTER
        if (request()->filled('customer')) {
            $query->where('customer_id', request('customer'));
        }
        if (request()->filled('category')) {
            $query->where('category_id', request('category'));
        }
        if (request()->filled('style')) {
            $query->where('style_id', request('style'));
        }
        if (request()->filled('color')) {
            $query->where('color_id', request('color'));
        }
        if (request()->filled('item')) {
            $query->where('item_id', request('item'));
        }
        if (request()->filled('brand')) {
            $query->where('brand_id', request('brand'));
        }

        if (request()->filled('date_from') && request()->filled('date_to')) {
            $query->whereBetween('tanggal', [request('date_from'), request('date_to')]);
        }

        $kkpomanagements = $query->paginate(10)->withQueryString();

        /*
    |--------------------------------------------------------------------------
    | FILTER DATA (HANYA YANG SUDAH ADA DI KKPO)
    |--------------------------------------------------------------------------
    */
        $base = clone $query;

        $filterCustomers = Customer::whereIn('id', $base->pluck('customer_id'))->get();
        $filterCategories = Category::whereIn('id', $base->pluck('category_id'))->get();
        $filterStyles = Style::whereIn('id', $base->pluck('style_id'))->get();
        $filterColors = Color::whereIn('id', $base->pluck('color_id'))->get();
        $filterItems = Item::whereIn('id', $base->pluck('item_id'))->get();
        $filterBrands = Brand::whereIn('id', $base->pluck('brand_id'))->get();

        /*
    |--------------------------------------------------------------------------
    | MODAL DATA (SEMUA MASTER DATA)
    |--------------------------------------------------------------------------
    */
        $customers = Customer::all();
        $categories = Category::all();
        $styles = Style::all();
        $colors = Color::all();
        $items = Item::all();
        $brands = Brand::all();
        $units = Unit::all();
        $currencies = Currency::all();

        return view('ppic.kkpomanagement', compact(
            'kkpomanagements',

            // filter
            'filterCustomers',
            'filterCategories',
            'filterStyles',
            'filterColors',
            'filterItems',
            'filterBrands',

            // modal
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
    public function kkpoManagementShow($id)
    {
        $kkpomanagement = KkpoManagement::with([
            'customer',
            'style',
            'color',
            'category',
            'item',
            'brand',
            'unit',
            'currency',
            'travelers',
            'suratJalan'
        ])->findOrFail($id);

        return view('ppic.detailkkpo', compact('kkpomanagement'));
    }
    public function kkpoManagementStore(Request $request)
    {
        $request->validate([
            'no_kkpo' => 'required|string|max:255',
            'customer_id' => 'required|exists:customers,id',
            'style_id' => 'required|exists:styles,id',
            'color_id' => 'required|exists:colors,id',
            'category_id' => 'required|exists:categories,id',
            'kp_po' => 'required|string|max:255',
            'qty_total' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'reject_allowance' => 'required|string',
            'item_id' => 'required|exists:items,id',
            'brand_id' => 'required|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'currency_id' => 'required|exists:currencies,id',
            'payment_terms' => 'nullable|integer',
            'notes' => 'nullable|string',
            'npwp' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'tanggal' => 'nullable|date',
        ]);

        try {

            KkpoManagement::create([
                'no_kkpo' => $request->no_kkpo,
                'customer_id' => $request->customer_id,
                'style_id' => $request->style_id,
                'color_id' => $request->color_id,
                'category_id' => $request->category_id,
                'kp_po' => $request->kp_po,
                'item_id' => $request->item_id,
                'brand_id' => $request->brand_id,
                'unit_id' => $request->unit_id,
                'qty_total' => $request->qty_total,
                'price' => $request->price,
                'reject_allowance' => $request->reject_allowance,
                'currency_id' => $request->currency_id,
                'payment_terms' => $request->payment_terms,
                'notes' => $request->notes,
                'npwp' => $request->npwp,
                'remark' => $request->remark,
                'tanggal' => $request->tanggal,
            ]);

            return redirect()
                ->route('ppic.kkpomanagement')
                ->with('success', 'KKPO berhasil ditambahkan');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan KKPO: ' . $e->getMessage());
        }
    }

    public function kkpoManagementUpdate(Request $request, $id)
    {
        $kkpomanagement = KkpoManagement::findOrFail($id);

        $request->validate([
            'no_kkpo' => 'required|exists:kkpo_managements,no_kkpo',
            'style_id' => 'required|exists:styles,id',
            'color_id' => 'required|exists:colors,id',
            'category_id' => 'required|exists:categories,id',
            'customer_id' => 'required|exists:customers,id',
            'kp_po' => 'required|string|max:255',
            'qty_total' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'reject_allowance' => 'required|string',
            'item_id' => 'required|exists:items,id',
            'brand_id' => 'required|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'currency_id' => 'required|exists:currencies,id',
            'payment_terms' => 'nullable|integer',
            'notes' => 'nullable|string',
            'npwp' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'tanggal' => 'nullable|date',
        ]);

        try {
            $kkpomanagement->update([
                'no_kkpo' => $request->no_kkpo,
                'customer_id' => $request->customer_id,
                'style_id' => $request->style_id,
                'color_id' => $request->color_id,
                'category_id' => $request->category_id,
                'kp_po' => $request->kp_po,
                'item_id' => $request->item_id,
                'brand_id' => $request->brand_id,
                'unit_id' => $request->unit_id,
                'qty_total' => $request->qty_total,
                'price' => $request->price,
                'reject_allowance' => $request->reject_allowance,
                'currency_id' => $request->currency_id,
                'payment_terms' => $request->payment_terms,
                'notes' => $request->notes,
                'npwp' => $request->npwp,
                'remark' => $request->remark,
                'tanggal' => $request->tanggal,
            ]);

            return redirect()
                ->route('ppic.kkpomanagement')
                ->with('success', 'KKPO berhasil diupdate');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal mengupdate KKPO');
        }
    }
    public function kkpoManagementDelete($id)
    {
        $kkpomanagement = KkpoManagement::findOrFail($id);
        try {
            $kkpomanagement->delete();

            return redirect()
                ->route('ppic.kkpomanagement')
                ->with('success', 'KKPO berhasil dihapus');
        } catch (QueryException $e) {

            return back()->with('error', 'Gagal menghapus KKPO');
        }
    }

    public function kkpoDetail($id)
    {
        $kkpo = KkpoManagement::with('customer', 'style', 'color', 'category')->findOrFail($id);
        return view('ppic.detailkkpo', compact('kkpo'));
    }
    public function monitoring(Request $request)
    {
        $query = KkpoManagement::with(['customer', 'style', 'color', 'category', 'suratJalan'])->latest();
        if (request()->filled('search')) {
            $search = request()->search;

            $query->whereHas('kkpoManagements', function ($q) use ($search) {
                $q->where('no_kkpo', 'like', "%{$search}%");
            })
                ->orWhere('no_surat_jalan', 'like', "%{$search}%")

                ->orWhereHas('kkpoManagements.customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('kkpoManagements.category', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('kkpoManagements.style', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('kkpoManagements.color', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }
        $monitoring = $query->paginate(10);
        return view('ppic.monitoring', compact('monitoring'));
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
            ->when($request->search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->whereHas('kkpoManagements', function ($k) use ($search) {
                        $k->where('no_kkpo', 'like', "%{$search}%");
                    })
                        ->orWhere('no_surat_jalan', 'like', "%{$search}%")
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

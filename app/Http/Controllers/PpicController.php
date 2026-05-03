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
    public function customerUpdate(Request $request, int $id)
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

    public function customerDelete(int $id)
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
    public function categoryUpdate(Request $request, int $id)
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
    public function categoryDelete(int $id)
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
    public function styleUpdate(Request $request, int $id)
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
    public function styleDelete(int $id)
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
    public function colorUpdate(Request $request, int $id)
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
    public function colorDelete(int $id)
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
    public function itemUpdate(Request $request, int $id)
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
    public function itemDelete(int $id)
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
    public function brandUpdate(Request $request, int $id)
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
    public function brandDelete(int $id)
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
    public function unitUpdate(Request $request, int $id)
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
    public function unitDelete(int $id)
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
    public function currencyUpdate(Request $request, int $id)
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
    public function currencyDelete(int $id)
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
        'styles',
        'colors',
        'categories',
        'items',
        'brands',
        'unit',
        'currency'
    ])->latest();

    // SEARCH
    if (request()->filled('search')) {
        $search = request('search');

        $query->where(function ($q) use ($search) {
            $q->where('no_kkpo', 'like', "%{$search}%")
                ->orWhere('kp_po', 'like', "%{$search}%")
                ->orWhereHas('customer', fn($q) => $q->where('name', 'like', "%{$search}%"))
                ->orWhereHas('categories', fn($q) => $q->where('name', 'like', "%{$search}%"))
                ->orWhereHas('styles', fn($q) => $q->where('name', 'like', "%{$search}%"))
                ->orWhereHas('colors', fn($q) => $q->where('name', 'like', "%{$search}%"))
                ->orWhereHas('items', fn($q) => $q->where('name', 'like', "%{$search}%"))
                ->orWhereHas('brands', fn($q) => $q->where('name', 'like', "%{$search}%"));
        });
    }

    // FILTER (pivot pakai whereHas)
    if (request('customer')) {
        $query->where('customer_id', request('customer'));
    }
    if (request('category')) {
        $query->whereHas('categories', fn($q) => $q->where('id', request('category')));
    }
    if (request('style')) {
        $query->whereHas('styles', fn($q) => $q->where('id', request('style')));
    }
    if (request('color')) {
        $query->whereHas('colors', fn($q) => $q->where('id', request('color')));
    }
    if (request('item')) {
        $query->whereHas('items', fn($q) => $q->where('id', request('item')));
    }
    if (request('brand')) {
        $query->whereHas('brands', fn($q) => $q->where('id', request('brand')));
    }

    $kkpomanagements = $query->paginate(10)->withQueryString();

    // FILTER DATA
    $filterCustomers = Customer::whereHas('kkpoManagements')->get();
    $filterCategories = Category::whereHas('kkpoManagements')->get();
    $filterStyles = Style::whereHas('kkpoManagements')->get();
    $filterColors = Color::whereHas('kkpoManagements')->get();
    $filterItems = Item::whereHas('kkpoManagements')->get();
    $filterBrands = Brand::whereHas('kkpoManagements')->get();

    // MODAL DATA
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
        'filterCustomers',
        'filterCategories',
        'filterStyles',
        'filterColors',
        'filterItems',
        'filterBrands',
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
    public function kkpoManagementShow(int $id)
    {
        $kkpomanagement = KkpoManagement::with([
            'customer',
            'styles',
            'colors',
            'categories',
            'items',
            'brands',
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

        'style_id' => 'required|array',
        'style_id.*' => 'exists:styles,id',

        'color_id' => 'required|array',
        'color_id.*' => 'exists:colors,id',

        'category_id' => 'required|array',
        'category_id.*' => 'exists:categories,id',

        'item_id' => 'required|array',
        'item_id.*' => 'exists:items,id',

        'brand_id' => 'required|array',
        'brand_id.*' => 'exists:brands,id',

        'kp_po' => 'required|string|max:255',
        'qty_total' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'reject_allowance' => 'required|string',

        'unit_id' => 'required|exists:units,id',
        'currency_id' => 'required|exists:currencies,id',
    ]);

    try {
        $kkpo = KkpoManagement::create([
            'no_kkpo' => $request->no_kkpo,
            'customer_id' => $request->customer_id,
            'kp_po' => $request->kp_po,
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

        // pivot sync
        $kkpo->styles()->sync($request->style_id);
        $kkpo->colors()->sync($request->color_id);
        $kkpo->categories()->sync($request->category_id);
        $kkpo->items()->sync($request->item_id);
        $kkpo->brands()->sync($request->brand_id);

        return redirect()->route('ppic.kkpomanagement')
            ->with('success', 'KKPO berhasil ditambahkan');

    } catch (\Exception $e) {
        return back()->withInput()->with('error', $e->getMessage());
    }
}

public function kkpoManagementUpdate(Request $request, int $id)
{
    $kkpo = KkpoManagement::findOrFail($id);

    $request->validate([
        'no_kkpo' => 'required|string|max:255',
        'customer_id' => 'required|exists:customers,id',

        'style_id' => 'required|array',
        'style_id.*' => 'exists:styles,id',

        'color_id' => 'required|array',
        'color_id.*' => 'exists:colors,id',

        'category_id' => 'required|array',
        'category_id.*' => 'exists:categories,id',

        'item_id' => 'required|array',
        'item_id.*' => 'exists:items,id',

        'brand_id' => 'required|array',
        'brand_id.*' => 'exists:brands,id',

        'kp_po' => 'required|string|max:255',
        'qty_total' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'reject_allowance' => 'required|string',

        'unit_id' => 'required|exists:units,id',
        'currency_id' => 'required|exists:currencies,id',
    ]);

    try {
        $kkpo->update([
            'no_kkpo' => $request->no_kkpo,
            'customer_id' => $request->customer_id,
            'kp_po' => $request->kp_po,
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

        // IMPORTANT: sync pivot
        $kkpo->styles()->sync($request->style_id);
        $kkpo->colors()->sync($request->color_id);
        $kkpo->categories()->sync($request->category_id);
        $kkpo->items()->sync($request->item_id);
        $kkpo->brands()->sync($request->brand_id);
        return redirect()->route('ppic.kkpomanagement')
            ->with('success', 'KKPO berhasil diupdate');

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

    public function kkpoManagementDelete(int $id)
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

    public function kkpoDetail(int $id)
    {
        $kkpo = KkpoManagement::with('customer', 'styles', 'colors', 'categories')->findOrFail($id);
        return view('ppic.detailkkpo', compact('kkpo'));
    }

    public function report(Request $request)
    {
        $suratJalan = SuratJalan::whereHas('travelers.movements')->select('no_surat_jalan')->distinct()->pluck('no_surat_jalan');
        $kkpo = KkpoManagement::whereHas('travelers.movements')->select('no_kkpo')->distinct()->pluck('no_kkpo');
        $customer = Customer::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $style = Style::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $category = Category::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $color = Color::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $item = Item::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $brand = Brand::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');

        $query = SuratJalan::with([
            'kkpoManagement',
            'kkpoManagement.customer',
            'kkpoManagement.categories',
            'kkpoManagement.styles',
            'kkpoManagement.colors',
            'kkpoManagement.items',
            'kkpoManagement.brands',
            'travelers.movements' // relasi ke traveler movements
        ])

        //search
            ->when($request->search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->whereHas('kkpoManagement', function ($k) use ($search) {
                        $k->where('no_kkpo', 'like', "%{$search}%");
                    })
                        ->orWhere('no_surat_jalan', 'like', "%{$search}%")
                        ->orWhereHas('kkpoManagement.customer', function ($c) use ($search) {
                            $c->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kkpoManagement.categories', function ($c) use ($search) {
                            $c->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kkpoManagement.styles', function ($s) use ($search) {
                            $s->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kkpoManagement.colors', function ($c) use ($search) {
                            $c->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kkpoManagement.items', function ($i) use ($search) {
                            $i->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kkpoManagement.brands', function ($b) use ($search) {
                            $b->where('name', 'like', "%{$search}%");
                        });
                });
            })

            // harusnya kkpo yg muncul hanya yg punya surat jalan out/sampai warehouse send, jadi filter berdasarkan surat jalan dulu baru filter kkpo, customer, style, category, color
            // filter berdasarkan pivot pakai whereHas
            ->when($request->kkpo, function ($q, $kkpo) {
                $q->whereHas('kkpoManagement', function ($k) use ($kkpo) {
                    $k->where('no_kkpo', $kkpo);
                });
            })

            ->when($request->no_surat_jalan, function ($q, $sj) {
                $q->where('no_surat_jalan', $sj);
            })

            ->when($request->customer, function ($q, $customer) {
                $q->whereHas('kkpoManagement.customer', function ($c) use ($customer) {
                    $c->where('id', $customer);
                });
            })

            ->when($request->style, function ($q, $style) {
                $q->whereHas('kkpoManagement.styles', function ($s) use ($style) {
                    $s->where('id', $style);
                });
            })

            ->when($request->category, function ($q, $category) {
                $q->whereHas('kkpoManagement.categories', function ($c) use ($category) {
                    $c->where('id', $category);
                });
            })

            ->when($request->color, function ($q, $color) {
                $q->whereHas('kkpoManagement.colors', function ($c) use ($color) {
                    $c->where('id', $color);
                });
            })

            ->when($request->item, function ($q, $item) {
                $q->whereHas('kkpoManagement.items', function ($i) use ($item) {
                    $i->where('id', $item);
                });
            })

            ->when($request->brand, function ($q, $brand) {
                $q->whereHas('kkpoManagement.brands', function ($b) use ($brand) {
                    $b->where('id', $brand);
                });
            });

        $data = $query->paginate(10);

        //filter data
        $filterSuratJalan = SuratJalan::whereHas('travelers.movements')->select('no_surat_jalan')->distinct()->pluck('no_surat_jalan');
        $filterKkpo = KkpoManagement::whereHas('travelers.movements')->select('no_kkpo')->distinct()->pluck('no_kkpo');
        $filterCustomer = Customer::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $filterStyle = Style::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $filterCategory = Category::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $filterColor = Color::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $filterItem = Item::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');
        $filterBrand = Brand::whereHas('kkpoManagements.travelers.movements')->select('name')->distinct()->pluck('name');

        

        return view('ppic.report', compact(
            'data',
            'filterSuratJalan',
            'filterKkpo',
            'filterCustomer',
            'filterStyle',
            'filterCategory',
            'filterColor',
            'filterItem',
            'filterBrand'
        ));
    }

    public function show(int $id)
    {
        $sj = SuratJalan::with([
            'kkpoManagement.customer',
            'kkpoManagement.categories',
            'kkpoManagement.styles',
            'kkpoManagement.colors',
            'kkpoManagement.items',
            'kkpoManagement.brands',
            'kkpoManagement.unit',
            'travelers.movements.currentDepartment'
        ])->findOrFail($id);

        return view('ppic.detailreport', compact('sj'));
    }
    public function exportReport(Request $request)
    {
        return Excel::download(
            new TravelerMovementExport($request->all()),
            'report-traveler.xlsx'
        );
    }

    public function travelerMonitoring(Request $request)
    {
        $movements = TravelerMovement::with([
            'traveler.suratJalan',
            'deptTujuan'
        ])
            ->orderBy('date_in')
            ->get();

        $data = $movements->groupBy('traveler_id')->map(function ($items) {

            $traveler = $items->first()->traveler;

            $row = [
                'traveler' => $traveler,
                'departments' => []
            ];

            // ambil movement terakhir
            $last = $items->sortByDesc('date_in')->first();
            $row['current_dept'] = optional($last->deptTujuan)->name;

            $totalIn = 0;
            $totalOut = 0;

            foreach ($items as $movement) {

                if (!$movement->deptTujuan) continue;

                $deptName = $movement->deptTujuan->name;

                if (!isset($row['departments'][$deptName])) {
                    $row['departments'][$deptName] = [
                        'tanggal' => $movement->date_in,
                        'qty_in' => 0,
                        'qty_out' => 0,
                    ];
                }

                $row['departments'][$deptName]['tanggal'] = $movement->date_in;
                $row['departments'][$deptName]['qty_in'] += $movement->qty_in ?? 0;
                $row['departments'][$deptName]['qty_out'] += $movement->qty_out ?? 0;

                $totalIn += $movement->qty_in ?? 0;
                $totalOut += $movement->qty_out ?? 0;
            }

            // WIP REAL (AMAN)
            $row['wip'] = max($totalIn - $totalOut, 0);

            // OPTIONAL: HILANGKAN YANG SUDAH SELESAI
            $row['is_finished'] = $row['wip'] == 0;

            return $row;
        })

            // kalau mau hide yg sudah selesai
            ->filter(function ($row) {
                return !$row['is_finished']; // hanya tampil yg masih WIP
            });

        return view('ppic.monitoring', compact('data'));
    }
}

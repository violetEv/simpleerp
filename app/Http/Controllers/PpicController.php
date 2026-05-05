<?php

namespace App\Http\Controllers;

use App\Exports\TravelerMovementExport;
use App\Imports\CustomerImport;
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
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class PpicController extends Controller
{
    public function dashboard()
    {
        $totalKKPOmonth = KkpoManagement::whereMonth('created_at', now()->month)->count();
        $totalColors = Color::count();
        $totalStyles = Style::count();
        $totalCategories = Category::count();
        $totalCustomers = Customer::count();
        $latestKKPO = KkpoManagement::latest()->take(5)->get();

        return view('ppic.dashboard', compact('totalKKPOmonth', 'totalColors', 'totalStyles', 'totalCategories', 'totalCustomers', 'latestKKPO'));
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
                ->with('success', 'Customer successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Customer name already exists');
            }
            return back()->with('error', 'Failed to add customer: ' . $e->getMessage());
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
                ->with('success', 'Customer successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update customer');
        }
    }

    public function customerDelete(int $id)
    {
        $customer = Customer::findOrFail($id);
        try {
            $customer->delete();

            return redirect()
                ->route('ppic.customer')
                ->with('success', 'Customer successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete customer because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete customer');
        }
    }

    public function import(Request $request)
    {
        $import = new CustomerImport();

        try {
            Excel::import($import, $request->file('file'));

            return back()->with(
                'success',
                "Import {$import->successRows} rows successfully."
            );
        } catch (ValidationException $e) {

            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
            }

            return back()->with('error', implode(' | ', $errorMessages));
        } catch (QueryException $e) {

            // CEK duplicate entry
            if ($e->getCode() == 23000) {
                return back()->with('error', 'Duplicate entry: ' . $e->errorInfo[2]);
            }

            return back()->with('error', 'Failed to import: ' . $e->getMessage());
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
                ->with('success', 'Category Process successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Category Process name already exists');
            }
            return back()->with('error', 'Failed to add Category Process: ' . $e->getMessage());
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
                ->with('success', 'Category Process successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Category Process');
        }
    }
    public function categoryDelete(int $id)
    {
        $category = Category::findOrFail($id);
        try {
            $category->delete();

            return redirect()
                ->route('ppic.category')
                ->with('success', 'Category Process successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Category Process because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Category Process');
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
                ->with('success', 'Style successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Style name already exists');
            }
            return back()->with('error', 'Failed to add Style: ' . $e->getMessage());
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
                ->with('success', 'Style successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Style');
        }
    }
    public function styleDelete(int $id)
    {
        $style = Style::findOrFail($id);
        try {
            $style->delete();

            return redirect()
                ->route('ppic.style')
                ->with('success', 'Style successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Style because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Style');
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
                ->with('success', 'Color successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Color name already exists');
            }
            return back()->with('error', 'Failed to add Color: ' . $e->getMessage());
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
                ->with('success', 'Color successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Color');
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
                return back()->with('error', 'Failed to delete Color because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Color');
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
                ->with('success', 'Item successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Item name already exists');
            }
            return back()->with('error', 'Failed to add Item: ' . $e->getMessage());
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
                ->with('success', 'Item successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Item');
        }
    }
    public function itemDelete(int $id)
    {
        $item = Item::findOrFail($id);
        try {
            $item->delete();

            return redirect()
                ->route('ppic.item')
                ->with('success', 'Item successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Item because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Item');
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
                ->with('success', 'Brand successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Brand name already exists');
            }
            return back()->with('error', 'Failed to add Brand: ' . $e->getMessage());
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
                ->with('success', 'Brand successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Brand');
        }
    }
    public function brandDelete(int $id)
    {
        $brand = Brand::findOrFail($id);
        try {
            $brand->delete();

            return redirect()
                ->route('ppic.brand')
                ->with('success', 'Brand successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Brand because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Brand');
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
                ->with('success', 'Unit successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Unit name already exists');
            }
            return back()->with('error', 'Failed to add Unit: ' . $e->getMessage());
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
                ->with('success', 'Unit successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Unit');
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
                return back()->with('error', 'Failed to delete Unit because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Unit');
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
                ->with('success', 'Currency successfully added');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Currency code already exists');
            }
            return back()->with('error', 'Failed to add Currency: ' . $e->getMessage());
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
                ->with('success', 'Currency successfully updated');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to update Currency');
        }
    }
    public function currencyDelete(int $id)
    {
        $currency = Currency::findOrFail($id);
        try {
            $currency->delete();

            return redirect()
                ->route('ppic.currency')
                ->with('success', 'Currency successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete Currency because it is still used in KKPO');
            }
            return back()->with('error', 'Failed to delete Currency');
        }
    }

    public function kkpoManagement()
    {
        $query = KkpoManagement::with([
            'customer',
            'details.category',
            'details.style',
            'details.color',
            'details.item',
            'details.brand',
            'details.unit',
            'details.currency',
        ])->latest();

        //  SEARCH
        if (request()->filled('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('no_kkpo', 'like', "%{$search}%")
                    ->orWhere('kp_po', 'like', "%{$search}%")
                    ->orWhereHas(
                        'customer',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'details.category',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'details.style',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'details.color',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'details.item',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'details.brand',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'details.unit',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'details.currency',
                        fn($q) =>
                        $q->where('name', 'like', "%{$search}%")
                    );
            });
        }

        // FILTER
        if (request('customer')) {
            $query->where('customer_id', request('customer'));
        }

        if (request('category')) {
            $query->whereHas(
                'details',
                fn($q) =>
                $q->where('category_id', request('category'))
            );
        }

        if (request('style')) {
            $query->whereHas(
                'details',
                fn($q) =>
                $q->where('style_id', request('style'))
            );
        }

        if (request('color')) {
            $query->whereHas(
                'details',
                fn($q) =>
                $q->where('color_id', request('color'))
            );
        }

        if (request('item')) {
            $query->whereHas(
                'details',
                fn($q) =>
                $q->where('item_id', request('item'))
            );
        }

        if (request('brand')) {
            $query->whereHas(
                'details',
                fn($q) =>
                $q->where('brand_id', request('brand'))
            );
        }
        if (request('unit')) {
            $query->whereHas(
                'details',
                fn($q) =>
                $q->where('unit_id', request('unit'))
            );
        }
        if (request('currency')) {
            $query->whereHas(
                'details',
                fn($q) =>
                $q->where('currency_id', request('currency'))
            );
        }

        $kkpomanagements = $query->paginate(10)->withQueryString();

        //  FILTER OPTIONS (HARUS DARI DETAIL SEKARANG)
        $filterCustomers = Customer::has('kkpoManagements')->get();
        $filterCategories = Category::has('details')->get();
        $filterStyles = Style::has('details')->get();
        $filterColors = Color::has('details')->get();
        $filterItems = Item::has('details')->get();
        $filterBrands = Brand::has('details')->get();
        $filterUnits = Unit::has('details')->get();
        $filterCurrencies = Currency::has('details')->get();


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
    public function kkpoManagementShow(int $id)
    {
        $kkpomanagement = KkpoManagement::with([
            'customer',
            'details.currency',
            'details.category',
            'details.style',
            'details.color',
            'details.item',
            'details.brand',
            'details.unit',
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
        'kp_po' => 'nullable|string|max:255',
        'payment_terms' => 'required|string|max:255',
        'notes' => 'nullable|string|max:255',
        'npwp' => 'required|string|max:255',
        'tanggal' => 'required|date',

        'details' => 'required|array|min:1',

        'details.*.category_id' => 'required|exists:categories,id',
        'details.*.style_id' => 'required|exists:styles,id',
        'details.*.color_id' => 'required|exists:colors,id',
        'details.*.item_id' => 'required|exists:items,id',
        'details.*.brand_id' => 'required|exists:brands,id',
        'details.*.qty' => 'required|numeric|min:0',
        'details.*.price' => 'required|numeric|min:0',
        'details.*.reject_allowance' => 'required|numeric|min:0',
        'details.*.unit_id' => 'required|exists:units,id',
    ]);

    DB::beginTransaction();

    try {

        // CEK: KKPO sama tapi customer beda
        $conflict = KkpoManagement::where('no_kkpo', $request->no_kkpo)
            ->where('customer_id', '!=', $request->customer_id)
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->with('error', 'KKPO sudah digunakan oleh customer lain!');
        }

        // AMBIL HEADER (kalau sudah ada untuk customer yg sama)
        $kkpo = KkpoManagement::where('no_kkpo', $request->no_kkpo)
            ->where('customer_id', $request->customer_id)
            ->first();

        //  KALAU BELUM ADA → CREATE HEADER
        if (!$kkpo) {
            $kkpo = KkpoManagement::create([
                'no_kkpo' => $request->no_kkpo,
                'customer_id' => $request->customer_id,
                'kp_po' => $request->kp_po,
                'payment_terms' => $request->payment_terms,
                'notes' => $request->notes,
                'npwp' => $request->npwp,
                'tanggal' => $request->tanggal,
            ]);
        }

        // INSERT DETAIL (boleh berkali-kali)
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
                'currency_id' => $detail['currency_id'] ?? null,
                'reject_allowance' => $detail['reject_allowance'],
            ]);
        }

        DB::commit();

        return redirect()->route('ppic.kkpomanagement')
            ->with('success', 'KKPO berhasil ditambahkan');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', 'Error: ' . $e->getMessage());
    }
}

    public function kkpoManagementUpdate(Request $request, int $id)
    {
        $kkpo = KkpoManagement::findOrFail($id);

        $request->validate([
            'no_kkpo' => 'required|string|max:255',
            'customer_id' => 'required|exists:customers,id',
            'kp_po' => 'nullable|string|max:255',
            'payment_terms' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'details' => 'required|array|min:1',

            'details.*.qty' => 'required|numeric|min:0',
            'details.*.unit_id' => 'required|exists:units,id',
        ]);

        DB::beginTransaction();

        try {

            $kkpo->update([
                'no_kkpo' => $request->no_kkpo,
                'customer_id' => $request->customer_id,
                'kp_po' => $request->kp_po,
                'payment_terms' => $request->payment_terms,
                'notes' => $request->notes,
                'npwp' => $request->npwp,
                'tanggal' => $request->tanggal,
            ]);

            // DELETE OLD DETAIL
            $kkpo->details()->delete();

            // INSERT NEW DETAIL
            foreach ($request->details as $detail) {
                $kkpo->details()->create([
                    'category_id' => $detail['category_id'] ?? null,
                    'style_id' => $detail['style_id'] ?? null,
                    'color_id' => $detail['color_id'] ?? null,
                    'item_id' => $detail['item_id'] ?? null,
                    'brand_id' => $detail['brand_id'] ?? null,
                    'qty' => $detail['qty'],
                    'unit_id' => $detail['unit_id'],
                    'price' => $detail['price'] ?? 0,
                    'remark' => $detail['remark'] ?? null,
                    'currency_id' => $detail['currency_id'] ?? null,
                    'reject_allowance' => $detail['reject_allowance'] ?? 0,
                ]);
            }

            DB::commit();

            return redirect()->route('ppic.kkpomanagement')
                ->with('success', 'KKPO successfully updated');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function kkpoManagementDelete(int $id)
    {
        $kkpo = KkpoManagement::findOrFail($id);
        try {
            $kkpo->delete();

            return redirect()->route('ppic.kkpomanagement')
                ->with('success', 'KKPO successfully deleted');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Failed to delete KKPO because it is still used in Surat Jalan');
            }
            return back()->with('error', 'Failed to delete KKPO: ' . $e->getMessage());
        }
    }
    public function getKkpoInfo(Request $request)
    {
        $kkpo = KkpoManagement::where('no_kkpo', $request->no_kkpo)->first();

        if ($kkpo) {
            return response()->json([
                'exists' => true,
                'customer_id' => $kkpo->customer_id,
            ]);
        }

        return response()->json(['exists' => false]);
    }

    public function kkpoDetail(int $id)
    {
        $kkpo = KkpoManagement::with('customer', 'styles', 'colors', 'categories')->findOrFail($id);
        return view('ppic.detailkkpo', compact('kkpo'));
    }

    public function report(Request $request)
    {
        $query = SuratJalan::with([
            'kkpoManagement.customer',
            'kkpoManagement.categories',
            'kkpoManagement.styles',
            'kkpoManagement.colors',
            'travelers.movements'
        ])

            //  WAJIB: hanya yg sudah ada SJ OUT (status send)
            ->whereHas('travelers.movements', function ($q) {
                $q->where('status', 'send');
            })

            //  SEARCH
            ->when($request->search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->whereHas('kkpoManagement', function ($k) use ($search) {
                        $k->where('no_kkpo', 'like', "%{$search}%");
                    })
                        ->orWhere('no_surat_jalan', 'like', "%{$search}%")
                        ->orWhereHas('kkpoManagement.customer', function ($c) use ($search) {
                            $c->where('name', 'like', "%{$search}%");
                        });
                });
            })

            //  FILTER ID BASED (FIX SEMUA)
            ->when($request->kkpo, function ($q, $kkpo) {
                $q->whereHas('kkpoManagement', fn($k) => $k->where('no_kkpo', $kkpo));
            })

            ->when($request->no_surat_jalan, function ($q, $sj) {
                $q->where('id', $sj);
            })

            ->when($request->customer, function ($q, $customer) {
                $q->whereHas('kkpoManagement.customer', fn($c) => $c->where('id', $customer));
            })

            ->when($request->style, function ($q, $style) {
                $q->whereHas('kkpoManagement.styles', fn($s) => $s->where('id', $style));
            })

            ->when($request->category, function ($q, $category) {
                $q->whereHas('kkpoManagement.categories', fn($c) => $c->where('id', $category));
            })

            ->when($request->color, function ($q, $color) {
                $q->whereHas('kkpoManagement.colors', fn($c) => $c->where('id', $color));
            });

        $data = $query->paginate(10)->withQueryString();

        // FILTER DATA (HARUS ADA ID + NAME)
        $filterSuratJalan = SuratJalan::select('id', 'no_surat_jalan')->get();

        $filterKkpo = KkpoManagement::select('no_kkpo')->distinct()->pluck('no_kkpo');

        $filterCustomer = Customer::select('id', 'name')->get();
        $filterStyle = Style::select('id', 'name')->get();
        $filterCategory = Category::select('id', 'name')->get();
        $filterColor = Color::select('id', 'name')->get();

        return view('ppic.report', compact(
            'data',
            'filterSuratJalan',
            'filterKkpo',
            'filterCustomer',
            'filterStyle',
            'filterCategory',
            'filterColor'
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

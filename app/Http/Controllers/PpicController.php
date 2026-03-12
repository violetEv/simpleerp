<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryProcess;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Kkpo;
use App\Models\Style;
use Illuminate\Http\Request;

class PpicController extends Controller
{
    public function dashboard()
    {
        $totalKKPO = Kkpo::count();
        $totalColors = Color::count();
        $totalSizes = Style::count();
        $totalMaterials = Category::count();

        return view('ppic.dashboard', compact('totalKKPO', 'totalColors', 'totalSizes', 'totalMaterials'));
    }
    public function customer(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('ppic.customer', compact('customers'));
    }
    public function customerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Customer::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('ppic.customer')
            ->with('success', 'Customer berhasil ditambahkan');
    }
    public function customerUpdate(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $customer->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('ppic.customer')
            ->with('success', 'Customer berhasil diupdate');
    }

    public function customerDelete($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()
            ->route('ppic.customer')
            ->with('success', 'Customer berhasil dihapus');
    }
    public function category()
    {
        $query = Category::query();
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

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('ppic.category')
            ->with('success', 'Category Process berhasil ditambahkan');
    }
    public function categoryUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('ppic.category')
            ->with('success', 'Category Process berhasil diupdate');
    }
    public function categoryDelete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()
            ->route('ppic.category')
            ->with('success', 'Category Process berhasil dihapus');
    }
    public function style()
    {
        $query = Style::query();
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

        Style::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('ppic.style')
            ->with('success', 'Style berhasil ditambahkan');
    }
    public function styleUpdate(Request $request, $id)
    {
        $style = Style::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $style->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('ppic.style')
            ->with('success', 'Style berhasil diupdate');
    }
    public function styleDelete($id)
    {
        $style = Style::findOrFail($id);
        $style->delete();

        return redirect()
            ->route('ppic.style')
            ->with('success', 'Category Process berhasil dihapus');
    }
    public function color()
    {
        $query = Color::query();
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

        Color::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('ppic.color')
            ->with('success', 'Color berhasil ditambahkan');
    }
    public function colorUpdate(Request $request, $id)
    {
        $color = Color::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $color->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('ppic.color')
            ->with('success', 'Color berhasil diupdate');
    }
    public function colorDelete($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return redirect()
            ->route('ppic.color')
            ->with('success', 'Color berhasil dihapus');
    }
    public function kkpo()
    {
        $query = Kkpo::with('customer', 'style', 'color', 'category', 'travelers');

        if (request()->filled('search')) {
            $search = request()->search;

            $query->where('no_kkpo', 'like', "%{$search}%")
                ->orWhereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('style', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('color', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $kkpos = $query->paginate(10)->withQueryString();
        return view('ppic.kkpo', compact('kkpos'));
    }

    public function kkpoStore(Request $request)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'no_kkpo' => 'required|string|max:255|unique:kkpos,no_kkpo',
            'style_id' => 'required|exists:styles,id',
            'color_id' => 'required|exists:colors,id',
            'category_id' => 'required|exists:categories,id',
            'customer_id' => 'required|exists:customers,id',
            'qty_total' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'reject_allowance' => 'required|string'
        ]);

        // Simpan data KKPO ke database
        Kkpo::create([
            'no_kkpo' => $request->no_kkpo,
            'style_id' => $request->style_id,
            'color_id' => $request->color_id,
            'category_id' => $request->category_id,
            'customer_id' => $request->customer_id,
            'qty_total' => $request->qty_total,
            'price' => $request->price,
            'reject_allowance' => $request->reject_allowance
        ]);

        return redirect()
            ->route('ppic.kkpo')
            ->with('success', 'KKPO berhasil ditambahkan');
    }

    public function kkpoUpdate(Request $request, $id)
    {
        $kkpo = Kkpo::findOrFail($id);

        // Validasi input jika diperlukan
        $request->validate([
            'no_kkpo' => 'required|string|max:255|unique:kkpos,no_kkpo,' . $kkpo->id,
            'style_id' => 'required|exists:styles,id',
            'color_id' => 'required|exists:colors,id',
            'category_id' => 'required|exists:categories,id',
            'customer_id' => 'required|exists:customers,id',
            'qty_total' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'reject_allowance' => 'required|string'
        ]);

        // Update data KKPO di database
        $kkpo->update([
            'no_kkpo' => $request->no_kkpo,
            'style_id' => $request->style_id,
            'color_id' => $request->color_id,
            'category_id' => $request->category_id,
            'customer_id' => $request->customer_id,
            'qty_total' => $request->qty_total,
            'price' => $request->price,
            'reject_allowance' => $request->reject_allowance
        ]);

        return redirect()
            ->route('ppic.kkpo')
            ->with('success', 'KKPO berhasil diupdate');
    }
    public function kkpoDelete($id)
    {
        $kkpo = Kkpo::findOrFail($id);
        $kkpo->delete();

        return redirect()
            ->route('ppic.kkpo')
            ->with('success', 'KKPO berhasil dihapus');
    }
    public function monitoring()
    {
        return view('ppic.monitoring');
    }
}

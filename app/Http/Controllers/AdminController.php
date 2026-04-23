<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Departments;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDepartments = Departments::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();

        return view('superadmin.dashboard', compact('totalUsers', 'totalDepartments', 'activeUsers', 'inactiveUsers'));
    }

    public function users(Request $request)
    {
        $query = User::with('department');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('department', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $users = $query->paginate(10)->withQueryString();

        return view('superadmin.users', compact('users'));
    }

    public function storeUser(StoreUserRequest $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'department_id' => $request->department_id ?? null,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('superadmin.users')
                ->with('success', 'User berhasil ditambahkan');
        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Email sudah digunakan');
            }

            return back()->with('error', 'Gagal menambahkan user');
        }
    }

    function delete($id)
    {
        $user = User::findOrFail($id);
        try {
            $user->delete();

            return redirect()
                ->route('superadmin.users')
                ->with('success', 'User berhasil dihapus');
        } catch (QueryException $e) {
            return redirect()
                ->route('superadmin.users')
                ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

       try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'department_id' => $request->department_id ?? null,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('superadmin.users')
                ->with('success', 'User berhasil diperbarui');
        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Email sudah digunakan');
            }

            return back()->with('error', 'Gagal memperbarui user');
        }
    }

    public function departments(Request $request)
    {
        //department urut nama A-Z
        $query = Departments::query()->orderBy('name', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('name', 'like', "%{$search}%");
        }

        $departments = $query->paginate(10)->withQueryString();

        return view('superadmin.departments', compact('departments'));
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            Departments::create([
                'name' => $request->name
            ]);

            return redirect()
                ->route('superadmin.departments')
                ->with('success', 'Department berhasil ditambahkan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama department sudah digunakan');
            }

            return back()->with('error', 'Gagal menambahkan department');
        }
    }

    public function updateDepartment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $department = Departments::findOrFail($id);
        try {
            $department->update([
                'name' => $request->name
            ]);

            return redirect()
                ->route('superadmin.departments')
                ->with('success', 'Department berhasil diperbarui');
        } catch (QueryException $e) {
            // if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Nama department sudah digunakan');
            // }

            // return back()->with('error', 'Gagal memperbarui department');
        }
    }
    public function deleteDepartment($id)
    {
        $department = Departments::findOrFail($id);
        // $department->name = request('name');
        try {
            $department->delete();

            return redirect()
                ->route('superadmin.departments')
                ->with('success', 'Department berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Department tidak dapat dihapus karena masih digunakan');
            }

            return back()->with('error', 'Gagal menghapus department');
        }

        return redirect()->route('superadmin.departments')->with('success', 'Department berhasil dihapus');
    }

    public function monitoring()
    {
        return view('superadmin.monitoring');
    }
}

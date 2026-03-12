<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Departments;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
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

    // public function searchUsers(Request $request)
    // {
    //     $query = User::with('department');

    //     if ($request->has('search')) {
    //         $search = $request->input('search');
    //         $query->where(function ($q) use ($search) {
    //             $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
    //         });
    //     }

    //     $users = $query->paginate(10);
    //     return view('superadmin.users', compact('users'));
    // }

    public function storeUser(StoreUserRequest $request)
    {
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
    }

    function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('superadmin.users')->with('success', 'User deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'department_id' => 'nullable',
            'status' => 'required',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function departments(Request $request)
    {
        $query = Departments::query();

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

        $slug = Str::slug($request->name);
        $count = Departments::where('slug', 'like', "{$slug}%")->count();

        if ($count) {
            $slug = "{$slug}-" . ($count + 1);
        }

        Departments::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('superadmin.departments')
            ->with('success', 'Department created successfully');
    }

    public function updateDepartment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $department = Departments::findOrFail($id);
        $department->update([
            'name' => $request->name
        ]);

        return redirect()->route('superadmin.departments')
            ->with('success', 'Department updated successfully');
    }
    public function deleteDepartment($id)
    {
        $department = Departments::findOrFail($id);
        // $department->name = request('name');
        $department->delete();

        return redirect()->route('superadmin.departments')->with('success', 'Department deleted successfully.');
    }

    public function monitoring()
    {
        return view('superadmin.monitoring');
    }
}

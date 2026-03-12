@section('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create User
    </h2>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Create User Form -->
                    <form action="{{ route('superadmin.users.create') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                            <input type="text" id="name" name="name"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" id="email" name="email"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-gray-700 font-medium mb-2">Role</label>
                            <select id="role" name="role"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="">Select Role</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="manager">Manager</option>
                                <option value="ppic">PPIC</option>
                                <option value="produksi">Produksi</option>
                                <option value="warehouse">Warehouse</option>
                            </select>
                        </div>

                        {{-- Department --}}
                        <div class="mb-4">
                            <label for="department_id" class="block text-gray-700 font-medium mb-2">Department</label>
                            <select id="department_id" name="department_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Department</option>
                                @foreach (App\Models\Departments::all() as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach 
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                            <input type="password" id="password" name="password"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        All Users
    </h2>

    @if (session('success'))
        <div class="mt-4">
            <x-alerts variant="success" title="Success" :message="session('success')" :showLink="false" />
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto">

            {{-- Search --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('superadmin.users') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search users..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>

                <button onclick="openAddModal()" class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    Add User
                </button>
            </div>

            {{-- ================= MODAL (ADD & EDIT) ================= --}}
            <div id="crud-modal" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">

                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modalTitle" class="text-lg font-semibold">Add User</h3>
                        <button type="button" onclick="closeModal('crud-modal')"
                            class="text-gray-500 text-2xl hover:text-gray-700">&times;</button>
                    </div>

                    <form id="userForm" action="{{ route('superadmin.users.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">

                        <div class="grid grid-cols-2 gap-4">

                            {{-- Name --}}
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" class="block mt-1 w-full" required />
                            </div>

                            {{-- Email --}}
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" type="email" name="email" class="block mt-1 w-full"
                                    required />
                            </div>

                            {{-- Role --}}
                            <div>
                                <x-input-label for="role" :value="__('Role')" />
                                <select id="role" name="role"
                                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Select Role</option>
                                    <option value="super_admin">Super Admin</option>
                                    <option value="produksi">Produksi</option>
                                    <option value="warehouse">Warehouse</option>
                                    <option value="ppic">PPIC</option>
                                </select>
                            </div>

                            {{-- Department --}}
                            <div id="department-div" style="display: none;">
                                <x-input-label for="department_id" :value="__('Department')" />
                                <select id="department_id" name="department_id"
                                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Select Department</option>
                                    @foreach (App\Models\Departments::all() as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Password --}}
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" type="password" name="password" class="block mt-1 w-full"
                                    required />
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                    class="block mt-1 w-full" required />
                            </div>

                            {{-- Status --}}
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status"
                                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-6">
                            <button type="submit" id="submitButton"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Add User
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- ================= TABLE ================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($users->count())
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4">{{ $user->name }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">{{ $user->role }}</td>
                                        <td class="px-6 py-4">{{ $user->department?->name }}</td>
                                        <td class="px-6 py-4">{{ $user->status }}</td>
                                        <td class="px-6 py-4 flex gap-3">

                                            <button
                                                onclick="editUser(
                                    '{{ $user->id }}',
                                    '{{ $user->name }}',
                                    '{{ $user->email }}',
                                    '{{ $user->role }}',
                                    '{{ $user->department_id }}',
                                    '{{ $user->status }}'
                                )"
                                                class="text-blue-600 hover:text-blue-900">
                                                Edit
                                            </button>

                                            <form action="{{ route('superadmin.users.delete', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-500">
                                        No users found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= SCRIPT ================= --}}
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('flex');
            document.getElementById(id).classList.add('hidden');
        }

        function openAddModal() {
            document.getElementById('modalTitle').innerText = "Add User";
            document.getElementById('submitButton').innerText = "Add User";
            document.getElementById('submitButton').classList.remove('bg-blue-600');
            document.getElementById('submitButton').classList.add('bg-green-600');

            document.getElementById('userForm').action = "{{ route('superadmin.users.store') }}";
            document.getElementById('formMethod').value = "POST";

            document.getElementById('userForm').reset();

            document.getElementById('password').required = true;
            document.getElementById('password_confirmation').required = true;

            // openModal('crud-modal');
            document.getElementById('crud-modal').classList.remove('hidden');
            document.getElementById('crud-modal').classList.add('flex');
        }

        function editUser(id, name, email, role, department_id, status) {
            document.getElementById('modalTitle').innerText = "Edit User";
            document.getElementById('submitButton').innerText = "Update User";
            document.getElementById('submitButton').classList.remove('bg-green-600');
            document.getElementById('submitButton').classList.add('bg-blue-600');

            document.getElementById('userForm').action =
                "{{ route('superadmin.users.update', ':id') }}".replace(':id', id);
            document.getElementById('formMethod').value = "PUT";

            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
            document.getElementById('role').value = role;
            document.getElementById('department_id').value = department_id ?? '';

            document.getElementById('password').required = false;
            document.getElementById('password_confirmation').required = false;

            document.getElementById('status').value = status;

            toggleDepartment();
            openModal('crud-modal');
        }

        document.getElementById('role').addEventListener('change', toggleDepartment);

        function toggleDepartment() {
            const role = document.getElementById('role').value;
            const deptDiv = document.getElementById('department-div');

            if (role === 'produksi') {
                deptDiv.style.display = 'block';
            } else {
                deptDiv.style.display = 'none';
                document.getElementById('department_id').value = '';
            }
        }
    </script>
@endsection

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
            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                <table class="min-w-full divide-y divide-gray-200">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">
                                    No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">
                                    Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">
                                    Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">
                                    Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"">
                                    Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($users->count())
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $user->name }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">{{ $user->role }}</td>
                                        <td class="px-6 py-4">{{ $user->department->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            @if ($user->status == 'active')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
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
                                                class="text-blue-600 hover:text-blue-900" title="Edit User"> 
                                                {{-- Edit icon outline --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 .375a48 48 0 013.75 0m-3.75 0a48 48 0 00-3.75 0" />
                                                </svg>
                                                
                                            </button>

                                            <form action="{{ route('superadmin.users.delete', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus User"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                    {{-- Delete icon outline --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v .916m7 .001a3 .3"
                                                            />
                                                    </svg>
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
                {{-- </div> --}}
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

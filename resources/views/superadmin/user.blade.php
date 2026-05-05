<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        All Users
    </h2> --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto">

            {{-- Search --}}
            <div class="bg-white shadow-sm rounded-lg mb-3 border border-gray-100 p-3">

                <div class="flex flex-wrap items-center justify-between gap-2">

                    {{-- LEFT GROUP --}}
                    <form action="{{ route('superadmin.user') }}" method="GET" class="flex items-center gap-2">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search user..."
                                class="h-9 pl-9 pr-3 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50] w-52">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="m21 21-4.35-4.35m1.85-5.65a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                            </svg>
                        </div>
                    </form>

                    {{-- RIGHT GROUP --}}
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-md p-1">

                        {{-- ADD --}}
                        <button onClick="openAddModal()"
                            class="h-8 px-3 text-xs rounded bg-[#0f4f50] text-white hover:bg-[#136566] flex items-center gap-1 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add User
                        </button>

                    </div>

                </div>

            </div>

            {{-- ================= MODAL (ADD & EDIT) ================= --}}
            <div id="crud-modal"
                class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">

                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modalTitle" class="text-lg font-semibold">Add User</h3>
                        <button type="button" onclick="closeModal('crud-modal')"
                            class="text-gray-500 text-2xl hover:text-gray-700">&times;</button>
                    </div>

                    <form id="userForm" action="{{ route('superadmin.user.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <input type="hidden" name="user_id" id="user_id">

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
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
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
                                Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- ================= TABLE ================= --}}
            <div
                class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-visible">

                <table class="min-w-full table-fixed text-gray-800">

                    {{-- THEAD --}}
                    <thead
                        class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">
                        <tr>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">
                                Name</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">
                                Email</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">
                                Role</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">
                                Department</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @if ($users->count())
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">{{ $user->role }}</td>
                                    <td class="px-4 py-2">{{ $user->department->name ?? '-' }}</td>
                                    <td class="px-4 py-2">
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
                                    <td class="px-4 py-3">
                                        <div class="inline-block text-left relative" x-data="{ menu: false }">

                                            <button @click="menu = !menu" class="text-gray-400 hover:text-gray-600">
                                                <svg class="h-5 w-5 pointer-events-none" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </button>

                                            {{-- DROPDOWN --}}
                                            <div x-show="menu" @click.outside="menu = false" x-transition x-cloak
                                                class="absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">

                                                {{-- <button
                                                    onclick="window.location='{{ route('superadmin.user.show', $user->id) }}'"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                                                    Detail
                                                </button> --}}

                                                <button type="button"
                                                    onclick='openEditModal(@json($user->id), @json($user->name), @json($user->email), @json($user->role), @json($user->department_id), @json($user->status))'
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                                                    Edit
                                                </button>

                                                <form action="{{ route('superadmin.user.delete', $user->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">
                                    No users found.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="p-3">
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
            // document.getElementById('submitButton').innerText = "Add User";
            document.getElementById('submitButton').classList.remove('bg-blue-600');
            document.getElementById('submitButton').classList.add('bg-green-600');

            document.getElementById('userForm').action = "{{ route('superadmin.user.store') }}";
            document.getElementById('formMethod').value = "POST";

            document.getElementById('userForm').reset();

            document.getElementById('password').required = true;
            document.getElementById('password_confirmation').required = true;

            // openModal('crud-modal');
            document.getElementById('crud-modal').classList.remove('hidden');
            document.getElementById('crud-modal').classList.add('flex');
        }

        function openEditModal(id, name, email, role, department_id, status) {
            document.getElementById('modalTitle').innerText = "Edit User";
            // document.getElementById('submitButton').innerText = "Update User";
            document.getElementById('submitButton').classList.remove('bg-green-600');
            document.getElementById('submitButton').classList.add('bg-blue-600');

            let url = "{{ route('superadmin.user.update', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('userForm').action = url;
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
            const deptSelect = document.getElementById('department_id');

            if (role === 'produksi') {
                deptDiv.style.display = 'block';
                deptSelect.required = true;
            } else {
                deptDiv.style.display = 'none';
                deptSelect.required = false;
                deptSelect.value = '';
            }
        }
    </script>
</x-app-layout>

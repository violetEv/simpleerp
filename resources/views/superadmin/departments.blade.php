@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Departments
    </h2>

    @if (session('success'))
        <div class="mt-4">
            <x-alerts variant="success" :message="session('success')" />
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto">

            {{-- Search --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('superadmin.departments') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search departments..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
                <button onClick="openAddModal()" class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    Add Department
                </button>
            </div>

            {{-- Modal Add & Edit Department --}}
            <div id="crud-modal" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">

                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-xl font-semibold">Add Department</h3>
                        <button type="button" onClick="closeModal()"
                            class="text-gray-500 text-2xl hover:text-gray-700">&times;</button>
                    </div>

                    <form id="crud-form" action="{{ route('superadmin.departments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="department_id" id="department_id">

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Department Name</label>
                            <input type="text" name="name" id="name" required
                                class="w-full border mt-1 border-gray-300 rounded px-3 py-2
                        focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <button type="submit" id="submit-button"
                            class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                            Add Department
                        </button>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Department Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($departments->count())
                            @foreach ($departments as $department)
                                <tr>
                                    <td class="px-6 py-4">{{ $department->name }}</td>
                                    <td class="px-6 py-4">
                                        <button onClick="openEditModal({{ $department->id }}, '{{ $department->name }}')"
                                            class="text-blue-600 hover:text-blue-900" title="Edit Department">
                                            {{-- Edit icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 .375a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
                                            </svg>
                                        </button>

                                        <form action="{{ route('superadmin.departments.delete', $department->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this department?')"
                                                class="text-red-600 hover:text-red-900" title="Hapus Department">
                                                {{-- Delete icon --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v .916m7 .001v8a2.25 2.25 0 01-2.25" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2" class="text-center py-4 text-gray-500">
                                    No departments found
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $departments->links() }}
                </div>
                {{-- </div> --}}
            </div>

        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('modal-title').textContent = 'Add Department';
            document.getElementById('submit-button').textContent = 'Add Department';
            document.getElementById('crud-form').action =
                "{{ route('superadmin.departments.store') }}";

            document.getElementById('form-method').value = "POST";

            document.getElementById('department_id').value = '';
            document.getElementById('name').value = '';

            document.getElementById('crud-modal').classList.remove('hidden');
            document.getElementById('crud-modal').classList.add('flex');
        }

        function openEditModal(id, name) {
            document.getElementById('modal-title').textContent = 'Edit Department';
            document.getElementById('submit-button').textContent = 'Update Department';

            document.getElementById('crud-form').action =
                "{{ route('superadmin.departments.update', ':id') }}"
                .replace(':id', id);

            document.getElementById('form-method').value = "PUT";

            document.getElementById('department_id').value = id;
            document.getElementById('name').value = name;

            document.getElementById('crud-modal').classList.remove('hidden');
            document.getElementById('crud-modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('crud-modal').classList.add('hidden');
            document.getElementById('crud-modal').classList.remove('flex');
        }
    </script>
@endsection

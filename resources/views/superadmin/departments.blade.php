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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">

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
                                            <button
                                                onClick="openEditModal({{ $department->id }}, '{{ $department->name }}')"
                                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                                Edit
                                            </button>

                                            <form action="{{ route('superadmin.departments.delete', $department->id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this department?')"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                                    Delete
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
                    <div class="mt-4 p-4">
                        {{ $departments->links() }}
                    </div>
                </div>
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

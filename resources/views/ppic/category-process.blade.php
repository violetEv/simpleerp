@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Category Process
    </h2>
    @if (session('success'))
        <div class="mt-4">
            <x-alerts variant="success" :message="session('success')" />
        </div>
    @endif
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- Search & Add Category Process Modal --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('ppic.category') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search category processes..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
                <button onClick="openAddModal()" class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    Add Category Process
                </button>
            </div>
            {{-- Category Process Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th> --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($categories->count())
                                @foreach ($categories as $categoryProcess)
                                    <tr>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $categoryProcess->id }}</td> --}}
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $categoryProcess->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button
                                                onClick="openEditModal({{ $categoryProcess->id }}, '{{ $categoryProcess->name }}')"
                                                class="text-blue-500 hover:text-blue-700 mr-2">Edit</button>
                                            <form action="{{ route('ppic.category.delete', $categoryProcess->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengapus category process ini?')"
                                                    class="text-red-500 hover:text-red-700">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-gray-500">
                                        No category processes found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-4 p-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add & Edit Category Process --}}
    <div id="addModal" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modal-title" class="text-xl font-semibold">Add Category Process</h3>
                <button type="button" onClick="closeModal()"
                    class="text-gray-500 text-2xl hover:text-gray-700">&times;</button>
            </div>
            <form id="crud-form" action="{{ route('ppic.category.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="category_id" id="category_id">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Category Process Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full border mt-1 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" id="submit-button"
                    class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                    Add Category Process
                </button>
            </form>
        </div>
    </div>
    <script>
        function closeModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function openAddModal() {
            document.getElementById('modal-title').textContent = 'Add Category Process';
            document.getElementById('submit-button').textContent = 'Add Category Process';
            document.getElementById('crud-form').action = "{{ route('ppic.category.store') }}";

            document.getElementById('form-method').value = 'POST';
            document.getElementById('category_id').value = '';
            document.getElementById('name').value = '';
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }
        openEditModal = (id, name) => {
            document.getElementById('modal-title').textContent = 'Edit Category Process';
            document.getElementById('submit-button').textContent = 'Update Category Process';
            document.getElementById('crud-form').action = '{{ route('ppic.category.update', ':id') }}/'.replace(':id',
                id);

            document.getElementById('form-method').value = 'PUT';

            document.getElementById('category_id').value = id;
            document.getElementById('name').value = name;

            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }
    </script>
@endsection

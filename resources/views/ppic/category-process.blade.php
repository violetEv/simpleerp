<x-app-layout>
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
                    + Tambah Category Process
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
                                                class="mr-2" title="Edit">
                                                <svg class="w-6 h-6 text-blue-500 hover:text-blue-700" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('ppic.category.delete', $categoryProcess->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengapus category process ini?')">
                                                    <svg
                                                        class="w-6 h-6 text-red-500 hover:text-red-700"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                    </svg></button>
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
            let url = "{{ route('ppic.category.update', ':id') }}";
url = url.replace(':id', id);

            document.getElementById('crud-form').action = url;

            document.getElementById('form-method').value = 'PUT';

            document.getElementById('category_id').value = id;
            document.getElementById('name').value = name;

            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }
    </script>
</x-app-layout>

<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Color
    </h2> --}}

    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- Search & Add Color Modal --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('ppic.color') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search Color..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>

                <button onClick="openAddModal()"
                    class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Add Color
                </button>
            </div>
            {{-- Color Table --}}
            <div class="bg-white overflow-hidden shadow rounded-lg p-2">
                {{-- <div class="p-4 bg-white border-b border-gray-200"> --}}

                    <table class="min-w-full table-fixed text-gray-800">
                        <thead class="bg-gray-50 text-gray-700 uppercase tracking wider">
                            <tr>
                                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th> --}}
                                <th
                                    class="px-4 py-2 text-left text-xs font-semibold">
                                    Color Name</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-semibold">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @if ($colors->count())
                                @foreach ($colors as $color)
                                    <tr>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $color->id }}</td> --}}
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $color->name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <button onClick="editColor({{ $color->id }}, '{{ $color->name }}')"
                                                class="mr-2" title="Edit">
                                                <svg class="w-6 h-6 text-blue-500 hover:text-blue-700"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                </svg></button>
                                            <form action="{{ route('ppic.color.delete', $color->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete {{ $color->name }}?')">
                                                    <svg class="w-6 h-6 text-red-500 hover:text-red-700"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="px-4 py-2 whitespace-nowrap text-center text-gray-500">
                                        Color not found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="p-3">
                        {{ $colors->links() }}
                    </div>
                {{-- </div> --}}
            </div>
            {{-- Modal Add & Edit Color --}}
            <div id="addModal"
                class="hidden fixed inset-0 bg-gray-600  bg-opacity-50 items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-medium">Add Color</h3>
                        <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                    <form id="crud-form" action="{{ route('ppic.color.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="color_id" id="color_id">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Color Name</label>
                            <input type="text" name="name" id="name" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                        </div>
                        <button type="submit" 
                            class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex')
            document.getElementById('modal-title').textContent = 'Add Color';
            // document.getElementById('submit-button').textContent = 'Add Color';
            document.getElementById('crud-form').action = "{{ route('ppic.color.store') }}";
            document.getElementById('form-method').value = 'POST';
            document.getElementById('color_id').value = '';
            document.getElementById('name').value = '';
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex')
        }

        function editColor(id, name) {
            openAddModal();
            document.getElementById('modal-title').textContent = 'Edit Color';
            // document.getElementById('submit-button').textContent = 'Update Color';
            let url = "{{ route('ppic.color.update', ':id') }}";
            url = url.replace(':id', id);

            document.getElementById('crud-form').action = url;
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('color_id').value = id;
            document.getElementById('name').value = name;
        }
    </script>
</x-app-layout>

<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Item
    </h2> --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
            {{-- SEARCH & ADD ITEM --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('ppic.item') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search item..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
                <button onClick="openAddModal()"
                    class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Add Item
                </button>
            </div>
            {{-- ITEM TABLE --}}
            <div class="bg-white shadow overflow-hidden p-2 rounded-lg">

                <table class="min-w-full table-fixed text-gray-800">
                    <thead class="bg-gray-50 text-gray-700 uppercase tracking wider">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold">
                                Item Name</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @if ($items->count())
                            @foreach ($items as $item)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <button onClick="editItem({{ $item->id }}, '{{ $item->name }}')"
                                            class="mr-2" title="Edit">
                                            <svg class="w-6 h-6 text-blue-500 hover:text-blue-700" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('ppic.item.delete', $item->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete {{ $item->name }}?')"
                                                class="text-red-500 hover:text-red-700" title="Delete">
                                                {{-- <svg class="w-6 h-6" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg> --}}
                                                <svg class="w-6 h-6 text-red-500 hover:text-red-700" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
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
                                <td colspan="2" class="px-4 py-2 text-gray-500 whitespace-nowrap text-center">Item not found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{-- ITEM MODAL --}}
            <div id="item-modal"
                class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-medium">Add Item</h3>
                        <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                    <form id="item-form" method="POST" action="{{ route('ppic.item.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Item Name</label>
                            <input type="text" name="name" id="name"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openAddModal() {
            document.getElementById('item-modal').classList.remove('hidden');
            document.getElementById('item-modal').classList.add('flex');
            document.getElementById('modal-title').textContent = 'Tambah Jenis Barang';
            document.getElementById('form-method').value = 'POST';
            document.getElementById('item-form').action = "{{ route('ppic.item.store') }}";
            document.getElementById('name').value = '';
        }

        function closeAddModal() {
            document.getElementById('item-modal').classList.add('hidden');
            document.getElementById('item-modal').classList.remove('flex');
        }

        function editItem(id, name) {
            document.getElementById('item-modal').classList.remove('hidden');
            document.getElementById('item-modal').classList.add('flex');
            document.getElementById('modal-title').textContent = 'Edit Jenis Barang';
            document.getElementById('form-method').value = 'PUT';
            let url = "{{ route('ppic.item.update', ':id') }}";
            url = url.replace(':id', id);

            document.getElementById('item-form').action = url;
            document.getElementById('name').value = name;
        }
    </script>
</x-app-layout>

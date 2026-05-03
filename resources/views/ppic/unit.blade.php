<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Satuan
    </h2> --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:ppic.satuan />
                </div>
            </div> --}}
            {{-- SEARCH & ADD SATUAN --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('ppic.unit') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search unit..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
                <button onClick="openAddModal()"
                    class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Add Unit
                </button>
            </div>
            {{-- SATUAN TABLE --}}
            <div class="bg-white overflow-hidden shadow rounded-lg p-2">
                {{-- <div class="p-4 bg-white border-b border-gray-200"> --}}
                    <table class="min-w-full table-fixed text-gray-800">
                        <thead class="bg-gray-50 text-gray-700 uppercase tracking wider">
                            <tr>
                                <th
                                    class="px-4 py-2 text-left text-xs font-semibold">
                                    Unit Name</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-semibold">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @if ($units->count())
                                @foreach ($units as $unit)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $unit->name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <button onClick="editUnit({{ $unit->id }}, '{{ $unit->name }}')"
                                                class="mr-2" title="Edit">
                                                <svg class="w-6 h-6 text-blue-500 hover:text-blue-700"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('ppic.unit.delete', $unit->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete {{ $unit->name }}?')" title="Delete">
                                                    <svg class="w-6 h-6 text-red-500 hover:text-red-700"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="px-4 py-2 whitespace-nowrap text-center text-gray-500">
                                        Unit not found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="p-3">
                        {{ $units->links() }}
                    </div>

                {{-- </div> --}}
            </div>
            {{-- MODAL ADD & EDIT UNIT --}}
            <div id="unitModal"
                class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-medium">Add Unit</h3>
                        <button onClick="closeModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                    <form id="unitForm" method="POST" action="{{ route('ppic.unit.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="unitMethod" value="POST">
                        <input type="hidden" name="unit_id" id="unitId">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Unit Name</label>
                            <input type="text" name="name" id="unitName"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                            Save
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openAddModal() {
            document.getElementById('unitModal').classList.remove('hidden');
            document.getElementById('unitModal').classList.add('flex');
            document.getElementById('modal-title').textContent = 'Add Unit';
            document.getElementById('unitForm').action = "{{ route('ppic.unit.store') }}";
            document.getElementById('unitMethod').value = 'POST';
            document.getElementById('unitId').value = '';
            document.getElementById('unitName').value = '';
        }

        function closeModal() {
            document.getElementById('unitModal').classList.add('hidden');
            document.getElementById('unitModal').classList.remove('flex');
        }

        function editUnit(id, name) {
            openAddModal();
            document.getElementById('modal-title').textContent = 'Edit Unit';
            let url = "{{ route('ppic.unit.update', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('unitForm').action = url;
            document.getElementById('unitMethod').value = 'PUT';
            document.getElementById('unitId').value = id;
            document.getElementById('unitName').value = name;
        }
    </script>
</x-app-layout>

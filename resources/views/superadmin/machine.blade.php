<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Mesin
    </h2> --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto">

            {{-- Search --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('superadmin.machine') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari mesin..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Cari
                    </button>
                </form>
                <button onClick="openAddModal()" class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Tambah Mesin
                </button>
            </div>

            {{-- Modal Add & Edit Mesin --}}
            <div id="crud-modal" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">

                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-xl font-semibold">Tambah Mesin</h3>
                        <button type="button" onClick="closeModal()"
                            class="text-gray-500 text-2xl hover:text-gray-700">&times;</button>
                    </div>

                    <form id="crud-form" action="{{ route('superadmin.machine.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="machine_id" id="machine_id">

                        {{-- pilih departemen washing atau dyeing untuk nama mesin --}}
                        <div class="mb-4">
                            <label for="department" class="block text-gray-700">Departemen</label>
                            <select name="department_id" id="department_id" required
                                class="w-full border mt-1 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Departemen</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Nama Mesin</label>
                            <input type="text" name="name" id="name" required
                                class="w-full border mt-1 border-gray-300 rounded px-3 py-2  focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <button type="submit" id="submit-button"
                            class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                            Tambah Mesin
                        </button>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                <table class="min-w-full table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Nama Mesin
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Departemen
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @if ($machines->count())
                            @foreach ($machines as $machine)
                                <tr>
                                    <td class="px-4 py-2">{{ $machine->name }}</td>
                                    <td class="px-4 py-2">{{ $machine->department->name ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        <button onClick="openEditModal({{ $machine->id }}, '{{ $machine->name }}', '{{ $machine->department_id }}')"
                                            class="text-blue-600 hover:text-blue-900" title="Edit Mesin">
                                            {{-- Edit icon --}}
                                            <svg class="w-6 h-6 text-blue-500 hover:text-blue-700"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                </svg>
                                        </button>

                                        <form action="{{ route('superadmin.machine.delete', $machine->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Apa Anda yakin ingin menghapus mesin {{ $machine->name }}?')"
                                                class="text-red-600 hover:text-red-900" title="Hapus Mesin">
                                                {{-- Delete icon --}}
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
                                <td colspan="2" class="text-center py-4 text-gray-500">
                                    Mesin tidak ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="p-3">
                    {{ $machines->links() }}
                </div>
                {{-- </div> --}}
            </div>

        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('modal-title').textContent = 'Tambah Mesin';
            document.getElementById('submit-button').textContent = 'Tambah Mesin';
            document.getElementById('crud-form').action =
                "{{ route('superadmin.machine.store') }}";

            document.getElementById('form-method').value = "POST";

            document.getElementById('machine_id').value = '';
            document.getElementById('name').value = '';
            // document.getElementById('department_id').value = '';

            document.getElementById('crud-modal').classList.remove('hidden');
            document.getElementById('crud-modal').classList.add('flex');
        }

        function openEditModal(id, name, department_id) {
            document.getElementById('modal-title').textContent = 'Edit Mesin';
            document.getElementById('submit-button').textContent = 'Update Mesin';
            let url = "{{ route('superadmin.machine.update', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('crud-form').action = url;

            document.getElementById('form-method').value = "PUT";

            document.getElementById('machine_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('department_id').value = department_id;

            document.getElementById('crud-modal').classList.remove('hidden');
            document.getElementById('crud-modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('crud-modal').classList.add('hidden');
            document.getElementById('crud-modal').classList.remove('flex');
        }
    </script>
</x-app-layout>

<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Brand
    </h2> --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:ppic.brand />
                </div>
            </div> --}}
            {{-- SEARCH & ADD BRAND --}}
            <div class="bg-white shadow-sm rounded-lg mb-3 border border-gray-100 p-3">

                <div class="flex flex-wrap items-center justify-between gap-2">

                    {{-- LEFT GROUP --}}
                    <form action="{{ route('ppic.brand') }}" method="GET" class="flex items-center gap-2">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search brand..."
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
                            Add Brand
                        </button>

                    </div>

                </div>

            </div>
            {{-- BRAND TABLE --}}
            <div
                class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-visible">

                <table class="min-w-full table-fixed text-gray-800">

                    {{-- THEAD --}}
                    <thead
                        class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">
                        <tr>
                            {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th> --}}
                            <th class="px-4 py-2 text-left text-xs font-semibold">
                                Brand Name</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @if ($brands->count())
                            @foreach ($brands as $brand)
                                <tr>
                                    {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $brand->id }}</td> --}}
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $brand->name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <button onClick="editBrand({{ $brand->id }}, '{{ $brand->name }}')"
                                            class="mr-2" title="Edit">
                                            <svg class="w-6 h-6 text-blue-500 hover:text-blue-700" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('ppic.brand.delete', $brand->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $brand->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus">
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
                                <td colspan="2" class="px-4 py-2 whitespace-nowrap text-center text-gray-500">
                                    Brand not found.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="flex items-center justify-between p-3">
                    <div class="text-sm text-gray-500">
                        Showing {{ $brands->firstItem() }} to {{ $brands->lastItem() }} of
                        {{ $brands->total() }} results
                    </div>

                    {{ $brands->links() }}
                </div>
                {{-- <livewire:ppic.brand /> --}}
            </div>
        </div>
        {{-- MODAL ADD & EDIT BRAND --}}
        <div id="addModal" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">

            <div class="bg-white rounded-xl p-5 w-full max-w-md shadow-lg">

                {{-- HEADER --}}
                <div class="flex items-center justify-between mb-4 border-b pb-2">
                    <h3 id="modal-title" class="text-lg font-semibold text-gray-800">
                        Add Brand
                    </h3>

                    <button onClick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                        &times;
                    </button>
                </div>

                {{-- FORM --}}
                <form id="brandForm" method="POST" action="{{ route('ppic.brand.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="brandMethod" value="POST">
                    <input type="hidden" name="brand_id" id="brandId">

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 mb-1">
                            Brand Name
                        </label>

                        <input type="text" name="name" id="name"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm
                    focus:outline-none focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50]"
                            required>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex justify-between gap-2 mt-5">

                        <button type="button" onClick="closeAddModal()"
                            class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-600 hover:bg-gray-100 w-1/2">
                            Cancel
                        </button>

                        <button type="submit"
                            class="px-4 py-2 text-sm rounded-md bg-[#136566] text-white hover:bg-[#0f4f50] w-1/2">
                            Save
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
    </div>
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
            document.getElementById('modal-title').textContent = 'Add Brand';
            // document.getElementById('submit-button').textContent = 'Tambah Merek';
            document.getElementById('brandForm').action = "{{ route('ppic.brand.store') }}";
            document.getElementById('brandMethod').value = 'POST';
            document.getElementById('brandId').value = '';
            document.getElementById('name').value = '';
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function editBrand(id, name) {
            openAddModal();
            document.getElementById('modal-title').textContent = 'Edit Brand';
            // document.getElementById('submit-button').textContent = 'Update Merek';
            let url = "{{ route('ppic.brand.update', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('brandForm').action = url;
            document.getElementById('brandMethod').value = 'PUT';
            document.getElementById('brandId').value = id;
            document.getElementById('name').value = name;
        }
    </script>
</x-app-layout>

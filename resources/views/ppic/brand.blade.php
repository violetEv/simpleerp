<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Brand
    </h2>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:ppic.brand />
                </div>
            </div> --}}
            {{-- SEARCH & ADD BRAND --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('ppic.brand') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search brands..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
                <button onClick="openAddModal()"
                    class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Tambah Brand
                </button>
            </div>
            {{-- BRAND TABLE --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead>
                            <tr>
                                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th> --}}
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($brands->count())
                                @foreach ($brands as $brand)
                                    <tr>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $brand->id }}</td> --}}
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $brand->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button onClick="editBrand({{ $brand->id }}, '{{ $brand->name }}')"
                                                class="mr-2" title="Edit">
                                                <svg class="w-6 h-6 text-blue-500 hover:text-blue-700"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('ppic.brand.delete', $brand->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this brand?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Delete">
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
                                    <td colspan="2" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Brand tidak ditemukan.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        {{-- <livewire:ppic.brand /> --}}
                </div>
            </div>
            {{-- MODAL ADD & EDIT BRAND --}}
            <div id="addModal" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-medium">Tambah Brand</h3>
                        <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                    <form id="brandForm" method="POST" action="{{ route('ppic.brand.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-medium mb-2">Nama Brand</label>
                            <input type="text" name="name" id="name" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#136566]">
                        </div>
                        <button type="submit" id="submit-button"
                            class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                            Tambah Brand
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
            document.getElementById('modal-title').textContent = 'Tambah Brand';
            document.getElementById('submit-button').textContent = 'Tambah Brand';
            document.getElementById('brandForm').action = "{{ route('ppic.brand.store') }}";
            document.getElementById('name').value = '';
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function editBrand(id, name) {
            openAddModal();
            document.getElementById('modal-title').textContent = 'Edit Brand';
            document.getElementById('submit-button').textContent = 'Update Brand';
            let url = "{{ route('ppic.brand.update', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('brandForm').action = url;
            document.getElementById('name').value = name;
        }
    </script>
</x-app-layout>

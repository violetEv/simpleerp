<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Customer
    </h2>
    @if (session('success'))
        <div class="mt-4">
            <x-alerts variant="success" title="Success" :message="session('success')" :showLink="false" />
        </div>
    @elseif (session('error'))
        <div class="mt-4">
            <x-alerts variant="danger" title="Error" :message="session('error')" :showLink="false" />
        </div>
    @endif
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- Search & Add Customer Modal --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('ppic.customer') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search customers..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>

                <button onClick="openAddModal()"
                    class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Tambah Customer
                </button>
            </div>
            {{-- Customer Table --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID</th> --}}
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Alamat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Telepon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama PIC</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($customers->count())
                                @foreach ($customers as $customer)
                                    <tr>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $customer->id }}</td> --}}
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->address ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->phone ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->attention ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button onClick="editCustomer({{ $customer->id }}, '{{ $customer->name }}', '{{ $customer->address }}', '{{ $customer->phone }}', '{{ $customer->attention }}')"
                                                title="Edit" class="mr-2">
                                                {{-- Edit icon outline --}}
                                                <svg class="w-6 h-6 text-blue-500 hover:text-blue-700"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                </svg>

                                            </button>
                                            <form action="{{ route('ppic.customer.delete', $customer->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengapus customer ini?')">
                                                    {{-- Delete icon outline --}}
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
                                        Customer tidak ditemukan.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-4 p-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
            {{-- Modal Add & Edit Customer --}}
            <div id="addModal" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-medium">Tambah Customer</h3>
                        <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                    <form id="crud-form" action="{{ route('ppic.customer.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="customer_id" id="customer_id">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Nama Customer</label>
                            <input type="text" name="name" id="name" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label for="address" class="block text-gray-700">Alamat</label>
                            <input type="text" name="address" id="address"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700">Telepon</label>
                            <input type="text" name="phone" id="phone"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label for="attention" class="block text-gray-700">Nama PIC</label>
                            <input type="text" name="attention" id="attention"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                        </div>
                        <button type="submit" id="submit-button"
                            class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                            Tambah Customer
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function openAddModal() {
            document.getElementById('modal-title').textContent = 'Tambah Customer';
            document.getElementById('submit-button').textContent = 'Tambah Customer';
            document.getElementById('crud-form').action = "{{ route('ppic.customer.store') }}";

            document.getElementById('form-method').value = 'POST';

            document.getElementById('customer_id').value = '';
            document.getElementById('name').value = '';
            document.getElementById('address').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('attention').value = '';


            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }

        function editCustomer(id, name, address, phone, attention) {
            document.getElementById('modal-title').textContent = 'Edit Customer';
            document.getElementById('submit-button').textContent = 'Update Customer';
            let url = "{{ route('ppic.customer.update', ':id') }}";
            url = url.replace(':id', id);

            document.getElementById('crud-form').action = url;
            // document.getElementById('crud-form').action = "{{ route('ppic.customer.update', ':id') }}/".replace(':id', id);

            document.getElementById('form-method').value = 'PUT';

            document.getElementById('customer_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('address').value = address;
            document.getElementById('phone').value = phone;
            document.getElementById('attention').value = attention;


            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }
    </script>
</x-app-layout>

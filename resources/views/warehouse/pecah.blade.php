@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Pecah Traveler
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

            {{-- SEARCH --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('warehouse.pecah') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search surat jalan..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">

                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                No Surat Jalan
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Customer
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Last Qty
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Status
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($pecahTravelers->count())
                            @foreach ($pecahTravelers as $pecahTraveler)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $pecahTraveler->no_surat_jalan }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $pecahTraveler->kkpo->customer->name ?? '-' }}
                                    </td>

                                    @php
                                        $sisaQty = $pecahTraveler->qty - ($pecahTraveler->travelers->sum('qty') ?? 0);
                                    @endphp

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $sisaQty }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $pecahTraveler->status ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($sisaQty <= 0)
                                            <button disabled
                                                class="px-2 py-1 bg-gray-400 text-white rounded-lg cursor-not-allowed">
                                                Pecah Traveler
                                            </button>
                                        @else
                                            <button onClick="openSplitTraveler({{ $pecahTraveler->id }})"
                                                class="px-2 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                                Pecah Traveler
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Nomor Surat Jalan Tidak Ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>

                </table>

                {{-- Pagination --}}
                <div class="px-6 py-4">
                    {{ $pecahTravelers->links() }}
                </div>
            </div>

        </div>

        {{-- Modal Pecah Traveler --}}
        <div id="addModal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">
            <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh] ">

                <div class="flex justify-between items-center mb-4">
                    <h3 id="modalTitle" class="text-lg font-medium">Pecah Traveler</h3>

                    <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                        &times;
                    </button>
                </div>

                <form id="pecahTravelerForm" method="POST" action="{{ route('warehouse.pecah.store') }}">

                    @csrf

                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <input type="hidden" name="parent_traveler_id" id="parent_traveler_id">

                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-700">
                            Surat Jalan
                        </label>

                        <input type="text" id="surat_jalan_display" readonly
                            class="mt-1 block w-full border border-gray-300 rounded-md bg-gray-100">

                        <input type="hidden" name="surat_jalan_id" id="surat_jalan_id">

                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Qty Awal
                            </label>

                            <input type="number" name="qty_awal" id="qty_awal" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md bg-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Qty Sisa
                            </label>

                            <input type="number" name="qty_sisa" id="qty_sisa" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md bg-gray-100">
                        </div>
                    </div>

                    <table class="w-full mb-4">
                        <thead>
                            <tr>
                                <th class="text-left text-sm font-medium text-gray-700">No Traveler</th>
                                <th class="text-left text-sm font-medium text-gray-700">Qty Split</th>
                                <th class="text-center text-sm font-medium text-gray-700">Departemen Tujuan</th>
                                <th class="text-center text-sm font-medium text-gray-700 w-10"></th>
                            </tr>
                        </thead>

                        <tbody id="travelerBody">

                            <tr>
                                <td>
                                    <input type="text" name="no_traveler[]" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md">
                                </td>

                                <td>
                                    <input type="number" name="qty_split[]" required min="0"
                                        class="mt-1 block w-full border border-gray-300 rounded-md qty-input"
                                        oninput="calculateTotal()">
                                </td>

                                <td>
                                    <select name="dept_tujuan_id[]" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md">

                                        <option value="">Select Departemen</option>

                                        @foreach (App\Models\Departments::all() as $departemen)
                                            <option value="{{ $departemen->id }}">
                                                {{ $departemen->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </td>

                                <td class="text-center">
                                    <button type="button" class="text-green-600 text-xl font-bold" onclick="addTableRow()">
                                        +
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Tanggal Pecah
                        </label>

                        <input type="date" name="tanggal" id="tanggal" required
                            class="mt-1 block w-full border border-gray-300 rounded-md">
                    </div>

                    {{-- <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Departemen Tujuan
                        </label>

                        <select name="dept_tujuan_id" id="dept_tujuan_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md">

                            <option value="">Select Departemen</option>

                            @foreach (App\Models\Departments::all() as $departemen)
                                <option value="{{ $departemen->id }}">
                                    {{ $departemen->name }}
                                </option>
                            @endforeach

                        </select>

                    </div> --}}

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Notes
                        </label>

                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                            Simpan Traveler
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        const pecahTravelerData = @json($pecahTravelers->items());

        function openSplitTraveler(id) {

            const selectedTraveler = pecahTravelerData.find(item => item.id == id);

            if (selectedTraveler) {

                document.getElementById('addModal').classList.remove('hidden');
                document.getElementById('addModal').classList.add('flex');

                document.getElementById('pecahTravelerForm').reset();

                document.getElementById('modalTitle').textContent =
                    'Pecah Traveler - ' + selectedTraveler.no_surat_jalan;

                document.getElementById('surat_jalan_display').value =
                    selectedTraveler.no_surat_jalan;

                document.getElementById('surat_jalan_id').value =
                    selectedTraveler.id;

                document.getElementById('qty_awal').value = selectedTraveler.qty;
                document.getElementById('qty_sisa').value = selectedTraveler.qty;

                calculateTotal();
            }
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function calculateTotal() {

            let qtyAwal = parseInt(document.getElementById('qty_awal').value) || 0;
            let totalSplit = 0;

            document.querySelectorAll('.qty-input').forEach(input => {
                totalSplit += parseInt(input.value) || 0;
            });

            if (totalSplit > qtyAwal) {
                alert('Total Qty Split tidak boleh lebih dari Qty Awal');
                return;
            }

            document.getElementById('qty_sisa').value = qtyAwal - totalSplit;
        }

        function addTableRow() {

            const tbody = document.getElementById('travelerBody');

            const row = document.createElement('tr');

            row.innerHTML = `
        <td>
            <input type="text" name="no_traveler[]" 
            class="mt-1 block w-full border border-gray-300 rounded-md">
        </td>

        <td>
            <input type="number" name="qty_split[]" 
            class="mt-1 block w-full border border-gray-300 rounded-md qty-input"
            oninput="calculateTotal()">
        </td>

        <td>
            <select name="dept_tujuan_id[]" required
                class="mt-1 block w-full border border-gray-300 rounded-md">

                <option value="">Select Departemen</option>

                @foreach (App\Models\Departments::all() as $departemen)
                    <option value="{{ $departemen->id }}">
                        {{ $departemen->name }}
                    </option>
                @endforeach

            </select>
        </td>

        <td class="text-center">
            <button type="button"
            class="text-red-600 text-xl font-bold"
            onclick="removeRow(this)">
            -
            </button>
        </td>
    `;

            tbody.appendChild(row);
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
            calculateTotal();
        }
    </script>
@endsection

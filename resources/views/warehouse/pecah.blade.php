{{-- @extends('layouts.app')

@section('content') --}}
<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Split Traveler
    </h2> --}}
    {{-- deskripsi halaman --}}
    <p class="text-sm text-gray-500 mb-4">
        Halaman ini digunakan untuk membuat traveler dari surat jalan yang sudah ada. Pastikan untuk mengisi data dengan benar karena data yang sudah diinput tidak dapat diubah.
    </p>
    <div class="py-4">
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
            {{-- <div class="bg-white shadow rounded-lg p-6"> --}}
            {{-- TAB NAVIGATION --}}
            <div id="tab-content-baru">

                <div class="bg-white shadow p-2 rounded-lg overflow-hidden">
                    <table class="min-w-full table-fixed">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    No Surat Jalan
                                </th>

                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    Customer
                                </th>

                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    Style
                                </th>

                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    Qty Awal
                                </th>

                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    Qty Sisa
                                </th>

                                {{-- <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    Status
                                </th> --}}

                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($pecahTravelers->count())
                                @foreach ($pecahTravelers as $pecahTraveler)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $pecahTraveler->no_surat_jalan }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $pecahTraveler->kkpoManagement->customer->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $pecahTraveler->kkpoManagement->styles->first()->name ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $pecahTraveler->qty }}
                                        </td>

                                        @php
                                            $sisaQty = $pecahTraveler->qty - $pecahTraveler->travelers->sum('qty');
                                        @endphp

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sisaQty }}
                                        </td>

                                        {{-- <td class="px-4 py-2 whitespace-nowrap">
                                            @if ($sisaQty <= 0)
                                                <span
                                                    class="px-2 bg-red-100 text-red-800 rounded-full text-xs leading-5 font-semibold inline-flex">
                                                    Closed
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Open
                                                </span>
                                            @endif --}}
                                        {{-- {{ $pecahTraveler->status ?? '-' }} --}}
                                        {{-- </td> --}}
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            @if ($sisaQty <= 0)
                                                <button disabled
                                                    class="px-2 py-1 bg-gray-400 text-white rounded-lg cursor-not-allowed">
                                                    {{-- ikon cut dengan text "split traveler" disamping icon --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m7.848 8.25 1.536.887M7.848 8.25a3 3 0 1 1-5.196-3 3 3 0 0 1 5.196 3Zm1.536.887a2.165 2.165 0 0 1 1.083 1.839c.005.351.054.695.14 1.024M9.384 9.137l2.077 1.199M7.848 15.75l1.536-.887m-1.536.887a3 3 0 1 1-5.196 3 3 3 0 0 1 5.196-3Zm1.536-.887a2.165 2.165 0 0 0 1.083-1.838c.005-.352.054-.695.14-1.025m-1.223 2.863 2.077-1.199m0-3.328a4.323 4.323 0 0 1 2.068-1.379l5.325-1.628a4.5 4.5 0 0 1 2.48-.044l.803.215-7.794 4.5m-2.882-1.664A4.33 4.33 0 0 0 10.607 12m3.736 0 7.794 4.5-.802.215a4.5 4.5 0 0 1-2.48-.043l-5.326-1.629a4.324 4.324 0 0 1-2.068-1.379M14.343 12l-2.882 1.664" />
                                                    </svg>
                                                    Buat Traveler
                                                </button>
                                            @else
                                                <button onclick="openSplitTraveler(this)"
                                                    data-id="{{ $pecahTraveler->id }}"
                                                    data-surat="{{ $pecahTraveler->no_surat_jalan }}"
                                                    data-qty_awal="{{ $sisaQty }}"
                                                    data-qty_sisa="{{ $sisaQty }}"
                                                    class="px-2 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">

                                                    Buat Traveler

                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                                        Nomor Surat Jalan Tidak Ditemukan.
                                    </td>
                                </tr>
                            @endif
                        </tbody>

                    </table>

                    {{-- Pagination --}}
                    <div class="p-3">
                        {{ $pecahTravelers->links() }}
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>

    </div>

    {{-- Modal Pecah Traveler --}}
    <div id="addModal"
        class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh] ">

            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-medium">Buat Traveler</h3>

                <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                    &times;
                </button>
            </div>

            <form id="pecahTravelerForm" method="POST" action="{{ route('warehouse.pecah.store') }}">

                @csrf

                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="parent_traveler_id" id="parent_traveler_id">

                <div class="mb-4">
                    <label for="pic" class="block text-gray-700">Nama PIC</label>
                    <input type="text" name="pic" id="pic" required
                        class="mt-1 block w-full border border-gray-300 rounded-md">
                </div>

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
                            <th class="text-left text-sm font-medium text-gray-700 pr-3 py-1">
                                No Traveler
                            </th>

                            <th class="text-left text-sm font-medium text-gray-700 px-3 py-1">
                                Qty Split
                            </th>

                            <th class="text-center text-sm font-medium text-gray-700 pr-3 py-1">
                                Departemen Tujuan
                            </th>

                            <th class="text-center text-sm font-medium text-gray-700 w-10 pr-3 py-1">
                                Tanggal Out
                            </th>
                            <th class="text-center text-sm font-medium text-gray-700 w-10 pr-3 py-1">
                            </th>
                        </tr>
                    </thead>

                    <tbody id="travelerBody">

                        <tr>
                            <td class="pr-3">
                                <input type="text" name="no_traveler[]" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md">
                            </td>

                            <td class="pr-3">
                                <input type="number" name="qty_split[]" required min="0"
                                    class="mt-1 block w-full border border-gray-300 rounded-md qty-input"
                                    oninput="calculateTotal()">
                            </td>

                            <td class="pr-3">
                                <select name="dept_tujuan_id[]" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md">

                                    <option value="">Pilih Departemen</option>

                                    @foreach (App\Models\Departments::all() as $departemen)
                                        <option value="{{ $departemen->id }}">
                                            {{ $departemen->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </td>

                            <td class="pr-3">
                                <input type="date" id="tanggal" name="tanggal[]" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md">
                            </td>

                            <td class="text-center px-3 py-2">
                                <button type="button" class="text-green-600 text-xl font-bold"
                                    onclick="addTableRow()">
                                    +
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <p id="qty-warning" class="text-red-500 text-sm mb-1 hidden">
                    Qty melebihi sisa qty yang tersedia.
                </p>

                {{-- <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Tanggal Out
                    </label>

                    <input type="date" name="tanggal" id="tanggal" required
                        class="mt-1 block w-full border border-gray-300 rounded-md">
                </div> --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Catatan
                    </label>

                    <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md"></textarea>
                </div>

                <div class="mt-3">
                    <button type="submit" id="submit-button"
                        onclick="return confirm('Data yang sudah diinput tidak dapat diubah. Apakah anda yakin ingin menyimpan data ini?')"
                        class="px-4 py-2 w-full bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                        Simpan Traveler
                    </button>
                </div>

            </form>

        </div>
    </div>
    </div>

    <script>
        function openSplitTraveler(btn) {

            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');

            document.getElementById('pecahTravelerForm').reset();
            document.getElementById('submit-button').disabled = false;
            document.getElementById('qty-warning').classList.add('hidden');

            let id = btn.dataset.id;
            let surat = btn.dataset.surat;
            let qtyAwal = btn.dataset.qty_awal;
            let qtySisa = btn.dataset.qty_sisa;

            document.getElementById('modalTitle').textContent =
                'Pecah Traveler - ' + surat;

            document.getElementById('surat_jalan_display').value = surat;

            document.getElementById('surat_jalan_id').value = id;

            document.getElementById('qty_awal').value = qtyAwal;

            document.getElementById('qty_sisa').value = qtySisa;

            calculateTotal();
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

            let warning = document.getElementById('qty-warning');
            let submitButton = document.getElementById('submit-button');

            if (totalSplit > qtyAwal) {

                warning.classList.remove('hidden');

                submitButton.disabled = true;
                submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                submitButton.classList.remove('bg-[#136566]', 'hover:bg-[#0f4f50]');

            } else {

                warning.classList.add('hidden');

                submitButton.disabled = false;
                submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                submitButton.classList.add('bg-[#136566]', 'hover:bg-[#0f4f50]');
            }

            document.getElementById('qty_sisa').value = qtyAwal - totalSplit;
        }

        function addTableRow() {

            const tbody = document.getElementById('travelerBody');

            const row = document.createElement('tr');

            row.innerHTML = `
        <td class="pr-3">
            <input type="text" name="no_traveler[]" required
            class="mt-1 block w-full border border-gray-300 rounded-md">
        </td>

        <td class="pr-3">
            <input type="number" name="qty_split[]" 
            class="mt-1 block w-full border border-gray-300 rounded-md qty-input"
            oninput="calculateTotal()">
        </td>

        <td class="pr-3">
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

        <td class="pr-3">
            <input type="date" name="tanggal[]" required
            class="mt-1 block w-full border border-gray-300 rounded-md">
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
    {{-- @endsection --}}
</x-app-layout>

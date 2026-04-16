{{-- @extends('layouts.app')

@section('content') --}}
<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Surat Jalan IN
    </h2>
    @if (session('success'))
        <div class="mt-4">
            <x-alerts variant="success" :message="session('success')" />
        </div>
    @endif
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- Search, filter section, button add order --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('warehouse.suratjalan') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search orders..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>

                <button onClick="openAddOrderModal()"
                    class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Tambah Surat Jalan IN
                </button>
            </div>

            {{-- Table of orders --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                No Surat Jalan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                KKPO
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Qty
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Tanggal</th>
                            {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Status</th> --}}
                            {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Last Updated</th> --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($orders->count())
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->no_surat_jalan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $order->kkpoManagement->kkpo->no_kkpo ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $order->kkpoManagement->kkpo->customer->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->qty }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- format tanggal 12 Maret 2024 --}}
                                        {{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}
                                    </td>
                                    {{-- <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($order->status == 'open')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $order->status }}</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ $order->status }}</span>
                                        @endif
                                    </td> --}}
                                    {{-- <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $order->updated_at->format('Y-m-d') }}</td> --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- <button onClick='openEditOrderModal(@json($order))'
                                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit</button> --}}
                                        <button onclick="openDetail(this)" title="Lihat Detail"
                                            data-kkpo="{{ $order->kkpoManagement->kkpo->no_kkpo ?? '-' }}"
                                            data-customer="{{ $order->kkpoManagement->kkpo->customer->name ?? '-' }}"
                                            data-sj="{{ $order->no_surat_jalan ?? '-' }}"
                                            data-qty="{{ $order->qty }}"
                                            data-style="{{ $order->kkpoManagement->style->name ?? '-' }}"
                                            data-color="{{ $order->kkpoManagement->color->name ?? '-' }}"
                                            data-category="{{ $order->kkpoManagement->category->name ?? '-' }}"
                                            {{-- data-dept="{{ $order->deptTujuan->name ?? '-' }}" --}} data-tanggal="{{ $order->tanggal }}"
                                            data-status="{{ $order->status }}"
                                            data-notes="{{ $order->notes ?? '-' }}">

                                            {{-- icon detail --}}
                                            <svg class="w-6 h-6 text-gray-500 hover:text-gray-700" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>

                                        </button>
                                        <form action="{{ route('warehouse.suratjalan.delete', ['id' => $order->id]) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus order ini?')">
                                                {{-- Icon delete --}}
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
                                <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                    Surat Jalan tidak ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <div class="px-6 py-4">
                        {{ $orders->links() }}
                    </div>
                </table>
            </div>

            {{-- Modal Add & Edit Order --}}
            <div id="order-modal"
                class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-xl font-semibold">Tambah Surat Jalan</h3>
                        <button type="button" onClick="closeModal()" title="Close"
                            class="text-gray-500 text-2xl hover:text-gray-700">&times;</button>
                    </div>

                    <form id="order-form" action="{{ route('warehouse.suratjalan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="mb-4">
                            <x-select-search label="KKPO - Customer - Category Process - Style - Color" name="kkpo_management_id" id="kkpo_management_id"
                                :options="$kkpoManagements
                                    ->map(function ($item) {
                                        return [
                                            'value' => $item->id,
                                            'label' =>
                                                ($item->kkpo?->no_kkpo ?? '-') .
                                                ' - ' .
                                                ($item->kkpo->customer?->name ?? '-') .
                                                ' - ' .
                                                ($item->category?->name ?? '-') .
                                                ' - ' .
                                                ($item->style?->name ?? '-') .
                                                ' - ' .
                                                ($item->color?->name ?? '-'),
                                
                                            'data' => [
                                                'qty_total' => $item->qty_total,
                                                'qty_used' => $item->suratJalan->sum('qty'),
                                            ],
                                        ];
                                    })
                                    ->toArray()" placeholder="Pilih KKPO Management"
                                searchPlaceholder="Cari KKPO Management..." required />

                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="no_surat_jalan" class="block text-gray-700">No Surat Jalan</label>
                                <input type="text" name="no_surat_jalan" id="no_surat_jalan" required
                                    class="w-full border mt-1 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="qty" class="block text-gray-700">Qty</label>

                                <input type="number" name="qty" id="qty" required min="0"
                                    oninput="checkQty()"
                                    class="w-full border mt-1 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                                <p id="qty-warning" class="text-red-500 text-sm mt-1 hidden">
                                    Qty melebihi sisa qty KKPO
                                </p>

                                <p class="text-gray-500 text-sm mt-1">
                                    {{-- ambil qty dari KKPO Management yang dipilih --}}
                                    Sisa Qty KKPO: <span id="sisa_qty_text">0</span>
                                    {{-- Sisa Qty KKPO : <span id="sisa_qty_text">{{}}</span> --}}
                                </p>
                            </div>
                            <div>
                                <label for="tanggal" class="block text-gray-700">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" required
                                    class="w-full border mt-1 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <button type="submit" id="submit-button"
                            onclick="return confirm('Apakah data yang Anda masukkan sudah benar?')"
                            class="bg-[#136566] mt-6 text-white w-full px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                            Tambah Surat Jalan
                        </button>

                    </form>
                </div>
            </div>

            {{-- Modal Detail --}}
            <div id="detail-modal"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh] ">

                    {{-- HEADER --}}
                    <div class="flex justify-between items-center mb-4 border-b pb-3">
                        <h3 class="text-lg font-semibold text-gray-700">
                            Detail Surat Jalan
                        </h3>

                        <button onclick="closeDetail()" title="Close"
                            class="text-gray-400 hover:text-gray-600 text-2xl">
                            &times;
                        </button>
                    </div>


                    {{-- ORDER ID + STATUS --}}
                    <div class="grid grid-cols-2 gap-7-3 text-sm mb-6">

                        <div>
                            <p class="text-gray-400 text-sm">No Surat Jalan</p>
                            <p id="detail_sj" class="font-semibold"></p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-sm">Status</p>
                            <span id="detail_status" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                            </span>
                        </div>

                    </div>


                    {{-- DETAIL --}}
                    <div class="grid grid-cols-2 gap-y-3 text-sm">

                        <span class="text-gray-500">KKPO</span>
                        <span id="detail_kkpo"></span>

                        {{-- <span class="text-gray-500">No Surat Jalan</span>
                        <span id="detail_sj"></span> --}}

                        <span class="text-gray-500">Customer</span>
                        <span id="detail_customer"></span>

                        <span class="text-gray-500">Category Process</span>
                        <span id="detail_category"></span>

                        <span class="text-gray-500">Style</span>
                        <span id="detail_style"></span>

                        <span class="text-gray-500">Color</span>
                        <span id="detail_color"></span>

                        <span class="text-gray-500">Qty</span>
                        <span id="detail_qty"></span>

                        {{-- <span class="text-gray-500">Dept Tujuan</span>
                        <span id="detail_dept"></span> --}}

                        <span class="text-gray-500">Tanggal</span>
                        <span id="detail_tanggal"></span>

                        <span class="text-gray-500">Notes</span>
                        <span id="detail_notes"></span>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function openAddOrderModal() {
            document.getElementById('modal-title').innerText = 'Tambah Surat Jalan';
            document.getElementById('submit-button').innerText = 'Tambah Surat Jalan';
            document.getElementById('form-method').value = 'POST';
            document.getElementById('order-form').action = "{{ route('warehouse.suratjalan.store') }}";
            document.getElementById('order_id').value = '';
            document.getElementById('kkpo_management_id').value = '';
            document.getElementById('no_surat_jalan').value = '';
            document.getElementById('qty').value = '';
            document.getElementById('tanggal').value = '';
            document.getElementById('order-modal').classList.remove('hidden');
            document.getElementById('order-modal').classList.add('flex');

            // reinit select
            setTimeout(() => {
                if (window.HSStaticMethods) {
                    window.HSStaticMethods.autoInit();
                }
            }, 100);
        }

        function openDetail(btn) {
            document.getElementById('detail-modal').classList.remove('hidden');
            document.getElementById('detail-modal').classList.add('flex');

            document.getElementById('detail_kkpo').innerText = btn.dataset.kkpo;
            document.getElementById('detail_customer').innerText = btn.dataset.customer;
            document.getElementById('detail_sj').innerText = btn.dataset.sj;
            document.getElementById('detail_qty').innerText = btn.dataset.qty;
            document.getElementById('detail_style').innerText = btn.dataset.style;
            document.getElementById('detail_color').innerText = btn.dataset.color;
            document.getElementById('detail_category').innerText = btn.dataset.category;
            document.getElementById('detail_tanggal').innerText = btn.dataset.tanggal;
            document.getElementById('detail_status').innerText = btn.dataset.status;
            document.getElementById('detail_notes').innerText = btn.dataset.notes;
        }

        function closeDetail() {
            document.getElementById('detail-modal').classList.add('hidden');
            document.getElementById('detail-modal').classList.remove('flex');
        }

        function openEditOrderModal(order) {
            document.getElementById('modal-title').innerText = 'Edit Surat Jalan';
            document.getElementById('submit-button').innerText = 'Update Surat Jalan';
            document.getElementById('form-method').value = 'PUT';

            document.getElementById('order-form').action =
                "{{ route('warehouse.suratjalan.update', ':id') }}".replace(':id', order.id);

            document.getElementById('order_id').value = order.id;
            document.getElementById('kkpo_management_id').value = order.kkpo_management_id;

            document.getElementById('no_surat_jalan').value = order.no_surat_jalan;
            document.getElementById('qty').value = order.qty;
            document.getElementById('tanggal').value = order.tanggal;

            // ambil customer dari dropdown
            let select = document.getElementById('kkpo_management_id');
            let selected = select.options[select.selectedIndex];
            let customer = selected.getAttribute('data-customer');

            document.getElementById('customer').value = customer ?? '';

            document.getElementById('order-modal').classList.remove('hidden');
            document.getElementById('order-modal').classList.add('flex');
            setTimeout(() => {
                if (window.HSStaticMethods) {
                    window.HSStaticMethods.autoInit();
                }
            }, 100);
        }

        function closeModal() {
            document.getElementById('order-modal').classList.add('hidden');
            document.getElementById('order-modal').classList.remove('flex');
        }

        let sisaQty = 0;

        function setDataSelection(select) {

            let selectedOption = select.options[select.selectedIndex];

            if (!selectedOption) return;

            let qtyTotal = selectedOption.getAttribute('data-qty_total');
            let qtyUsed = selectedOption.getAttribute('data-qty_used');

            qtyTotal = parseInt(qtyTotal) || 0;
            qtyUsed = parseInt(qtyUsed) || 0;

            sisaQty = qtyTotal - qtyUsed;

            document.getElementById('sisa_qty_text').innerText = sisaQty;

            checkQty();
        }

        function checkQty() {

            let qtyInput = document.getElementById('qty');
            let warning = document.getElementById('qty-warning');
            let submitBtn = document.getElementById('submit-button');

            let qty = parseInt(qtyInput.value) || 0;

            // jika sisa qty lebih dari 0 dan sisa qty = 0, maka submit btn disable
            if (qty > sisaQty) {

                warning.classList.remove('hidden');

                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            } else {

                warning.classList.add('hidden');

                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            let select = document.getElementById('kkpo_management_id');

            if (select) {
                select.addEventListener('change', function() {
                    setDataSelection(this);
                });
            }
        });
    </script>
    {{-- @endsection --}}
</x-app-layout>

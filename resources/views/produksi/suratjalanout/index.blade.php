<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Surat Jalan Out
    </h2> --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:produksi.suratjalanout />
                </div>
            </div> --}}
            {{-- search filter add suratjalan --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('produksi.suratjalanout.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search orders..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>

                <button onClick="openAddOrderModal()"
                    class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Tambah Surat Jalan OUT
                </button>
            </div>
            {{-- Modal Add & Edit Order --}}
            <div id="order-modal"
                class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-xl font-semibold">Input Surat Jalan OUT</h3>
                        <button type="button" onClick="closeModal()" title="Close"
                            class="text-gray-500 text-2xl hover:text-gray-700">&times;</button>
                    </div>

                    <form id="order-form" action="{{ route('produksi.suratjalanout.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="mb-4">
                            <x-select-search label="SJ IN - Customer - Item - Style - KP/PO - Color"
                                name="kkpo_management_id" id="kkpo_management_id" :options="$suratJalanIns
                                    ->map(function ($item) {
                                        return [
                                            'value' => $item->id,
                                            'label' =>
                                                // ($item->no_kkpo ?? '-') .
                                                ($item->no_surat_jalan ?? '-') .
                                                ' - ' .
                                                ($item->kkpoManagement->customer->name ?? '-') .
                                                ' - ' .
                                                // ($item->category?->name ?? '-') .
                                                // ' - ' .
                                                // ($item->style?->name ?? '-') .
                                                // ' - ' .
                                                ($item->kkpoManagement->item->name ?? '-') .
                                                ' - ' .
                                                // ($item->no_surat_jalan ?? '-') .
                                                ($item->kkpoManagement->style->name ?? '-') .
                                                ' - ' .
                                                ($item->kkpoManagement->kp_po ?? '-') .
                                                ' - ' .
                                                ($item->kkpoManagement->color->name ?? '-'),
                                
                                            'data' => [
                                                'qty_total' => $item->qty_total,
                                                // 'qty_used' => $item->suratJalan->sum('qty'),
                                            ],
                                        ];
                                    })
                                    ->toArray()"
                                placeholder="Pilih Data Surat Jalan" searchPlaceholder="Cari Data Surat Jalan..."
                                required />

                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- surat jalan select --}}
                            <div>
                                <x-select-search label="No Surat Jalan IN" name="surat_jalan_id" id="surat_jalan_id"
                                    :options="$suratJalanIns
                                        ->map(function ($item) {
                                            return [
                                                'value' => $item->id,
                                                'label' => $item->no_surat_jalan ?? '-',
                                            ];
                                        })
                                        ->toArray()" placeholder="Pilih No Surat Jalan IN"
                                    searchPlaceholder="Cari No Surat Jalan IN..." />
                            </div>
                            {{-- traveler dropdown --}}
                            <div class ="mb-4">
                                <x-select-search label="Traveler" name="traveler_id" id="traveler_id" :options="$travelers
                                    ->map(function ($item) {
                                        return [
                                            'value' => $item->id,
                                            'label' => $item->no_traveler ?? '-',
                                        ];
                                    })
                                    ->toArray()"
                                    placeholder="Pilih Traveler" searchPlaceholder="Cari Traveler..." />
                            </div>
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

                                {{-- <p class="text-gray-500 text-sm mt-1"> --}}
                                {{-- ambil qty dari KKPO Management yang dipilih --}}
                                {{-- Sisa Qty KKPO: <span id="sisa_qty_text">0</span> --}}
                                {{-- Sisa Qty KKPO : <span id="sisa_qty_text">{{}}</span> --}}
                                {{-- </p> --}}
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

            {{-- Table of orders --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                <table class="min-w-full table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                No Surat Jalan OUT</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                No Surat Jalan IN</th>
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
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $order->no_surat_jalan }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->suratJalanIn->no_surat_jalan ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->kkpoManagement->no_kkpo ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->kkpoManagement->customer->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $order->qty }}</td>

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- format tanggal 12 Maret 2024 --}}
                                        {{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}
                                    </td>
                                    {{-- <td class="px-4 py-2 whitespace-nowrap">
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
                                    {{-- <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->updated_at->format('Y-m-d') }}</td> --}}
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- <button onClick='openEditOrderModal(@json($order))'
                                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit</button> --}}
                                        <button onclick="openDetail(this)" title="Lihat Detail"
                                            data-kkpo="{{ $order->kkpoManagement->kkpo->no_kkpo ?? '-' }}"
                                            data-customer="{{ $order->kkpoManagement->customer->name ?? '-' }}"
                                            data-sj="{{ $order->no_surat_jalan ?? '-' }}"
                                            data-qty="{{ $order->qty }}"
                                            data-style="{{ $order->kkpoManagement->style->name ?? '-' }}"
                                            data-color="{{ $order->kkpoManagement->color->name ?? '-' }}"
                                            data-category="{{ $order->kkpoManagement->category->name ?? '-' }}"
                                            {{-- data-dept="{{ $order->deptTujuan->name ?? '-' }}" --}} data-tanggal="{{ $order->tanggal }}"
                                            data-status="{{ $order->status }}"
                                            data-notes="{{ $order->notes ?? '-' }}">

                                            {{-- icon detail --}}
                                            <svg class="w-6 h-6 text-blue-500 hover:text-blue-700" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>

                                        </button>
                                        <form
                                            action="{{ route('warehouse.suratjalan.delete', ['id' => $order->id]) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus order ini?')">
                                                {{-- Icon delete --}}
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
                                <td colspan="8" class="px-4 py-2 whitespace-nowrap text-center text-gray-500">
                                    Surat Jalan tidak ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="p-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        function openAddOrderModal() {
            document.getElementById('order-form').reset();
            document.getElementById('form-method').value = 'POST';
            document.getElementById('modal-title').textContent = 'Input Surat Jalan OUT';
            document.getElementById('order_id').value = '';
            document.getElementById('order-modal').classList.remove('hidden');
            document.getElementById('order-modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('order-modal').classList.add('hidden');
            document.getElementById('order-modal').classList.remove('flex');
        }

        function checkQty() {
            const qtyInput = document.getElementById('qty');
            const qtyWarning = document.getElementById('qty-warning');
            const kkpoSelect = document.getElementById('kkpo_management_id');
            const sisaQtyText = document.getElementById('sisa_qty_text');

            const selectedOption = kkpoSelect.options[kkpoSelect.selectedIndex];
            const qtyTotal = parseInt(selectedOption.dataset.qty_total) || 0;
            const qtyUsed = parseInt(selectedOption.dataset.qty_used) || 0;
            const sisaQty = qtyTotal - qtyUsed;

            sisaQtyText.textContent = sisaQty;

            if (parseInt(qtyInput.value) > sisaQty) {
                qtyWarning.classList.remove('hidden');
                document.getElementById('submit-button').disabled = true;
            } else {
                qtyWarning.classList.add('hidden');
                document.getElementById('submit-button').disabled = false;
            }
        }
    </script>
</x-app-layout>

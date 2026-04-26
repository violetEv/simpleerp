<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Monitoring & Report PPIC
    </h2> --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- Search --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('ppic.monitoring') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search monitoring..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
                {{-- filter checkbox for kkpo, customer, category, style, color, and export button --}}
                <div class="flex items-center gap-4">
                    <form action="{{ route('ppic.monitoring') }}" method="GET" class="flex items-center gap-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="filter_kkpo" value="1"
                                class="form-checkbox text-[#136566] border-gray-300 rounded"
                                {{ request('filter_kkpo') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">KKPO</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="filter_customer" value="1"
                                class="form-checkbox text-[#136566] border-gray-300 rounded"
                                {{ request('filter_customer') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Customer</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="filter_category" value="1"
                                class="form-checkbox text-[#136566] border-gray-300 rounded"
                                {{ request('filter_category') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Category</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="filter_style" value="1"
                                class="form-checkbox text-[#136566] border-gray-300 rounded"
                                {{ request('filter_style') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Style</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="filter_color" value="1"
                                class="form-checkbox text-[#136566] border-gray-300 rounded"
                                {{ request('filter_color') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Color</span>
                        </label>
                    </form>
                    <a href="{{ route('ppic.monitoring', request()->query()) }}"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                        Export Excel
                    </a>
                </div>
            </div>
            {{-- Table --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                <table class="min-w-full table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                KKPO</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Style</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Color</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                KP / PO</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Qty Total</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Qty Used</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Remaining Qty</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($monitoring->count())
                            @foreach ($monitoring as $item)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->no_kkpo ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->customer?->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->category?->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->style?->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->color?->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->kp_po ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->qty_total }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->qty_used }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->qty_total - $item->qty_used }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <button onclick="openDetailModal(this)"
                                            data-kkpo="{{ $item->kkpo->no_kkpo ?? '-' }}"
                                            data-customer="{{ $item->kkpo->customer?->name ?? '-' }}"
                                            data-sj="{{ $item->kp_po ?? '-' }}"
                                            data-qty="{{ $item->qty_total - $item->qty_used }}"
                                            class="text-blue-500 border border-blue-500 rounded-xl py-1 px-4 hover:bg-blue-50">
                                            Detail</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="px-4 py-2 text-center text-gray-500">Monitoring data tidak ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="px-4 py-3 bg-gray-50 border-t flex items-center justify-end">
                    {{ $monitoring->links() }}
                </div>

            </div>
            {{-- Detail Modal --}}
            <div id="detail-modal"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh] ">
                    <div class="flex justify-between items-center mb-4 border-b pb-3">
                        <h3 class="text-lg font-semibold text-gray-700">
                            Detail Orders
                        </h3>

                        <button onclick="closeDetailModal()" title="Close" class="text-gray-400 hover:text-gray-600 text-2xl">
                            &times;
                        </button>
                    </div>
                    <p><strong>KKPO:</strong> <span id="detail_kkpo"></span></p>
                    <p><strong>Customer:</strong> <span id="detail_customer"></span></p>
                    <p><strong>SJ/KP/PO:</strong> <span id="detail_sj"></span></p>
                    <p><strong>Remaining Qty:</strong> <span id="detail_qty"></span></p>
                    <button onclick="closeDetailModal()"
                        class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // untuk checbox filter

        function openDetailModal(btn) {
            const detailModal = document.getElementById('detail-modal');
            detailModal.classList.remove('hidden');
            detailModal.classList.add('flex');

            document.getElementById('detail_kkpo').innerText = btn.dataset.kkpo;
            document.getElementById('detail_customer').innerText = btn.dataset.customer;
            document.getElementById('detail_sj').innerText = btn.dataset.sj;
            document.getElementById('detail_qty').innerText = btn.dataset.qty;
        }

        function closeDetailModal() {
            const detailModal = document.getElementById('detail-modal');
            detailModal.classList.add('hidden');
            detailModal.classList.remove('flex');
        }
    </script>
</x-app-layout>

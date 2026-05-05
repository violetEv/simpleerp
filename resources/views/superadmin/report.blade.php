<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Report
    </h2> --}}
    {{-- data count --}}
    {{-- {{ $data->count() }} data ditemukan. --}}
    <p class="text-sm text-gray-500 mb-4">
        Menampilkan data KKPO yang telah selesai (memiliki surat jalan keluar). Klik "Detail" untuk melihat informasi
        traveler dan pergerakannya.
    </p>

    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- FILTER CARD --}}
            <div class="bg-white shadow-sm rounded-lg mb-3 border border-gray-100">

                <form method="GET" x-data="{ open: false }" class="p-3 space-y-3">

                    {{-- TOP BAR --}}
                    <div class="flex flex-wrap items-center gap-2">

                        {{-- DATE FROM --}}
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="h-9 px-3 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50]">

                        {{-- DATE TO --}}
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="h-9 px-3 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50]">
                        {{-- SEARCH --}}
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                                class="h-9 pl-9 pr-3 text-sm border border-gray-200 rounded-md  focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50] w-full md:w-52">

                            {{-- ICON SEARCH --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="m21 21-4.35-4.35m1.85-5.65a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                            </svg>
                        </div>

                        {{-- FILTER (SECONDARY) --}}
                        <button type="button" @click="open = !open"
                            class="h-9 px-3 text-sm rounded-md border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 flex items-center gap-1 transition">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                            </svg>

                            Filter
                        </button>

                        <button
                            class="h-9 px-4 text-sm rounded-md bg-[#0f4f50] text-white hover:bg-[#136566] active:scale-[0.98] flex items-center gap-1 transition">

                            {{-- ICON CHECK --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4.5 12.75 10.5 18 19.5 6" />
                            </svg>

                            Apply
                        </button>

                        {{-- RESET (TERTIARY) --}}
                        <a href="{{ route('superadmin.report') }}"
                            class="h-9 px-3 text-sm rounded-md text-gray-500 hover:text-gray-700 flex items-center gap-1 transition">

                            Reset
                        </a>

                        {{-- EXPORT (SECONDARY SUCCESS) --}}
                        <a href="{{ route('superadmin.report.export', request()->all()) }}"
                            class="h-9 px-3 text-sm rounded-md border border-green-200 text-green-700 bg-green-50 hover:bg-green-100 flex items-center gap-1 transition">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 16.5V3m0 13.5-4.5-4.5M12 16.5l4.5-4.5M3 21h18" />
                            </svg>

                            Export
                        </a>

                    </div>

                    {{-- ADVANCED FILTER --}}
                    <div x-show="open" x-transition class="grid grid-cols-3 md:grid-cols-3 gap-2 pt-2 border-t">

                        <x-select-search name="kkpo" :value="request('kkpo')" :options="$kkpo->map(fn($k) => ['value' => $k, 'label' => $k])" placeholder="KKPO" />

                        <x-select-search name="no_surat_jalan" :value="request('no_surat_jalan')" :options="$suratJalan->map(fn($s) => ['value' => $s, 'label' => $s])"
                            placeholder="Surat Jalan" />

                        <x-select-search name="customer" :value="request('customer')" :options="$customer->map(fn($c) => ['value' => $c, 'label' => $c])" placeholder="Customer" />

                        <x-select-search name="style" :value="request('style')" :options="$style->map(fn($s) => ['value' => $s, 'label' => $s])" placeholder="Style" />

                        <x-select-search name="category" :value="request('category')" :options="$category->map(fn($c) => ['value' => $c, 'label' => $c])"
                            placeholder="Category Process" />

                        <x-select-search name="color" :value="request('color')" :options="$color->map(fn($c) => ['value' => $c, 'label' => $c])" placeholder="Color" />

                    </div>

                </form>
            </div>


            <div class="bg-white shadow rounded-lg overflow-hidden p-2">

                <div class="overflow-x-auto">
                    <table class="min-w-full table-fixed text-gray-800">
                        <thead class="bg-gray-50 text-gray-700 uppercase tracking wider">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold">
                                    KKPO
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">
                                    No
                                    Surat
                                    Jalan IN</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">
                                    Pelanggan</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">
                                    Kategori Proses</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">
                                    Model
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">
                                    Qty
                                    In
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">
                                    Qty
                                    Out
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">
                                    Balance</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            {{-- Data report akan di-looping di sini dan hanya menampilkan satu data per kkpo --}}
                            @if ($data->count())
                                @foreach ($data as $sj)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sj->kkpoManagements->no_kkpo ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sj->no_surat_jalan ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sj->kkpoManagements->customer->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sj->kkpoManagements->category->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sj->kkpoManagements->style->name ?? '-' }}
                                        </td>

                                        @php
                                            $totalIn = 0;
                                            $totalOut = 0;
                                            $totalBalance = 0;

                                            foreach ($sj->travelers as $t) {
                                                foreach ($t->movements as $m) {
                                                    $totalIn += $m->qty_in;
                                                    $totalOut += $m->qty_out;
                                                    $totalBalance += $m->balance;
                                                }
                                            }
                                        @endphp

                                        <td class="px-4 py-2 whitespace-nowrap">{{ $totalIn }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $totalOut }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $totalBalance }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <a href="{{ route('superadmin.report.show', ['id' => $sj->id]) }}"
                                                class="text-blue-500 border border-blue-500 rounded-xl py-1 px-4 hover:bg-blue-50">
                                                Detail</a>
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="px-4 py-2 text-center text-gray-500">Data tidak
                                        tersedia.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="p-3">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- auto filter tanggal tanpa submit --}}
    {{-- <script>
        document.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('change', () => {
                el.closest('form').submit();
            });
        });
    </script> --}}
</x-app-layout>

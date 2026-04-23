
<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Report
    </h2> --}}

    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- FILTER CARD --}}
            <div class="bg-white shadow-sm rounded-lg mb-3 border border-gray-100">

                <form method="GET" x-data="{ open: false }" class="p-3 space-y-3">

                    {{-- TOP BAR --}}
                    <div class="flex flex-wrap items-center gap-2">

                        {{-- DATE FROM --}}
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="h-9 px-3 text-sm border border-gray-200 rounded-md
                  focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50]">

                        {{-- DATE TO --}}
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="h-9 px-3 text-sm border border-gray-200 rounded-md
                  focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50]">
                        {{-- SEARCH (FIXED WIDTH) --}}
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                            class="h-9 px-3 text-sm border border-gray-200 rounded-md
                                  focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50]
                                  w-full md:w-48">

                        {{-- FILTER --}}
                        <button type="button" @click="open = !open"
                            class="h-9 px-3 text-sm rounded-md
                                   bg-[#0f4f50] text-white hover:bg-[#136566]
                                   transition">
                            Filter
                        </button>

                        {{-- APPLY --}}
                        <button
                            class="h-9 px-3 text-sm rounded-md
                                   bg-[#136566] text-white hover:bg-[#1b7a7b]
                                   transition">
                            Apply
                        </button>

                        {{-- RESET --}}
                        <a href="{{ route('ppic.report') }}"
                            class="h-9 px-3 text-sm rounded-md
                              bg-gray-200 text-gray-700 hover:bg-gray-300
                              flex items-center">
                            Reset
                        </a>

                        {{-- EXPORT --}}
                        <a href="{{ route('ppic.report.export', request()->all()) }}"
                            class="h-9 px-3 text-sm rounded-md
                              bg-green-600 text-white hover:bg-green-700 flex items-center">
                            Export
                        </a>

                    </div>

                    {{-- ADVANCED FILTER --}}
                    <div x-show="open" x-transition class="grid grid-cols-1 md:grid-cols-4 gap-2 pt-2 border-t">

                        <x-select-search name="kkpo" :value="request('kkpo')" :options="$kkpo->map(fn($k) => ['value' => $k, 'label' => $k])" placeholder="KKPO" />

                        <x-select-search name="no_surat_jalan" :value="request('no_surat_jalan')" :options="$suratJalan->map(fn($s) => ['value' => $s, 'label' => $s])"
                            placeholder="Surat Jalan" />

                        <x-select-search name="customer" :value="request('customer')" :options="$customer->map(fn($c) => ['value' => $c, 'label' => $c])" placeholder="Customer" />

                        <x-select-search name="style" :value="request('style')" :options="$style->map(fn($s) => ['value' => $s, 'label' => $s])" placeholder="Style" />

                    </div>

                </form>
            </div>


            <div class="bg-white shadow rounded-lg overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="min-w-full table-fixed">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    KKPO
                                </th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                    Surat
                                    Jalan</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category Process</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Style
                                </th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Qty
                                    In
                                </th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Qty
                                    Out
                                </th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Balance</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Data report akan di-looping di sini dan hanya menampilkan satu data per kkpo --}}
                            @if ($data->count())
                                @foreach ($data as $sj)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sj->kkpoManagement->no_kkpo ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sj->no_surat_jalan ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sj->kkpoManagement->customer->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sj->kkpoManagement->category->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sj->kkpoManagement->style->name ?? '-' }}
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
                                                <a href="{{ route('ppic.report.show', ['id' => $sj->id]) }}"
                                                    class="text-blue-500 border border-blue-500 rounded-xl py-1 px-4 hover:bg-blue-50">
                                                    Detail</a>
                                            </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="px-4 py-2 text-center text-gray-500">Data tidak tersedia.
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

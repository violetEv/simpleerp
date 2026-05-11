<x-app-layout>
{{-- 
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Warehouse Dasbor
    </h2> --}}
    {{-- CARD STATISTIC --}}
    <div class="grid grid-cols-1 mt-6 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- QTY MASUK --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 12 3l9 4.5M4.5 9.75V16.5
                        a2.25 2.25 0 0 0 1.172 1.979L12
                        21l6.328-2.521A2.25 2.25 0 0 0
                        19.5 16.5V9.75M9 12l3 1.5 3-1.5" />
                </svg>

            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Qty Masuk
                </p>

                <p class="text-gray-800 font-semibold text-xl">
                    {{ number_format($totalQtyTraveler) }}
                </p>

                <p class="text-gray-400 text-xs">
                    Total Barang Masuk
                </p>
            </div>
        </div>

        {{-- QTY BONGKAR --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5 12 21l9-4.5M3
                        12l9 4.5L21 12M3 7.5 12
                        12l9-4.5" />
                </svg>

            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Qty Bongkar
                </p>

                <p class="text-gray-800 font-semibold text-xl">
                    {{ number_format($totalQtyKeluar) }}
                </p>

                <p class="text-gray-400 text-xs">
                    Total Barang Dibongkar
                </p>
            </div>
        </div>

        {{-- BALANCE BONGKAR --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a9
                        9 0 1 1-18 0 9 9 0 0 1
                        18 0Z" />
                </svg>

            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Balance Bongkar
                </p>

                <p class="text-gray-800 font-semibold text-xl">
                    {{ number_format($balanceBongkar) }}
                </p>

                <p class="text-gray-400 text-xs">
                    Sisa Barang Belum Dibongkar
                </p>
            </div>
        </div>

    </div>

    {{-- TABLE SURAT JALAN --}}
    <div class="bg-white rounded-lg shadow pb-3 mt-6 mb-10">

        <div class="flex justify-between items-center p-4 border-b">

            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    Surat Jalan Terbaru
                </h3>

                <p class="text-sm text-gray-500">
                    Daftar surat jalan yang perlu diproses.
                </p>
            </div>

            <a href="{{ route('warehouse.pecah') }}" class="text-sm text-[#136566] hover:text-[#0f4f50] transition">

                Lihat Semua
            </a>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full table-fixed text-gray-800">

                <thead
                    class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">

                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">
                            No. Surat Jalan
                        </th>

                        <th class="px-4 py-3 text-left font-semibold">
                            Customer
                        </th>

                        <th class="px-4 py-3 text-left font-semibold">
                            Category Process
                        </th>
                        <th class="px-4 py-3 text-left font-semibold">
                            Style
                        </th>
                        <th class="px-4 py-3 text-left font-semibold">
                            Color
                        </th>

                        <th class="px-4 py-3 text-left font-semibold">
                            Tanggal
                        </th>

                        <th class="px-4 py-3 text-left font-semibold">
                            Qty
                        </th>

                        <th class="px-4 py-3 text-left font-semibold">
                            Status
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 text-sm">

                    @forelse ($recentActivities as $activity)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $activity->no_surat_jalan }}
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $activity->kkpoManagement->customer->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $activity->kkpoManagement->details->first()->category->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $activity->kkpoManagement->details->first()->style->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $activity->kkpoManagement->details->first()->color->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ Carbon\Carbon::parse($activity->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap font-medium">
                                {{ number_format($activity->qty) }}
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">

                                @if ($activity->status == 'open')
                                    <span
                                        class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">

                                        Belum Dibongkar

                                    </span>
                                @elseif ($activity->status == 'in_process')
                                    <span
                                        class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800">

                                        Sedang Dibongkar

                                    </span>
                                @elseif ($activity->status == 'closed')
                                    <span
                                        class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">

                                        Sudah Dibongkar

                                    </span>
                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-sm text-gray-500">

                                Tidak ada surat jalan terbaru.

                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>

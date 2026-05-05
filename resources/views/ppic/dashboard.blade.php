<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        PPIC Dashboard
    </h2>
    {{-- CARD DATA PAKE LOGO --}}
    {{-- total kkpo bulan ini, total color, total style, total category, total customer --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0zm-4.5 0H12m-2.25 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total KKPO</p>
                <p class="text-gray-800 font-semibold text-lg">{{ $totalKKPOmonth }}</p>
                <p class="text-gray-400 text-xs">Bulan ini</p>
            </div>
            {{-- tambah keterangan 'bulan ini' kecil di bawah 'Total KKPO' --}}

        </div>

        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0zm-4.5 0H12m-2.25 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Style</p>
                <p class="text-gray-800 font-semibold text-lg">{{ $totalStyles }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0zm-4.5 0H12m-2.25 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Color</p>
                <p class="text-gray-800 font-semibold text-lg">{{ $totalColors }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0zm-4.5 0H12m-2.25 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Category</p>
                <p class="text-gray-800 font-semibold text-lg">{{ $totalCategories }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0zm-4.5 0H12m-2.25 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Customer</p>
                <p class="text-gray-800 font-semibold text-lg">{{ $totalCustomers }}</p>
            </div>
        </div>
    </div>
    {{-- TABLE LATEST KKPO --}}
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Latest KKPO</h3>
            <a href="{{ route('ppic.kkpomanagement') }}" class="text-sm text-[#136566] hover:text-[#0f4f50] transition">
                View All
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed text-gray-800">
                <thead
                    class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">

                    <tr>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                            No KKPO
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                            Customer
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                            Category
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                            Style / Color
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @if ($latestKKPO->count() > 0)
                        @foreach ($latestKKPO as $kkpo)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $kkpo->no_kkpo }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $kkpo->customer->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $kkpo->details->first()->category->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $kkpo->details->first()->style->name ?? '-' }} •
                                    {{ $kkpo->details->first()->color->name ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="px-4 py-2 whitespace-nowrap text-gray-500 text-center">
                                No KKPO found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

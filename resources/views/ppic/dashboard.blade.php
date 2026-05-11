<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        PPIC Dashboard
    </h2>

    {{-- CARD DATA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- TOTAL KKPO --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                {{-- icon documents --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .375a2.25
                        2.25 0 1 1-4.5 0
                        2.25 2.25 0 0 1 4.5 0zM19.5
                        3h-5.625c-.621
                        0-1.125-.504-1.125-1.125V3zM18
                        14v-.375c0-.621-.504-1.125-1.125-1.125H13.5m-2.625
                        0H10.5c-.621
                        0-1.125-.504-1.125-1.125V10m0
                        4v-.375c0-.621-.504-1.125-1.125-1.125H3m16.5
                        -9h-5.625c-.621
                        0-1.125-.504-1.125-1.125V3m0
                        4v-.375c0-.621-.504-1.125-1.125-1.125H10m8.25
                        -5H12a2.25
                        2.25 0 00-2.25
                        2.25v16A2.25
                        2.25 0 0012
                        21h8a2.25
                        2.25 0 002.25-2.25V5A2.25
                        2.25 0 0018
                        .75z" />
                </svg>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Total KKPO
                </p>

                <p class="text-gray-800 font-semibold text-xl">
                    {{ $totalKKPO }}
                </p>

                <p class="text-gray-400 text-xs">
                    Total Documents
                </p>
            </div>
        </div>

        {{-- TOTAL ITEM KKPO --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 6.75h9m-9 5.25h9m-9 5.25h9" />
                </svg>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Total Items KKPO
                </p>

                <p class="text-gray-800 font-semibold text-xl">
                    {{ $totalKKPODetails }}
                </p>

                <p class="text-gray-400 text-xs">
                    Total Styles / Orders
                </p>
            </div>
        </div>

        {{-- TOTAL PRODUCTION QTY --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v18m0 0h18m-18 0V9.75
                m4.5 11.25V6.75m4.5 14.25v-9
                m4.5 9v-6" />
                </svg>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Total Production
                </p>

                <p class="text-gray-800 font-semibold text-xl">
                    {{ number_format($totalProductionQty) }}
                </p>

                <p class="text-gray-400 text-xs">
                    Total Ordered Quantity
                </p>
            </div>
        </div>

        {{-- CUSTOMER --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0
                        3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5
                        7.5 0 0 1 14.998 0A17.933
                        17.933 0 0 1 12
                        21c-2.676
                        0-5.216-.584-7.499-1.882Z" />
                </svg>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Total Customer
                </p>

                <p class="text-gray-800 font-semibold text-xl">
                    {{ $totalCustomers }}
                </p>
            </div>
        </div>
        {{-- total production qty --}}

        {{-- STYLE --}}
        {{-- <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4.5 12a7.5 7.5 0 1 1 15 0
                        7.5 7.5 0 0 1-15 0Z" />
                </svg>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Total Style
                </p>

                <p class="text-gray-800 font-semibold text-xl">
                    {{ $totalStyles }}
                </p>
            </div>
        </div> --}}

        {{-- COLOR --}}
        {{-- <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9.53 16.122a3 3 0 1 1 4.243-4.243
                        3 3 0 0 1-4.243 4.243Z" />
                </svg>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Total Color
                </p>

                <p class="text-gray-800 font-semibold text-xl">
                    {{ $totalColors }}
                </p>
            </div>
        </div> --}}

        {{-- CATEGORY --}}
        {{-- <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 4.5h16.5v4.5H3.75V4.5Zm0 6.75h16.5v8.25H3.75v-8.25Z" />
                </svg>
            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Total Category
                </p>

                <p class="text-gray-800 font-semibold text-xl">
                    {{ $totalCategories }}
                </p>
            </div>
        </div> --}}

    </div>

    {{-- TABLE LATEST KKPO --}}
    <div class="bg-white rounded-lg shadow pb-3 mt-6 mb-10">

        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
                Latest KKPO
            </h3>

            <a href="{{ route('ppic.kkpo') }}" class="text-sm text-[#136566] hover:text-[#0f4f50] transition">

                View All
            </a>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full table-fixed text-gray-800">

                <thead
                    class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">

                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">
                            No KKPO
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
                            KP
                        </th>

                        <th class="px-4 py-3 text-left font-semibold">
                            Qty
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 text-sm">

                    @forelse ($latestKKPO as $kkpo)

                        @foreach ($kkpo->details as $detail)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $kkpo->no_kkpo }}
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $kkpo->customer->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $detail->category->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $detail->style->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $detail->color->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $detail->kp ?? '-' }}
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap font-medium">
                                    {{ $detail->qty ?? '-' }}
                                </td>

                            </tr>
                        @endforeach

                    @empty

                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">

                                No KKPO found.

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</x-app-layout>

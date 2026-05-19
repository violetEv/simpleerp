{{-- manager/dashboard.blade.php --}}

<x-app-layout>

    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Manager Dashboard
    </h2>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- TOTAL KKPO --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">

            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 14.25v-8.625a2.625
                        2.625 0 0 0-2.625-2.625H7.125
                        A2.625 2.625 0 0 0 4.5
                        5.625v12.75A2.625 2.625 0 0 0
                        7.125 21h9.75a2.625 2.625
                        0 0 0 2.625-2.625V14.25Z" />

                </svg>

            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Total KK/PO
                </p>

                <p class="text-gray-800 font-semibold text-2xl">
                    {{ $totalKKPO }}
                </p>

                <p class="text-gray-400 text-xs">
                    Total Documents
                </p>
            </div>
        </div>

        {{-- TOTAL CUSTOMER --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">

            <div class="bg-[#136566] text-white rounded-full p-3 mr-4">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0
                        3.75 3.75 0 0 1 7.5 0ZM4.501
                        20.118a7.5 7.5 0 0 1 14.998
                        0A17.933 17.933 0 0 1 12
                        21c-2.676 0-5.216-.584-7.499-1.882Z" />

                </svg>

            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Active Customers
                </p>

                <p class="text-gray-800 font-semibold text-2xl">
                    {{ $totalCustomers }}
                </p>

                <p class="text-gray-400 text-xs">
                    Registered Customers
                </p>
            </div>
        </div>

        {{-- ONGOING --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">

            <div class="bg-yellow-500 text-white rounded-full p-3 mr-4">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 13.125C3 8.914
                        6.914 5 11.125 5h1.75C17.086
                        5 21 8.914 21 13.125V19a2
                        2 0 0 1-2 2H5a2 2 0 0
                        1-2-2v-5.875Z" />

                </svg>

            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Ongoing Production
                </p>

                <p class="text-gray-800 font-semibold text-2xl">
                    {{ $ongoingTravelers }}
                </p>

                <p class="text-gray-400 text-xs">
                    Travelers in Process
                </p>
            </div>
        </div>

        {{-- FINISHED --}}
        <div class="bg-white rounded-lg shadow p-4 flex items-center">

            <div class="bg-green-600 text-white rounded-full p-3 mr-4">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75 11.25 15
                        15 9.75m6 2.25a9 9 0
                        1 1-18 0 9 9 0 0 1
                        18 0Z" />

                </svg>

            </div>

            <div>
                <p class="text-gray-500 text-sm">
                    Finished Production
                </p>

                <p class="text-gray-800 font-semibold text-2xl">
                    {{ $finishedTravelers }}
                </p>

                <p class="text-gray-400 text-xs">
                    Completed Travelers
                </p>
            </div>
        </div>

    </div>

    {{-- CHART + PROGRESS --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-6">

        {{-- CHART --}}
        <div class="xl:col-span-2 bg-white rounded-lg shadow p-5">

            <div class="flex justify-between items-center mb-5">

                <h3 class="text-lg font-semibold text-gray-800">
                    Production Trend
                </h3>

                <span class="text-sm text-gray-400">
                    Monthly Production
                </span>

            </div>

            <canvas id="productionChart" height="100"></canvas>

        </div>

        {{-- PROGRESS --}}
        <div class="bg-white rounded-lg shadow p-5">

            <div class="flex justify-between items-center mb-2">

                <h3 class="text-lg font-semibold text-gray-800">
                    Production Progress
                </h3>

                <span class="text-[#136566] font-semibold">
                    {{ $finishedTravelers > 0
                        ? round(($finishedTravelers / $totalTravelers) * 100)
                        : 0 }}%
                </span>

            </div>

            <div class="w-full bg-gray-200 rounded-full h-3">

                <div class="bg-[#136566] h-3 rounded-full"
                    style="width:
                    {{ $finishedTravelers > 0
                        ? round(($finishedTravelers / $totalTravelers) * 100)
                        : 0 }}%">
                </div>

            </div>

            <div class="mt-6 space-y-4">

                <div class="flex justify-between items-center">

                    <span class="text-sm text-gray-500">
                        Finished
                    </span>

                    <span class="font-semibold text-green-600">
                        {{ $finishedTravelers }}
                    </span>

                </div>

                <div class="flex justify-between items-center">

                    <span class="text-sm text-gray-500">
                        Ongoing
                    </span>

                    <span class="font-semibold text-yellow-500">
                        {{ $ongoingTravelers }}
                    </span>

                </div>

                <div class="flex justify-between items-center">

                    <span class="text-sm text-gray-500">
                        Pending Qty
                    </span>

                    <span class="font-semibold text-red-500">
                        {{ number_format($pendingQty) }}
                    </span>

                </div>

            </div>

        </div>

    </div>

    {{-- RECENT ACTIVITY --}}
    <div class="bg-white rounded-lg shadow mt-6 mb-10">

        <div class="flex justify-between items-center p-4 border-b">

            <h3 class="text-lg font-semibold text-gray-800">
                Recent Production Activities
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-[#136566]/10 text-gray-700 uppercase text-[11px]">

                    <tr>

                        <th class="px-4 py-3 text-left">
                            Traveler
                        </th>

                        <th class="px-4 py-3 text-left">
                            Department
                        </th>

                        <th class="px-4 py-3 text-left">
                            Qty In
                        </th>

                        <th class="px-4 py-3 text-left">
                            Qty Out
                        </th>

                        <th class="px-4 py-3 text-left">
                            Date
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($recentMovements as $movement)

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3">
                                {{ $movement->traveler->no_traveler ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $movement->currentDepartment->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $movement->qty_in }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $movement->qty_out }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $movement->created_at->format('d M Y') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="text-center py-4 text-gray-500">

                                No Activities Found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        const ctx = document.getElementById('productionChart');

        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: @json($chartLabels),

                datasets: [{
                    label: 'Production Qty',
                    data: @json($chartData),
                    borderWidth: 1,
                    borderRadius: 8,
                }]
            },

            options: {

                responsive: true,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>

</x-app-layout>
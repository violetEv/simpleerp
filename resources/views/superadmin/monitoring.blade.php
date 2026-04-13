<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Monitoring
    </h2>
    {{-- Search & Filter--}}
    <div class="flex items-center justify-between mb-4 mt-4">
        <form action="{{ route('superadmin.monitoring') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="search" placeholder="Search monitoring..."
                class="border border-gray-300 rounded-lg px-4 py-2"
                value="{{ request('search') }}">
            <button type="submit"
                class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                Search
            </button>
        </form>
        <div class="flex items-center gap-2">
            <label for="filter" class="text-gray-700">Filter:</label>
            <select id="filter" name="filter"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All</option>
                <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="this_week" {{ request('filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                <option value="this_month" {{ request('filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
            </select>
        </div>
    </div>
    {{-- Table monitoring akan ditampilkan di sini --}}
    <div class="p-6 bg-white border-b border-gray-200">
        <p class="text-gray-500">Monitoring data will be displayed here.</p>
    </div>
    <table class="min-w-full divide-y divide-gray-200 mt-4">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO KKPO</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            {{-- @foreach ($monitoringData as $data) --}}
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">NO KKPO</td>
                    <td class="px-6 py-4 whitespace-nowrap"></td>
                    <td class="px-6 py-4 whitespace-nowrap"></td>
                </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>
</x-app-layout>
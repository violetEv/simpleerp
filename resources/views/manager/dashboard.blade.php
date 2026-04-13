<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manager Dashboard
    </h2>
    {{-- CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Employees</h3>
            <p class="text-3xl font-bold text-gray-900">171</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Projects</h3>
            <p class="text-3xl font-bold text-gray-900">24</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Pending Tasks</h3>
            <p class="text-3xl font-bold text-gray-900">12</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Completed Tasks</h3>
            <p class="text-3xl font-bold text-gray-900">8</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700">Overdue Tasks</h3>
            <p class="text-3xl font-bold text-gray-900">2</p>
        </div>
    </div>
    {{-- Table of recent activities --}}
    <div class="mt-8">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Recent Activities</h3>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">John Doe completed Task A</td>
                        <td class="px-6 py-4 whitespace-nowrap">2024-06-01</td>
                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Jane Smith started Task B</td>
                        <td class="px-6 py-4 whitespace-nowrap">2024-06-02</td>
                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">In Progress</span></td>
                    </tr>
                    <!-- More rows... -->
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>

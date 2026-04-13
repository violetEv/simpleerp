<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Super Admin Dashboard
    </h2>

    <!-- CARD TOTAL -->
    <div class="grid grid-cols-12 gap-6 mb-8">

        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="flex items-center gap-4 rounded-lg bg-white p-4 shadow">
                <div class="rounded-full bg-green-100 p-2 text-green-500">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $totalUsers }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="flex items-center gap-4 rounded-lg bg-white p-4 shadow">
                <div class="rounded-full bg-blue-100 p-2 text-blue-500">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Departments</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $totalDepartments }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="flex items-center gap-4 rounded-lg bg-white p-4 shadow">
                <div class="rounded-full bg-yellow-100 p-2 text-yellow-500">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Users</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $activeUsers }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="flex items-center gap-4 rounded-lg bg-white p-4 shadow">
                <div class="rounded-full bg-red-100 p-2 text-red-500">
                    <i class="fas fa-user-slash"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Inactive Users</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $inactiveUsers }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- RECENT ACTIVITY -->
    <div class="bg-white rounded-lg p-6 shadow">
        <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
        <ul class="divide-y divide-gray-200">
            <li class="flex items-center gap-4 py-3">
                <div class="rounded-full bg-gray-300 p-2 text-gray-500">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $recentActivity->user->name ?? 'Unknown User' }}</p>
                    <p class="text-sm text-gray-500">Added a new user</p>
                    <p class="text-xs text-gray-400">2 hours ago</p>
                </div>
            </li>
        </ul>
    </div>
</x-app-layout>
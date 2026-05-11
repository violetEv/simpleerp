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

    <!-- USER ACTIVITY -->
    <div class="bg-white rounded-lg pb-3 mb-10 shadow">
        <h2 class="text-xl font-semibold p-4">User Activity</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed text-gray-800">
                <thead
                    class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">

                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">User</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">Department</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider">Last Login</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    {{-- buat degan data controller spt @includeIf('        $recentActivities = TravelerMovement::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();', ['some' => 'data']) --}}
                    @foreach ($recentActivities as $activity)
                        <tr class="border-t">
                            {{-- menampilkan nama user, department, dan waktu login terakhir --}}
                            <td class="px-4 py-2">{{ $activity->user->name ?? 'Unknown User' }}</td>
                            <td class="px-4 py-2">{{ $activity->user->department->name ?? 'Unknown Department' }}</td>
                            <td class="px-4 py-2">{{ $activity->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

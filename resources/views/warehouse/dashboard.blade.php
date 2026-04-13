{{-- @extends('layouts.app')

@section('content') --}}
<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ auth()->user()->department_id ? auth()->user()->department->name : 'No Department' }} Dashboard</h2>

    {{-- CARD STATISTIC --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-500 text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 012-2h4a2 2 0 012 2v6m-3 0h3m-3 0H9m12 0a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h3m10 0h3m-3 0H9" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Total Orders</p>
                    <p class="text-xl font-bold">150</p>
                </div>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 012-2h4a2 2 0 012 2v6m-3 0h3m-3 0H9m12 0a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h3m10 0h3m-3 0H9" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Completed Orders</p>
                    <p class="text-xl font-bold">120</p>
                </div>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 012-2h4a2 2 0 012 2v6m-3 0h3m-3 0H9m12 0a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h3m10 0h3m-3 0H9" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Pending Orders</p>
                    <p class="text-xl font-bold">30</p>
                </div>
            </div>
        </div>
    </div>

    {{-- RECENT ACTIVITY --}}
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
        <div class="bg-white shadow rounded-lg p-4">
            <ul class="divide-y divide-gray-200">
                <li class="py-2 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Order #12345 was created.</p>
                        <p class="text-xs text-gray-400">2 hours ago</p>
                    </div>
                    <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Completed
                    </span>
                </li>
                <li class="py-2 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Order #12346 was created.</p>
                        <p class="text-xs text-gray-400">1 hour ago</p>
                    </div>
                    <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Processing
                    </span>
                </li>
            </ul>
        </div>
    </div>
    {{-- @endsection --}}
</x-app-layout>

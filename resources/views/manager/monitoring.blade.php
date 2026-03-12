@extends('layouts.app')

@section('content')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Monitoring
</h2>

{{-- Search & filter section --}}
<div class="flex items-center mt-4 space-x-4">
    <input type="text" placeholder="Search..." class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    <select class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">All Statuses</option>
        <option value="completed">Completed</option>
        <option value="in_progress">In Progress</option>
        <option value="overdue">Overdue</option>
    </select>
    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Filter</button>
</div>

{{-- Table of monitored items --}}
<div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">Task A</td>
                <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span></td>
                <td class="px-6 py-4 whitespace-nowrap">2024-06-01</td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">Task B</td>
                <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">In Progress</span></td>
                <td class="px-6 py-4 whitespace-nowrap">2024-06-02</td>
            </tr>
            <!-- More rows... -->
        </tbody>
    </table>
</div>

@endsection
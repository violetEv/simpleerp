@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Report
    </h2>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- SEARCH & FILTER SECTION --}}
            <div class="mb-4 flex items-center space-x-4">
                <input type="text" name="search" id="search" placeholder="Search by KKPO, Customer, Category, Style"
                    class="px-4 py-2 border rounded-lg w-full md:w-1/3">
                <select name="no_surat_jalan" id="no_surat_jalan" class="px-4 py-2 border rounded-lg">
                    <option value="">All Surat Jalan</option>
                    @foreach (App\Models\SuratJalan::pluck('no_surat_jalan')->unique() as $no_surat_jalan)
                        <option value="{{ $no_surat_jalan }}">{{ $no_surat_jalan }}</option>
                    @endforeach
                </select>
                <select name="kkpo" id="kkpo" class="px-4 py-2 border rounded-lg">
                    <option value="">All KKPO</option>
                    @foreach (App\Models\Kkpo::pluck('no_kkpo')->unique() as $no_kkpo)
                        <option value="{{ $no_kkpo }}">{{ $no_kkpo }}</option>
                    @endforeach
                </select>
                <select name="customer" id="customer" class="px-4 py-2 border rounded-lg">
                    <option value="">All Customers</option>
                    @foreach (App\Models\Customer::pluck('name')->unique() as $customer)
                        <option value="{{ $customer }}">{{ $customer }}</option>
                    @endforeach
                </select>
                <select name="style" id="style" class="px-4 py-2 border rounded-lg">
                    <option value="">All Styles</option>
                    @foreach (App\Models\Style::pluck('name')->unique() as $style)
                        <option value="{{ $style }}">{{ $style }}</option>
                    @endforeach
                </select>
                {{-- <select name="category_process" id="category_process" class="px-4 py-2 border rounded-lg">
                    <option value="">All Categories</option>
                    @foreach (App\Models\Category::all() as $category)
                        <option value="{{ $category->name }}">{{ ucfirst($category->name) }}</option>
                    @endforeach
                </select> --}}
                {{-- <select name="status" id="status" class="px-4 py-2 border rounded-lg">
                    <option value="">All Statuses</option>
                    <option value="done">Completed</option>
                    <option value="in_progress">In Progress</option>
                    <option value="overdue">Overdue</option>        
                </select> --}}
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Filter</button>
                <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg">Export</button>
            </div>

            {{-- Tabel report akan ditampilkan di sini setelah implementasi filter dan pencarian selesai. --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KKPO
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                                Surat
                                Jalan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category Process</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Style
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty
                                In
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty
                                Out
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Balance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Data report akan di-looping di sini dan hanya menampilkan satu data per kkpo --}}
                        @foreach ($movements as $movement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $movement->traveler->suratJalan->kkpoManagement->kkpo->no_kkpo ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $movement->traveler->suratJalan->no_surat_jalan ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $movement->traveler->suratJalan->kkpoManagement->customer->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $movement->traveler->suratJalan->kkpoManagement->category->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $movement->traveler->suratJalan->kkpoManagement->style->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $movement->qty_in }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $movement->qty_out }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $movement->balance }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('manager.detailreport', $movement->id) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded-lg">View Detail</a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="p-3">
                    {{ $movements->links() }}
                </div>
                {{-- Pagination akan ditampilkan di sini jika diperlukan --}}
                {{-- TABLE OF REPORTS --}}
                {{-- <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr> --}}
                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                                Traveler
                            </th> --}}
                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KKPO
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                                Surat
                                Jalan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category Process</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Style
                            </th> --}}
                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Current Department</th> --}}
                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($reports as $report)
                            <tr> --}}
                {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $report->traveler->no_traveler }}</td> --}}
                {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $report->traveler->kkpo ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $report->traveler->no_surat_jalan ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $report->traveler->customer ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $report->traveler->category_process ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $report->traveler->style ?? '-' }}</td> --}}
                {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $report->department->name ?? '-' }}</td> --}}
                {{-- <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($report->traveler->status == 'done')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                    @elseif ($report->traveler->status == 'in_progress')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">In
                                            Progress</span>
                                    @elseif ($report->traveler->status == 'overdue')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Overdue</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('manager.detailmonitoring', $report->id) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded-lg">View</a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-3">
                    {{ $reports->links() }}
                </div>
            </div> --}}
            </div>
        </div>
    </div>
@endsection

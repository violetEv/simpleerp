{{-- @extends('layouts.app')

@section('content') --}}
<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Surat Jalan IN
    </h2> --}}

    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            {{-- Search, filter section, button add order --}}
            <div class="bg-white shadow-sm rounded-lg mb-3 border border-gray-100 p-3">

                <div class="flex flex-wrap items-center justify-between gap-2">

                    {{-- LEFT GROUP --}}
                    <form action="{{ route('warehouse.suratjalan') }}" method="GET" class="flex items-center gap-2">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari surat jalan..."
                                class="h-9 pl-9 pr-3 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50] w-52">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="m21 21-4.35-4.35m1.85-5.65a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                            </svg>
                        </div>
                    </form>

                    {{-- RIGHT GROUP --}}
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-md p-1">

                        {{-- ADD --}}
                        <button onClick="openAddOrderModal()"
                            class="h-8 px-3 text-xs rounded bg-[#0f4f50] text-white hover:bg-[#136566] flex items-center gap-1 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Surat Jalan IN
                        </button>

                    </div>

                </div>
            </div>

            {{-- Table of orders --}}
            <div
                class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-visible">

                <table class="min-w-full table-fixed text-gray-800">

                    {{-- THEAD --}}
                    <thead
                        class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                No Surat Jalan IN</th>
                            {{-- <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                KKPO
                            </th> --}}
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                Category Process</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                Style</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                Color</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                Qty
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @if ($orders->count())
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $order->no_surat_jalan }}</td>
                                    {{-- <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->kkpoManagement->no_kkpo ?? '-' }}</td> --}}
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->kkpoManagement->customer->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->kkpoManagement->details->first()->style->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->kkpoManagement->details->first()->color->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->kkpoManagement->details->first()->category->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $order->qty }}</td>
                                        {{-- format tanggal 12 Maret 2024 --}}
                                        <td class="px-4 py-2 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}
                                    </td>
                                    {{-- <td class="px-4 py-2 whitespace-nowrap">
                                        @if ($order->status == 'open')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $order->status }}</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ $order->status }}</span>
                                        @endif
                                    </td> --}}
                                    {{-- <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->updated_at->format('Y-m-d') }}</td> --}}
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- <button onClick='openEditOrderModal(@json($order))'
                                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit</button> --}}
                                        <button onclick="openDetail(this)" title="Lihat Detail"
                                            data-kkpo="{{ $order->kkpoManagement->no_kkpo ?? '-' }}"
                                            data-customer="{{ $order->kkpoManagement->customer->name ?? '-' }}"
                                            data-sj="{{ $order->no_surat_jalan ?? '-' }}"
                                            data-qty="{{ $order->qty }}"
                                            data-style="{{ $order->kkpoManagement->details->first()->style->name ?? '-' }}"
                                            data-color="{{ $order->kkpoManagement->details->first()->color->name ?? '-' }}"
                                            data-category="{{ $order->kkpoManagement->details->first()->category->name ?? '-' }}"
                                            {{-- data-dept="{{ $order->deptTujuan->name ?? '-' }}" --}} data-tanggal="{{ $order->tanggal }}"
                                            data-status="{{ $order->status }}"
                                            data-notes="{{ $order->notes ?? '-' }}">

                                            {{-- icon detail --}}
                                            <svg class="w-6 h-6 text-blue-500 hover:text-blue-700" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>

                                        </button>
                                        <form action="{{ route('warehouse.suratjalan.delete', ['id' => $order->id]) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus order ini?')">
                                                {{-- Icon delete --}}
                                                <svg class="w-6 h-6 text-red-500 hover:text-red-700" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="px-4 py-2 whitespace-nowrap text-center text-gray-500">
                                    Surat Jalan tidak ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="p-3">
                    {{ $orders->links() }}
                </div>
            </div>

            @include('warehouse.partials.modal-add-edit-sj')

            @include('warehouse.partials.modal-detail-sj-in')

        </div>
    </div>

    {{-- @endsection --}}
</x-app-layout>

{{-- @extends('layouts.app')

@section('content') --}}
<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Surat Jalan IN
    </h2> --}}

    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            {{-- Search, filter section, button add order --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('warehouse.suratjalan') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari surat jalan..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Cari
                    </button>
                </form>

                <button onClick="openAddOrderModal()"
                    class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Tambah Surat Jalan IN
                </button>
            </div>

            {{-- Table of orders --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                <table class="min-w-full table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                No Surat Jalan IN</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                KKPO
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                Qty
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                Tanggal</th>
                            {{-- <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                Status</th> --}}
                            {{-- <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                Last Updated</th> --}}
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($orders->count())
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $order->no_surat_jalan }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->kkpoManagement->no_kkpo ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->kkpoManagement->customer->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $order->qty }}</td>

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- format tanggal 12 Maret 2024 --}}
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
                                            data-style="{{ $order->kkpoManagement->styles->first()->name ?? '-' }}"
                                            data-color="{{ $order->kkpoManagement->colors->first()->name ?? '-' }}"
                                            data-category="{{ $order->kkpoManagement->categories->first()->name ?? '-' }}"
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
                                <td colspan="6" class="px-4 py-2 whitespace-nowrap text-center text-gray-500">
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
            
            @include('warehouse.partials.modal-detail-sj')

        </div>
    </div>

    {{-- @endsection --}}
</x-app-layout>

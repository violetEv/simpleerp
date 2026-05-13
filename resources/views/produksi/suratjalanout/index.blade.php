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
                    <form action="{{ route('produksi.suratjalanout.index') }}" method="GET"
                        class="flex items-center gap-2">
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
                            Tambah Surat Jalan OUT
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
                                No Surat Jalan Out</th>
                            {{-- <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                KKPO
                            </th> --}}
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                Style</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                Color</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                KP</th>
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
                                        {{ $order->suratJalanIn->no_surat_jalan ?? '-' }} </td> --}}
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->suratJalanIn->kkpoManagement->customer->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->suratJalanIn->kkpoManagement->details->first()?->style?->name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->suratJalanIn->kkpoManagement->details->first()?->color?->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $order->suratJalanIn->kkpoManagement->kp_po ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $order->qty }}</td>

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- format tanggal 12 Maret 2024 --}}
                                        {{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="inline-block text-left relative" x-data="{ menu: false }">

                                            {{-- BUTTON --}}
                                            <button @click="menu = !menu"
                                                class="text-gray-400 hover:text-gray-600 transition">

                                                <svg class="h-5 w-5 pointer-events-none" fill="currentColor"
                                                    viewBox="0 0 20 20">

                                                    <path
                                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </button>

                                            {{-- DROPDOWN --}}
                                            <div x-show="menu" @click.outside="menu = false" x-transition x-cloak
                                                class="absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">

                                                {{-- DETAIL --}}
                                                <button onclick="openDetail(this)"
                                                    data-sj_out="{{ $order->no_surat_jalan ?? '-' }}"
                                                    data-customer="{{ $order->suratJalanIn->kkpoManagement->customer->name ?? '-' }}"
                                                    data-sj="{{ $order->no_surat_jalan ?? '-' }}"
                                                    data-qty="{{ $order->qty }}"
                                                    data-style="{{ $order->suratJalanIn->kkpoManagement->details->first()->style->name ?? '-' }}"
                                                    data-color="{{ $order->suratJalanIn->kkpoManagement->details->first()->color->name ?? '-' }}"
                                                    data-category="{{ $order->suratJalanIn->kkpoManagement->details->first()->category->name ?? '-' }}"
                                                    data-tanggal="{{ $order->tanggal }}"
                                                    data-status="{{ $order->status }}"
                                                    data-notes="{{ $order->notes ?? '-' }}"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition">

                                                    Detail
                                                </button>

                                                {{-- EDIT --}}
                                                <button type="button"
                                                    onclick='openEditModal(@json($order))'
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition">

                                                    Edit
                                                </button>

                                                {{-- DELETE --}}
                                                <form
                                                    action="{{ route('produksi.suratjalanout.delete', ['id' => $order->id]) }}"
                                                    method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">

                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
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
               <div class="flex items-center justify-between p-3">

                        <div class="text-sm text-gray-500">
                            Menampilkan {{ $orders->firstItem() }}
                            - {{ $orders->lastItem() }}
                            dari {{ $orders->total() }} hasil
                        </div>

                        <div class="text-sm">
                            {{ $orders->links() }}
                        </div>

                    </div>
            </div>

            @include('produksi.suratjalanout.partials.modal-add-edit-sj-out')

            @include('produksi.suratjalanout.partials.modal-detail-sj')

        </div>
    </div>

    {{-- @endsection --}}
</x-app-layout>

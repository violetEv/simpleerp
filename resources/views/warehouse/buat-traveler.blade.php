{{-- @extends('layouts.app')

@section('content') --}}
<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Split Traveler
    </h2> --}}
    {{-- deskripsi halaman --}}
    <p class="text-sm text-gray-500 mb-4">
        Halaman ini digunakan untuk membuat traveler dari surat jalan yang sudah ada. Pastikan untuk mengisi data dengan
        benar.
        {{-- karena data yang sudah diinput tidak dapat diubah. --}}
    </p>
    <div class="py-4">
        <div class="max-w-7xl mx-auto">

            {{-- SEARCH --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('warehouse.create-traveler') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari surat jalan..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Cari
                    </button>
                </form>
            </div>

            {{-- TABLE --}}
            {{-- <div class="bg-white shadow rounded-lg p-6"> --}}
            {{-- TAB NAVIGATION --}}
            {{-- <div class="overflow-x-auto"> --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-6">
                <div class="border-b border-gray-200 pb-2">
                    <nav class="flex space-x-4">

                        <button onclick="switchTab('baru')" id="tab-baru"
                            class="tab-btn px-4 py-2 text-sm font-medium transition-all duration-200 border-b-2 border-[#136566] text-[#136566]">
                            Traveler Baru
                        </button>

                        <button onclick="switchTab('rework')" id="tab-rework"
                            class="tab-btn px-4 py-2 text-sm font-medium transition-all duration-200 text-gray-500 border-b-2 border-transparent hover:text-gray-700">
                            Traveler Rework
                        </button>

                    </nav>
                </div>

                <div id="tab-content-baru">
                    <div
                        class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-visible">

                        <table class="min-w-full table-fixed text-gray-800">

                            {{-- THEAD --}}
                            <thead
                                class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        No Surat Jalan
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Customer
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Category Process
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Style
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Color
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Qty Awal
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold ppercase">
                                        Qty Sisa
                                    </th>

                                    {{-- <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Status
                                </th> --}}

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                @if ($pecahTravelers->count())
                                    @foreach ($pecahTravelers as $pecahTraveler)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $pecahTraveler->no_surat_jalan }}
                                            </td>

                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $pecahTraveler->kkpo->customer->name ?? '-' }}
                                            </td>

                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $pecahTraveler->kkpo->details->first()->category->name ?? '-' }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $pecahTraveler->kkpo->details->first()->style->name ?? '-' }}
                                            </td>

                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $pecahTraveler->kkpo->details->first()->color->name ?? '-' }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $pecahTraveler->qty }}
                                            </td>

                                            @php
                                                $sisaQty = $pecahTraveler->qty - $pecahTraveler->travelers->sum('qty');
                                            @endphp

                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $sisaQty }}
                                            </td>

                                            {{-- <td class="px-4 py-2 whitespace-nowrap">
                                            @if ($sisaQty <= 0)
                                                <span
                                                    class="px-2 bg-red-100 text-red-800 rounded-full text-xs leading-5 font-semibold inline-flex">
                                                    Closed
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Open
                                                </span>
                                            @endif --}}
                                            {{-- {{ $pecahTraveler->status ?? '-' }} --}}
                                            {{-- </td> --}}
                                            <td class="px-4 py-2 whitespace-nowrap">

                                                @if ($sisaQty <= 0)
                                                    <button disabled
                                                        class="px-2 py-1 bg-gray-400 text-white rounded-lg cursor-not-allowed">
                                                        {{-- ikon cut dengan text "split traveler" disamping icon --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m7.848 8.25 1.536.887M7.848 8.25a3 3 0 1 1-5.196-3 3 3 0 0 1 5.196 3Zm1.536.887a2.165 2.165 0 0 1 1.083 1.839c.005.351.054.695.14 1.024M9.384 9.137l2.077 1.199M7.848 15.75l1.536-.887m-1.536.887a3 3 0 1 1-5.196 3 3 3 0 0 1 5.196-3Zm1.536-.887a2.165 2.165 0 0 0 1.083-1.838c.005-.352.054-.695.14-1.025m-1.223 2.863 2.077-1.199m0-3.328a4.323 4.323 0 0 1 2.068-1.379l5.325-1.628a4.5 4.5 0 0 1 2.48-.044l.803.215-7.794 4.5m-2.882-1.664A4.33 4.33 0 0 0 10.607 12m3.736 0 7.794 4.5-.802.215a4.5 4.5 0 0 1-2.48-.043l-5.326-1.629a4.324 4.324 0 0 1-2.068-1.379M14.343 12l-2.882 1.664" />
                                                        </svg>
                                                        Buat Traveler
                                                    </button>
                                                @else
                                                    <button onclick="openSplitTraveler(this)"
                                                        data-id="{{ $pecahTraveler->id }}"
                                                        data-surat="{{ $pecahTraveler->no_surat_jalan }}"
                                                        data-qty_awal="{{ $pecahTraveler->qty }}"
                                                        data-qty_sisa="{{ $sisaQty }}"
                                                        class="px-2 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">

                                                        Buat Traveler

                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="px-4 py-2 text-center text-gray-500">
                                            Nomor Surat Jalan Tidak Ditemukan.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>

                        {{-- Pagination --}}
                        <div class="p-3">
                            {{ $pecahTravelers->links() }}
                        </div>
                    </div>

                    {{-- </div> --}}
                </div>

                {{-- table rework --}}
                <div id="tab-content-rework" class="hidden">

                    <div
                        class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-visible">

                        <table class="min-w-full table-fixed text-gray-800">

                            <thead
                                class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        No Traveler
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Customer
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Category Process
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Style
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Color
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Status
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Qty Rework
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Departemen Asal
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Aksi
                                    </th>

                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">

                                @forelse($reworkTravelers as $traveler)
                                    @php

                                        $totalDiproses = $traveler->traveler->childTravelers->sum('qty');

                                        $sisaRework = $traveler->qty_reject - $totalDiproses;
                                    @endphp

                                    <tr>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->traveler->no_traveler ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $pecahTraveler->kkpo->customer->name ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $pecahTraveler->kkpo->details->first()->category->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $pecahTraveler->kkpo->details->first()->style->name ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $pecahTraveler->kkpo->details->first()->color->name ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                                Rework
                                            </span>
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sisaRework }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->latestMovement->deptAsal->name ?? '-' }}
                                        </td>

                                        {{-- <td class="px-4 py-2 whitespace-nowrap">
                                                {{-- disamping input no traveler turunan, muncul no traveler asal dengan tambahan suffix -A (contoh: TRV-001-A) --}}
                                        {{-- <span class="text-gray-500 text-sm">
                                                {{ $traveler->traveler->no_traveler ?? '-' }}
                                            </span>  --}}
                                        {{-- <input type="text" name="no_traveler_turunan" id="no_trav_turunan"
                                                    placeholder="-A" required
                                                    class="border border-gray-300 rounded-lg px-2 py-1 w-full bg-gray-100 text-sm text-center">

                                                {{-- <input type="text" name="no_traveler_turunan" id="no_trav_turunan" placeholder="-A" required
                                                class="border border-gray-300 rounded-lg px-2 py-1 w-full bg-gray-100 text-sm text-center"> 
                                            </td>

                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <select name="dept_tujuan_id" required
                                                    class="mt-1 block w-full border border-gray-300 rounded-md">

                                                    <option value="">Pilih Departemen</option>

                                                    @foreach (App\Models\Departments::all() as $departemen)
                                                        <option value="{{ $departemen->id }}">
                                                            {{ $departemen->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                {{-- {{ $traveler->deptTujuan->name ?? '-' }} 
                                            </td> --}}

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <button type="button" onclick="openReworkModal(this)"
                                                data-id="{{ $traveler->id }}"
                                                data-traveler="{{ $traveler->traveler->no_traveler }}"
                                                data-qty="{{ $sisaRework }}"
                                                class="px-2 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                                Buat Traveller Rework
                                            </button>

                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-center text-gray-500">
                                            Data Traveler Rework Tidak Ada.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>
                        {{-- pagination --}}
                        <div class="p-3">
                            {{ $reworkTravelers->links() }}
                        </div>

                    </div>

                </div>
            </div>

            {{-- Modal Pecah Traveler --}}
            <div id="addModal"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh] ">

                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modalTitle" class="text-lg font-medium">Buat Traveler</h3>

                        <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>

                    <form id="pecahTravelerForm" method="POST"
                        action="{{ route('warehouse.create-traveler.store') }}">

                        @csrf

                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="parent_traveler_id" id="parent_traveler_id">

                        <div class="mb-4">
                            <label for="pic" class="block text-gray-700">Nama PIC</label>
                            <input type="text" name="pic" id="pic" required
                                class="mt-1 block w-full border border-gray-300 rounded-md">
                        </div>

                        <div class="mb-4">

                            <label class="block text-sm font-medium text-gray-700">
                                Surat Jalan
                            </label>

                            <input type="text" id="surat_jalan_display" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md bg-gray-100">

                            <input type="hidden" name="surat_jalan_in_id" id="surat_jalan_in_id">

                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Qty Awal
                                </label>

                                <input type="number" name="qty_awal" id="qty_awal" readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Qty Sisa
                                </label>

                                <input type="number" name="qty_sisa" id="qty_sisa" readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md bg-gray-100">
                            </div>
                        </div>

                        <table class="w-full mb-4">
                            <thead>
                                <tr>
                                    <th class="text-left text-sm font-medium text-gray-700 pr-3 py-1">
                                        No Traveler
                                    </th>

                                    <th class="text-left text-sm font-medium text-gray-700 px-3 py-1">
                                        Qty Split
                                    </th>

                                    <th class="text-center text-sm font-medium text-gray-700 pr-3 py-1">
                                        Departemen Tujuan
                                    </th>

                                    <th class="text-center text-sm font-medium text-gray-700 w-10 pr-3 py-1">
                                        Tanggal Out
                                    </th>
                                    <th class="text-center text-sm font-medium text-gray-700 w-10 pr-3 py-1">
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="travelerBody">

                                <tr>
                                    <td class="pr-3">
                                        <input type="text" name="no_traveler[]" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md">
                                    </td>

                                    <td class="pr-3">
                                        <input type="number" name="qty_split[]" required min="0"
                                            class="mt-1 block w-full border border-gray-300 rounded-md qty-input"
                                            oninput="calculateTotal()">
                                    </td>

                                    <td class="pr-3">
                                        <select name="dept_tujuan_id[]" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md">

                                            <option value="">Pilih Departemen</option>

                                            @foreach (App\Models\Departments::all() as $departemen)
                                                <option value="{{ $departemen->id }}">
                                                    {{ $departemen->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </td>

                                    <td class="pr-3">
                                        <input type="date" id="tanggal" name="tanggal[]" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md">
                                    </td>

                                    <td class="text-center px-3 py-2">
                                        <button type="button" class="text-green-600 text-xl font-bold"
                                            onclick="addTableRow()">
                                            +
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <p id="qty-warning" class="text-red-500 text-sm mb-1 hidden">
                            Qty melebihi sisa qty yang tersedia.
                        </p>

                        {{-- <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Tanggal Out
                    </label>

                    <input type="date" name="tanggal" id="tanggal" required
                        class="mt-1 block w-full border border-gray-300 rounded-md">
                </div> --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">
                                Catatan
                            </label>

                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md"></textarea>
                        </div>

                        <div class="mt-3">
                            <button type="submit" id="submit-button"
                                onclick="return confirm('Apakah anda yakin ingin menyimpan data ini?')"
                                class="px-4 py-2 w-full bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                                Simpan Traveler
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        {{-- Modal Rework Traveler --}}
        <div id="reworkModal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">

            <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh]">

                {{-- HEADER --}}
                <div class="flex justify-between items-center mb-4">

                    <h3 id="reworkModalTitle" class="text-lg font-medium">
                        Buat Traveler Rework
                    </h3>

                    <button onclick="closeReworkModal()" class="text-gray-500 text-2xl hover:text-gray-700">

                        &times;

                    </button>
                </div>

                {{-- FORM --}}
                <form id="reworkForm" method="POST">

                    @csrf

                    {{-- INFO TRAVELER --}}
                    <div class="mb-4">

                        <div class="mb-4">
                            <label for="rework_pic" class="block text-gray-700">Nama PIC</label>
                            <input type="text" name="pic" id="rework_pic" required
                                class="mt-1 block w-full border border-gray-300 rounded-md">
                        </div>
                        <label class="block text-sm font-medium text-gray-700">
                            Traveler Asal
                        </label>

                        <input type="text" id="rework_traveler_display" readonly
                            class="mt-1 block w-full border border-gray-300 rounded-md bg-gray-100">

                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">

                        <div>

                            <label class="block text-sm font-medium text-gray-700">
                                Qty
                            </label>

                            <input type="number" id="rework_qty" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md bg-gray-100">

                        </div>

                        <div>

                            <label class="block text-sm font-medium text-gray-700">
                                Qty Sisa
                            </label>

                            <input type="number" id="rework_qty_sisa" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md bg-gray-100">

                        </div>

                    </div>

                    {{-- TABLE SPLIT --}}
                    <table class="w-full mb-4">

                        <thead>
                            <tr>

                                <th class="text-left text-sm font-medium text-gray-700 pr-3 py-1">
                                    Traveler Turunan
                                </th>

                                <th class="text-left text-sm font-medium text-gray-700 px-3 py-1">
                                    Qty Pecah
                                </th>

                                <th class="text-left text-sm font-medium text-gray-700 px-3 py-1">
                                    Departemen Tujuan
                                </th>

                                <th class="w-10"></th>

                            </tr>
                        </thead>

                        <tbody id="reworkBody">

                            <tr>

                                {{-- NO TRAVELER --}}
                                <td class="pr-3">

                                    <input type="text" name="no_traveler_turunan[]" required
                                        placeholder="Contoh: TRV-001-A"
                                        class="mt-1 block w-full border border-gray-300 rounded-md">

                                </td>

                                {{-- QTY --}}
                                <td class="pr-3">

                                    <input type="number" name="qty_split[]" required min="1"
                                        class="mt-1 block w-full border border-gray-300 rounded-md rework-qty-input"
                                        oninput="calculateReworkTotal()">

                                </td>

                                {{-- DEPARTEMEN --}}
                                <td class="pr-3">

                                    <select name="dept_tujuan_id[]" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md">

                                        <option value="">
                                            Pilih Departemen
                                        </option>
                                        @foreach (App\Models\Departments::all() as $departemen)
                                            <option value="{{ $departemen->id }}">
                                                {{ $departemen->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </td>

                                {{-- BUTTON --}}
                                <td class="text-center px-3 py-2">

                                    <button type="button" class="text-green-600 text-xl font-bold"
                                        onclick="addReworkRow()">

                                        +

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                    {{-- WARNING --}}
                    <p id="rework-warning" class="text-red-500 text-sm mb-2 hidden">

                        Qty pecah melebihi qty rework.

                    </p>

                    {{-- SUBMIT --}}
                    <div class="mt-3">

                        <button type="submit" id="rework-submit-button"
                            onclick="return confirm('Yakin ingin membuat traveler rework?')"
                            class="px-4 py-2 w-full bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">

                            Simpan Traveler Rework

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <script>
            function openSplitTraveler(btn) {

                document.getElementById('addModal').classList.remove('hidden');
                document.getElementById('addModal').classList.add('flex');

                document.getElementById('pecahTravelerForm').reset();

                let id = btn.dataset.id;
                let surat = btn.dataset.surat;
                let qtyAwal = parseInt(btn.dataset.qty_awal) || 0;
                let qtySisa = parseInt(btn.dataset.qty_sisa) || 0;

                document.getElementById('modalTitle').textContent =
                    'Buat Traveler - ' + surat;

                document.getElementById('surat_jalan_display').value = surat;

                document.getElementById('surat_jalan_in_id').value = id;

                // tampilkan qty asli
                document.getElementById('qty_awal').value = qtyAwal;

                // tampilkan qty sisa
                document.getElementById('qty_sisa').value = qtySisa;

                // simpan qty sisa awal untuk perhitungan
                document.getElementById('qty_sisa').dataset.original = qtySisa;

                calculateTotal();
            }

            function closeAddModal() {
                document.getElementById('addModal').classList.add('hidden');
                document.getElementById('addModal').classList.remove('flex');
            }

            function calculateTotal() {

                let qtySisaAwal = parseInt(
                    document.getElementById('qty_sisa').dataset.original
                ) || 0;

                let totalSplit = 0;

                document.querySelectorAll('.qty-input').forEach(input => {
                    totalSplit += parseInt(input.value) || 0;
                });

                let sisaSekarang = qtySisaAwal - totalSplit;

                let warning = document.getElementById('qty-warning');
                let submitButton = document.getElementById('submit-button');

                if (sisaSekarang < 0) {

                    warning.classList.remove('hidden');

                    submitButton.disabled = true;

                } else {

                    warning.classList.add('hidden');

                    submitButton.disabled = false;
                }

                // update tampilan qty sisa realtime
                document.getElementById('qty_sisa').value = sisaSekarang;
            }

            function addTableRow() {

                const tbody = document.getElementById('travelerBody');

                const row = document.createElement('tr');

                row.innerHTML = `
        <td class="pr-3">
            <input type="text" name="no_traveler[]" required
            class="mt-1 block w-full border border-gray-300 rounded-md">
        </td>

        <td class="pr-3">
            <input type="number" name="qty_split[]" 
            class="mt-1 block w-full border border-gray-300 rounded-md qty-input"
            oninput="calculateTotal()">
        </td>

        <td class="pr-3">
            <select name="dept_tujuan_id[]" required
                class="mt-1 block w-full border border-gray-300 rounded-md">

                <option value="">Select Departemen</option>

                @foreach (App\Models\Departments::all() as $departemen)
                    <option value="{{ $departemen->id }}">
                        {{ $departemen->name }}
                    </option>
                @endforeach

            </select>
        </td>

        <td class="pr-3">
            <input type="date" name="tanggal[]" required
            class="mt-1 block w-full border border-gray-300 rounded-md">
        </td>

        <td class="text-center">
            <button type="button"
            class="text-red-600 text-xl font-bold"
            onclick="removeRow(this)">
            -
            </button>
        </td>
    `;

                tbody.appendChild(row);
            }

            function removeRow(btn) {
                btn.closest('tr').remove();
                calculateTotal();
            }

            function switchTab(tab) {

                let tabBaru = document.getElementById('tab-content-baru');
                let tabRework = document.getElementById('tab-content-rework');

                let btnBaru = document.getElementById('tab-baru');
                let btnRework = document.getElementById('tab-rework');

                if (tab === 'baru') {

                    tabBaru.classList.remove('hidden');
                    tabRework.classList.add('hidden');

                    // ACTIVE
                    btnBaru.classList.add('border-[#136566]', 'text-[#136566]');
                    btnBaru.classList.remove('text-gray-500', 'border-transparent');

                    // INACTIVE
                    btnRework.classList.remove('border-[#136566]', 'text-[#136566]');
                    btnRework.classList.add('text-gray-500', 'border-transparent');

                } else {

                    tabBaru.classList.add('hidden');
                    tabRework.classList.remove('hidden');

                    // ACTIVE
                    btnRework.classList.add('border-[#136566]', 'text-[#136566]');
                    btnRework.classList.remove('text-gray-500', 'border-transparent');

                    // INACTIVE
                    btnBaru.classList.remove('border-[#136566]', 'text-[#136566]');
                    btnBaru.classList.add('text-gray-500', 'border-transparent');
                }
            }

            function openReworkModal(btn) {

                document.getElementById('reworkModal')
                    .classList.remove('hidden');

                document.getElementById('reworkModal')
                    .classList.add('flex');

                const id = btn.dataset.id;
                const traveler = btn.dataset.traveler;
                const qty = parseInt(btn.dataset.qty);

                document.getElementById('rework_traveler_display')
                    .value = traveler;

                document.getElementById('rework_qty')
                    .value = qty;

                document.getElementById('rework_qty_sisa')
                    .value = qty;

                document.getElementById('rework_qty_sisa')
                    .dataset.original = qty;

                document.getElementById('reworkForm')
                    .action = `/warehouse/rework/${id}/store`;

                calculateReworkTotal();
            }

            function closeReworkModal() {

                document.getElementById('reworkModal')
                    .classList.add('hidden');

                document.getElementById('reworkModal')
                    .classList.remove('flex');
            }

            function calculateReworkTotal() {

                let qtyAwal = parseInt(
                    document.getElementById('rework_qty_sisa')
                    .dataset.original
                ) || 0;

                let total = 0;

                document.querySelectorAll('.rework-qty-input')
                    .forEach(input => {

                        total += parseInt(input.value) || 0;
                    });

                let sisa = qtyAwal - total;

                document.getElementById('rework_qty_sisa')
                    .value = sisa;

                let warning =
                    document.getElementById('rework-warning');

                let submitBtn =
                    document.getElementById('rework-submit-button');

                if (sisa < 0) {

                    warning.classList.remove('hidden');

                    submitBtn.disabled = true;

                } else {

                    warning.classList.add('hidden');

                    submitBtn.disabled = false;
                }
            }

            function addReworkRow() {

                const tbody =
                    document.getElementById('reworkBody');

                const row = document.createElement('tr');

                row.innerHTML = `

            <td class="pr-3">

                <input type="text"
                    name="no_traveler_turunan[]"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded-md">

            </td>

            <td class="pr-3">

                <input type="number"
                    name="qty_split[]"
                    required
                    min="1"
                    class="mt-1 block w-full border border-gray-300 rounded-md rework-qty-input"
                    oninput="calculateReworkTotal()">

            </td>

            <td class="pr-3">

                <select name="dept_tujuan_id[]"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded-md">

                    <option value="">
                        Pilih Departemen
                    </option>

                    @foreach (App\Models\Departments::all() as $departemen)

                        <option value="{{ $departemen->id }}">
                            {{ $departemen->name }}
                        </option>

                    @endforeach

                </select>

            </td>

            <td class="text-center">

                <button type="button"
                    class="text-red-600 text-xl font-bold"
                    onclick="removeReworkRow(this)">

                    -

                </button>

            </td>
        `;

                tbody.appendChild(row);
            }

            function removeReworkRow(btn) {

                btn.closest('tr').remove();

                calculateReworkTotal();
            }

            //         function openReworkModal(btn) {

            //     const id = btn.dataset.id;
            //     const traveler = btn.dataset.traveler;
            //     const qty = btn.dataset.qty;

            //     document.getElementById('reworkModal')
            //         .classList.remove('hidden');

            //     document.getElementById('reworkModal')
            //         .classList.add('flex');

            //     document.getElementById('rework_traveler').value = traveler;

            //     document.getElementById('rework_qty').dataset.max = qty;

            //     document.getElementById('reworkForm').action =
            //         `/warehouse/rework/${id}/store`;
            // }

            // function closeReworkModal() {

            //     document.getElementById('reworkModal')
            //         .classList.add('hidden');

            //     document.getElementById('reworkModal')
            //         .classList.remove('flex');
            // }

            // function calculateReworkTotal() {

            //     let maxQty = parseInt(
            //         document.getElementById('rework_qty').dataset.max
            //     ) || 0;

            //     let total = 0;

            //     document.querySelectorAll('.rework-qty')
            //         .forEach(input => {

            //             total += parseInt(input.value) || 0;
            //         });

            //     if (total > maxQty) {

            //         alert('Qty melebihi qty rework');
            //     }
            // }
        </script>
        {{-- @endsection --}}
</x-app-layout>

<x-app-layout>

    <p class="text-sm text-gray-500 mb-4">
        Halaman ini digunakan untuk membuat traveler dari surat jalan yang sudah ada. Pastikan untuk mengisi data dengan
        benar.
    </p>
    <div class="py-4">
        <div class="max-w-7xl mx-auto">

            {{-- SEARCH --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('warehouse.pecah') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari surat jalan..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Cari
                    </button>
                </form>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden p-6">
                <div class="border-b border-gray-200 pb-2">
                    <nav class="flex space-x-4">

                        <button onclick="switchTab('baru')" id="tab-baru"
                            class="tab-btn px-4 py-2 text-sm font-medium transition-all duration-200 border-b-2 border-[#136566] text-[#136566]">
                            Traveler Baru
                        </button>

                        <button onclick="switchTab('rework')" id="tab-rework"
                            class="tab-btn px-4 py-2 text-sm font-medium transition-all duration-200 text-gray-500 border-b-2 border-transparent hover:text-gray-700">
                            Traveler Turunan
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

                        <div class="flex items-center justify-between p-3">

                            <div class="text-sm text-gray-500">
                                Menampilkan {{ $pecahTravelers->firstItem() }}
                                - {{ $pecahTravelers->lastItem() }}
                                dari {{ $pecahTravelers->total() }} hasil
                            </div>

                            <div class="text-sm">
                                {{ $pecahTravelers->links() }}
                            </div>

                        </div>
                    </div>
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

                                    {{-- <th class="px-4 py-2 text-left text-xs font-semibold uppercase">
                                        Status
                                    </th> --}}

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

                            <tbody class="bg-white divide-y divide-gray-200 text-sm">

                                @forelse($reworkTravelers as $traveler)
                                    @php

                                        $totalDiproses = $traveler->traveler->children->sum('qty');

                                        $sisaRework = $traveler->qty_reject - $totalDiproses;
                                    @endphp

                                    <tr>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->traveler->no_traveler ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->traveler->suratJalan->kkpo->customer->name ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->traveler->suratJalan->kkpo->details->first()->category->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->traveler->suratJalan->kkpo->details->first()->style->name ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->traveler->suratJalan->kkpo->details->first()->color->name ?? '-' }}
                                        </td>

                                        {{-- <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                                Rework
                                            </span>
                                        </td> --}}

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $sisaRework }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->deptAsal->name ?? '-' }}
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
                                                Buat Turunan
                                            </button>

                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="9" class="px-4 py-2 text-center text-gray-500">
                                            Data Traveler Rework Tidak Ada.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>
                        <div class="flex items-center justify-between p-3">

                            <div class="text-sm text-gray-500">
                                Menampilkan {{ $reworkTravelers->firstItem() }}
                                - {{ $reworkTravelers->lastItem() }}
                                dari {{ $reworkTravelers->total() }} hasil
                            </div>

                            <div class="text-sm">
                                {{ $reworkTravelers->links() }}
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

    {{-- Modal Pecah Traveler --}}
    @include('warehouse.modal-traveler-new')

    {{-- Modal Traveler Turunan --}}
    @include('warehouse.modal-traveler-turunan')


</x-app-layout>
<script>
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
</script>

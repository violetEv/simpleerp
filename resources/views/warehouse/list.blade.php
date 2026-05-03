{{-- @extends('layouts.app')

@section('content') --}}
<x-app-layout>

    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        List Traveler
    </h2> --}}

    {{-- @if (session('success'))
        <div class="mt-4">
            <x-alerts variant="success" title="Success" :message="session('success')" :showLink="false" />
        </div>
    @elseif (session('error'))
        <div class="mt-4">
            <x-alerts variant="danger" title="Error" :message="session('error')" :showLink="false" />
        </div>
    @endif --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- SEARCH --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('warehouse.list') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
            </div>
            {{-- TABLE --}}
            {{-- <div class="overflow-x-auto"> --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-6">
                <div class="border-b border-gray-200 mb-4">
                    <nav class="flex space-x-4">

                        <button onclick="switchTab('baru')" id="tab-baru"
                            class="tab-btn px-4 py-2 text-sm font-medium border-b-2 border-[#136566] text-[#136566]">
                            Traveler Baru
                        </button>

                        <button onclick="switchTab('rework')" id="tab-rework"
                            class="tab-btn px-4 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700">
                            Traveler Rework
                        </button>

                    </nav>
                </div>
                {{-- table baru --}}
                <div id="tab-content-baru">
                    <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                        <table class="min-w-full table-fixed">

                            <thead class="bg-gray-50">
                                <tr>
                                    {{-- <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th> --}}
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        No Traveler</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Surat
                                        Jalan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                        Out</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Departemen Tujuan
                                    </th>
                                    {{-- <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th> --}}
                                    {{-- <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th> --}}
                                    {{-- <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Notes</th> --}}
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi
                                    </th>
                                    {{-- <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Dari</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ke</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Notes</th> --}}
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($travelers->count())
                                    @foreach ($travelers as $traveler)
                                        <tr>
                                            {{-- <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $loop->iteration + ($travelers->currentPage() - 1) * $travelers->perPage() }}
                                            </td> --}}
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $traveler->no_traveler }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $traveler->suratJalan->no_surat_jalan ?? '-' }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $traveler->qty }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{-- format tanggal 12 Maret 2024 --}}
                                                {{ \Carbon\Carbon::parse($traveler->tanggal)->format('d F Y') ?? '-' }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $traveler->deptTujuan->name ?? '-' }}
                                            </td>
                                            {{-- <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $traveler->type ?? '-' }}
                                    </td> --}}
                                            {{-- <td class="px-4 py-2 whitespace-nowrap">{{ $traveler->status }}</td> --}}
                                            {{-- <td class="px-4 py-2 whitespace-nowrap">{{ $traveler->notes }}</td> --}}
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{-- <a href="{{ route('warehouse.list', $traveler->id) }}"
                                    class="text-green-500 border-sm hover:underline ml-2">+ Buat turunan</a> --}}
                                                <button onclick="openDetail(this)"
                                                    data-traveler="{{ $traveler->no_traveler ?? '-' }}"
                                                    data-customer="{{ $traveler->suratJalan->kkpoManagement->customer->name ?? '-' }}"
                                                    data-sj="{{ $traveler->suratJalan->no_surat_jalan ?? '-' }}"
                                                    data-qty="{{ $traveler->qty }}"
                                                    data-style="{{ $traveler->suratJalan->kkpoManagement->style->name ?? '-' }}"
                                                    data-color="{{ $traveler->suratJalan->kkpoManagement->color->name ?? '-' }}"
                                                    data-category="{{ $traveler->suratJalan->kkpoManagement->category->name ?? '-' }}"
                                                    {{-- data-dept="{{ $traveler->deptTujuan->name ?? '-' }}" --}} data-tanggal="{{ $traveler->tanggal }}"
                                                    {{-- data-status="{{ $traveler->status }}" --}} data-notes="{{ $traveler->notes ?? '-' }}"
                                                    class="text-blue-500 border border-blue-500 rounded-xl py-1 px-4 hover:bg-blue-50">

                                                    Detail
                                                </button>
                                                {{-- edit --}}
                                                <button onClick='openEditOrderModal(@json($traveler))' title="Edit"
                                                    class="px-4 py-2 text-blue-500 rounded-lg hover:text-blue-700 ml-2">
                                                    {{-- icon edit outline --}}
                                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18.375 19.5L17.25 18.375" />
                                                    </svg>
                                                </button>
                                                {{-- delete --}}
                                                {{-- <form
                                                    action="{{ route('warehouse.list.delete', ['id' => $traveler->id]) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus traveler ini?')">
                                                      
                                                        <svg class="w-6 h-6 text-red-500 hover:text-red-700"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                        </svg>
                                                    </button>
                                                </form> --}}
                                                {{-- <a href="{{ route('warehouse.list', $traveler->id) }}"
                                            class="text-blue-500 border border-blue-500 rounded-xl py-1 px-4 hover:underline">Detail</a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-center text-gray-500">
                                            Data Traveler Baru Tidak Ada.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{-- PAGINATION --}}
                        <div class="p-4">
                            {{ $travelers->links() }}
                        </div>
                    </div>
                </div>
                {{-- table rework --}}
                <div id="tab-content-rework" class="hidden">

                    <div class="bg-white shadow rounded-lg overflow-hidden p-2">

                        <table class="min-w-full table-fixed">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        No Traveler
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Departemen Asal
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Qty Rework
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Status
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        No Turunan
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Departemen Tujuan
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Aksi
                                    </th>

                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">

                                @forelse($reworkTravelers as $traveler)
                                    <tr>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->traveler->no_traveler ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->deptAsal->name ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $traveler->qty_reject }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                                Rework
                                            </span>
                                        </td>
                                        <form action="{{ route('warehouse.rework.store', $traveler->id) }}"
                                            method="POST">
                                            @csrf
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{-- disamping input no traveler turunan, muncul no traveler asal dengan tambahan suffix -A (contoh: TRV-001-A) --}}
                                                {{-- <span class="text-gray-500 text-sm">
                                                {{ $traveler->traveler->no_traveler ?? '-' }}
                                            </span>  --}}
                                                <input type="text" name="no_traveler_turunan" id="no_trav_turunan"
                                                    placeholder="-A" required
                                                    class="border border-gray-300 rounded-lg px-2 py-1 w-full bg-gray-100 text-sm text-center">

                                                {{-- <input type="text" name="no_traveler_turunan" id="no_trav_turunan" placeholder="-A" required
                                                class="border border-gray-300 rounded-lg px-2 py-1 w-full bg-gray-100 text-sm text-center"> --}}
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
                                                {{-- {{ $traveler->deptTujuan->name ?? '-' }} --}}
                                            </td>

                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <button type="submit"
                                                    class="px-2 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                                    Terbitkan
                                                </button>
                                            </td>
                                        </form>
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
            {{-- Modal Detail --}}
            <div id="detail-modal"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh] ">

                    {{-- HEADER --}}
                    <div class="flex justify-between items-center mb-4 border-b pb-3">
                        <h3 class="text-lg font-semibold text-gray-700">
                            Detail Traveler
                        </h3>

                        <button onclick="closeDetail()" class="text-gray-400 hover:text-gray-600 text-2xl">
                            &times;
                        </button>
                    </div>


                    {{-- ORDER ID + STATUS --}}
                    <div class="grid grid-cols-2 gap-7-3 text-sm mb-6">

                        <div>
                            <p class="text-gray-400 text-sm">No Traveler</p>
                            <p id="detail_traveler" class="font-semibold"></p>
                        </div>

                        <div>
                            {{-- <p class="text-gray-400 text-sm">Status</p>
                            <span id="detail_status" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                            </span> --}}
                        </div>

                    </div>


                    {{-- DETAIL --}}
                    <div class="grid grid-cols-2 gap-y-3 text-sm">

                        {{-- <span class="text-gray-500">NO Traveler</span>
                        <span id="detail_traveler"></span> --}}

                        <span class="text-gray-500">No Surat Jalan</span>
                        <span id="detail_sj"></span>

                        <span class="text-gray-500">Customer</span>
                        <span id="detail_customer"></span>

                        <span class="text-gray-500">Category Process</span>
                        <span id="detail_category"></span>

                        <span class="text-gray-500">Style</span>
                        <span id="detail_style"></span>

                        <span class="text-gray-500">Color</span>
                        <span id="detail_color"></span>

                        <span class="text-gray-500">Qty</span>
                        <span id="detail_qty"></span>

                        {{-- <span class="text-gray-500">Dept Tujuan</span>
                        <span id="detail_dept"></span> --}}

                        <span class="text-gray-500">Tanggal</span>
                        <span id="detail_tanggal"></span>

                        <span class="text-gray-500">Notes</span>
                        <span id="detail_notes"></span>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        const travelerData = @json($travelers->items());

        function openDetail(btn) {
            document.getElementById('detail-modal').classList.remove('hidden');
            document.getElementById('detail-modal').classList.add('flex');

            document.getElementById('detail_traveler').innerText = btn.dataset.traveler;
            document.getElementById('detail_customer').innerText = btn.dataset.customer;
            document.getElementById('detail_sj').innerText = btn.dataset.sj;
            document.getElementById('detail_qty').innerText = btn.dataset.qty;
            document.getElementById('detail_style').innerText = btn.dataset.style;
            document.getElementById('detail_color').innerText = btn.dataset.color;
            document.getElementById('detail_category').innerText = btn.dataset.category;
            // document.getElementById('detail_dept').innerText = btn.dataset.dept;
            // format tanggal 12 Maret 2024
            const tanggal = new Date(btn.dataset.tanggal);
            const options = {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            };
            document.getElementById('detail_tanggal').innerText = tanggal.toLocaleDateString('id-ID', options);
            // document.getElementById('detail_status').innerText = btn.dataset.status;
            document.getElementById('detail_notes').innerText = btn.dataset.notes;
        }

        function closeDetail() {
            document.getElementById('detail-modal').classList.add('hidden');
            document.getElementById('detail-modal').classList.remove('flex');
        }

        function switchTab(tab) {

            let tabBaru = document.getElementById('tab-content-baru');
            let tabRework = document.getElementById('tab-content-rework');

            let btnBaru = document.getElementById('tab-baru');
            let btnRework = document.getElementById('tab-rework');

            if (tab === 'baru') {

                tabBaru.classList.remove('hidden');
                tabRework.classList.add('hidden');

                btnBaru.classList.add('border-[#136566]', 'text-[#136566]');
                btnBaru.classList.remove('text-gray-500');

                btnRework.classList.remove('border-[#136566]', 'text-[#136566]');
                btnRework.classList.add('text-gray-500');

            } else {

                tabBaru.classList.add('hidden');
                tabRework.classList.remove('hidden');

                btnRework.classList.add('border-[#136566]', 'text-[#136566]');
                btnRework.classList.remove('text-gray-500');

                btnBaru.classList.remove('border-[#136566]', 'text-[#136566]');
                btnBaru.classList.add('text-gray-500');
            }

        }
    </script>

    {{-- @endsection --}}
</x-app-layout>

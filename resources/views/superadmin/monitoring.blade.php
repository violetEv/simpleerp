<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-4">
                <h2 class="text-xl font-semibold mb-4">
                    Monitoring WIP Traveler
                </h2>

                <div class="overflow-auto">
                    <table class="min-w-full text-sm border">

                        {{-- HEADER --}}
                        <thead class="bg-gray-100 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-2 text-left">Traveler</th>

                                @php
                                    $departments = [
                                        'Warehouse Bongkar',
                                        'QC Before',
                                        'Dry Process',
                                        'Washing',
                                        'Dyeing',
                                        'Dryer',
                                        'QC After',
                                        'Warehouse Packing',
                                        'Warehouse Folding',
                                        'Warehouse Send',
                                    ];
                                @endphp

                                @foreach ($departments as $dept)
                                    <th class="px-3 py-2 text-center">
                                        {{ ucwords(str_replace('_', ' ', $dept)) }}
                                    </th>
                                @endforeach
                                <th class="px-4 py-2 text-center">WIP</th>
                                <th class="px-4 py-2 text-center">Detail</th>
                            </tr>
                            {{-- 🔥 SUB HEADER PENJELAS --}}
                            <tr class="bg-gray-50 text-[10px] text-gray-500">
                                <th></th>

                                @foreach ($departments as $dept)
                                    <th class="text-center">
                                        Tgl<br>Qty
                                    </th>
                                @endforeach

                                <th class="text-center">Sisa</th>
                                <th>
                                    </t </thead>

                                    {{-- BODY --}}
                        <tbody>
                            @forelse ($data as $row)
                                <tr class="border-t hover:bg-gray-50">

                                    {{-- TRAVELER --}}
                                    <td class="px-4 py-3 bg-[#136566]/5 border-r">
                                        <div class="font-semibold text-[#0f4f50]">
                                            {{ $row['traveler']->no_traveler ?? '-' }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ $row['traveler']->suratJalan->no_surat_jalan ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- DEPARTMENTS --}}
                                    @foreach ($departments as $dept)
                                        @php
                                            $cell = $row['departments'][$dept] ?? null;
                                            $isCurrent = $row['current_dept'] === $dept;
                                        @endphp

                                        <td
                                            class="px-3 py-2 text-center text-xs
            {{ $isCurrent ? 'bg-yellow-100 font-semibold' : '' }}">

                                            @if ($cell)
                                                <div>
                                                    {{ \Carbon\Carbon::parse($cell['tanggal'])->format('d/m') }}
                                                </div>

                                                <div class="text-green-600 text-[10px]">
                                                    IN: {{ $cell['qty_in'] }}
                                                </div>

                                                <div class="text-red-500 text-[10px]">
                                                    OUT: {{ $cell['qty_out'] }}
                                                </div>
                                            @else
                                                -
                                            @endif

                                        </td>
                                    @endforeach

                                    <td class="px-4 py-2 text-center">
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold {{ $row['wip'] > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $row['wip'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('ppic.report.show', $row['traveler']->id) }}"
                                            class="text-blue-500 hover:underline">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center py-6 text-gray-500">
                                        Tidak ada data monitoring
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

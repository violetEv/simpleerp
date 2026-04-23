<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Log
    </h2> --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- TABLE --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                <table class="min-w-full table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                                Traveler</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal In</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Qty In</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Out</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Qty Out</th>
                            @if (in_array($dept, ['QC Before', 'QC After']))
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Qty Rework</th>
                            @endif
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Departemen Tujuan</th>
                            @if (in_array($dept, ['Dyeing', 'Washing']))
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mesin</th>
                            @endif
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($movements->count())
                            @foreach ($movements as $movement)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $movement->traveler->no_traveler }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($movement->date_in)->format('d F Y') }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $movement->qty_in }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($movement->date_out)->format('d F Y') }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $movement->qty_out }}</td>
                                    @if (in_array($dept, ['QC Before', 'QC After']))
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $movement->qty_reject }}</td>
                                    @endif
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- jika belum mengisi qty out dan departemen tujuan, tampilkan tanda strip (-) --}}
                                        @if (!$movement->date_out || !$movement->deptTujuan)
                                            -
                                        @else
                                            {{ $movement->deptTujuan->name ?? '-' }}
                                        @endif
                                    </td>
                                    {{-- untuk departmen washing dan dyeing saja, muncul kolom machine --}}
                                    @if (in_array($dept, ['Dyeing', 'Washing']))
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $movement->machine->name ?? '-' }}</td>
                                    @endif
                                    <td class="px-4 py-2 whitespace-nowrap">

                                        @if ($movement->status_case == 'selisih')
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                                Selisih
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                                Normal
                                            </span>
                                        @endif

                                        {{-- @if ($movement->traveler->status == 'open')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Open
                                            </span>
                                        @elseif ($movement->traveler->status == 'in_progress')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                In Progress
                                            </span>
                                        @elseif ($movement->traveler->status == 'done')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Done
                                            </span>
                                        @endif --}}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <a href="{{ route('produksi.logdetail', $movement->id) }}"
                                            class="text-blue-600 hover:text-blue-900">View Log</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="px-4 py-2 whitespace-nowrap text-gray-500 text-center">
                                    Traveler tidak ditemukan.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="p-3">
                    {{ $movements->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

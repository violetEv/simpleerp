<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto">

            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                <table class="min-w-full table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No Traveler</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal In</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qty In</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Out</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qty Out</th>

                            @if (in_array($dept, ['QC Before', 'QC After']))
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qty Reject
                                </th>
                            @endif

                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Departemen
                                Tujuan</th>

                            @if (in_array($dept, ['Dyeing', 'Washing']))
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mesin</th>
                            @endif

                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse ($movements as $movement)
                            {{-- ROW HIGHLIGHT --}}
                            <tr
                                class="{{ ($movement->qty_loss ?? 0) > 0
                                    ? 'bg-red-100'
                                    : (($movement->qty_reject ?? 0) > 0
                                        ? 'bg-yellow-100'
                                        : 'bg-white') }}">
                                {{-- NO TRAVELER --}}
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $movement->traveler->no_traveler }}
                                </td>

                                {{-- DATE IN --}}
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($movement->date_in)->format('d F Y') }}
                                </td>

                                {{-- QTY IN --}}
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $movement->qty_in }}

                                    {{-- STATUS
                                    @if ($movement->status_case === 'discrepancy')
                                        <span class="px-2 py-1 bg-red-500 text-white rounded text-xs ml-2">
                                            Selisih
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-green-500 text-white rounded text-xs ml-2">
                                            Normal
                                        </span>
                                    @endif --}}

                                    {{-- LOSS INFO --}}
                                    @if ($movement->qty_loss > 0)
                                        <div class="text-xs text-red-700 font-semibold mt-1">
                                            Loss: {{ $movement->qty_loss }}
                                        </div>
                                    @endif
                                </td>

                                {{-- DATE OUT --}}
                                <td class="px-4 py-2 whitespace-nowrap">
                                    @if ($movement->date_out)
                                        {{ \Carbon\Carbon::parse($movement->date_out)->format('d F Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- QTY OUT --}}
                                <td
                                    class="px-4 py-2 whitespace-nowrap 
                                {{ $movement->qty_loss > 0 ? 'text-red-600 font-bold' : '' }}">
                                    {{ $movement->qty_out ?? '-' }}
                                </td>

                                {{-- QC FIELD --}}
                                @if (in_array($dept, ['QC Before', 'QC After']))
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $movement->qty_reject ?? 0 }}
                                    </td>
                                @endif

                                {{-- DESTINATION --}}
                                <td class="px-4 py-2 whitespace-nowrap">
                                    @if (!$movement->date_out || !$movement->deptTujuan)
                                        -
                                    @else
                                        {{ $movement->deptTujuan->name }}
                                    @endif
                                </td>

                                {{-- MACHINE --}}
                                @if (in_array($dept, ['Dyeing', 'Washing']))
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $movement->machine->name ?? '-' }}
                                    </td>
                                @endif

                                {{-- ACTION --}}
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <a href="{{ route('produksi.logdetail', $movement->id) }}"
                                        class="text-blue-600 hover:text-blue-900 font-medium">
                                        View Log
                                    </a>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-3 text-center text-gray-500">
                                    Data log belum tersedia.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

                {{-- PAGINATION --}}
                <div class="p-3">
                    {{ $movements->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

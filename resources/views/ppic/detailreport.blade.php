<x-app-layout>

    {{-- HEADER --}}
    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Report</h3>

        <div class="grid grid-cols-2 gap-y-3 text-sm">
            @php
                $kkpo = $sj->kkpoManagement->first();
            @endphp
            <span class="text-gray-500">No Surat Jalan</span>
            <span>{{ $sj->no_surat_jalan }}</span>

            <span class="text-gray-500">KKPO</span>
            <span>{{ $kkpo->no_kkpo ?? '-' }}</span>

            <span class="text-gray-500">Customer</span>
            <span>{{ $kkpo->customer->name ?? '-' }}</span>

            <span class="text-gray-500">Item</span>
            <span>{{ $kkpo->item->name ?? '-' }}</span>

            <span class="text-gray-500">Category</span>
            <span>{{ $kkpo->category->name ?? '-' }}</span>

            <span class="text-gray-500">Style</span>
            <span>{{ $kkpo->style->name ?? '-' }}</span>

            <span class="text-gray-500">Color</span>
            <span>{{ $kkpo->color->name ?? '-' }}</span>

            <span class="text-gray-500">Brand</span>
            <span>{{ $kkpo->brand->name ?? '-' }}</span>

            <span class="text-gray-500">Unit</span>
            <span>{{ $kkpo->unit->name ?? '-' }}</span>

        </div>
    </div>

    {{-- TABLE MOVEMENT --}}
    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Movement History</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-2 px-4 border-b text-left text-sm text-gray-500">Traveler</th>
                        <th class="py-2 px-4 border-b text-left text-sm text-gray-500">Department</th>
                        <th class="py-2 px-4 border-b text-left text-sm text-gray-500">Qty In</th>
                        <th class="py-2 px-4 border-b text-left text-sm text-gray-500">Qty Out</th>
                        <th class="py-2 px-4 border-b text-left text-sm text-gray-500">Balance</th>
                        <th class="py-2 px-4 border-b text-left text-sm text-gray-500">Status</th>
                        <th class="py-2 px-4 border-b text-left text-sm text-gray-500">Tanggal In</th>
                        <th class="py-2 px-4 border-b text-left text-sm text-gray-500">Tanggal Out</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $grandIn = 0;
                        $grandOut = 0;
                        $grandBalance = 0;
                    @endphp

                    @foreach ($sj->travelers as $t)
                        {{-- HEADER TRAVELER --}}
                        <tr class="bg-gray-100">
                            <td colspan="8" class="px-4 py-2 font-semibold">
                                Traveler: {{ $t->no_traveler }}
                            </td>
                        </tr>

                        @foreach ($t->movements as $mov)
                            @php
                                $grandIn += $mov->qty_in;
                                $grandOut += $mov->qty_out;
                                $grandBalance += $mov->balance;
                            @endphp

                            <tr>
                                <td class="py-2 px-4 border-b">{{ $t->no_traveler }}</td>
                                <td class="py-2 px-4 border-b">{{ $mov->currentDepartment->name ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $mov->qty_in }}</td>
                                <td class="py-2 px-4 border-b">{{ $mov->qty_out }}</td>
                                <td class="py-2 px-4 border-b">{{ $mov->balance }}</td>

                                <td class="py-2 px-4 border-b">
                                    @if ($t->status == 'in_progress')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 rounded text-xs">
                                            In Progress
                                        </span>
                                    @else
                                        <span class="bg-green-100 text-green-800 px-2 rounded text-xs">
                                            Done
                                        </span>
                                    @endif
                                </td>

                                <td class="py-2 px-4 border-b">{{ $mov->date_in }}</td>
                                <td class="py-2 px-4 border-b">{{ $mov->date_out }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>

                {{-- TOTAL --}}
                <tfoot class="bg-gray-50 font-semibold">
                    <tr>
                        <td colspan="2" class="px-4 py-2 text-right">TOTAL</td>
                        <td class="px-4 py-2">{{ $grandIn }}</td>
                        <td class="px-4 py-2">{{ $grandOut }}</td>
                        <td class="px-4 py-2">{{ $grandBalance }}</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>

</x-app-layout>

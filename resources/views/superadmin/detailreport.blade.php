<x-app-layout>

    @php

        $kkpo = $sj->kkpo;

        $detail = $kkpo->details->first();

    @endphp

    <div class="py-4">

        {{-- HEADER --}}
        <div class="bg-white rounded-xl shadow-sm border p-6 mb-4">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <h2 class="text-xl font-semibold text-gray-800">

                        Production Tracking Detail

                    </h2>

                    <p class="text-sm text-gray-500 mt-1">

                        Monitoring traveler movement and production status.

                    </p>

                </div>

                <a href="{{ route('superadmin.report') }}"
                    class="px-4 py-2 text-sm rounded-lg border border-gray-200
                hover:bg-gray-50">

                    Back

                </a>

            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">

                <div>
                    <div class="text-gray-500">KKPO</div>
                    <div class="font-medium">
                        {{ $kkpo->no_kkpo ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="text-gray-500">SJ IN</div>
                    <div class="font-medium">
                        {{ $sj->no_surat_jalan }}
                    </div>
                </div>

                <div>
                    <div class="text-gray-500">Customer</div>
                    <div class="font-medium">
                        {{ $kkpo->customer->name ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="text-gray-500">Style</div>
                    <div class="font-medium">
                        {{ $detail?->style?->name ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="text-gray-500">Color</div>
                    <div class="font-medium">
                        {{ $detail?->color?->name ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="text-gray-500">Category</div>
                    <div class="font-medium">
                        {{ $detail?->category?->name ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="text-gray-500">Item</div>
                    <div class="font-medium">
                        {{ $detail?->item?->name ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="text-gray-500">Brand</div>
                    <div class="font-medium">
                        {{ $detail?->brand?->name ?? '-' }}
                    </div>
                </div>
            </div>

        </div>

        {{-- TRAVELER --}}
        <div class="space-y-4">

            @foreach ($sj->travelers as $traveler)
                @php

                    $lastMovement = $traveler->movements->sortByDesc('created_at')->first();

                    $isFinished =
                        optional($lastMovement?->currentDepartment)->name == 'Warehouse Send' &&
                        $traveler->suratJalanOuts->count() > 0;

                @endphp

                <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

                    {{-- HEADER --}}
                    <div class="px-5 py-4 border-b bg-gray-50">

                        <div class="flex items-center justify-between">

                            <div>

                                <h3 class="font-semibold text-gray-800">

                                    {{ $traveler->no_traveler }}

                                </h3>

                                <p class="text-xs text-gray-500 mt-1">

                                    Current Dept :
                                    {{ optional($traveler->currentDepartment)->name ?? '-' }}

                                </p>

                            </div>

                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $isFinished ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">

                                {{ $isFinished ? 'Finished' : 'In Progress' }}

                            </span>

                        </div>

                    </div>

                    {{-- MOVEMENT --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full text-sm">

                            <thead class="bg-[#136566]/5">

                                <tr>

                                    <th class="px-4 py-3 text-left">
                                        Department
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Qty In
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Qty Out
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Date In
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Date Out
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($traveler->movements->sortBy('created_at') as $mov)
                                    <tr class="border-t">

                                        <td class="px-4 py-3">

                                            {{ $mov->currentDepartment->name ?? '-' }}

                                        </td>

                                        <td class="px-4 py-3 text-green-600">

                                            {{ $mov->qty_in }}

                                        </td>

                                        <td class="px-4 py-3 text-red-500">

                                            {{ $mov->qty_out }}

                                        </td>

                                        <td class="px-4 py-3">

                                            {{ $mov->date_in ?? '-' }}

                                        </td>

                                        <td class="px-4 py-3">

                                            {{ $mov->date_out ?? '-' }}

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>
            @endforeach

        </div>
    </div>

</x-app-layout>

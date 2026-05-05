<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto">

            {{-- BACK --}}
            <div class="flex justify-between items-center mb-4 mt-2">
                <a href="{{ route('ppic.kkpomanagement') }}"
                    class="text-sm text-gray-500 hover:text-[#136566] transition">
                    ← Back
                </a>
            </div>

            {{-- HEADER --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    KKPO Detail - {{ $kkpomanagement->no_kkpo }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Complete information related to KKPO and customer
                </p>
            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- KKPO DETAIL --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-[#136566] mb-4 uppercase tracking-wide">
                        KKPO Information
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div>
                            <div class="text-gray-500 text-xs">No KKPO</div>
                            <div class="font-semibold text-gray-800">{{ $kkpomanagement->no_kkpo }}</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Style / Color</div>
                            <div class="text-gray-800">
                                {{ $kkpomanagement->details->first()->style->name }} • {{ $kkpomanagement->details->first()->color->name }}
                            </div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Brand</div>
                            <div>{{ $kkpomanagement->details->first()->brand->name }}</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Category</div>
                            <div>{{ $kkpomanagement->details->first()->category->name }}</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Qty</div>
                            <div class="font-semibold">
                                {{ $kkpomanagement->details->first()->qty }}
                                <span class="text-gray-500 text-xs">
                                    {{ $kkpomanagement->details->first()->unit->name ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Unit Price</div>
                            <div class="font-semibold">
                                {{ number_format($kkpomanagement->details->first()->price, 0, ',', '.') }}
                                <span class="text-gray-500 text-xs">
                                    {{ $kkpomanagement->details->first()->currency->code ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Tolerance</div>
                            <div>{{ $kkpomanagement->details->first()->reject_allowance ?? '-' }}%</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Payment Terms</div>
                            <div>{{ $kkpomanagement->payment_terms ?? '-' }} Hari</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Issue Date</div>
                            <div>{{ $kkpomanagement->tanggal ?? '-' }}</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">NPWP</div>
                            <div>{{ $kkpomanagement->npwp ?? '-' }}</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Remark</div>
                            <div>{{ $kkpomanagement->remark ?? '-' }}</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Notes</div>
                            <div>{{ $kkpomanagement->notes ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                {{-- CUSTOMER --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-[#136566] mb-4 uppercase tracking-wide">
                        Customer
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div>
                            <div class="text-gray-500 text-xs">Name</div>
                            <div class="font-semibold text-gray-800">
                                {{ $kkpomanagement->customer->name ?? '-' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Address</div>
                            <div>{{ $kkpomanagement->customer->address ?? '-' }}</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">Telephone</div>
                            <div>{{ $kkpomanagement->customer->phone ?? '-' }}</div>
                        </div>

                        <div>
                            <div class="text-gray-500 text-xs">PIC</div>
                            <div>{{ $kkpomanagement->customer->attention ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TRAVELERS --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm mt-6 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-[#136566] uppercase tracking-wide">
                        Travelers Related to This KKPO
                    </h3>
                </div>

                @if ($kkpomanagement->travelers->isEmpty())
                    <div class="p-6 text-sm text-gray-500">
                        No travelers related.
                    </div>
                @else
                    <table class="min-w-full text-sm text-gray-700">
                        <thead
                            class="bg-[#136566]/10 border-b border-[#136566]/20 text-[11px] uppercase tracking-wide text-gray-600">
                            <tr>
                                <th class="px-4 py-2 text-left">No SJ</th>
                                <th class="px-4 py-2 text-left">Traveler</th>
                                <th class="px-4 py-2 text-left">Style</th>
                                <th class="px-4 py-2 text-left">Color</th>
                                <th class="px-4 py-2 text-left">Category</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($kkpomanagement->travelers as $traveler)
                                <tr class="border-t hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        {{ $traveler->suratJalan->no_surat_jalan ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 font-medium">
                                        {{ $traveler->no_traveler }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $traveler->suratJalan->kkpomanagement->details->first()->style->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $traveler->suratJalan->kkpomanagement->details->first()->color->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $traveler->suratJalan->kkpomanagement->details->first()->category->name ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
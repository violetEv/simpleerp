<x-app-layout>
    {{-- <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
        Detail KKPO
    </h2> --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('ppic.kkpomanagement') }}" class="text-sm text-blue-500">
            ← Kembali
        </a>
    </div>

    <div>
        <div class="max-w-7xl mx-auto">
            {{-- <div class="bg-white shadow rounded-lg p-6"> --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4">
                        <i class="fas fa-box"></i> Order - {{ $kkpomanagement->no_kkpo }}
                    </h3>
                    <p><strong>Style:</strong> {{ $kkpomanagement->style->name }}</p>
                    <p><strong>Color:</strong> {{ $kkpomanagement->color->name }}</p>
                    <p><strong>Category:</strong> {{ $kkpomanagement->category->name }}</p>
                    <p><strong>Quantity:</strong> {{ $kkpomanagement->qty_total }}</p>
                    <p><strong>Unit:</strong> {{ $kkpomanagement->unit->name ?? '-' }}</p>
                    <p><strong>Price:</strong> {{ number_format($kkpomanagement->price, 0, ',', '.') }}</p>
                    <p><strong>Currency:</strong> {{ $kkpomanagement->currency->code ?? '-' }}</p>
                    <p><strong>Reject Allowance:</strong> {{ $kkpomanagement->reject_allowance ?? '-' }}%</p>
                </div>
                
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4">
                        <i class="fas fa-user"></i> Customer
                    </h3>
                    <p><strong>Customer:</strong> {{ $kkpomanagement->customer->name ?? '-' }}</p>
                    <p><strong>Alamat:</strong> {{ $kkpomanagement->customer->address ?? '-' }}</p>
                    <p><strong>Telephone:</strong> {{ $kkpomanagement->customer->phone ?? '-' }}</p>
                    <p><strong>PIC:</strong> {{ $kkpomanagement->customer->attention ?? '-' }}</p>

                </div>
            </div>
            {{-- 1 kotak div untuk reject allowance --}}
                {{-- <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4">
                        <i class="fas fa-exclamation-triangle"></i> Reject Allowance
                    </h3>
                    <p><strong>Reject Allowance:</strong> {{ $kkpomanagement->reject_allowance }}%</p>
                </div> --}}
            {{-- </div> --}}
            <div class="bg-white shadow rounded-lg p-6 mt-6">
                <h3 class="text-lg font-medium mb-4">Travelers Terkait</h3>
                @if ($kkpomanagement->travelers->isEmpty())
                    <p class="text-gray-500">Tidak ada travelers yang terkait dengan KKPO ini.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No Surat
                                    Jalan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No Traveler
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Style</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Color</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Category
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($kkpomanagement->travelers as $traveler)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $traveler->suratJalan->no_surat_jalan ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $traveler->no_traveler }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $traveler->suratJalan->kkpomanagement->style->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $traveler->suratJalan->kkpomanagement->color->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $traveler->suratJalan->kkpomanagement->category->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

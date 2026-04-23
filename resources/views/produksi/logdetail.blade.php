<x-app-layout>
    <div class="py-6">
        <div class="max-w-5xl mx-auto">

            {{-- 🔷 HEADER --}}
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Detail Log Produksi
            </h2>

            {{-- ========================= --}}
            {{-- 🟦 CARD 1: INFO TRAVELER --}}
            {{-- ========================= --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">
                    Informasi Traveler
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <p><strong>No Traveler:</strong> {{ $movement->traveler->no_traveler }}</p>
                    <p><strong>Status:</strong> {{ $movement->traveler->status }}</p>
                    <p><strong>Departemen Asal:</strong> {{ $movement->deptAsal->name ?? '-' }}</p>
                    <p><strong>Departemen Sekarang:</strong> {{ $movement->currentDepartment->name ?? '-' }}</p>
                </div>
            </div>

            {{-- ========================= --}}
            {{-- 🟩 CARD 2: DATA IN --}}
            {{-- ========================= --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">
                    Data Masuk (IN)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <p><strong>Petugas IN:</strong> {{ $movement->created_by ?? '-' }}</p>
                    <p><strong>Tanggal IN:</strong> {{ $movement->date_in }}</p>
                    <p><strong>Qty IN:</strong> {{ $movement->qty_in }}</p>

                    <p>
                        <strong>Status IN:</strong>
                        @if($movement->status_case === 'selisih')
                            <span class="px-2 py-1 bg-red-500 text-white text-xs rounded">
                                Selisih
                            </span>
                        @else
                            <span class="px-2 py-1 bg-green-500 text-white text-xs rounded">
                                Normal
                            </span>
                        @endif
                    </p>

                    @if($movement->qty_loss > 0)
                        <p class="text-red-600 font-semibold">
                            Loss: {{ $movement->qty_loss }}
                        </p>
                    @endif

                    @if($movement->machine)
                        <p><strong>Mesin:</strong> {{ $movement->machine->name }}</p>
                    @endif
                </div>
            </div>

            {{-- ========================= --}}
            {{-- 🟨 CARD 3: DATA OUT --}}
            {{-- ========================= --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">
                    Data Keluar (OUT)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                    <p><strong>Petugas OUT:</strong> {{ $movement->updated_by ?? '-' }}</p>
                    <p><strong>Tanggal OUT:</strong> {{ $movement->date_out ?? '-' }}</p>

                    <p>
                        <strong>Qty OUT:</strong>
                        <span class="{{ $movement->qty_loss > 0 ? 'text-red-600 font-bold' : '' }}">
                            {{ $movement->qty_out ?? '-' }}
                        </span>
                    </p>

                    <p><strong>Qty Reject:</strong> {{ $movement->qty_reject ?? 0 }}</p>

                    <p><strong>Tujuan:</strong> {{ $movement->deptTujuan->name ?? '-' }}</p>

                    {{-- STATUS OUT --}}
                    <p>
                        <strong>Status OUT:</strong>
                        @if($movement->qty_loss > 0)
                            <span class="px-2 py-1 bg-red-500 text-white text-xs rounded">
                                Tidak Balance
                            </span>
                        @elseif(($movement->qty_reject ?? 0) > 0)
                            <span class="px-2 py-1 bg-yellow-500 text-white text-xs rounded">
                                Ada Reject
                            </span>
                        @else
                            <span class="px-2 py-1 bg-green-500 text-white text-xs rounded">
                                OK
                            </span>
                        @endif
                    </p>

                    {{-- NOTES --}}
                    @if($movement->notes)
                        <div class="md:col-span-2">
                            <p><strong>Catatan:</strong></p>
                            <div class="bg-gray-100 p-3 rounded text-sm">
                                {{ $movement->notes }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
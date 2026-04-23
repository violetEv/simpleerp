@if ($movementActive && $movementActive->qty_in && !$movementActive->date_out)
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Input Qty Out</h3>
        <form action="{{ route('produksi.out.store', $traveler->id) }}" method="POST" id="formOut">
            @csrf
            <input type="hidden" name="traveler_id" value="{{ $traveler->id }}">
            <input type="hidden" id="qty_in_hidden" value="{{ $movementActive->qty_in ?? 0 }}">
            <div class="mb-4">
                <label for="updated_by" class="block text-sm font-medium text-gray-700">Petugas Output</label>
                <input type="text" name="updated_by" id="updated_by" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="qty_out" class="block text-sm font-medium text-gray-700">Qty Out</label>
                <input type="number" name="qty_out" id="qty_out" min="0"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required>
            </div>

            {{-- QC FIELD --}}
            @include('produksi.proses.components.qc-field')

            {{-- DESTINATION --}}
            @include('produksi.proses.components.destination-field')

            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700">Catatan
                    (Optional)</label>
                <textarea name="notes" id="notes" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
            </div>

            {{-- WARNING SELISIH --}}
            <div id="warning-selisih" class="mb-4 hidden">
                <p class="text-sm text-red-600">Warning: Qty Out is less than Qty In. Please provide a
                    reason.
                </p>
            </div>

            <button type="submit"
                onclick="return confirm('Data yang sudah disimpan tidak dapat diubah kembali. Apakah Anda yakin ingin menyimpan data?')"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">SIMPAN
                OUT</button>
        </form>
    </div>
@endif

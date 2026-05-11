@if (!$movementActive)
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Input Qty In</h3>
        <form id="formIn" onsubmit="return handleSubmitIn()" action="{{ route('produksi.in.store', $traveler->id) }}"
            method="POST">
            @csrf
            <input type="hidden" name="traveler_id" value="{{ $traveler->id }}">
            <input type="hidden" id="expected_qty" value="{{ $lastMovement ? $lastMovement->qty_out : 0 }}">
            {{-- <input type="hidden" name="created_by" value="{{ Auth::id() }}"> --}}
            {{-- petugas input input manual --}}
            <div class="mb-4">
                <label for="created_by" class="block text-sm font-medium text-gray-700">Petugas Input</label>
                <input type="text" name="created_by" id="created_by" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="qty_in" class="block text-sm font-medium text-gray-700">Qty In</label>
                <input type="number" name="qty_in" id="qty_in" min="0"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required>
            </div>

            {{-- Mesin (dipisah component) --}}
            @include('produksi.proses.components.machine-field')

            <button type="button" onclick="return handleSubmitIn()" {{-- onclick="return confirm('Data yang sudah disimpan tidak dapat diubah kembali. Apa Anda yakin ingin menyimpan?')" --}}
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">SIMPAN
                IN</button>
        </form>
    </div>
@endif

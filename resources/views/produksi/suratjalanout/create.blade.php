<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Buat Surat Jalan Out
    </h2>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- CARD FORM INPUT SURAT JALAN OUT --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <form action="{{ route('produksi.suratjalanout.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="traveler_id" value="{{ $traveler->id }}">
                    <div class="mb-4">
                        <label for="no_surat_jalan" class="block text-gray-700 font-medium mb-2">No Surat Jalan</label>
                        <input type="text" name="no_surat_jalan" id="no_surat_jalan" required
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                    </div>
                    <div class="mb-4">
                        <x-select-search label="KKPO Management" name="kkpo_management_id" id="kkpo_management_id"
                            required :options="$kkpoManagements->map(function ($kkpo) {
                                return [
                                    'value' => $kkpo->id,
                                    'label' =>
                                        $kkpo->no_kkpo .
                                        ' - ' .
                                        $kkpo->category->name .
                                        ' - ' .
                                        $kkpo->customer->name .
                                        ' - ' .
                                        $kkpo->style->name .
                                        ' - ' .
                                        $kkpo->color->name .
                                        ' - ' .
                                        $kkpo->item->name,
                                ];
                            })" />

                    </div>
                    <div class="mb-4">
                        <label for="qty" class="block text-gray-700 font-medium mb-2">Qty</label>
                        <input type="number" name="qty" id="qty" required min="0"
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                    </div>
                    <div class="mb-4">
                        <label for="tanggal" class="block text-gray-700 font-medium mb-2">Tanggal Keluar</label>
                        <input type="date" name="tanggal" id="tanggal" required
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                    </div>
                    <button type="submit"
                        class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Set tanggal default ke hari ini
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalInput = document.getElementById('tanggal');
            const today = new Date().toISOString().split('T')[0];
            tanggalInput.value = today;
        });
    </script>

</x-app-layout>

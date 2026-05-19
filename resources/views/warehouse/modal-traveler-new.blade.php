    <div id="addModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm items-center justify-center z-50 p-4">

        <div class="bg-white rounded-2xl w-full max-w-3xl shadow-2xl overflow-hidden animate-modal">
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-2 border-b bg-white">
                <div>
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-800">
                        Buat Traveler
                    </h3>

                    <p class="text-sm text-gray-500">
                        Pastikan data traveler yang dibuat sudah benar.
                    </p>
                </div>

                <button onClick="closeAddModal()" class="text-2xl leading-none hover:text-red-200 transition">
                    &times;
                </button>
            </div>

            <form id="pecahTravelerForm" method="POST" action="{{ route('warehouse.pecah.store') }}">

                @csrf

                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="parent_traveler_id" id="parent_traveler_id">

                <div class="p-6 overflow-y-auto max-h-[70vh]">

                    {{-- INFORMASI SURAT JALAN --}}
                    <div class="border border-gray-200 rounded-2xl p-5 mb-6 bg-gray-50">

                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-semibold text-gray-800">
                                    Informasi Surat Jalan
                                </h4>

                                {{-- <p class="text-sm text-gray-500">
                                    Detail surat jalan yang dipilih
                                </p> --}}
                            </div>

                            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-xl text-center min-w-[120px]">
                                <p class="text-xs font-medium">
                                    Qty Sisa
                                </p>

                                <p id="qty_sisa_text" class="text-2xl font-bold">
                                    0
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama PIC
                                </label>

                                <input type="text" name="pic" id="pic" required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Surat Jalan
                                </label>

                                <input type="text" id="surat_jalan_display" readonly
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm bg-gray-100">

                                <input type="hidden" name="surat_jalan_id" id="surat_jalan_id">
                            </div>

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Qty Awal
                                </label>

                                <input type="number" name="qty_awal" id="qty_awal" readonly
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Qty Sisa Saat Ini
                                </label>

                                <input type="number" name="qty_sisa" id="qty_sisa" readonly
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm bg-gray-100 font-semibold">
                            </div>

                        </div>

                    </div>

                    {{-- DETAIL TRAVELER --}}
                    <div class="border border-gray-200 rounded-2xl p-5 mb-6">

                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-semibold text-gray-800">
                                    Detail Traveler
                                </h4>

                                {{-- <p class="text-sm text-gray-500">
                                    Tambahkan traveler sesuai kebutuhan
                                </p> --}}
                            </div>

                            <button type="button" onclick="addTableRow()"
                                class="px-4 py-2 bg-[#136566] text-white rounded-xl hover:bg-[#0f4f50] transition text-sm font-medium">
                                + Tambah
                            </button>
                        </div>

                        <div class="overflow-x-auto">

                            <table class="w-full">

                                <thead>
                                    <tr class="border-b border-gray-200 text-xs uppercase text-gray-500 tracking-wide">

                                        <th class="text-left py-3 pr-3 w-[28%]">
                                            No Traveler
                                        </th>

                                        <th class="text-left py-3 pr-3 w-[15%]">
                                            Qty
                                        </th>

                                        <th class="text-left py-3 pr-3 w-[30%]">
                                            Departemen Tujuan
                                        </th>

                                        <th class="text-left py-3 pr-3 w-[22%]">
                                            Tanggal Bongkar
                                        </th>

                                        <th class="text-center py-3 w-[5%]">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="travelerBody">

                                    <tr class="border-b border-gray-100">

                                        <td class="pr-3 py-3">
                                            <input type="text" name="no_traveler[]" required
                                                placeholder="Masukkan No Traveler"
                                                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]">
                                        </td>

                                        <td class="pr-3 py-3">
                                            <input type="number" name="qty_split[]" required min="0"
                                                placeholder="0"
                                                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm qty-input focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]"
                                                oninput="calculateTotal()">
                                        </td>

                                        <td class="pr-3 py-3">
                                            <select name="dept_tujuan_id[]" required
                                                class="w-full border border-gray-300 rounded-xl text-sm px-4 py-2 focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]">

                                                <option value="">
                                                    Pilih Departemen
                                                </option>

                                                @foreach (App\Models\Departments::all() as $departemen)
                                                    <option value="{{ $departemen->id }}">
                                                        {{ $departemen->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </td>

                                        <td class="pr-3 py-3">
                                            <input type="date" name="tanggal[]" required
                                                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]">
                                        </td>

                                        <td class="text-center py-3">
                                            <span
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-green-100 text-green-700 font-bold">
                                                1
                                            </span>
                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                        <p id="qty-warning" class="text-red-500 text-sm mt-4 hidden font-medium">
                            Qty melebihi sisa qty yang tersedia.
                        </p>

                    </div>

                    {{-- CATATAN --}}
                    <div class="border border-gray-200 rounded-2xl p-5">

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan
                        </label>

                        <textarea name="notes" id="notes" rows="4" placeholder="Tambahkan catatan jika diperlukan..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]"></textarea>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="border-t bg-gray-50 px-6 py-4 flex items-center justify-between">

                    <button type="button" onclick="closeAddModal()"
                        class="px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition">
                        Batal
                    </button>

                    <button type="submit" id="submit-button"
                        onclick="return confirm('Apakah anda yakin ingin menyimpan data ini?')"
                        class="px-5 py-2.5 bg-[#136566] text-white rounded-xl hover:bg-[#0f4f50] transition font-medium">
                        Simpan Traveler
                    </button>

                </div>

            </form>

        </div>

    </div>
    <script>
        function openSplitTraveler(btn) {

            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');

            document.getElementById('pecahTravelerForm').reset();
            document.getElementById('submit-button').disabled = false;
            document.getElementById('qty-warning').classList.add('hidden');

            let id = btn.dataset.id;
            let surat = btn.dataset.surat;
            let qtyAwal = btn.dataset.qty_awal;
            let qtySisa = btn.dataset.qty_sisa;

            document.getElementById('modalTitle').textContent =
                'Pecah Traveler - ' + surat;

            document.getElementById('surat_jalan_display').value = surat;

            document.getElementById('surat_jalan_id').value = id;

            document.getElementById('qty_awal').value = qtyAwal;

            document.getElementById('qty_sisa').value = qtySisa;
            document.getElementById('qty_sisa').dataset.original = qtySisa;

            calculateTotal();
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function calculateTotal() {

            let originalQty = parseInt(document.getElementById('qty_sisa').dataset.original) || 0;

            let totalSplit = 0;

            document.querySelectorAll('.qty-input').forEach(input => {
                totalSplit += parseInt(input.value) || 0;
            });

            let warning = document.getElementById('qty-warning');
            let submitButton = document.getElementById('submit-button');

            if (totalSplit > originalQty) {

                warning.classList.remove('hidden');

                submitButton.disabled = true;
                submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                submitButton.classList.remove('bg-[#136566]', 'hover:bg-[#0f4f50]');

            } else {

                warning.classList.add('hidden');

                submitButton.disabled = false;
                submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                submitButton.classList.add('bg-[#136566]', 'hover:bg-[#0f4f50]');
            }

            let sisaSekarang = originalQty - totalSplit;

            document.getElementById('qty_sisa').value = sisaSekarang;
            document.getElementById('qty_sisa_text').textContent = sisaSekarang;
        }

        function addTableRow() {

            const tbody = document.getElementById('travelerBody');

            const rowCount = tbody.querySelectorAll('tr').length + 1;

            const row = document.createElement('tr');

            row.classList.add('border-b', 'border-gray-100');

            row.innerHTML = `

        <td class="pr-3 py-3">
            <input type="text"
                name="no_traveler[]"
                required
                placeholder="Masukkan No Traveler"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]">
        </td>

        <td class="pr-3 py-3">
            <input type="number"
                name="qty_split[]"
                required
                min="0"
                placeholder="0"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm qty-input focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]"
                oninput="calculateTotal()">
        </td>

        <td class="pr-3 py-3">
            <select name="dept_tujuan_id[]"
                required
                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]">

                <option value="">
                    Pilih Departemen
                </option>

                @foreach (App\Models\Departments::all() as $departemen)
                    <option value="{{ $departemen->id }}">
                        {{ $departemen->name }}
                    </option>
                @endforeach

            </select>
        </td>

        <td class="pr-3 py-3">
            <input type="date"
                name="tanggal[]"
                required
                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]">
        </td>

        <td class="text-center py-3">
            <button type="button"
                class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-red-100 text-red-700 hover:bg-red-200 transition font-bold"
                onclick="removeRow(this)">
                -
            </button>
        </td>
    `;
            tbody.appendChild(row);
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
            calculateTotal();
        }
    </script>

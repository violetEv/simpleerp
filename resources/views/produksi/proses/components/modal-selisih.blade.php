<div id="modalSelisih" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">

        <h3 class="text-lg font-semibold mb-2 text-gray-800">
            Peringatan
        </h3>

        <p id="modalSelisihText" class="text-sm text-gray-600 mb-4">
            {{-- isi via JS --}}
        </p>

        <div class="flex justify-end gap-2">
            <button onclick="closeModalSelisih()" class="px-4 py-2 bg-gray-400 text-white rounded">
                Cek Ulang
            </button>

            <button onclick="lanjutSubmit()" class="px-4 py-2 bg-[#136566] text-white rounded">
                Lanjutkan
            </button>
        </div>

    </div>
</div>
<script>
    let formRef = null;

    function handleSubmitIn() {
        let expected = parseInt(document.getElementById('expected_qty').value) || 0;
        let actual = parseInt(document.getElementById('qty_in').value) || 0;

        formRef = document.getElementById('formIn');

        if (expected !== 0 && actual > expected) {
            alert('Qty IN tidak boleh lebih besar dari sebelumnya');
            return false;
        }

        let selisih = expected - actual;

        // ✅ sama / pertama kali
        if (selisih === 0 || expected === 0) {
            formRef.submit();
            return false;
        }

        // 🔥 harusnya masuk sini
        document.getElementById('modalSelisihText').innerText =
            "Terdapat selisih " + selisih + " pcs";

        document.getElementById('modalSelisih').classList.remove('hidden');
        document.getElementById('modalSelisih').classList.add('flex');

        return false; // ❗ penting supaya ga submit
    }

    function closeModalSelisih() {
        document.getElementById('modalSelisih').classList.add('hidden');
        document.getElementById('modalSelisih').classList.remove('flex');
    }

    function lanjutSubmit() {
        let formRef = document.getElementById('formIn'); // aman tanpa global

        let notes = document.getElementById('notes');
        if (notes && notes.value.trim() === '') {
            notes.value = "Selisih saat penerimaan";
        }

        formRef.submit();
    }
</script>

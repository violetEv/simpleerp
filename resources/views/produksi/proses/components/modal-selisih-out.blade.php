<div id="modalSelisih" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">

        <h3 class="text-lg font-semibold mb-2 text-gray-800">
            ⚠️ Peringatan Selisih
        </h3>

        <p id="modalSelisihText" class="text-sm text-gray-600 mb-4"></p>

        <div class="flex justify-end gap-2">
            <button onclick="closeModalSelisih()" class="px-4 py-2 bg-gray-400 text-white rounded">
                Cek Ulang
            </button>

            <button onclick="lanjutSubmitOut()" class="px-4 py-2 bg-[#136566] text-white rounded">
                Lanjutkan
            </button>
        </div>

    </div>
</div>
<script>
let formOutRef = null;

const qtyInEl = document.getElementById('qty_in_hidden');
const qtyOutEl = document.getElementById('qty_out');
const warningEl = document.getElementById('warning-selisih');

function validateRealtime() {
    let qtyIn = parseInt(qtyInEl.value) || 0;
    let qtyOut = parseInt(qtyOutEl.value) || 0;

    warningEl.classList.add('hidden');
    warningEl.innerText = "";

    if (!qtyOutEl.value) return;

    let selisih = qtyIn - qtyOut;

    // ❌ OUT lebih besar dari IN
    if (qtyOut > qtyIn) {
        warningEl.className = "mt-2 text-sm font-medium rounded p-2 bg-red-100 text-red-700";
        warningEl.innerText = "❌ Qty OUT melebihi Qty IN";
        warningEl.classList.remove('hidden');
        return;
    }

    // ⚠️ ada selisih
    if (selisih > 0) {
        warningEl.className = "mt-2 text-sm font-medium rounded p-2 bg-yellow-100 text-yellow-700";
        warningEl.innerText = "⚠️ Terdapat selisih " + selisih + " pcs";
        warningEl.classList.remove('hidden');
    }
}

qtyOutEl?.addEventListener('input', validateRealtime);

// ==========================
// SUBMIT HANDLER
// ==========================
function handleSubmitOut() {
    const form = document.getElementById('formOut');

    let qtyIn = parseInt(qtyInEl.value) || 0;
    let qtyOut = parseInt(qtyOutEl.value) || 0;

    formOutRef = form;

    if (qtyOut > qtyIn) {
        alert('Qty OUT tidak boleh lebih besar dari Qty IN');
        return false;
    }

    let selisih = qtyIn - qtyOut;

    // normal submit
    if (selisih === 0) {
        form.submit();
        return false;
    }

    // show modal
    document.getElementById('modalSelisihText').innerText =
        "Terdapat selisih " + selisih + " pcs.\nApakah Anda yakin ingin melanjutkan?";

    const modal = document.getElementById('modalSelisih');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    return false;
}

// ==========================
// CLOSE MODAL
// ==========================
function closeModalSelisih() {
    const modal = document.getElementById('modalSelisih');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// ==========================
// LANJUT SUBMIT (FINAL CHECK)
// ==========================
function lanjutSubmitOut() {
    const notesEl = document.getElementById('notes');

    let qtyIn = parseInt(qtyInEl.value) || 0;
    let qtyOut = parseInt(qtyOutEl.value) || 0;

    let selisih = qtyIn - qtyOut;

    // wajib isi catatan kalau ada selisih
    if (selisih > 0 && notesEl.value.trim() === '') {
        alert('⚠️ Harap isi catatan terlebih dahulu sebelum melanjutkan!');
        notesEl.focus();
        return;
    }

    closeModalSelisih();

    formOutRef.submit();
}
</script>
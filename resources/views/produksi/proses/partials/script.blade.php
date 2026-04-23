<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('formOut');
        const qtyInEl = document.getElementById('qty_in_hidden');
        const qtyOutEl = document.getElementById('qty_out');
        const qtyRejectEl = document.getElementById('qty_reject');
        const warningEl = document.getElementById('warning-selisih');
        const notesEl = document.getElementById('notes');

        let formOutRef = null;

        function validateRealtime() {
            let qtyIn = Number(qtyInEl?.value || 0);
            let qtyOut = Number(qtyOutEl?.value || 0);
            let qtyReject = Number(qtyRejectEl?.value || 0);

            let total = qtyOut + qtyReject;
            let loss = qtyIn - total;

            warningEl.classList.add('hidden');
            warningEl.innerText = "";

            if (qtyOut === 0 && qtyReject === 0) return;

            if (total > qtyIn) {
                warningEl.className = "mb-4 text-sm font-medium rounded p-2 bg-red-100 text-red-700";
                warningEl.innerText = "❌ Qty OUT + Reject melebihi Qty IN";
                warningEl.classList.remove('hidden');
                return;
            }

            if (loss > 0) {
                warningEl.className = "mb-4 text-sm font-medium rounded p-2 bg-yellow-100 text-yellow-700";
                warningEl.innerText = `⚠️ Terdapat selisih ${loss} pcs`;
                warningEl.classList.remove('hidden');
            }
        }

        qtyOutEl?.addEventListener('input', validateRealtime);
        qtyRejectEl?.addEventListener('input', validateRealtime);

        form?.addEventListener('submit', function(e) {
            e.preventDefault();

            let qtyIn = Number(qtyInEl?.value || 0);
            let qtyOut = Number(qtyOutEl?.value || 0);
            let qtyReject = Number(qtyRejectEl?.value || 0);

            let total = qtyOut + qtyReject;
            let loss = qtyIn - total;

            formOutRef = form;

            if (total > qtyIn) {
                alert('Qty OUT + Reject melebihi Qty IN');
                return;
            }

            if (qtyOut === 0 && qtyReject === 0) {
                alert('Qty OUT dan Reject tidak boleh kosong semua');
                return;
            }

            
            if (loss > 0) {
                document.getElementById('modalSelisihText').innerText =
                    "Terdapat selisih " + loss + " pcs.\nApakah Anda yakin ingin melanjutkan?";

                const modal = document.getElementById('modalSelisih');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                return;
            }

            // kalau normal
            form.submit();
        });

    });
</script>

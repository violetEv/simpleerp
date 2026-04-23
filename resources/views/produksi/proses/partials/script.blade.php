<script>
document.getElementById('formOut')?.addEventListener('submit', function (e) {

    let qtyIn = parseInt(document.getElementById('qty_in_hidden').value) || 0;
    let qtyOut = parseInt(document.getElementById('qty_out').value) || 0;
    let qtyReject = parseInt(document.getElementById('qty_reject')?.value) || 0;

    let total = qtyOut + qtyReject;
    let loss = qtyIn - total;

    if (total > qtyIn) {
        e.preventDefault();
        alert('Qty OUT + Reject melebihi Qty IN');
        return;
    }

    if (loss > 0) {
        document.getElementById('notes').value = "Selisih saat proses";
    }
});
</script>
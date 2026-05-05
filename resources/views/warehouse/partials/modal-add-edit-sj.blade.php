{{-- Modal Add & Edit Order --}}
<div id="order-modal"
    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">
    <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh] ">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-4">
            <h3 id="modal-title" class="text-xl font-semibold">Input Surat Jalan IN</h3>
            <button type="button" onClick="closeModal()" title="Close"
                class="text-gray-500 text-2xl hover:text-gray-700">&times;</button>
        </div>

        <form id="order-form" action="{{ route('warehouse.suratjalan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="order_id" id="order_id">
            <div class="grid grid-cols-3 gap-4">
                <x-select-search id="kkpo_management_id" name="kkpo_management_id" label="KKPO" :onChange="'handleKKPOChange'"
                    :options="$kkpoManagements
                        ->map(
                            fn($k) => [
                                'value' => $k->id,
                                'label' => $k->no_kkpo,
                                'data' => [
                                    'qty_total' => $k->details->sum('qty'),
                                    'qty_used' => $k->suratJalan->sum('qty'),
                    
                                    'customer' => $k->customer
                                        ? ['id' => $k->customer->id, 'name' => $k->customer->name]
                                        : null,
                                    'styles' => $k->details
                                        ->pluck('style')
                                        ->filter()
                                        ->unique('id')
                                        ->map(
                                            fn($s) => [
                                                'id' => $s->id,
                                                'name' => $s->name,
                                            ],
                                        )
                                        ->values()
                                        ->toArray(),
                    
                                    'colors' => $k->details
                                        ->pluck('color')
                                        ->filter()
                                        ->unique('id')
                                        ->map(
                                            fn($c) => [
                                                'id' => $c->id,
                                                'name' => $c->name,
                                            ],
                                        )
                                        ->values()
                                        ->toArray(),
                    
                                    'categories' => $k->details
                                        ->pluck('category')
                                        ->filter()
                                        ->unique('id')
                                        ->map(
                                            fn($c) => [
                                                'id' => $c->id,
                                                'name' => $c->name,
                                            ],
                                        )
                                        ->values()
                                        ->toArray(),
                                    'kp_po' => $k->kp_po ? ['id' => $k->kp_po, 'name' => $k->kp_po] : null,
                                ],
                            ],
                        )
                        ->values()
                        ->toArray()" />
                <x-select-search id="customer" name="customer_id" label="Customer" :options="[]"
                    :disabled="false" />
                <x-select-search id="category" name="category_id[]" label="Category" multiple />
                <x-select-search id="style" name="style_id[]" label="Style" multiple />
                <x-select-search id="color" name="color_id[]" label="Color" multiple />
                <x-select-search id="kp_po" name="kp_po_id" label="KP PO" :options="[]" />

                <div>
                    <label for="no_surat_jalan" class="block text-gray-700">No Surat Jalan</label>
                    <input type="text" name="no_surat_jalan" id="no_surat_jalan" required
                        class="w-full border mt-1 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="qty" class="block text-gray-700">Qty</label>

                    <input type="number" name="qty" id="qty" required min="0" oninput="checkQty()"
                        class="w-full border mt-1 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <p id="qty-warning" class="text-red-500 text-sm mt-1 hidden">
                        Qty melebihi sisa qty KKPO
                    </p>

                    <p class="text-gray-500 text-sm mt-1">
                        Sisa Qty KKPO: <span id="sisa_qty_text">0</span>
                    </p>
                </div>
                <div>
                    <label for="tanggal" class="block text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" required
                        class="w-full border mt-1 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <button type="submit" id="submit-button"
                onclick="return confirm('Apakah data yang Anda masukkan sudah benar?')"
                class="bg-[#136566] mt-6 text-white w-full px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                Simpan
            </button>

        </form>
    </div>
</div>
<script>
    // window.handleKKPOChange = handleKKPOChange

    let sisaQty = 0

    window.handleKKPOChange = function(option) {
        const data = option.data || {}

        // customer tetap single
        fillSelectSingle('customer', data.customer)

        //  ini yang berubah
        fillSelectList('style', data.styles)
        fillSelectList('color', data.colors)
        fillSelectList('category', data.categories)

        fillSelectSingle('kp_po', data.kp_po)

        // qty
        const total = parseInt(data.qty_total) || 0
        const used = parseInt(data.qty_used) || 0

        sisaQty = total - used
        document.getElementById('sisa_qty_text').innerText = sisaQty

        document.getElementById('qty').value = ''
        checkQty()
    }

    function fillSelectSingle(id, item) {

        const el = document.getElementById(id)
        if (!el) return

        const comp = Alpine.$data(el)

        if (!comp) return

        if (item) {
            const opt = {
                value: item.id,
                label: item.name
            }

            comp.options = [opt]
            comp.selected = item.id
            comp.selectedOption = opt
            comp.disabled = false

        } else {
            comp.options = []
            comp.selected = ''
            comp.selectedOption = null
            comp.disabled = true
        }
    }

    function fillSelectList(id, items) {

        const el = document.getElementById(id)
        if (!el) return

        const comp = Alpine.$data(el)

        if (!comp) return

        if (items && items.length) {

            const opts = items.map(i => ({
                value: i.id,
                label: i.name
            }))

            comp.options = opts

            // penting untuk multiple
            comp.selected = items.map(i => i.id)

            comp.selectedOption = null
            comp.disabled = false

        } else {
            comp.options = []
            comp.selected = []
            comp.selectedOption = null
            comp.disabled = true
        }
    }

    // function toggle(id, val) {
    //     const el = document.getElementById(id)
    //     if (!el || !el.__x) return

    //     el.__x.$data.disabled = !val
    // }

    function checkQty() {
        const qty = parseInt(document.getElementById('qty').value) || 0
        const warn = document.getElementById('qty-warning')

        if (qty > sisaQty) {
            warn.classList.remove('hidden')
        } else {
            warn.classList.add('hidden')
        }
    }

    // ===== RESET =====
    function resetSelects() {

        ['customer', 'category', 'style', 'color', 'kp_po'].forEach(id => {
            let el = document.getElementById(id);
            if (el && el.__x) {
                el.__x.$data.options = [];
                el.__x.$data.selected = '';
                el.__x.$data.selectedOption = null;
                el.__x.$data.disabled = true;
            }
        });

        sisaQty = 0;
        document.getElementById('sisa_qty_text').innerText = '0';
    }


    // ===== MODAL =====
    function openAddOrderModal() {

        document.getElementById('modal-title').innerText = 'Tambah Surat Jalan';

        document.getElementById('order_id').value = '';
        document.getElementById('no_surat_jalan').value = '';
        document.getElementById('qty').value = '';
        document.getElementById('tanggal').value = '';

        resetSelects();
        showModal();
    }


    function showModal() {
        let modal = document.getElementById('order-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        let modal = document.getElementById('order-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    // window.handleKKPOChange = handleKKPOChange;
</script>

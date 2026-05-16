{{-- Modal Add & Edit Order --}}
<div id="order-modal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm items-center justify-center z-50 p-4">

    <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-6 py-4 border-b bg-white">

            <h3 id="modal-title" class="text-lg font-semibold text-gray-800">
                Input Surat Jalan IN
            </h3>

            <button type="button" onclick="closeModal()" class="text-2xl text-gray-500 hover:text-red-500">
                &times;
            </button>

        </div>

        {{-- FORM --}}
        <form id="order-form" action="{{ route('warehouse.suratjalan.store') }}" method="POST">

            @csrf

            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="order_id" id="order_id">

            {{-- IMPORTANT --}}
            <input type="hidden" name="kkpo_detail_id" id="kkpo_detail_id">

            <div class="p-6 overflow-y-auto max-h-[70vh]">

                <div class="border border-gray-200 rounded-2xl p-5 bg-gray-50">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- KKPO --}}
                        <div class="md:col-span-2">

                            <x-select-search id="kkpo_management_id" name="kkpo_management_id"
                                label="KK/PO - KK BEA CUKAI" :onChange="'handleKKPOChange'" :options="$kkpoManagements
                                    ->map(function ($k) {
                                        return [
                                            'value' => $k->id,
                                
                                            'label' => $k->no_kkpo,
                                
                                            'data' => [
                                                'customer' => $k->customer
                                                    ? [
                                                        'id' => $k->customer->id,
                                                        'name' => $k->customer->name,
                                                    ]
                                                    : null,
                                
                                                'kp_po' => $k->kp_po
                                                    ? [
                                                        'id' => $k->kp_po,
                                                        'name' => $k->kp_po,
                                                    ]
                                                    : null,
                                
                                                'details' => $k->details
                                                    ->map(function ($d) {
                                                        $used = $d->suratJalans->sum('qty');
                                
                                                        return [
                                                            'id' => $d->id,
                                
                                                            'style_id' => $d->style_id,
                                                            'style_name' => $d->style->name ?? '-',
                                
                                                            'color_id' => $d->color_id,
                                                            'color_name' => $d->color->name ?? '-',
                                
                                                            'category_id' => $d->category_id,
                                                            'category_name' => $d->category->name ?? '-',
                                
                                                            'qty_awal' => $d->qty,
                                
                                                            'qty_used' => $used,
                                
                                                            'qty_sisa' => $d->qty - $used,
                                                        ];
                                                    })
                                                    ->values()
                                                    ->toArray(),
                                            ],
                                        ];
                                    })
                                    ->values()
                                    ->toArray()"
                                placeholder="Pilih data" searchPlaceholder="Cari..." />

                        </div>

                        {{-- CUSTOMER --}}
                        <x-select-search id="customer" name="customer_id" label="Customer" :options="[]"
                            :disabled="true" required placeholder="Pilih Customer" searchPlaceholder="Cari Customer" />

                        {{-- KP --}}
                        <x-select-search id="kp_po" name="kp_po_id" label="KP" :options="[]"
                            :disabled="true" required placeholder="Pilih KP / PO" searchPlaceholder="Cari KP / PO" />

                        {{-- CATEGORY --}}
                        <x-select-search id="category" name="category_id" label="Category" :options="[]"
                            :onChange="'updateDetailQty'" required placeholder="Pilih Category" searchPlaceholder="Cari Category" />

                        {{-- STYLE --}}
                        <x-select-search id="style" name="style_id" label="Style" :options="[]"
                            :onChange="'updateDetailQty'" required placeholder="Pilih Style" searchPlaceholder="Cari Style" />

                        {{-- COLOR --}}
                        <x-select-search id="color" name="color_id" label="Color" :options="[]"
                            :onChange="'updateDetailQty'" required placeholder="Pilih Color" searchPlaceholder="Cari Color" />

                        {{-- NO SJ --}}
                        <div>
                            <label for="no_surat_jalan" class="block text-sm text-gray-700 mb-1">
                                No Surat Jalan
                            </label>

                            <input type="text" name="no_surat_jalan" id="no_surat_jalan" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm
                                focus:ring-2 focus:ring-[#136566]/30 focus:outline-none">
                        </div>

                        {{-- QTY --}}
                        <div>
                            <label for="qty" class="block text-sm text-gray-700 mb-1">
                                Qty
                            </label>

                            <input type="number" name="qty" id="qty" required min="1"
                                oninput="checkQty()"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm
                                focus:ring-2 focus:ring-[#136566]/30 focus:outline-none">

                            <p id="qty-warning" class="text-red-500 text-sm mt-1 hidden">
                                Qty melebihi sisa qty KKPO
                            </p>

                            <p class="text-gray-500 text-sm mt-1">
                                Sisa Qty KKPO :
                                <span id="sisa_qty_text" class="font-semibold text-gray-700">
                                    0
                                </span>
                            </p>
                        </div>

                        {{-- TANGGAL --}}
                        <div>
                            <label for="tanggal" class="block text-sm text-gray-700 mb-1">
                                Tanggal
                            </label>

                            <input type="date" name="tanggal" id="tanggal" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm
                                focus:ring-2 focus:ring-[#136566]/30 focus:outline-none">
                        </div>

                    </div>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="border-t bg-gray-50 px-6 py-4 flex justify-between">

                <button type="button" onclick="closeModal()"
                    class="px-5 py-2.5 border rounded-xl text-gray-700 hover:bg-gray-100">
                    Batal
                </button>

                <button type="submit" id="submit-button"
                    onclick="return confirm('Apakah data yang Anda masukkan sudah benar?')"
                    class="px-5 py-2.5 bg-[#136566] text-white rounded-xl hover:bg-[#0f4f50]">

                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    let currentDetails = []

    let sisaQty = 0

    // =========================
    // KKPO CHANGE
    // =========================
    window.handleKKPOChange = function(option) {

        const data = option.data || {}

        currentDetails = data.details || []

        // CUSTOMER
        fillSelectSingle('customer', data.customer)

        // KP
        fillSelectSingle('kp_po', data.kp_po)

        // STYLE
        fillSelectList(
            'style',

            [...new Map(

                currentDetails.map(i => [

                    i.style_id,

                    {
                        id: i.style_id,
                        name: i.style_name
                    }
                ])

            ).values()]
        )

        // COLOR
        fillSelectList(
            'color',

            [...new Map(

                currentDetails.map(i => [

                    i.color_id,

                    {
                        id: i.color_id,
                        name: i.color_name
                    }
                ])

            ).values()]
        )

        // CATEGORY
        fillSelectList(
            'category',

            [...new Map(

                currentDetails.map(i => [

                    i.category_id,

                    {
                        id: i.category_id,
                        name: i.category_name
                    }
                ])

            ).values()]
        )

        // AUTO UPDATE IF ALL AUTO SELECTED
        setTimeout(() => {
            updateDetailQty()
        }, 100)
    }

    // =========================
    // UPDATE DETAIL
    // =========================
    window.updateDetailQty = function() {

        const style = getSelectedValue('style')

        const color = getSelectedValue('color')

        const category = getSelectedValue('category')

        if (!style || !color || !category) return

        const detail = currentDetails.find(d => {

            return Number(d.style_id) === Number(style) &&
                Number(d.color_id) === Number(color) &&
                Number(d.category_id) === Number(category)
        })

        if (!detail) {

            sisaQty = 0

            document.getElementById('sisa_qty_text')
                .innerText = 0

            document.getElementById('kkpo_detail_id')
                .value = ''

            return
        }

        // IMPORTANT
        document.getElementById('kkpo_detail_id')
            .value = detail.id

        sisaQty = detail.qty_sisa

        document.getElementById('sisa_qty_text')
            .innerText = sisaQty

        checkQty()
    }

    // =========================
    // GET SELECT VALUE
    // =========================
    function getSelectedValue(id) {

        const el = document.getElementById(id)

        if (!el) return null

        const comp = Alpine.$data(el)

        if (!comp) return null

        return comp.selected
    }

    // =========================
    // FILL SINGLE
    // =========================
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

    // =========================
    // FILL LIST
    // =========================
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

            comp.disabled = false

            // AUTO SELECT IF ONLY 1
            if (opts.length === 1) {

                comp.selected = opts[0].value

                comp.selectedOption = opts[0]

            } else {

                comp.selected = ''

                comp.selectedOption = null
            }

        } else {

            comp.options = []

            comp.selected = ''

            comp.selectedOption = null

            comp.disabled = true
        }

        // trigger update qty kalau auto selected
        setTimeout(() => {

            if (
                id === 'style' ||
                id === 'color' ||
                id === 'category'
            ) {
                updateDetailQty()
            }

        }, 50)
    }

    // =========================
    // CHECK QTY
    // =========================
    function checkQty() {

        const qty = parseInt(
            document.getElementById('qty').value
        ) || 0

        const warn = document.getElementById('qty-warning')
        const submitBtn = document.getElementById('submit-button')


        if (qty > sisaQty) {

            warn.classList.remove('hidden')
            submitBtn.disabled = true

            submitBtn.classList.add(
                'opacity-50',
                'cursor-not-allowed'
            )

        } else {

            warn.classList.add('hidden')
            submitBtn.disabled = false

            submitBtn.classList.remove(
                'opacity-50',
                'cursor-not-allowed'
            )
        }
    }

    // =========================
    // RESET
    // =========================
    function resetQty() {

        sisaQty = 0

        document.getElementById('sisa_qty_text')
            .innerText = '0'

        document.getElementById('kkpo_detail_id')
            .value = ''
    }

    function resetSelects() {

        [
            'customer',
            'kp_po',
            'style',
            'color',
            'category'
        ].forEach(id => {

            const el = document.getElementById(id)

            if (el && el.__x) {

                el.__x.$data.options = []

                el.__x.$data.selected = ''

                el.__x.$data.selectedOption = null

                el.__x.$data.disabled = true
            }
        })

        resetQty()
    }

    // =========================
    // MODAL
    // =========================
    function openAddOrderModal() {

        document.getElementById('modal-title')
            .innerText = 'Tambah Surat Jalan'

        document.getElementById('submit-button').disabled = false

        document.getElementById('submit-button').classList.remove(
            'opacity-50',
            'cursor-not-allowed'
        )
        document.getElementById('order-form').reset();


        document.getElementById('order_id').value = ''

        document.getElementById('no_surat_jalan').value = ''

        document.getElementById('qty').value = ''

        document.getElementById('tanggal').value = ''

        resetSelects()

        showModal()
    }

    function showModal() {

        const modal = document.getElementById('order-modal')

        modal.classList.remove('hidden')

        modal.classList.add('flex')
    }

    function closeModal() {

        const modal = document.getElementById('order-modal')

        modal.classList.add('hidden')

        modal.classList.remove('flex')
    }
</script>

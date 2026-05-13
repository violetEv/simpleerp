{{-- Modal Surat Jalan Out --}}
<div id="order-modal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm items-center justify-center z-50 p-4">

    <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-6 py-4 border-b bg-white">

            <h3 class="text-lg font-semibold text-gray-800">
                Input Surat Jalan OUT
            </h3>

            <button type="button" onclick="closeModal()" class="text-2xl text-gray-500 hover:text-red-500">
                &times;
            </button>

        </div>

        {{-- FORM --}}
        <form action="{{ route('produksi.suratjalanout.store') }}" method="POST">
            @csrf

            <input type="hidden" id="surat_jalan_out_id" name="surat_jalan_out_id">

            <div class="p-6 overflow-y-auto max-h-[70vh]">

                <div class="border border-gray-200 rounded-2xl p-5 bg-gray-50">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- SJ IN --}}
                        <div class="md:col-span-2">

                            <x-select-search id="surat_jalan_in" name="surat_jalan_in_id" label="Surat Jalan IN"
                                :onChange="'handleSJInChange'" :options="$suratJalanIns
                                    ->map(function ($sj) {
                                        return [
                                            'value' => $sj->id,
                                            'label' => $sj->no_surat_jalan,
                                            'data' => [
                                                'customer' => $sj->kkpoManagement?->customer?->name ?? '-',
                                                'style' =>
                                                    $sj->kkpoManagement?->details?->first()?->style?->name ?? '-',
                                                'color' =>
                                                    $sj->kkpoManagement?->details?->first()?->color?->name ?? '-',
                                                'kp_po' => [
                                                    'id' => $sj->kkpoManagement?->id,
                                                    'name' => $sj->kkpoManagement?->kp_po ?? '-',
                                                ],
                                                'travelers' => $sj->travelers
                                                    ->map(function ($t) {
                                                        return [
                                                            'id' => $t->id,
                                                            'name' => $t->no_traveler ?? 'Traveler',
                                                            'qty' => $t->qty ?? 0,
                                                        ];
                                                    })
                                                    ->values(),
                                            ],
                                        ];
                                    })
                                    ->values()
                                    ->toArray()" />

                        </div>

                        {{-- CUSTOMER --}}
                        <x-select-search id="customer" name="customer_id" label="Customer" :options="[]" />

                        {{-- STYLE --}}
                        <x-select-search id="style" name="style_id" label="Style" :options="[]" />

                        {{-- COLOR --}}
                        <x-select-search id="color" name="color_id" label="Color" :options="[]" />

                        {{-- KP --}}
                        <x-select-search id="kp_po" name="kp_po_id" label="KP" :options="[]" />

                        {{-- TRAVELER --}}
                        <x-select-search id="traveler" name="traveler_id[]" label="Traveler" :multiple="true"
                            :options="[]" />

                        {{-- QTY --}}
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Qty</label>
                            <input type="number" id="qty_out" name="qty"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-gray-100 font-semibold"
                                readonly>
                        </div>

                        {{-- NO SJ --}}
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">No Surat Jalan Out</label>
                            <input type="text" name="no_surat_jalan"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#136566]/30">
                        </div>

                        {{-- TANGGAL --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm text-gray-700 mb-1">Tanggal</label>
                            <input type="date" name="tanggal"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#136566]/30">
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

                <button type="submit" class="px-5 py-2.5 bg-[#136566] text-white rounded-xl hover:bg-[#0f4f50]">
                    Simpan
                </button>

            </div>

        </form>

    </div>
</div>

<script>
    let currentTravelers = [];

    /* OPEN */
    function openAddOrderModal() {

        const modal = document.getElementById('order-modal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        const form = modal.querySelector('form');

        form.reset();

        // RESET ACTION
        form.action =
            "{{ route('produksi.suratjalanout.store') }}";

        // REMOVE PUT
        const methodPut = document.getElementById('method-put');

        if (methodPut) {
            methodPut.remove();
        }

        currentTravelers = [];

        resetTravelerSelect();
        resetQty();
    }

    /* CLOSE */
    function closeModal() {
        const modal = document.getElementById('order-modal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        currentTravelers = [];
    }

    function openEditModal(order) {

        openAddOrderModal();

        const form = document.querySelector('#order-modal form');

        let url =
            "{{ route('produksi.suratjalanout.update', ':id') }}";

        url = url.replace(':id', order.id);

        form.action = url;

        // METHOD PUT
        let methodInput = document.getElementById('method-put');

        if (!methodInput) {

            methodInput = document.createElement('input');

            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            methodInput.id = 'method-put';

            form.appendChild(methodInput);
        }

        setTimeout(() => {

            // NO SJ
            form.querySelector('[name="no_surat_jalan"]').value =
                order.no_surat_jalan ?? '';

            // TANGGAL
            form.querySelector('[name="tanggal"]').value =
                order.tanggal ?? '';

            // QTY
            document.getElementById('qty_out').value =
                order.qty ?? 0;

            // SJ IN
            const sjComp = document.getElementById('surat_jalan_in')._x_dataStack[0];

            sjComp.selected = order.surat_jalan_in_id;

        }, 200);
    }


    /* SJ CHANGE */
    window.handleSJInChange = function(option) {

        console.log('OPTION:', option);

        const data = option?.data || option || {};

        console.log('DATA:', data);

        fillSelect('customer', data.customer);
        fillSelect('style', data.style);
        fillSelect('color', data.color);
        fillSelect('kp_po', data.kp_po?.name ?? '-');

        currentTravelers = data.travelers || [];

        fillTravelerSelect(currentTravelers);

        resetQty();
    };

    /* SELECT */
    function fillSelect(id, label) {

        const el = document.getElementById(id);
        const comp = Alpine.$data(el);

        if (!comp) return;

        comp.options = label ? [{
            value: label,
            label
        }] : [];
        comp.selected = label || '';
    }

    /* TRAVELER */
    function fillTravelerSelect(list) {

        const el = document.getElementById('traveler');
        const comp = Alpine.$data(el);

        if (!comp) return;

        comp.options = list.map(t => ({
            value: String(t.id),
            label: t.name
        }));

        comp.selected = [];

        // WATCH selected
        Alpine.effect(() => {

            const selectedIds = comp.selected || [];

            const selected = currentTravelers.filter(t =>
                selectedIds.includes(String(t.id))
            );

            const total = selected.reduce((sum, t) => {
                return sum + (Number(t.qty) || 0);
            }, 0);

            document.getElementById('qty_out').value = total;
        });
    }

    function resetQty() {
        document.getElementById('qty_out').value = 0;
    }

    function resetTravelerSelect() {
        const el = document.getElementById('traveler');
        const comp = Alpine.$data(el);

        if (!comp) return;

        comp.options = [];
        comp.selected = [];
    }
</script>

<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto">

            {{-- FILTER CARD --}}
            <div class="bg-white shadow-sm rounded-lg mb-3 border border-gray-100">

                <form method="GET" x-data="{ open: false }" class="p-3 space-y-3">

                    {{-- TOP BAR --}}
                    <div class="flex flex-wrap items-center justify-between gap-2">

                        {{-- LEFT GROUP --}}
                        <div class="flex flex-wrap items-center gap-2">
                            {{-- DATE FROM --}}
                            {{-- <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500 whitespace-nowrap">
                                    From
                                </span>

                                <input type="date" name="date_from" value="{{ request('date_from') }}"
                                    class="h-9 px-3 text-sm border border-gray-200 rounded-md
        focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50]
        text-gray-600">
                            </div> --}}

                            {{-- DATE TO --}}
                            {{-- <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500 whitespace-nowrap">
                                    To
                                </span>

                                <input type="date" name="date_to" value="{{ request('date_to') }}"
                                    class="h-9 px-3 text-sm border border-gray-200 rounded-md
        focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50]
        text-gray-600">
                            </div> --}}

                            {{-- SEARCH --}}
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search kkpo..." @keyup.enter="$el.form.submit()"
                                    class="h-9 pl-9 pr-3 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50] w-52">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="m21 21-4.35-4.35m1.85-5.65a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                                </svg>
                            </div>

                            {{-- FILTER BUTTON --}}
                            <button type="button" @click="open = !open"
                                class="relative h-9 px-3 text-sm rounded-md border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 flex items-center gap-1 transition">

                                {{-- ACTIVE DOT --}}
                                @if (request()->hasAny(['customer', 'category', 'style', 'color', 'item', 'brand', 'date_from', 'date_to', 'search']))
                                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#136566] rounded-full"></span>
                                @endif

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                                </svg>

                                Filter
                            </button>

                            {{-- APPLY --}}
                            {{-- APPLY --}}
                            <button
                                class="h-9 px-4 text-sm rounded-md border border-[#136566]
    text-[#136566] bg-white hover:bg-[#136566]/5
    active:scale-[0.98] flex items-center gap-1 transition">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4.5 12.75 10.5 18 19.5 6" />
                                </svg>

                                Apply
                            </button>

                            {{-- RESET --}}
                            <a href="{{ route('ppic.kkpo') }}"
                                class="h-9 px-3 text-sm rounded-md text-gray-500 hover:text-gray-700 flex items-center transition">
                                Reset
                            </a>

                        </div>

                        {{-- RIGHT GROUP (ACTIONS BOXED) --}}
                        <div class="flex items-center gap-1 bg-gray-50 border border-gray-200 rounded-md p-1">

                            {{-- ADD --}}
                            <button type="button" onclick="openAddModal()"
                                class="h-8 px-3 text-xs rounded bg-[#0f4f50] text-white hover:bg-[#136566] flex items-center gap-1 transition">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>

                                Add KKPO
                            </button>

                        </div>

                    </div>
                    {{-- ADVANCED FILTER --}}
                    <div x-show="open" x-transition class="grid grid-cols-3 md:grid-cols-3 gap-2 pt-2 border-t">

                        {{-- customer, category process, style, item, color, brand, unit, currency --}}
                        <x-select-search name="customer" :value="request('customer')" :options="$filterCustomers->map(fn($c) => ['value' => $c->id, 'label' => $c->name])" placeholder="Customer" />
                        <x-select-search name="category" :value="request('category')" :options="$filterCategories->map(fn($c) => ['value' => $c->id, 'label' => $c->name])"
                            placeholder="Category Process" />

                        <x-select-search name="style" :value="request('style')" :options="$filterStyles->map(fn($s) => ['value' => $s->id, 'label' => $s->name])" placeholder="Style" />

                        <x-select-search name="color" :value="request('color')" :options="$filterColors->map(fn($c) => ['value' => $c->id, 'label' => $c->name])" placeholder="Color" />

                        <x-select-search name="item" :value="request('item')" :options="$filterItems->map(fn($i) => ['value' => $i->id, 'label' => $i->name])" placeholder="Item" />

                        <x-select-search name="brand" :value="request('brand')" :options="$filterBrands->map(fn($b) => ['value' => $b->id, 'label' => $b->name])" placeholder="Brand" />

                        {{-- <x-select-search name="currency" :value="request('currency')" :options="$currencies->map(fn($c) => ['value' => $c->id, 'label' => $c->code])" placeholder="Currency" /> --}}

                    </div>

                </form>

            </div>

            {{-- TABLE CARD --}}
            <div
                class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-visible">

                <table class="min-w-full table-fixed text-gray-800">

                    {{-- THEAD --}}
                    <thead
                        class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold">
                                <div class="flex flex-col">
                                    <span class="text-gray-800">No KKPO</span>
                                    <span class="text-gray-500 text-[10px]">Customer</span>
                                </div>
                            </th>

                            <th class="px-4 py-2 text-left font-semibold">
                                <div class="flex flex-col">
                                    <span class="text-gray-800">Category Process</span>
                                    <span class="text-gray-500 text-[10px]">Style</span>
                                </div>
                            </th>

                            {{-- <th class="px-4 py-2 text-left font-semibold">Item</th>/ --}}
                            <th class="px-4 py-2 text-left font-semibold">KP</th>
                            <th class="px-4 py-2 text-left font-semibold">Color</th>
                            <th class="px-4 py-2 text-left font-semibold">Qty</th>
                            <th class="px-4 py-2 text-left font-semibold">Unit Price</th>
                            <th class="px-4 py-2 text-left font-semibold">Tolerance</th>
                            <th class="px-4 py-2 text-left font-semibold">Issue Date</th>
                            <th class="px-4 py-2 text-left font-semibold">Action</th>
                        </tr>
                    </thead>

                    {{-- TBODY --}}
                    <tbody class="bg-white text-sm">
                        @if ($kkpoDetails->count())
                            @foreach ($kkpoDetails as $detail)
                                <tr class="hover:bg-gray-50 even:bg-gray-50/40 transition">

                                    {{-- KKPO --}}
                                    <td class="px-4 py-3 border-r border-gray-100 last:border-r-0 align-top">
                                        <div class="font-semibold text-gray-900">
                                            {{ $detail->kkpo->no_kkpo ?? '-' }}
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            {{ $detail->kkpo->customer->name ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- CATEGORY --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        <div class="font-medium text-gray-800">
                                            {{ $detail->category->name ?? '-' }} </div>
                                        <div class="text-gray-500 text-xs">
                                            {{ $detail->style->name ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- ITEM --}}
                                    {{-- <td class="px-4 py-3 border-r border-gray-100 align-top">
                                            {{ $detail->item->name ?? '-' }}
                                        </td> --}}

                                    {{-- KP --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        {{ $detail->kkpo->kp_po ?? '-' }}
                                    </td>

                                    {{-- COLOR --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        {{ $detail->color->name ?? '-' }}
                                    </td>

                                    {{-- QTY --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        <div class="font-semibold">
                                            {{ $detail->qty ?? '-' }}
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            {{ $detail->unit->name ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- PRICE --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        <div class="font-semibold">
                                            {{ number_format($detail->price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            {{ $detail->kkpo->currency->code ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- TOLERANCE --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        {{ $detail->reject_allowance ?? '-' }}%
                                    </td>

                                    {{-- ISSUE DATE LOCAL ID --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        {{ $detail->kkpo->date ? \Carbon\Carbon::parse($detail->kkpo->date)->format('d M Y') : '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="inline-block text-left relative" x-data="{ menu: false }">

                                            <button @click="menu = !menu" class="text-gray-400 hover:text-gray-600">
                                                <svg class="h-5 w-5 pointer-events-none" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </button>

                                            {{-- DROPDOWN --}}
                                            <div x-show="menu" @click.outside="menu = false" x-transition x-cloak
                                                class="absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">

                                                <button
                                                    onclick="window.location='{{ route('ppic.kkpodetail.show', $detail->id) }}'"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                                                    Detail
                                                </button>

                                                <button type="button"
                                                    onclick='openEditModal(@json($detail))'
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                                                    Edit
                                                </button>

                                                <form action="{{ route('ppic.kkpo.delete', $detail->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                {{-- @endforeach --}}
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">
                                    <div class="text-center py-6 text-gray-500 text-sm">
                                        KKPO not found.
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="flex items-center justify-between p-3">
                    <div class="text-sm text-gray-500">
                        Showing {{ $kkpoDetails->firstItem() }}
                        to {{ $kkpoDetails->lastItem() }}
                        of {{ $kkpoDetails->total() }} results
                    </div>

                    {{ $kkpoDetails->links() }}
                </div>
            </div>

            {{-- Modal Add & Edit KKPO --}}
            {{-- Modal Add & Edit KKPO --}}
            <div id="addModal"
                class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm items-center justify-center z-50 p-4">

                <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden">

                    {{-- HEADER --}}
                    <div class="flex items-center justify-between px-6 py-4 border-b bg-white">

                        <div>
                            <h3 id="modal-title" class="text-lg font-semibold text-gray-800">
                                Add KKPO
                            </h3>
                            <p class="text-sm text-gray-500">
                                Fill in the form below to add a new KKPO
                            </p>
                        </div>

                        <button type="button" onclick="closeModal()"
                            class="text-2xl text-gray-500 hover:text-red-500 transition">
                            &times;
                        </button>

                    </div>

                    {{-- FORM --}}
                    <form id="crud-form" action="{{ route('ppic.kkpo.store') }}" method="POST">

                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="details[0][id]" id="detail-id">

                        <div class="p-6 overflow-y-auto max-h-[70vh] space-y-6">

                            {{-- KKPO INFO --}}
                            <div class="border border-gray-200 rounded-2xl p-5 bg-gray-50 space-y-4">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">No KKPO</label>
                                        <input type="text" name="no_kkpo" id="no_kkpo" required
                                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]">
                                    </div>

                                    <div>
                                        <x-select-search name="customer_id" id="customer_id" label="Customer"
                                            :options="$customers->map(
                                                fn($c) => ['value' => $c->id, 'label' => $c->name],
                                            )" placeholder="Select Customer" />
                                    </div>

                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">KP</label>
                                        <input type="text" name="kp_po" id="kp_po"
                                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">NPWP</label>
                                        <input type="text" name="npwp" id="npwp"
                                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                                    </div>

                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    <div>
                                        <x-select-search name="currency_id" id="currency_id" label="Currency"
                                            :options="$currencies->map(
                                                fn($c) => [
                                                    'value' => $c->id,
                                                    'label' => $c->name . ' (' . $c->code . ')',
                                                ],
                                            )" />
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Payment Terms</label>
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="payment_terms" id="payment_terms" min="0"
                                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                                            <span class="text-gray-500 text-sm">Days</span>
                                        </div>
                                    </div>

                                </div>

                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">Issue Date</label>
                                    <input type="date" name="date" id="date"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                                </div>

                            </div>

                            {{-- DETAIL --}}
                            <div class="border border-gray-200 rounded-2xl p-5">

                                <div class="flex items-center justify-between mb-4">

                                    <div>
                                        <h4 class="font-semibold text-gray-800">Detail KKPO</h4>
                                        <p class="text-sm text-gray-500">Fill in the details of the KKPO items</p>
                                    </div>

                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    <x-select-search name="details[0][category_id]" id="category_id" label="Category"
                                        :options="$categories->map(fn($c) => ['value' => $c->id, 'label' => $c->name])" />

                                    <x-select-search name="details[0][style_id]" id="style_id" label="Style"
                                        :options="$styles->map(fn($s) => ['value' => $s->id, 'label' => $s->name])" />

                                    <x-select-search name="details[0][color_id]" id="color_id" label="Color"
                                        :options="$colors->map(fn($c) => ['value' => $c->id, 'label' => $c->name])" />

                                    <x-select-search name="details[0][item_id]" id="item_id" label="Item"
                                        :options="$items->map(fn($i) => ['value' => $i->id, 'label' => $i->name])" />

                                    <x-select-search name="details[0][brand_id]" id="brand_id" label="Brand"
                                        :options="$brands->map(fn($b) => ['value' => $b->id, 'label' => $b->name])" />

                                    <x-select-search name="details[0][unit_id]" id="unit_id" label="Unit"
                                        :options="$units->map(fn($u) => ['value' => $u->id, 'label' => $u->name])" />

                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">

                                    <div>
                                        <label class="text-sm text-gray-700">Qty</label>
                                        <input type="number" name="details[0][qty]" id="qty" min="0"
                                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-700">Unit Price</label>
                                        <input type="number" name="details[0][price]" id="price" min="0"
                                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-700">Tolerance</label>
                                        <input type="number" name="details[0][reject_allowance]"
                                            id="reject_allowance"  min="0"
                                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                                    </div>

                                </div>

                            </div>

                            {{-- REMARK --}}
                            <div>
                                <label class="block text-sm text-gray-700 mb-2">Notes</label>
                                <textarea name="details[0][remark]" id="remark" rows="3"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3"></textarea>
                            </div>

                        </div>

                        {{-- FOOTER --}}
                        <div class="border-t bg-gray-50 px-6 py-4 flex items-center justify-between">

                            <button type="button" onclick="closeModal()"
                                class="px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition">
                                Cancel
                            </button>

                            <button type="submit" id="submit-button"
                                class="px-5 py-2.5 bg-[#136566] text-white rounded-xl hover:bg-[#0f4f50] transition font-medium">
                                Save
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    {{-- ambil script kkpo --}}
    <script>
        function closeModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function openAddModal() {
            document.getElementById('modal-title').textContent = 'Add KKPO';
            // document.getElementById('submit-button').textContent = 'Save';
            document.getElementById('crud-form').action = "{{ route('ppic.kkpo.store') }}";

            document.getElementById('form-method').value = 'POST';
            // reset form
            document.getElementById('crud-form').reset();

            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
            setTimeout(() => {
                document.querySelectorAll('[x-data]').forEach(el => {
                    if (el._x_dataStack) {
                        el._x_dataStack[0].selected = null;
                    }
                });
            }, 150);
        }

        function openEditModal(detail) {

            openAddModal();

            document.getElementById('modal-title').textContent = 'Edit KKPO';

            let kkpo = detail.kkpo;

            let url = "{{ route('ppic.kkpo.update', ':id') }}";
            url = url.replace(':id', kkpo.id);

            document.getElementById('crud-form').action = url;
            document.getElementById('form-method').value = 'PUT';

            setTimeout(() => {

                // HEADER
                document.getElementById('no_kkpo').value = kkpo.no_kkpo ?? '';

                document.getElementById('customer_id')._x_dataStack[0].selected =
                    kkpo.customer_id ?? '';

                document.getElementById('kp_po').value = kkpo.kp_po ?? '';

                document.getElementById('npwp').value = kkpo.npwp ?? '';

                document.getElementById('payment_terms').value =
                    kkpo.payment_terms ?? '';

                document.getElementById('currency_id')._x_dataStack[0].selected =
                    kkpo.currency_id ?? '';

                document.getElementById('date').value = kkpo.date ?? '';

                // document.getElementById('notes').value = kkpo.notes ?? '';

                // DETAIL
                document.getElementById('detail-id').value = detail.id ?? '';

                document.getElementById('category_id')._x_dataStack[0].selected =
                    detail.category_id ?? '';

                document.getElementById('style_id')._x_dataStack[0].selected =
                    detail.style_id ?? '';

                document.getElementById('color_id')._x_dataStack[0].selected =
                    detail.color_id ?? '';

                document.getElementById('item_id')._x_dataStack[0].selected =
                    detail.item_id ?? '';

                document.getElementById('brand_id')._x_dataStack[0].selected =
                    detail.brand_id ?? '';

                document.getElementById('qty').value = detail.qty ?? '';

                document.getElementById('price').value = detail.price ?? '';

                document.getElementById('reject_allowance').value =
                    detail.reject_allowance ?? '';

                document.getElementById('remark').value =
                    detail.remark ?? '';

                document.getElementById('unit_id')._x_dataStack[0].selected =
                    detail.unit_id ?? '';

            }, 150);
        }
        document.getElementById('no_kkpo').addEventListener('blur', function() {

            let noKkpo = this.value;

            if (!noKkpo) return;

            fetch(`/ppic/kkpo/check?no_kkpo=${noKkpo}`)
                .then(res => res.json())
                .then(data => {

                    let customerSelect = document.getElementById('customer_id');
                    let currencySelect = document.getElementById('currency_id');

                    if (data.exists) {

                        let kkpo = data.data;

                        // AUTO FILL
                        customerSelect._x_dataStack[0].selected =
                            kkpo.customer_id ?? '';

                        document.getElementById('kp_po').value =
                            kkpo.kp_po ?? '';

                        document.getElementById('npwp').value =
                            kkpo.npwp ?? '';

                        document.getElementById('payment_terms').value =
                            kkpo.payment_terms ?? '';

                        currencySelect._x_dataStack[0].selected =
                            kkpo.currency_id ?? '';

                        document.getElementById('date').value =
                            kkpo.date ?? '';

                        // OPTIONAL LOCK
                        customerSelect.setAttribute('disabled', true);

                    } else {

                        // RESET kalau tidak ada
                        customerSelect.removeAttribute('disabled');

                        customerSelect._x_dataStack[0].selected = '';

                        document.getElementById('kp_po').value = '';
                        document.getElementById('npwp').value = '';
                        document.getElementById('payment_terms').value = '';

                        currencySelect._x_dataStack[0].selected = '';

                        document.getElementById('date').value = '';
                    }
                });
        });
    </script>
</x-app-layout>

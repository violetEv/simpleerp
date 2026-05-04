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
                                class="h-9 px-3 text-sm rounded-md border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 flex items-center gap-1 transition">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                                </svg>

                                Filter
                            </button>

                            {{-- APPLY --}}
                            <button
                                class="h-9 px-4 text-sm rounded-md bg-[#0f4f50] text-white hover:bg-[#136566] active:scale-[0.98] flex items-center gap-1 transition">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4.5 12.75 10.5 18 19.5 6" />
                                </svg>

                                Apply
                            </button>

                            {{-- RESET --}}
                            <a href="{{ route('ppic.kkpomanagement') }}"
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

                            <th class="px-4 py-2 text-left font-semibold">Item</th>
                            <th class="px-4 py-2 text-left font-semibold">KP</th>
                            <th class="px-4 py-2 text-left font-semibold">Color</th>
                            <th class="px-4 py-2 text-left font-semibold">Qty</th>
                            <th class="px-4 py-2 text-left font-semibold">Unit Price</th>
                            <th class="px-4 py-2 text-left font-semibold">Tolerance</th>
                            <th class="px-4 py-2 text-left font-semibold">Action</th>
                        </tr>
                    </thead>

                    {{-- TBODY --}}
                    <tbody class="bg-white text-sm">
                        @if ($kkpomanagements->count())
                            @foreach ($kkpomanagements as $kkpomanagement)
                                <tr class="hover:bg-gray-50 even:bg-gray-50/40 transition">

                                    {{-- KKPO --}}
                                    <td class="px-4 py-3 border-r border-gray-100 last:border-r-0 align-top">
                                        <div class="font-semibold text-gray-900">
                                            {{ $kkpomanagement->no_kkpo ?? '-' }}
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            {{ $kkpomanagement->customer->name ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- CATEGORY --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        <div class="font-medium text-gray-800">
                                            {{ $kkpomanagement->categories->pluck('name')->join(', ') ?: '-' }} </div>
                                        <div class="text-gray-500 text-xs">
                                            {{ $kkpomanagement->styles->pluck('name')->join(', ') ?: '-' }}
                                        </div>
                                    </td>

                                    {{-- ITEM --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        {{ $kkpomanagement->items->pluck('name')->join(', ') ?: '-' }}
                                    </td>

                                    {{-- KP --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        {{ $kkpomanagement->kp_po ?? '-' }}
                                    </td>

                                    {{-- COLOR --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        {{ $kkpomanagement->colors->pluck('name')->join(', ') ?: '-' }}
                                    </td>

                                    {{-- QTY --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        <div class="font-semibold">
                                            {{ $kkpomanagement->qty_total ?? '-' }}
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            {{ $kkpomanagement->unit->name ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- PRICE --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        <div class="font-semibold">
                                            {{ number_format($kkpomanagement->price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            {{ $kkpomanagement->currency->code ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- TOLERANCE --}}
                                    <td class="px-4 py-3 border-r border-gray-100 align-top">
                                        {{ $kkpomanagement->reject_allowance ?? '-' }}%
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
                                                    onclick="window.location='{{ route('ppic.kkpomanagement.show', $kkpomanagement->id) }}'"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                                                    Detail
                                                </button>

                                                <button type="button"
                                                    onclick='openEditModal(@json($kkpomanagement))'
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                                                    Edit
                                                </button>

                                                <form
                                                    action="{{ route('ppic.kkpomanagement.delete', $kkpomanagement->id) }}"
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

                <div class="p-3">
                    {{ $kkpomanagements->links() }}
                </div>
            </div>

            {{-- Modal Add & Edit KKPO --}}
            <div id="addModal"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh] ">

                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-semibold text-gray-800">Add KKPO</h3>
                        <button onClick="closeModal()" title="Close"
                            class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                    <form id="crud-form" action="{{ route('ppic.kkpomanagement.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="no_kkpo" class="block text-gray-700">No KKPO</label>
                                <input type="text" name="no_kkpo" id="no_kkpo"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-[#136566] focus:border-[#136566]"
                                    required>
                            </div>
                            <div>
                                <x-select-search name="customer_id" id="customer_id" label="Customer"
                                    :options="$customers->map(
                                        fn($customer) => [
                                            'value' => $customer->id,
                                            'label' => $customer->name,
                                        ],
                                    )" placeholder="Select Customer"
                                    searchPlaceholder="Search Customer..." required />
                            </div>
                            <div>
                                <x-select-search name="category_id[]" id="category_id" label="Category Process"
                                    :options="$categories->map(
                                        fn($category) => [
                                            'value' => $category->id,
                                            'label' => $category->name,
                                        ],
                                    )" multiple placeholder="Select Category Process"
                                    searchPlaceholder="Search Category Process..." required />
                            </div>
                            <div>
                                <x-select-search name="style_id[]" id="style_id" label="Style" :options="$styles->map(
                                    fn($style) => [
                                        'value' => $style->id,
                                        'label' => $style->name,
                                    ],
                                )"
                                    multiple placeholder="Select Style" searchPlaceholder="Search Style..."
                                    required />
                            </div>
                            <div>
                                <x-select-search name="color_id[]" id="color_id" label="Color" :options="$colors->map(fn($c) => ['value' => $c->id, 'label' => $c->name])"
                                    multiple placeholder="Select Colors" searchPlaceholder="Search Colors..."
                                    required />
                            </div>
                            {{-- item --}}
                            <div>
                                <x-select-search name="item_id[]" id="item_id" label="Item" :options="$items->map(
                                    fn($item) => [
                                        'value' => $item->id,
                                        'label' => $item->name,
                                    ],
                                )"
                                    multiple placeholder="Select Item" searchPlaceholder="Search Item..." required />
                            </div>
                            <div>
                                <x-select-search name="brand_id[]" id="brand_id" label="Brand" :options="$brands->map(
                                    fn($brand) => [
                                        'value' => $brand->id,
                                        'label' => $brand->name,
                                    ],
                                )"
                                    multiple placeholder="Select Brand" searchPlaceholder="Search Brand..."
                                    required />
                            </div>

                            <div>
                                <label for="kp_po" class="block text-gray-700">KP</label>
                                <input type="text" name="kp_po" id="kp_po"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-[#136566] focus:border-[#136566]">
                            </div>

                            {{-- item --}}


                            <div>
                                <label for="qty_total" class="block text-gray-700">Qty</label>
                                <input type="number" name="qty_total" id="qty_total" min="0"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-[#136566] focus:border-[#136566]"
                                    required>
                            </div>

                            <div>
                                <x-select-search name="unit_id" id="unit_id" label="Unit" :options="$units->map(
                                    fn($unit) => [
                                        'value' => $unit->id,
                                        'label' => $unit->name,
                                    ],
                                )"
                                    placeholder="Select Unit" searchPlaceholder="Search Unit..." required />
                            </div>

                            <div>
                                <label for="npwp" class="block text-gray-700">NPWP</label>
                                <input type="text" name="npwp" id="npwp" required
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-[#136566] focus:border-[#136566]">
                            </div>
                            <div>
                                <label for="remark" class="block text-gray-700">Remark</label>
                                <textarea name="remark" rows="1" id="remark"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-[#136566] focus:border-[#136566]"></textarea>
                            </div>

                            <div>
                                <x-select-search name="currency_id" id="currency_id" label="Currency"
                                    :options="$currencies->map(
                                        fn($currency) => [
                                            'value' => $currency->id,
                                            'label' => $currency->name . ' (' . $currency->code . ')',
                                        ],
                                    )" placeholder="Select Currency"
                                    searchPlaceholder="Search Currency..." required />
                            </div>
                            <div>
                                <label for="price" class="block text-gray-700">Unit Price</label>
                                <input type="number" name="price" id="price" min="0"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-[#136566] focus:border-[#136566]"
                                    required>
                            </div>
                            <div>
                                <label for="reject_allowance" class="block text-gray-700">Tolerance</label>
                                <input type="number" step="0.01" name="reject_allowance" id="reject_allowance"
                                    min="0"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-[#136566] focus:border-[#136566]"
                                    required>
                            </div>
                            {{-- catatan --}}
                            {{-- syarat pembayaran dengan label hari di belakangnya --}}
                            <div>
                                <label for="payment_terms" class="block text-gray-700">Payment Terms</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="payment_terms" id="payment_terms" min="0"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-[#136566] focus:border-[#136566]">
                                    <span class="text-gray-500">Days</span>
                                </div>
                            </div>
                        </div>

                        {{-- tanggal --}}
                        <div class="mt-4">
                            <label for="tanggal" class="block text-gray-700">Issue Date</label>
                            <input type="date" name="tanggal" id="tanggal" required
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-[#136566] focus:border-[#136566]">
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-[#136566] focus:border-[#136566]"></textarea>
                        </div>
                        <div class="mt-6">
                            <button type="submit" id="submit-button"
                                class="w-full px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50] transition shadow-sm">
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
            document.getElementById('crud-form').action = "{{ route('ppic.kkpomanagement.store') }}";

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

        function openEditModal(kkpomanagement) {
            openAddModal();

            document.getElementById('modal-title').textContent = 'Edit KKPO';

            let url = "{{ route('ppic.kkpomanagement.update', ':id') }}";
            url = url.replace(':id', kkpomanagement.id);

            document.getElementById('crud-form').action = url;
            document.getElementById('form-method').value = 'PUT';

            setTimeout(() => {
                document.getElementById('no_kkpo').value = kkpomanagement.no_kkpo;

                //  IMPORTANT: pakai mapping array
                document.getElementById('customer_id')._x_dataStack[0].selected = kkpomanagement.customer_id;

                document.getElementById('category_id')._x_dataStack[0].selected = kkpomanagement.categories?.map(
                    c => c.id) ?? [];

                document.getElementById('style_id')._x_dataStack[0].selected = kkpomanagement.styles?.map(s => s
                    .id) ?? [];

                document.getElementById('color_id')._x_dataStack[0].selected = kkpomanagement.colors?.map(c => c
                    .id) ?? [];

                document.getElementById('item_id')._x_dataStack[0].selected = kkpomanagement.items?.map(i => i
                    .id) ?? [];

                document.getElementById('brand_id')._x_dataStack[0].selected = kkpomanagement.brands?.map(b => b
                    .id) ?? [];

                document.getElementById('unit_id')._x_dataStack[0].selected = kkpomanagement.unit_id;

                document.getElementById('currency_id')._x_dataStack[0].selected = kkpomanagement.currency_id;

                document.getElementById('kp_po').value = kkpomanagement.kp_po;
                document.getElementById('qty_total').value = kkpomanagement.qty_total;
                document.getElementById('price').value = kkpomanagement.price;
                document.getElementById('reject_allowance').value = kkpomanagement.reject_allowance;
                document.getElementById('npwp').value = kkpomanagement.npwp;
                document.getElementById('remark').value = kkpomanagement.remark;
                document.getElementById('payment_terms').value = kkpomanagement.payment_terms;
                document.getElementById('tanggal').value = kkpomanagement.tanggal;
                document.getElementById('notes').value = kkpomanagement.notes;
            }, 150);
        }
        document.getElementById('no_kkpo').addEventListener('blur', function() {
            let noKkpo = this.value;

            if (!noKkpo) return;

            fetch(`/ppic/kkpo/check?no_kkpo=${noKkpo}`)
                .then(res => res.json())
                .then(data => {
                    let customerSelect = document.getElementById('customer_id');

                    if (data.exists) {
                        // auto set customer
                        customerSelect._x_dataStack[0].selected = data.customer_id;

                        // disable biar ga bisa selingkuh 😏
                        customerSelect.setAttribute('disabled', true);
                    } else {
                        // kalau baru, boleh pilih customer
                        customerSelect.removeAttribute('disabled');
                        customerSelect._x_dataStack[0].selected = null;
                    }
                });
        });
    </script>
</x-app-layout>

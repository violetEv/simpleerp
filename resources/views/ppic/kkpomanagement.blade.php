<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        KKPO
    </h2> --}}
    {{-- @if (session('success'))
        <div class="mt-4">
            <x-alerts variant="success" title="Success" :message="session('success')" :showLink="false" />
        </div>
    @elseif (session('error'))
        <div class="mt-4">
            <x-alerts variant="danger" title="Error" :message="session('error')" :showLink="false" />
        </div>
    @endif --}}
    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            {{-- Search KKPO and add KKPO modal --}}
            <div class="flex items-center justify-between mb-4 mt-4 space-x-4">
                <form action="{{ route('ppic.kkpomanagement') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search KKPO..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>

                <button onClick="openAddModal()"
                    class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Tambah KKPO
                </button>
            </div>
            {{-- KKPO Table --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                {{-- <div class="p-4 bg-white border-b border-gray-200 overflow-x-auto"> --}}

                <table class="min-w-full table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No
                            </th> --}}
                            {{-- buat agar No KKPO dan Customer dalam 1 kolom aja, posisi No KKPO di atas Customer dengan font lebih tebal, dan jika data tidak ada tampilkan '-' --}}
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No KKPO
                                <br>
                                Customer
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category Process
                                <br>
                                {{-- </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"> --}}
                                Style
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Item
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                KP / PO
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Color
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Qty Total
                                <br>
                                {{-- </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> --}}
                                Unit
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                                <br>
                                Curr
                            </th>
                            {{-- <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reject Allowance
                            </th> --}}
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($kkpomanagements->count())
                            @foreach ($kkpomanagements as $kkpomanagement)
                                <tr>
                                    {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td> --}}
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <strong>{{ $kkpomanagement->no_kkpo ?? '-' }}</strong>
                                        <br>
                                        {{ $kkpomanagement->customer->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <strong>{{ $kkpomanagement->category->name ?? '-' }}</strong>
                                        <br>
                                        {{-- </td>
                                    <td class="px-4 py-2 whitespace-nowrap"> --}}
                                        {{ $kkpomanagement->style->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $kkpomanagement->item->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $kkpomanagement->kp_po ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $kkpomanagement->color->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- <strong>{{ $kkpomanagement->qty_total - $kkpomanagement->suratJalan->sum('qty') }}</strong>
                                        <br> --}}
                                        <strong>{{ $kkpomanagement->qty_total ?? '-' }}</strong>
                                        <br>

                                        {{-- </td>
                                    <td class="px-4 py-2 whitespace-nowrap"> --}}
                                        {{ $kkpomanagement->unit->name ?? '-' }}
                                    </td>
                                    {{-- format harga dengan ribuan separator --}}
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <strong>{{ number_format($kkpomanagement->price, 0, ',', '.') }}</strong>
                                        <br>
                                        {{ $kkpomanagement->currency->code ?? '-' }}
                                    </td>
                                    {{-- <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $kkpomanagement->reject_allowance ?? '-' }}</td> --}}
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- Detail --}}
                                        <button class="mr-2" title="Detail KKPO"
                                            onclick="window.location='{{ route('ppic.kkpomanagement.show', $kkpomanagement->id) }}'">
                                            {{-- icon detail --}}
                                            <svg class="w-6 h-6 text-green-500 hover:text-green-700" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button class="mr-2" title="Edit"
                                            onclick='openEditModal(@json($kkpomanagement))'>
                                            {{-- icon edit --}}
                                            <svg class="w-6 h-6 text-blue-500 hover:text-blue-700" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('ppic.kkpomanagement.delete', $kkpomanagement->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Order"
                                                onclick="return confirm('Apakah Anda yakin ingin mengapus KKPO ini?')">
                                                <svg class="w-6 h-6 text-red-500 hover:text-red-700" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                    No KKPO found.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="p-3">
                    {{ $kkpomanagements->links() }}
                </div>
                {{-- </div> --}}
            </div>
            {{-- Modal Add & Edit KKPO --}}
            <div id="addModal"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50 max-w-7xl mx-auto p-6">
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl overflow-auto max-h-[90vh] ">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-medium">Tambah KKPO</h3>
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
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
                            </div>
                            <div>
                                <x-select-search name="customer_id" id="customer_id" label="Customer"
                                    :options="$customers->map(
                                        fn($customer) => [
                                            'value' => $customer->id,
                                            'label' => $customer->name,
                                        ],
                                    )" placeholder="Pilih Customer"
                                    searchPlaceholder="Cari Customer..." required />
                            </div>
                            <div>
                                <x-select-search name="category_id" id="category_id" label="Category Process"
                                    :options="$categories->map(
                                        fn($category) => [
                                            'value' => $category->id,
                                            'label' => $category->name,
                                        ],
                                    )" placeholder="Pilih Category Process"
                                    searchPlaceholder="Cari Category Process..." required />
                            </div>
                            <div>
                                <x-select-search name="style_id" id="style_id" label="Style" :options="$styles->map(
                                    fn($style) => [
                                        'value' => $style->id,
                                        'label' => $style->name,
                                    ],
                                )"
                                    placeholder="Pilih Style" searchPlaceholder="Cari Style..." required />
                            </div>
                            <div>
                                <x-select-search name="color_id" id="color_id" label="Color" :options="$colors->map(
                                    fn($color) => [
                                        'value' => $color->id,
                                        'label' => $color->name,
                                    ],
                                )"
                                    placeholder="Pilih Color" searchPlaceholder="Cari Color..." required />
                            </div>
                            {{-- item --}}
                            <div>
                                <x-select-search name="item_id" id="item_id" label="Item" :options="$items->map(
                                    fn($item) => [
                                        'value' => $item->id,
                                        'label' => $item->name,
                                    ],
                                )"
                                    placeholder="Pilih Item" searchPlaceholder="Cari Item..." required />
                            </div>
                            <div>
                                <x-select-search name="brand_id" id="brand_id" label="Brand" :options="$brands->map(
                                    fn($brand) => [
                                        'value' => $brand->id,
                                        'label' => $brand->name,
                                    ],
                                )"
                                    placeholder="Pilih Brand" searchPlaceholder="Cari Brand..." required />
                            </div>

                            <div>
                                <label for="kp_po" class="block text-gray-700">KP / PO</label>
                                <input type="text" name="kp_po" id="kp_po"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
                            </div>

                            {{-- item --}}


                            <div>
                                <label for="qty_total" class="block text-gray-700">Qty Total</label>
                                <input type="number" name="qty_total" id="qty_total" min="0"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
                            </div>

                            <div>
                                <x-select-search name="unit_id" id="unit_id" label="Satuan" :options="$units->map(
                                    fn($unit) => [
                                        'value' => $unit->id,
                                        'label' => $unit->name,
                                    ],
                                )"
                                    placeholder="Pilih Satuan" searchPlaceholder="Cari Satuan..." required />
                            </div>
                            <div>
                                <x-select-search name="currency_id" id="currency_id" label="Currency"
                                    :options="$currencies->map(
                                        fn($currency) => [
                                            'value' => $currency->id,
                                            'label' => $currency->name . ' (' . $currency->code . ')',
                                        ],
                                    )" placeholder="Pilih Currency"
                                    searchPlaceholder="Cari Currency..." required />
                            </div>
                            <div>
                                <label for="price" class="block text-gray-700">Price</label>
                                <input type="number" name="price" id="price" min="0"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
                            </div>
                            <div>
                                <label for="reject_allowance" class="block text-gray-700">Reject Allowance</label>
                                <input type="number" step="0.01" name="reject_allowance" id="reject_allowance"
                                    min="0" class="w-full border border-gray-300 rounded px-3 py-2 mt-1"
                                    required>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" id="submit-button"
                                class="w-full px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                                Add KKPO
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const modal = document.getElementById('addModal')
        const form = document.getElementById('crud-form')

        function openModal() {
            modal.classList.remove('hidden')
            modal.classList.add('flex')
        }

        function closeModal() {
            modal.classList.add('hidden')
            modal.classList.remove('flex')
        }

        function resetForm() {
            form.reset()

            // reset semua select Alpine
            document.querySelectorAll('[x-data]').forEach(el => {
                if (el.__x) {
                    el.__x.$data.selected = ''
                }
            })
        }

        function setSelect(id, value) {
            const el = document.getElementById(id)
            if (!el || !el.__x) return

            el.__x.$data.selected = value ?? ''
        }

        function fillForm(data) {
            document.getElementById('no_kkpo').value = data.no_kkpo ?? ''
            document.getElementById('kp_po').value = data.kp_po ?? ''
            document.getElementById('qty_total').value = data.qty_total ?? ''
            document.getElementById('price').value = data.price ?? ''
            document.getElementById('reject_allowance').value = data.reject_allowance ?? ''

            setSelect('customer_id', data.customer_id)
            setSelect('category_id', data.category_id)
            setSelect('style_id', data.style_id)
            setSelect('color_id', data.color_id)
            setSelect('item_id', data.item_id)
            setSelect('brand_id', data.brand_id)
            setSelect('unit_id', data.unit_id)
            setSelect('currency_id', data.currency_id)
        }

        function openAddModal() {
            resetForm()

            document.getElementById('modal-title').textContent = 'Tambah KKPO'
            document.getElementById('submit-button').textContent = 'Tambah KKPO'

            form.action = "{{ route('ppic.kkpomanagement.store') }}"
            document.getElementById('form-method').value = 'POST'

            openModal()
        }

        function openEditModal(data) {
            resetForm()

            document.getElementById('modal-title').textContent = 'Edit KKPO'
            document.getElementById('submit-button').textContent = 'Update KKPO'

            let url = "{{ route('ppic.kkpomanagement.update', ':id') }}"
            url = url.replace(':id', data.id)

            form.action = url
            document.getElementById('form-method').value = 'PUT'

            openModal()

            // kasih sedikit delay biar Alpine ready
            setTimeout(() => {
                fillForm(data)
            }, 50)
        }
    </script>
</x-app-layout>

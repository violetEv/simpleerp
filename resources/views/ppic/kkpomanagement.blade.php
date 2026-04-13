<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        KKPO
    </h2>
    @if (session('success'))
        <div class="mt-4">
            <x-alerts variant="success" title="Success" :message="session('success')" :showLink="false" />
        </div>
    @elseif (session('error'))
        <div class="mt-4">
            <x-alerts variant="danger" title="Error" :message="session('error')" :showLink="false" />
        </div>
    @endif
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- Search KKPO and add KKPO modal --}}
            <div class="flex items-center justify-between mb-4 mt-4 space-x-4">
                <form action="{{ route('ppic.kkpo') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search KKPO..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>

                <button onClick="openAddModal()" class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    Add KKPO
                </button>
            </div>
            {{-- KKPO Table --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                {{-- <div class="p-4 bg-white border-b border-gray-200 overflow-x-auto"> --}}

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No KKPO
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category
                                Process
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Style
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Color
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                KP / PO
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Qty Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price (IDR)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reject Allowance
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($kkpomanagements->count())
                            @foreach ($kkpomanagements as $kkpomanagement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kkpomanagement->kkpo->no_kkpo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kkpomanagement->customer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kkpomanagement->category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kkpomanagement->style->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kkpomanagement->color->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kkpomanagement->kp_po }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $kkpomanagement->qty_total - $kkpomanagement->suratJalan->sum('qty') }}</td>
                                    {{-- fomrat harga dengan ribuan separator --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ number_format($kkpomanagement->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kkpomanagement->reject_allowance }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button class="mr-2" title="Edit Order"
                                            onclick="openEditModal({{ $kkpomanagement->id }})">
                                            {{-- icon edit --}}
                                            <svg class="w-6 h-6 text-blue-500 hover:text-blue-700" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
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
                                <td colspan="11" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
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
                        <h3 id="modal-title" class="text-lg font-medium">Add KKPO</h3>
                        <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                    <form id="crud-form" action="{{ route('ppic.kkpo.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="kkpo_id" class="block text-gray-700">No KKPO</label>
                                <select name="kkpo_id" id="kkpo_id" required
                                    data-hs-select='{
                                                    "hasSearch": true,
                                                    "searchPlaceholder": "Cari KKPO...",
                                                    "placeholder": "Pilih KKPO...",
                                                    "toggleClasses": "mt-1 relative py-2 px-3 flex w-full cursor-pointer bg-white border border-gray-300 rounded text-sm text-left",
                                                    "dropdownClasses": "mt-2 max-h-60 z-50 overflow-y-auto w-full bg-white border border-gray-200 rounded-lg shadow-lg",
                                                    "optionClasses": "px-3 py-2 text-sm cursor-pointer hover:bg-gray-100 rounded",
                                                    "searchWrapperClasses": "p-2 sticky top-0 bg-white",
                                                    "searchClasses": "w-full px-2 py-1 border border-gray-300 rounded"
                                                }'>
                                    <option value="">Select No KKPO</option>
                                    @foreach (App\Models\Kkpo::all() as $kkpo)
                                        <option value="{{ $kkpo->id }}"
                                            data-hs-select-option='{
                                            {{-- "description": "{{ $kkpo->no_kkpo }}" --}}
                                        }'>
                                            {{ $kkpo->no_kkpo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="customer_id" class="block text-gray-700">Customer</label>
                                <select name="customer_id" id="customer_id" required
                                    data-hs-select='{
                                                "hasSearch": true,
                                                "searchPlaceholder": "Cari Customer...",
                                                "placeholder": "Pilih Customer...",
                                                "toggleClasses": "mt-1 relative py-2 px-3 flex w-full cursor-pointer bg-white border border-gray-300 rounded text-sm text-left",
                                                "dropdownClasses": "mt-2 max-h-60 z-50 overflow-y-auto w-full bg-white border border-gray-200 rounded-lg shadow-lg",
                                                "optionClasses": "px-3 py-2 text-sm cursor-pointer hover:bg-gray-100 rounded",
                                                "searchWrapperClasses": "p-2 sticky top-0 bg-white",
                                                "searchClasses": "w-full px-2 py-1 border border-gray-300 rounded"
                                            }'>
                                    <option value="">Select Customer</option>
                                    @foreach (App\Models\Customer::all() as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="category_id" class="block text-gray-700">Category Process</label>
                                <select name="category_id" id="category_id" required
                                    data-hs-select='{
                                                "hasSearch": true,
                                                "searchPlaceholder": "Cari Category...",
                                                "placeholder": "Pilih Category...",
                                                "toggleClasses": "mt-1 relative py-2 px-3 flex w-full cursor-pointer bg-white border border-gray-300 rounded text-sm text-left",
                                                "dropdownClasses": "mt-2 max-h-60 z-50 overflow-y-auto w-full bg-white border border-gray-200 rounded-lg shadow-lg",
                                                "optionClasses": "px-3 py-2 text-sm cursor-pointer hover:bg-gray-100 rounded",
                                                "searchWrapperClasses": "p-2 sticky top-0 bg-white",
                                                "searchClasses": "w-full px-2 py-1 border border-gray-300 rounded"
                                            }'>
                                    <option value="">Select Category Process</option>
                                    @foreach (App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="style_id" class="block text-gray-700">Style</label>
                                <select name="style_id" id="style_id" required
                                    data-hs-select='{
                                                "hasSearch": true,
                                                "searchPlaceholder": "Cari Style...",
                                                "placeholder": "Pilih Style...",
                                                "toggleClasses": "mt-1 relative py-2 px-3 flex w-full cursor-pointer bg-white border border-gray-300 rounded text-sm text-left",
                                                "dropdownClasses": "mt-2 max-h-60 z-50 overflow-y-auto w-full bg-white border border-gray-200 rounded-lg shadow-lg",
                                                "optionClasses": "px-3 py-2 text-sm cursor-pointer hover:bg-gray-100 rounded",
                                                "searchWrapperClasses": "p-2 sticky top-0 bg-white",
                                                "searchClasses": "w-full px-2 py-1 border border-gray-300 rounded"
                                            }'>
                                    <option value="">Select Style</option>
                                    @foreach (App\Models\Style::all() as $style)
                                        <option value="{{ $style->id }}">{{ $style->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="color_id" class="block text-gray-700">Color</label>
                                <select name="color_id" id="color_id" required
                                    data-hs-select='{
                                                "hasSearch": true,
                                                "searchPlaceholder": "Cari Color...",
                                                "placeholder": "Pilih Color...",
                                                "toggleClasses": "mt-1 relative py-2 px-3 flex w-full cursor-pointer bg-white border border-gray-300 rounded text-sm text-left",
                                                "dropdownClasses": "mt-2 max-h-60 z-50 overflow-y-auto w-full bg-white border border-gray-200 rounded-lg shadow-lg",
                                                "optionClasses": "px-3 py-2 text-sm cursor-pointer hover:bg-gray-100 rounded",
                                                "searchWrapperClasses": "p-2 sticky top-0 bg-white",
                                                "searchClasses": "w-full px-2 py-1 border border-gray-300 rounded"
                                            }'>
                                    <option value="">Select Color</option>
                                    @foreach (App\Models\Color::all() as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="kp_po" class="block text-gray-700">KP / PO</label>
                                <input type="text" name="kp_po" id="kp_po"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
                            </div>

                            <div>
                                <label for="qty_total" class="block text-gray-700">Qty Total</label>
                                <input type="number" name="qty_total" id="qty_total" min="0"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
                            </div>
                            <div>
                                <label for="price" class="block text-gray-700">Price (IDR)</label>
                                <input type="number" name="price" id="price"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
                            </div>
                            <div>
                                <label for="reject_allowance" class="block text-gray-700">Reject Allowance</label>
                                <input type="number" step="0.01" name="reject_allowance" id="reject_allowance"
                                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
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
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function openAddModal() {
            document.getElementById('modal-title').textContent = 'Add KKPO';
            document.getElementById('submit-button').textContent = 'Add KKPO';
            document.getElementById('crud-form').action = "{{ route('ppic.kkpomanagement.store') }}";
            document.getElementById('form-method').value = 'POST';

            document.getElementById('kkpo_id').value = '';
            document.getElementById('customer_id').value = '';
            document.getElementById('category_id').value = '';
            document.getElementById('style_id').value = '';
            document.getElementById('color_id').value = '';
            document.getElementById('kp_po').value = '';
            document.getElementById('qty_total').value = '';
            document.getElementById('price').value = '';
            document.getElementById('reject_allowance').value = '';

            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');

            // setinit
            setTimeout(() => {
                if (window.HSSelect) {
                    new HSSelect(document.querySelector('#kkpo_id'));
                }
            }, 200);
            // ketika sudah memilih no kkpo dan customer dan submit, customer tidak bisa dipilih lagi, karena 1 kkpo hanya bisa untuk 1 customer
            // const kkpoSelect = document.getElementById('kkpo_id');
            // const customerSelect = document.getElementById('customer_id');

            // kkpoSelect.addEventListener('change', function() {
            //     const selectedKKPO = this.value;
            //     if (selectedKKPO) {
            //         customerSelect.disabled = true;
            //     } else {
            //         customerSelect.disabled = false;
            //     }
            // });

        }

        function openEditModal(id) {
            // Fetch KKPO data by ID (you can use AJAX or pass data to the modal)
            // For demonstration, let's assume you have the KKPO data available in a JavaScript object
            const kkpoData = @json($kkpomanagements->keyBy('id'));

            if (kkpoData[id]) {
                const kkpomanagement = kkpoData[id];
                document.getElementById('modal-title').textContent = 'Edit KKPO';
                document.getElementById('submit-button').textContent = 'Update KKPO';
                document.getElementById('crud-form').action = '{{ route('ppic.kkpomanagement.update', ':id') }}'.replace(
                    ':id', id);
                document.getElementById('form-method').value = 'PUT';

                document.getElementById('kkpo_id').value = kkpomanagement.kkpo_id;
                document.getElementById('customer_id').value = kkpomanagement.customer_id;
                document.getElementById('category_id').value = kkpomanagement.category_id;
                document.getElementById('style_id').value = kkpomanagement.style_id;
                document.getElementById('color_id').value = kkpomanagement.color_id;
                document.getElementById('kp_po').value = kkpomanagement.kp_po;
                document.getElementById('qty_total').value = kkpomanagement.qty_total;
                document.getElementById('price').value = kkpomanagement.price;
                document.getElementById('reject_allowance').value = kkpomanagement.reject_allowance;

                document.getElementById('addModal').classList.remove('hidden');
                document.getElementById('addModal').classList.add('flex');
            } else {
                alert('KKPO data not found!');
            }
            setTimeout(() => {
                if (window.HSSelect) {
                    new HSSelect(document.querySelector('#kkpo_id'));
                }
            }, 200);
        }
    </script>
</x-app-layout>

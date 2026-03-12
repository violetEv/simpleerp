@extends('layouts.app')

@section('content')
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
            <div class="flex items-center justify-between mb-4 mt-4">
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
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200 overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
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
                                    Qty Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
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
                            @if ($kkpos->count())
                                @foreach ($kkpos as $kkpo)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $kkpo->no_kkpo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $kkpo->customer->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $kkpo->category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $kkpo->style->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $kkpo->color->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $kkpo->qty_total - $kkpo->suratJalan->sum('qty') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $kkpo->price }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $kkpo->reject_allowance }}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button class="text-blue-500 hover:text-blue-700 mr-2"
                                                onclick="openEditModal({{ $kkpo->id }})">Edit</button>
                                            <form action="{{ route('ppic.kkpo.delete', $kkpo->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengapus KKPO ini?')"
                                                    class="text-red-500 hover:text-red-700">Delete</button>
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
                    <div class="mt-4 p-4">
                        {{ $kkpos->links() }}
                    </div>
                </div>
            </div>
            {{-- Modal Add & Edit KKPO --}}
            <div id="addModal" class="hidden fixed inset-0 bg-gray-600  bg-opacity-50 items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-md overflow-auto max-h-screen">
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
                                <label for="no_kkpo" class="block text-gray-700">No KKPO</label>
                                <input type="text" name="no_kkpo" id="no_kkpo"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                            </div>
                            <div>
                                <label for="customer_id" class="block text-gray-700">Customer</label>
                                <select name="customer_id" id="customer_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                                    <option value="">Select Customer</option>
                                    @foreach (App\Models\Customer::all() as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="category_id" class="block text-gray-700">Category Process</label>
                                <select name="category_id" id="category_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                                    <option value="">Select Category Process</option>
                                    @foreach (App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="style_id" class="block text-gray-700">Style</label>
                                <select name="style_id" id="style_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                                    <option value="">Select Style</option>
                                    @foreach (App\Models\Style::all() as $style)
                                        <option value="{{ $style->id }}">{{ $style->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="color_id" class="block text-gray-700">Color</label>
                                <select name="color_id" id="color_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                                    <option value="">Select Color</option>
                                    @foreach (App\Models\Color::all() as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="qty_total" class="block text-gray-700">Qty Total</label>
                                <input type="number" name="qty_total" id="qty_total" min="0"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                            </div>
                            <div>
                                <label for="price" class="block text-gray-700">Price</label>
                                <input type="number" name="price" id="price"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
                            </div>
                            <div>
                                <label for="reject_allowance" class="block text-gray-700">Reject Allowance</label>
                                <input type="string" name="reject_allowance" id="reject_allowance"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1" required>
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
            document.getElementById('crud-form').action = "{{ route('ppic.kkpo.store') }}";
            document.getElementById('form-method').value = 'POST';

            document.getElementById('no_kkpo').value = '';
            document.getElementById('customer_id').value = '';
            document.getElementById('category_id').value = '';
            document.getElementById('style_id').value = '';
            document.getElementById('color_id').value = '';
            document.getElementById('qty_total').value = '';
            document.getElementById('price').value = '';
            document.getElementById('reject_allowance').value = '';

            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }

        function openEditModal(id) {
            // Fetch KKPO data by ID (you can use AJAX or pass data to the modal)
            // For demonstration, let's assume you have the KKPO data available in a JavaScript object
            const kkpoData = @json($kkpos->keyBy('id'));

            if (kkpoData[id]) {
                const kkpo = kkpoData[id];
                document.getElementById('modal-title').textContent = 'Edit KKPO';
                document.getElementById('submit-button').textContent = 'Update KKPO';
                document.getElementById('crud-form').action = '{{ route('ppic.kkpo.update', ':id') }}'.replace(':id', id);
                document.getElementById('form-method').value = 'PUT';

                document.getElementById('no_kkpo').value = kkpo.no_kkpo;
                document.getElementById('customer_id').value = kkpo.customer_id;
                document.getElementById('category_id').value = kkpo.category_id;
                document.getElementById('style_id').value = kkpo.style_id;
                document.getElementById('color_id').value = kkpo.color_id;
                document.getElementById('qty_total').value = kkpo.qty_total;
                document.getElementById('price').value = kkpo.price;
                document.getElementById('reject_allowance').value = kkpo.reject_allowance

                document.getElementById('addModal').classList.remove('hidden');
                document.getElementById('addModal').classList.add('flex');
            } else {
                alert('KKPO data not found!');
            }
        }
    </script>
@endsection

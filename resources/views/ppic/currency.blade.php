<x-app-layout>
    {{-- currency sama kaya input customer, style, item, color, unit --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- search form & add currency --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('ppic.currency') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search currency..." value="{{ request('search') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
                <button onClick="openAddModal()"
                    class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    + Add Currency
                </button>
            </div>
            {{-- table currency --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                <table class="min-w-full table-fixed text-gray-800">
                    <thead class="bg-gray-50 text-gray-700 uppercase tracking wider">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold">
                                Currency Name</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">
                                Code</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @if ($currencies->count())
                            @foreach ($currencies as $currency)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $currency->name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $currency->code }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <button
                                            onClick="openEditModal({{ $currency->id }}, '{{ $currency->name }}', '{{ $currency->code }}')"
                                            title="Edit" class="mr-2">
                                            {{-- Edit icon outline --}}
                                            <svg class="w-6 h-6 text-blue-500 hover:text-blue-700" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('ppic.currency.delete', $currency->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete {{ $currency->name }} ?')">
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
                                <td colspan="3" class="px-4 py-2 whitespace-nowrap text-gray-500 text-center">
                                    Currency not found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="p-3">
                    {{ $currencies->links() }}
                </div>
            </div>
            {{-- modal add & edit currency --}}
            <div id="addCurrencyModal"
                class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-medium">Add Currency</h3>
                        <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                    <form id="crud-form" action="{{ route('ppic.currency.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Currency Name</label>
                            <input type="text" name="name" id="name" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700">Currency Code</label>
                            <input type="text" name="code" id="code" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <button type="submit" 
                            class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                            Save
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openAddModal() {
            document.getElementById('modal-title').textContent = 'Add Currency';
            // document.getElementById('submit-button').textContent = 'Save Currency';
            document.getElementById('crud-form').action = "{{ route('ppic.currency.store') }}";
            document.getElementById('form-method').value = 'POST';
            document.getElementById('addCurrencyModal').classList.remove('hidden');
            document.getElementById('addCurrencyModal').classList.add('flex');
        }

        function closeAddModal() {
            document.getElementById('addCurrencyModal').classList.add('hidden');
            document.getElementById('addCurrencyModal').classList.remove('flex');
        }

        function openEditModal(id, name, code) {
            document.getElementById('modal-title').textContent = 'Edit Currency';
            // document.getElementById('submit-button').textContent = 'Save';
            let url = "{{ route('ppic.currency.update', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('crud-form').action = url;
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('name').value = name;
            document.getElementById('code').value = code;
            document.getElementById('addCurrencyModal').classList.remove('hidden');
            document.getElementById('addCurrencyModal').classList.add('flex');
        }
    </script>
</x-app-layout>

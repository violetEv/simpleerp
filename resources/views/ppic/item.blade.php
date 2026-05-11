<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Item
    </h2> --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
            {{-- SEARCH & ADD ITEM --}}
            <div class="bg-white shadow-sm rounded-lg mb-3 border border-gray-100 p-3">

                <div class="flex flex-wrap items-center justify-between gap-2">

                    {{-- LEFT GROUP --}}
                    <form action="{{ route('ppic.item') }}" method="GET" class="flex items-center gap-2">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search item..."
                                class="h-9 pl-9 pr-3 text-sm border border-gray-200 rounded-md focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50] w-52">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="m21 21-4.35-4.35m1.85-5.65a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                            </svg>
                        </div>
                    </form>

                    {{-- RIGHT GROUP --}}
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-md p-1">
                        {{-- ADD --}}
                        <button onClick="openAddModal()"
                            class="h-8 px-3 text-xs rounded bg-[#0f4f50] text-white hover:bg-[#136566] flex items-center gap-1 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add Item
                        </button>

                    </div>

                </div>

            </div>
            {{-- ITEM TABLE --}}
            <div
                class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-visible">

                <table class="min-w-full table-fixed text-gray-800">

                    {{-- THEAD --}}
                    <thead
                        class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold">
                                Item Name</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @if ($items->count())
                            @foreach ($items as $item)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <button onClick="editItem({{ $item->id }}, '{{ $item->name }}')"
                                            class="mr-2" title="Edit">
                                            <svg class="w-6 h-6 text-blue-500 hover:text-blue-700" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('ppic.item.delete', $item->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete {{ $item->name }}?')"
                                                class="text-red-500 hover:text-red-700" title="Delete">
                                                {{-- <svg class="w-6 h-6" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg> --}}
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
                                <td colspan="2" class="px-4 py-2 text-gray-500 whitespace-nowrap text-center">Item
                                    not found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="flex items-center justify-between p-3">
                    <div class="text-sm text-gray-500">
                        Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of
                        {{ $items->total() }} results
                    </div>

                    {{ $items->links() }}
                </div>
                {{-- ITEM MODAL --}}
                <div id="item-modal"
                    class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">

                    <div class="bg-white rounded-xl p-5 w-full max-w-md shadow-lg">

                        {{-- HEADER --}}
                        <div class="flex items-center justify-between mb-4 border-b pb-2">
                            <h3 id="modal-title" class="text-lg font-semibold text-gray-800">
                                Add Item
                            </h3>

                            <button onClick="closeAddModal()"
                                class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                                &times;
                            </button>
                        </div>

                        {{-- FORM --}}
                        <form id="item-form" method="POST" action="{{ route('ppic.item.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="form-method" value="POST">
                            <input type="hidden" name="item_id" id="item_id" value="">
                            <div class="mb-4">
                                <label class="block text-sm text-gray-700 mb-1">
                                    Item Name
                                </label>

                                <input type="text" name="name" id="name"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm
                    focus:outline-none focus:ring-1 focus:ring-[#0f4f50] focus:border-[#0f4f50]"
                                    required>
                            </div>

                            {{-- BUTTON --}}
                            <div class="flex justify-between gap-2 pt-2">

                                <button type="button" onClick="closeAddModal()"
                                    class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-600 hover:bg-gray-100 w-1/2">
                                    Cancel
                                </button>

                                <button type="submit"
                                    class="px-4 py-2 text-sm rounded-md bg-[#136566] text-white hover:bg-[#0f4f50] w-1/2">
                                    Save
                                </button>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <script>
            function openAddModal() {
                document.getElementById('item-modal').classList.remove('hidden');
                document.getElementById('item-modal').classList.add('flex');
                document.getElementById('modal-title').textContent = 'Add Item';
                document.getElementById('form-method').value = 'POST';
                document.getElementById('item-form').action = "{{ route('ppic.item.store') }}";
                document.getElementById('name').value = '';
                document.getElementById('item_id').value = '';
            }

            function closeAddModal() {
                document.getElementById('item-modal').classList.add('hidden');
                document.getElementById('item-modal').classList.remove('flex');
            }

            function editItem(id, name) {
                document.getElementById('item-modal').classList.remove('hidden');
                document.getElementById('item-modal').classList.add('flex');
                document.getElementById('modal-title').textContent = 'Edit Item';
                document.getElementById('form-method').value = 'PUT';
                let url = "{{ route('ppic.item.update', ':id') }}";
                url = url.replace(':id', id);

                document.getElementById('item-form').action = url;
                document.getElementById('item_id').value = id;
                document.getElementById('name').value = name;
            }
        </script>
</x-app-layout>

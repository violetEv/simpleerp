<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Item
    </h2>
    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- <div class="p-6 bg-white border-b border-gray-200"> --}}
                {{-- <livewire:ppic.item /> --}}
                {{-- </div> --}}
                {{-- SEARCH & ADD ITEM --}}
                <div class="flex items-center justify-between mb-4 p-4">
                    <form action="{{ route('ppic.item') }}" method="GET" class="flex items-center gap-2">
                        <input type="text" name="search" placeholder="Search items..."
                            class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                        <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                            Search
                        </button>
                    </form>
                    <button onClick="openAddModal()"
                        class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                        + Tambah Item
                    </button>
                </div>
                {{-- ITEM TABLE --}}
                <div class="p-4 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($items->count())
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button onClick="editItem({{ $item->id }}, '{{ $item->name }}')"
                                                class="mr-2" title="Edit">
                                                <svg class="w-6 h-6 text-blue-500 hover:text-blue-700"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('ppic.item.delete', $item->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                                                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="px-6 py-4 whitespace-nowrap text-center">Item tidak ditemukan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

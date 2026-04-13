<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        List Traveler
    </h2>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- SEARCH --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('produksi.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
            </div>
            {{-- TABLE --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                                Traveler</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Departemen Asal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Memunculkan data traveler pada departemen saat ini --}}
                        @if ($travelers->count())
                            @foreach ($travelers as $t)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $t->no_traveler }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $t->deptAsal->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($t->status == 'open')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Open
                                            </span>
                                        @elseif ($t->status == 'in_progress')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                In Progress
                                            </span>
                                        @elseif ($t->status == 'done')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Done
                                            </span>    
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('produksi.process', $t->id) }}"
                                            class="text-white hover:text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Process</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">No travelers found.</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
                <div class="p-3">
                    {{ $travelers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
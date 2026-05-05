<x-app-layout>
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        List Traveler
    </h2> --}}

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            {{-- SEARCH --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('produksi.proses.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>
            </div>
            {{-- TABLE --}}
            <div class="bg-white shadow rounded-lg overflow-hidden p-2">
                <table class="min-w-full table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No
                                Traveler</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Departemen Asal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
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
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $t->no_traveler }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $t->latestMovement->deptAsal->name ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if ($t->status == 'open')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Open
                                            </span>
                                        @elseif ($t->status == 'in_progress')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                In Progress
                                            </span>
                                        @elseif ($t->status == 'done')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Done
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{-- jika status traveler adalah open, tampilkan tombol process, jika done, tampilkan tombol buat surat jalan out dan sembunyikan tombol process, jika in_progress, sembunyikan tombol process dan buat surat jalan out --}}
                                        @if ($t->status == 'open' || $t->status == 'in_progress')
                                            <a href="{{ route('produksi.proses.process', $t->id) }}"
                                                class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 my-2 rounded-lg">
                                                Process
                                            </a> 
                                            {{-- JIKA STATUS DONE DAN DEPARTEMEN SAAT ITU ADALAH WAREHOUSE SEND --}}
                                            {{-- PAKE CURRENT DEPARTEMEN --}}
                                        @elseif ($t->status == 'done' && $t->deptTujuan && $t->deptTujuan->name == 'Warehouse Send')
                                            <a href="{{ route('produksi.suratjalanout.create', $t->id) }}"
                                                class="text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg">
                                                Buat Surat Jalan Out
                                            </a>
                                        @else
                                        {{-- sedang diproses --}}
                                            <span class="text-gray-400 italic">Selesai</span>
                                        @endif
                                        {{--                                                 
                                        <a href="{{ route('produksi.process', $t->id) }}"
                                            class="text-white hover:text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Process</a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-4 py-3 whitespace-nowrap text-center">No travelers found.
                                </td>
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

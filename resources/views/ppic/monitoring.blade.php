<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-4">
                {{-- <h2 class="text-xl font-semibold mb-4">
                    Monitoring WIP Traveler
                </h2> --}}
                <div class="bg-white shadow-sm rounded-lg mb-3 border border-gray-100 p-3">

                    <form method="GET">

                        <div class="flex items-center gap-2">

                            <div class="relative">

                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari traveler / surat jalan..."
                                    class="h-10 pl-10 pr-4 text-sm border border-gray-200 rounded-lg
                    focus:ring-1 focus:ring-[#136566]
                    focus:border-[#136566] w-72">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="m21 21-4.35-4.35m1.85-5.65a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                                </svg>

                            </div>

                            <button class="h-10 px-4 bg-[#136566] text-white rounded-lg text-sm hover:bg-[#0f4f50]">

                                Search

                            </button>

                        </div>

                    </form>

                </div>
                <div class="w-full overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-max min-w-full text-sm border-collapse table-fixed">

                        {{-- HEADER --}}
                        <thead
                            class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">

                            <tr>
                                <th
                                    class="sticky left-0 z-20 bg-[#dff3f3] px-4 py-3 text-left font-semibold min-w-[220px]">
                                    Traveler
                                </th>

                                @foreach ($departments as $dept)
                                    <th class="px-3 py-3 text-center font-semibold min-w-[180px]">
                                        {{ $dept}}
                                    </th>
                                @endforeach

                                <th class="px-4 py-3 text-center font-semibold">
                                    WIP
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white text-sm">

                            @forelse ($data as $row)

                                <tr class="border-b hover:bg-gray-50 transition">

                                    {{-- TRAVELER --}}
                                    <td class="sticky left-0 z-10 px-4 py-3 align-top bg-white border-r min-w-[220px]">
                                        <div class="font-semibold text-[#136566]">
                                            {{ $row['traveler']->no_traveler }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ $row['traveler']->suratJalan->no_surat_jalan ?? '-' }}
                                        </div>

                                        <div class="mt-1">
                                            <span
                                                class="px-2 py-1 rounded-full text-[10px]
                        {{ $row['wip'] > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">

                                                {{ $row['current_dept'] ?? 'Finished' }}
                                            </span>
                                        </div>

                                    </td>

                                    {{-- DEPARTMENT --}}
                                    @foreach ($departments as $dept)
                                        @php
                                            $cell = $row['departments'][$dept] ?? null;

                                            $isCurrent = $row['current_dept'] === $dept;
                                        @endphp

                                        <td
                                            class="px-3 py-3 align-top border-l
                    {{ $isCurrent ? 'bg-yellow-50' : '' }}">

                                            @if ($cell)
                                                <div class="space-y-1 text-xs">

                                                    <div class="text-gray-500">
                                                        IN :
                                                        {{ $cell['date_in'] ? \Carbon\Carbon::parse($cell['date_in'])->format('d M Y') : '-' }}
                                                    </div>

                                                    <div class="text-gray-500">
                                                        OUT :
                                                        {{ $cell['date_out'] ? \Carbon\Carbon::parse($cell['date_out'])->format('d M Y') : '-' }}
                                                    </div>

                                                    <div class="font-medium text-green-600">
                                                        Qty In :
                                                        {{ $cell['qty_in'] }}
                                                    </div>

                                                    <div class="font-medium text-red-500">
                                                        Qty Out :
                                                        {{ $cell['qty_out'] }}
                                                    </div>

                                                    <div class="text-[10px] text-blue-600">
                                                        Duration:
                                                        {{ $cell['duration'] }}
                                                    </div>

                                                </div>
                                            @else
                                                <div class="text-gray-300 text-center">
                                                    —
                                                </div>
                                            @endif

                                        </td>
                                    @endforeach

                                    {{-- WIP --}}
                                    <td class="px-4 py-3 text-center">

                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $row['wip'] > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">

                                            {{ $row['wip'] }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="{{ count($departments) + 2 }}"
                                        class="py-10 text-center text-gray-400">

                                        Tidak ada data monitoring

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                    <div class="p-4 border-t bg-white">
                        {{ $travelers->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">

            <div
                class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-visible">

                <table class="min-w-full table-fixed text-gray-800">

                    {{-- THEAD --}}
                    <thead
                        class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">
                                No Traveler
                            </th>

                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">
                                Departemen Asal
                            </th>

                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">
                                Qty Rework
                            </th>

                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">
                                Status
                            </th>

                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">
                                No Turunan
                            </th>

                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">
                                Departemen Tujuan
                            </th>

                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200 text-sm">

                        @forelse($reworkTravelers as $traveler)
                            <tr>

                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $traveler->traveler->no_traveler ?? '-' }}
                                </td>

                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $traveler->deptAsal->name ?? '-' }}
                                </td>

                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $traveler->qty_reject }}
                                </td>

                                <td class="px-4 py-2 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                        Rework
                                    </span>
                                </td>
                                <form action="{{ route('warehouse.rework.store', $traveler->id) }}" method="POST">
                                    @csrf
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- disamping input no traveler turunan, muncul no traveler asal dengan tambahan suffix -A (contoh: TRV-001-A) --}}
                                        {{-- <span class="text-gray-500 text-sm">
                                                {{ $traveler->traveler->no_traveler ?? '-' }}
                                            </span>  --}}
                                        <input type="text" name="no_traveler_turunan" id="no_trav_turunan"
                                            placeholder="-A" required
                                            class="border border-gray-300 rounded-lg px-2 py-1 w-full bg-gray-100 text-sm text-center">

                                        {{-- <input type="text" name="no_traveler_turunan" id="no_trav_turunan" placeholder="-A" required
                                                class="border border-gray-300 rounded-lg px-2 py-1 w-full bg-gray-100 text-sm text-center"> --}}
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <select name="dept_tujuan_id" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md">

                                            <option value="">Pilih Departemen</option>

                                            @foreach (App\Models\Departments::all() as $departemen)
                                                <option value="{{ $departemen->id }}">
                                                    {{ $departemen->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        {{-- {{ $traveler->deptTujuan->name ?? '-' }} --}}
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <button type="submit"
                                            class="px-2 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                            Terbitkan
                                        </button>
                                    </td>
                                </form>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-4 py-2 text-center text-gray-500">
                                    Data Traveler Rework Tidak Ada.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
                {{-- pagination --}}
                <div class="p-3">
                    {{ $reworkTravelers->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

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
            {{-- Search & Add KKPO Modal --}}
            <div class="flex items-center justify-between mb-4">
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID</th> --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($kkpos->count())
                                @foreach ($kkpos as $kkpo)
                                    <tr>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $kkpo->id }}</td> --}}
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $kkpo->no_kkpo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button onClick="editKkpo({{ $kkpo->id }}, '{{ $kkpo->no_kkpo }}')"
                                                class="mr-2" title="Edit">
                                                <svg class="w-6 h-6 text-blue-500 hover:text-blue-700"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('ppic.kkpo.delete', $kkpo->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Delete"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus KKPO ini?')">
                                                    <svg class="w-6 h-6 text-red-500 hover:text-red-700"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" fill="none" viewBox="0 0 24 24">
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
                                    <td colspan="2" class="text-center py-4 text-gray-500">
                                        No KKPO found
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
            <div id="addModal" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-medium">Add KKPO</h3>
                        <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                    <form id="crud-form" action="{{ route('ppic.kkpo.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="kkpo_id" id="kkpo_id">
                        <div class="mb-4">
                            <label for="no_kkpo" class="block text-gray-700">No KKPO</label>
                            <input type="text" name="no_kkpo" id="no_kkpo" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                        </div>
                        <button type="submit" id="submit-button"
                            class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                            Add KKPO
                        </button>
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

            document.getElementById('kkpo_id').value = '';
            document.getElementById('no_kkpo').value = '';

            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }

        function editKkpo(id, no_kkpo) {
            document.getElementById('modal-title').textContent = 'Edit KKPO';
            document.getElementById('submit-button').textContent = 'Update KKPO';
            document.getElementById('crud-form').action = '{{ route('ppic.kkpo.update', ':id') }}/'.replace(':id',
                id);
            document.getElementById('form-method').value = 'PUT';

            document.getElementById('kkpo_id').value = id;
            document.getElementById('no_kkpo').value = no_kkpo;

            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }
    </script>
</x-app-layout>

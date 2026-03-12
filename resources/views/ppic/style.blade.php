@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Style
    </h2>
    @if (session('success'))
        <div class="mt-4">
            <x-alerts variant="success" title="Success" :message="session('success')" :showLink="false" />
        </div>
        {{-- @elseif (session('error'))
        <div class="mt-4">
            <x-alerts variant="danger" title="Error" :message="session('error')" :showLink="false" />
        </div> --}}
    @endif
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- Search & Add Style Modal --}}
            <div class="flex items-center justify-between mb-4">
                <form action="{{ route('ppic.style') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Search styles..."
                        class="border border-gray-300 rounded-lg px-4 py-2" value="{{ request('search') }}">
                    <button type="submit" class="bg-[#136566] text-white px-4 py-2 rounded-lg hover:bg-[#0f4f50]">
                        Search
                    </button>
                </form>

                <button onClick="openAddModal()" class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                    Add Style
                </button>
            </div>
            {{-- Style Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th> --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($styles->count())
                                @foreach ($styles as $style)
                                    <tr>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $style->id }}</td> --}}
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $style->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button onClick="editStyle({{ $style->id }}, '{{ $style->name }}')"
                                                class="text-blue-500 hover:text-blue-700 mr-2">Edit</button>
                                            <form action="{{ route('ppic.style.delete', $style->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengapus style ini?')"
                                                    class="text-red-500 hover:text-red-700">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        No styles found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-4 p-4">
                        {{ $styles->links() }}
                    </div>
                </div>
            </div>
            {{-- Modal Add & Edit Style --}}
            <div id="addModal" class="hidden fixed inset-0 bg-gray-600  bg-opacity-50 items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-medium">Add Style</h3>
                        <button onClick="closeAddModal()" class="text-gray-500 text-2xl hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                    <form id="crud-form" action="{{ route('ppic.style.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="style_id" id="style_id">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Style Name</label>
                            <input type="text" name="name" id="name" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                        </div>
                        <button type="submit" id="submit-button"
                            class="px-4 py-2 bg-[#136566] text-white rounded-lg hover:bg-[#0f4f50]">
                            Add Style
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex')
            document.getElementById('modal-title').textContent = 'Add Style';
            document.getElementById('submit-button').textContent = 'Add Style';
            document.getElementById('crud-form').action = "{{ route('ppic.style.store') }}";
            document.getElementById('form-method').value = 'POST';
            document.getElementById('style_id').value = '';
            document.getElementById('name').value = '';
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex')
        }

        function editStyle(id, name) {
            openAddModal();
            document.getElementById('modal-title').textContent = 'Edit Style';
            document.getElementById('submit-button').textContent = 'Update Style';
            document.getElementById('crud-form').action = '{{ route('ppic.style.update', ':id') }}/'.replace(':id',
                id);
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('style_id').value = id;
            document.getElementById('name').value = name;
        }
    </script>
@endsection

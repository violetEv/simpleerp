<x-app-layout>
    <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
        Detail KKPO
    </h2>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi KKPO</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>No KKPO:</strong> {{ $kkpo->kkpo->no_kkpo }}</p>
                        <p><strong>Customer:</strong> {{ $kkpo->kkpo->customer->name ?? '-' }}</p>
                        <p><strong>Style:</strong> {{ $kkpo->style->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p><strong>Qty:</strong> {{ $kkpo->qty_total ?? '-' }}</p>
                        <p><strong>Due Date:</strong> {{ $kkpo->date ?? '-' }}</p>
                        <p><strong>Status:</strong> {{ $kkpo->status ?? '-' }}</p>
                    </div>
                </div>
            </div>
            {{-- ALERT --}}
            {{-- @if (session('success'))
                <div class="alert alert-success mt-4">{{ session('success') }}</div>
            @endif      
            @if (session('error'))
                <div class="alert alert-danger mt-4">{{ session('error') }}</div>
            @endif --}}
            {{-- BRAND --}}
            {{-- <div class="bg-white shadow rounded-lg p-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Brand</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($kkpo->brands->count())
                                @foreach ($kkpo->brands as $brand)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $brand->name }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>    
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">No brands associated.</td>
                                </tr>
                            @endif
                        </tbody>    
                    </table>
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
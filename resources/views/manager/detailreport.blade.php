<x-app-layout>
{{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Report
</h2> --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('manager.report') }}"
           class="text-sm text-blue-500">
            ← Kembali
        </a>
    </div>
<div>
    <div class="max-w-7xl mx-auto">
        {{-- CARD DETAIL REPORT --}}
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Report</h3>
            @foreach ($movement->traveler->movements as $movement)
                <p><strong>No Traveler:</strong> {{ $movement->traveler->no_traveler }}</p>
                <p><strong>Customer:</strong> {{ $movement->traveler->suratJalan->kkpoManagement->customer->name ?? '-' }}</p>
                <p><strong>Category:</strong> {{ $movement->traveler->suratJalan->kkpoManagement->category->name ?? '-' }}</p>
                <p><strong>Style:</strong> {{ $movement->traveler->suratJalan->kkpoManagement->style->name ?? '-' }}</p>
                <hr class="my-4">
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
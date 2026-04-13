<x-app-layout>
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Report
</h2>
<div class="py-6">
    <div class="max-w-7xl mx-auto">
        {{-- CARD DETAIL REPORT --}}
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Report</h3>
            @foreach ($movement as $movement)
                <p><strong>No Traveler:</strong> {{ $movement->traveler->no_traveler }}</p>
                <p><strong>Customer:</strong> {{ $movement->traveler->suratJalan->kkpo->customer->name ?? '-' }}</p>
                <p><strong>Category:</strong> {{ $movement->traveler->suratJalan->kkpo->category->name ?? '-' }}</p>
                <p><strong>Style:</strong> {{ $movement->traveler->suratJalan->kkpo->style->name ?? '-' }}</p>
                <hr class="my-4">
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
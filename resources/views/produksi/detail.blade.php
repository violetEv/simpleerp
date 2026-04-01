@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Log Detail
    </h2>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- card detail log --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Log Detail</h3>
                <p><strong>No Traveler:</strong> {{ $movement->traveler->no_traveler }}</p>
                <p><strong>Department:</strong> {{ $movement->department->name ?? '-' }}</p>
                <p><strong>Qty In:</strong> {{ $movement->qty_in ?? '-' }}</p>
                <p><strong>Qty Out:</strong> {{ $movement->qty_out ?? '-' }}</p>
                <p><strong>Date In:</strong> {{ $movement->date_in ?? '-' }}</p>
                <p><strong>Date Out:</strong> {{ $movement->date_out ?? '-' }}</p>
                <p><strong>Machine:</strong> {{ $movement->machine->name ?? '-' }}</p>
                <p><strong>Notes:</strong> {{ $movement->notes ?? '-' }}</p>
            </div>
        </div>
    </div>
@endsection
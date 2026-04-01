@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Log Detail
    </h2>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
        {{-- CARD DETAIL TRAVELER --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Traveler Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>No Traveler:</strong> {{ $movement->traveler->no_traveler }}</p>
                        {{-- <p><strong>Current Dept:</strong> {{ $movement->department->name ?? '-' }}</p> --}}
                        <p><strong>Qty In:</strong> {{ $movement->qty_in ?? '-' }}</p>
                        <p><strong>Qty Out:</strong> {{ $movement->qty_out ?? '-' }}</p>
                        <p><strong>Status:</strong> {{ $movement->traveler->status }}</p>
                    </div>
                    <div>
                        <p><strong>Created At:</strong> {{ $movement->created_at }}</p>
                        <p><strong>Updated At:</strong> {{ $movement->updated_at }}</p>
                    </div>
                </div>
            </div>

            {{-- CARD DETAIL MOVEMENT --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Movement Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>Qty In:</strong> {{ $movement->qty_in ?? '-' }}</p>
                        <p><strong>Qty Out:</strong> {{ $movement->qty_out ?? '-' }}</p>
                    </div>
                    <div>
                        @if ($movement->machine)
                            <p><strong>Mesin:</strong> {{ $movement->machine->name }}</p>
                        @else
                            <p><strong>Mesin:</strong> -</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
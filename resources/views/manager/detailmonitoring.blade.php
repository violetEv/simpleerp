@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Detail Monitoring
    </h2>
    {{-- card detail monitoring --}}
    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Traveler: {{ $movement->traveler->no_traveler }}</h3>
        <p><strong>Department:</strong> {{ $movement->department->name }}</p>
        <p><strong>Status:</strong> {{ $movement->status }}</p>
        <p><strong>Start Time:</strong> {{ $movement->start_time }}</p>
        <p><strong>End Time:</strong> {{ $movement->end_time }}</p>
        {{-- Add more details as needed --}}
    </div>

@endsection

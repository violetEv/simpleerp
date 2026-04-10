@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Detail Monitoring
    </h2>
    {{-- card detail monitoring --}}
    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Traveler: {{ $movement->traveler->no_traveler }}</h3>
        <p><strong>Posisi Sekarang:</strong> {{ $movement->traveler->deptAsal->name }}</p>
        {{-- <p><strong>Status:</strong> {{ $movement->status }}</p>
        <p><strong>Start Time:</strong> {{ $movement->start_time }}</p>
        <p><strong>End Time:</strong> {{ $movement->end_time }}</p> --}}
        {{-- table pergerakan traveler berdasar departemen  ada di departemen mana, qty berapa, statusnya apa, start time, end time, dll --}}
        <div class="mt-6">
            <h4 class="text-md font-medium text-gray-900 mb-2">Movement History</h4>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Department</th>
                        <th class="py-2 px-4 border-b">Qty In</th>
                        <th class="py-2 px-4 border-b">Qty Out</th>
                        <th class="py-2 px-4 border-b">Balance</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Tanggal In</th>
                        <th class="py-2 px-4 border-b">Tanggal Out</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movement->traveler->movements as $mov)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $mov->department->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $mov->qty_in }}</td>
                            <td class="py-2 px-4 border-b">{{ $mov->qty_out }}</td>
                            <td class="py-2 px-4 border-b">{{ $mov->balance }}</td>
                            <td class="py-2 px-4 border-b">
                                @if ($mov->traveler->status == 'in_progress')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        In Progress
                                    </span>
                                @elseif ($mov->traveler->status == 'done')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Done
                                    </span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b">{{ $mov->traveler->date_in }}</td>
                            <td class="py-2 px-4 border-b">{{ $mov->traveler->date_out }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

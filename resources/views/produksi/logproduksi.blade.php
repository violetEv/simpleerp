@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Log
    </h2>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            {{-- TABLE --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                                Traveler</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Departemen Asal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departemen Tujuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($movements->count())
                            @foreach ($movements as $movement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $movement->traveler->no_traveler }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $movement->traveler->deptAsal->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $movement->traveler->deptTujuan->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $movement->traveler->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('produksi.logdetail', $movement->id) }}"
                                            class="text-blue-600 hover:text-blue-900">View Log</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">No travelers found.</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
                <div class="p-3">
                    {{ $movements->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection

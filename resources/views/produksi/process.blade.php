@extends('layouts.app')

@section('content')

    @php
        $dept = auth()->user()->department->name;
    @endphp

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        List Traveler
    </h2>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">

            {{-- INFO TRAVELER --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Traveler Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>No Traveler:</strong> {{ $traveler->no_traveler }}</p>
                        <p><strong>Departemen Asal:</strong> {{ $traveler->deptAsal->name ?? '-' }}</p>
                        <p><strong>Status:</strong> {{ $traveler->status }}</p>
                    </div>
                    <div>
                        <p><strong>Created At:</strong> {{ $traveler->created_at }}</p>
                        <p><strong>Updated At:</strong> {{ $traveler->updated_at }}</p>
                    </div>
                </div>
            </div>
            {{-- ALERT --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            {{-- STEP 1: INPUT IN --}}
            @if (!$movement || !$movement->qty_in)
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Input Qty In</h3>
                    <form action="{{ route('produksi.in', $traveler->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="traveler_id" value="{{ $traveler->id }}">
                        <div class="mb-4">
                            <label for="qty_in" class="block text-sm font-medium text-gray-700">Qty In</label>
                            <input type="number" name="qty_in" id="qty_in" min="0"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required>
                        </div>

                        {{-- Mesin hanya untuk dyeing dan washing --}}
                        @if (in_array($dept, ['Dyeing', 'Washing']))
                            <div class="mb-4">
                                <label for="machine_id" class="block text-sm font-medium text-gray-700">Mesin</label>
                                <select name="machine_id" id="machine_id" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select Mesin</option>
                                    @foreach ($machines as $machine)
                                        <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <button type="submit" onclick="return confirm('Data yang sudah disimpan tidak dapat diubah kembali. Apa Anda yakin ingin menyimpan?')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">SIMPAN
                            IN</button>
                    </form>
                </div>
            @endif

            {{-- STEP 2: INPUT OUT --}}
            @if ($movement && $movement->qty_in && !$movement->qty_out)
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Input Qty Out</h3>
                    <form action="{{ route('produksi.out', $traveler->id) }}" method="POST" id="formOut">
                        @csrf
                        <input type="hidden" id="qty_in_hidden" value="{{ $movement->qty_in }}">
                        <input type="hidden" name="traveler_id" value="{{ $traveler->id }}">
                        <div class="mb-4">
                            <label for="qty_out" class="block text-sm font-medium text-gray-700">Qty Out</label>
                            <input type="number" name="qty_out" id="qty_out" min="0"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required>
                        </div>

                        {{-- QC ONLY --}}
                        @if (in_array($dept, ['QC Before', 'QC After']))
                            <div class="mb-4">
                                <label for="qty_reject" class="block text-sm font-medium text-gray-700">Qty Reject</label>
                                <input type="number" name="qty_reject" id="qty_reject" min="0"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div class="mb-4">
                                <label for="type_reject" class="block text-sm font-medium text-gray-700">Reject
                                    Reason</label>
                                <input type="text" name="type_reject" id="type_reject"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        @endif

                        {{-- DESTINATION KECUALI SEND --}}
                        @if ($dept != 'Send')
                            <div class="mb-4">
                                <label for="dept_tujuan_id" class="block text-sm font-medium text-gray-700">Destination
                                    Department</label>
                                <select name="dept_tujuan_id" id="dept_tujuan_id" 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Optional)</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                        </div>

                        {{-- WARNING SELISIH --}}
                        <div id="warning-selisih" class="mb-4 hidden">
                            <p class="text-sm text-red-600">Warning: Qty Out is less than Qty In. Please provide a reason.
                            </p>
                        </div>

                        <button type="submit" onclick="return confirm('Data yang sudah disimpan tidak dapat diubah kembali. Apakah Anda yakin ingin menyimpan data?')"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">SIMPAN
                            OUT</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    {{-- JS VALIDASI SELISIH --}}
    <script>
        document.getElementById('formOut')?.addEventListener('input', function() {

            let qtyIn = parseInt(document.getElementById('qty_in_hidden').value) || 0;
            let qtyOut = parseInt(document.getElementById('qty_out').value) || 0;
            let qtyReject = parseInt(document.getElementById('qty_reject')?.value) || 0;

            let selisih = qtyIn - (qtyOut + qtyReject);

            let warning = document.getElementById('warning-selisih');
            if (selisih > 0) {
                warning.classList.remove('hidden');
                warning.innerHTML = "⚠️ Selisih " + selisih + " pcs (kemungkinan hilang)";
            } else {
                warning.classList.add('hidden');
            }

        });
    </script>

@endsection

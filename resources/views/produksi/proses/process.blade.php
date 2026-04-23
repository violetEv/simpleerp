<x-app-layout>
    @php
        $dept = auth()->user()->department->name;
    @endphp

    <div class="flex justify-end mb-4">
        <a href="{{ route('produksi.proses.index') }}" class="text-sm text-blue-500">
            ← Kembali
        </a>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">

            {{-- INFO --}}
            @include('produksi.proses.partials.info')

            {{-- STEP IN --}}
            @if (!$movementActive)
                @include('produksi.proses.partials.form-in')
            @endif

            {{-- STEP OUT --}}
            @if ($movementActive && $movementActive->qty_in && !$movementActive->date_out)
                @include('produksi.proses.partials.form-out')
            @endif

        </div>
    </div>
    @include('produksi.proses.components.modal-selisih')
    @include('produksi.proses.components.modal-selisih-out')

    {{-- @include('produksi.proses.partials.script') --}}

</x-app-layout>

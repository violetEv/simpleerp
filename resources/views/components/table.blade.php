<div
    class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition overflow-visible">

    <table class="min-w-full table-fixed text-gray-800">

        {{-- THEAD --}}
        <thead
            class="bg-[#136566]/10 text-gray-700 border-b border-[#136566]/30 text-[11px] uppercase tracking-wide">
            {{ $head }}
        </thead>

        <tbody class="bg-white text-sm">
            {{ $slot }}
        </tbody>

    </table>
    {{-- PAGINATION --}}
    <div class="p-3">
        {{ $pagination ?? '' }}
    </div>
</div>
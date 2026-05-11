@props([
    'name',
    'id' => null,
    'options' => [],
    'value' => null,
    'label' => null,
    'placeholder' => 'Pilih data...',
    'searchPlaceholder' => '',
    'required' => false,
    'onChange' => null,
])

<div
    id="{{ $id ?? $name }}"
    x-data="selectSearch({
        options: @js($options),
        selected: @js($value),
        placeholder: '{{ $placeholder }}',
        searchPlaceholder: '{{ $searchPlaceholder }}',
        onChange: {{ $onChange ? "'$onChange'" : 'null' }}
    })"
    class="relative w-full"
>

    {{-- LABEL --}}
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif

    {{-- HIDDEN INPUT --}}
    <input type="hidden" name="{{ $name }}" :value="selected">

    {{-- VALIDATION TRIGGER --}}
    <input type="text"
        x-model="selected"
        class="absolute opacity-0 pointer-events-none"
        tabindex="-1"
        {{ $required ? 'required' : '' }}>

    {{-- SELECT BOX --}}
    <div
        @click="if(!disabled) toggle()"
        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-white cursor-pointer
               transition
               hover:border-gray-400
               focus-within:ring-2 focus-within:ring-[#136566]/30 focus-within:border-[#136566]"
        :class="{ 'bg-gray-100 cursor-not-allowed opacity-70': disabled }"
    >
        <span class="text-sm text-gray-700" x-text="selectedLabel"></span>
    </div>

    {{-- DROPDOWN --}}
    <div
        x-show="open"
        x-transition
        @click.outside="open = false"
        class="absolute z-50 mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden"
    >

        {{-- SEARCH --}}
        <div class="p-2 border-b border-gray-100">
            <input
                type="text"
                x-model="search"
                :placeholder="searchPlaceholder"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm
                       focus:ring-2 focus:ring-[#136566]/30 focus:border-[#136566]"
            >
        </div>

        {{-- OPTIONS --}}
        <ul class="max-h-52 overflow-y-auto text-sm">

            <template x-for="option in filteredOptions" :key="option.value">
                <li
                    @click="select(option)"
                    class="px-4 py-2 cursor-pointer hover:bg-gray-50 transition"
                >
                    <span x-text="option.label"></span>
                </li>
            </template>

            <li x-show="filteredOptions.length === 0"
                class="px-4 py-3 text-gray-500 text-sm">
                No data found.
            </li>

        </ul>
    </div>
</div>
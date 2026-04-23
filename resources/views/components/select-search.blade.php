@props([
    'name',
    'id' => null,
    'options' => [],
    'value' => null,
    'label' => null,
    'placeholder' => 'Pilih data...',
    'searchPlaceholder' => 'Cari...',
    'onChange' => null,
])

<div id="{{ $id ?? $name }}" x-data="selectSearch({
    options: @js($options),
    selected: @js($value),
    placeholder: '{{ $placeholder }}'
})" class="relative w-full">
    @if ($label)
        <label class="block text-gray-700 mb-1">{{ $label }}</label>
    @endif

    {{-- hidden input --}}
    <input type="hidden" name="{{ $name }}" :value="selected">

    {{-- trigger --}}
    <div @click="toggle" class="w-full border border-gray-300 rounded px-3 py-2 bg-white cursor-pointer">
        <span x-text="selectedLabel || placeholder"></span>
    </div>

    {{-- dropdown --}}
    <div x-show="open" x-transition @click.outside="open = false"
        class="absolute z-50 mt-1 w-full bg-white border rounded shadow">
        {{-- search --}}
        <div class="p-2">
            <input type="text" x-model="search" placeholder="{{ $searchPlaceholder }}"
                class="w-full border px-2 py-1 rounded">
        </div>

        {{-- options --}}
        <ul class="max-h-48 overflow-y-auto">
            <template x-for="option in filteredOptions" :key="option.value">
                <li @click="
        select(option);
        {{ $onChange ? $onChange . '(option)' : '' }}"
                    class="px-3 py-2 hover:bg-gray-100 cursor-pointer"
                    :class="{ 'bg-gray-100': isSelected(option.value) }">
                    <span x-text="option.label"></span>
                </li>
            </template>

            <li x-show="filteredOptions.length === 0" class="px-3 py-2 text-gray-500">
                Tidak ada data
            </li>
        </ul>
    </div>
</div>

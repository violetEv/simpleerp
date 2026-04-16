@props([
    'name',
    'id' => null,
    'options' => [],
    'value' => null,
    'label' => null,
    'placeholder' => 'Pilih data...',
    'searchPlaceholder' => 'Cari...',
    'required' => false,
])

<div>
    @if ($label)
        <label for="{{ $id ?? $name }}" class="block text-gray-700">
            {{ $label }}
        </label>
    @endif

    <select name="{{ $name }}" id="{{ $id ?? $name }}" {{ $required ? 'required' : '' }}
        data-hs-select='{
            "hasSearch": true,
            "searchPlaceholder": "{{ $searchPlaceholder }}",
            "placeholder": "{{ $placeholder }}",
            "toggleClasses": "mt-1 relative py-2 px-3 flex w-full cursor-pointer bg-white border border-gray-300 rounded text-sm text-left",
            "dropdownClasses": "mt-2 max-h-60 z-50 overflow-y-auto w-full bg-white border border-gray-200 rounded-lg shadow-lg",
            "optionClasses": "px-3 py-2 text-sm cursor-pointer hover:bg-gray-100 rounded",
            "searchWrapperClasses": "p-2 sticky top-0 bg-white",
            "searchClasses": "w-full px-2 py-1 border border-gray-300 rounded"
        }'>
        <option value="">{{ $placeholder }}</option>

        {{-- @foreach ($options as $option)
            <option value="{{ $option['value'] }}"
                {{ $value == $option['value'] ? 'selected' : '' }}>
                {{ $option['label'] }}
            </option>
        @endforeach --}}
        @foreach ($options as $option)
            <option value="{{ $option['value'] }}" {{ $value == $option['value'] ? 'selected' : '' }}
                @if (isset($option['data'])) @foreach ($option['data'] as $key => $val)
                data-{{ $key }}="{{ $val }}"
            @endforeach @endif>
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>
</div>

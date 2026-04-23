@props(['items' => []])

<nav class="flex mb-2e" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">

        @foreach ($items as $item)
            <li class="inline-flex items-center">

                {{-- ITEM PERTAMA --}}
                @if ($loop->first)
                    <a href="{{ $item['url'] }}"
                       class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">

                        {{-- ICON (optional) --}}
                        @if (!empty($item['icon']))
                            <i class="{{ $item['icon'] }} mr-1"></i>
                        @endif

                        {{ $item['label'] }}
                    </a>

                @else
                    <div class="flex items-center space-x-1.5">

                        {{-- 🔥 ICON PANAH --}}
                        <svg class="w-3.5 h-3.5 text-gray-400"
                             xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="m9 5 7 7-7 7" />
                        </svg>

                        {{-- LAST ITEM --}}
                        @if ($loop->last)
                            <span class="text-sm font-medium text-gray-800">
                                @if (!empty($item['icon']))
                                    <i class="{{ $item['icon'] }} mr-1"></i>
                                @endif
                                {{ $item['label'] }}
                            </span>
                        @else
                            <a href="{{ $item['url'] }}"
                               class="text-sm font-medium text-gray-500 hover:text-gray-700">

                                @if (!empty($item['icon']))
                                    <i class="{{ $item['icon'] }} mr-1"></i>
                                @endif

                                {{ $item['label'] }}
                            </a>
                        @endif

                    </div>
                @endif

            </li>
        @endforeach

    </ol>
</nav>
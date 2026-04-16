@php
    use App\Helpers\MenuResolver;
    $menus = MenuResolver::get();
@endphp

<aside
    class="fixed xl:fixed top-0 left-0 z-50 h-screen
          bg-[#0f4f50] text-white
           transition-all duration-300 ease-in-out
           shadow-xl"
    :class="[
        $store.sidebar.isExpanded ? 'w-64' : 'w-20',
        $store.sidebar.isMobileOpen ? 'translate-x-0' : '-translate-x-full xl:translate-x-0'
    ]">

    {{-- LOGO --}}
    <div class="h-16 flex items-center justify-center bg-[#136566] border-b border-[#1b7a7b]">
        <span x-show="$store.sidebar.isExpanded" x-transition class="text-white font-semibold">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </span>
        <span x-show="!$store.sidebar.isExpanded" x-transition class="text-white font-semibold">
            LA
        </span>
    </div>

    {{-- <div class="no-scrollbar"> --}}
    <nav class="p-3 space-y-1 overflow-y-auto h-[calc(100vh-64px)]">

        @foreach ($menus as $menu)
            @if (isset($menu['sub']))
                <div x-data="{ open: false }">

                    <button @click="open=!open"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-md
                               hover:bg-[#1b7a7b] transition">

                        <div class="flex items-center gap-3">
                            <i class="{{ $menu['icon'] }} w-5 text-center"></i>

                            <span x-show="$store.sidebar.isExpanded" x-transition>
                                {{ $menu['name'] }}
                            </span>
                        </div>

                        <svg x-show="$store.sidebar.isExpanded" :class="open ? 'rotate-90' : ''"
                            class="w-3 h-3 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 6L14 10L6 14V6Z" />
                        </svg>
                    </button>

                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        @foreach ($menu['sub'] as $sub)
                            <a href="{{ route($sub['route']) }}"
                                class="block px-3 py-2 text-sm rounded hover:bg-[#1b7a7b]
{{ request()->routeIs($sub['route']) ? 'bg-[#0b3f40] text-white' : '' }}">
                                {{ $sub['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ route($menu['route']) }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[#1b7a7b]
{{ request()->routeIs($menu['route']) ? 'bg-[#0b3f40] text-white' : '' }}">

                    <i class="{{ $menu['icon'] }} w-5 text-center"></i>

                    <span x-show="$store.sidebar.isExpanded" x-transition>
                        {{ $menu['name'] }}
                    </span>
                </a>
            @endif
        @endforeach

    </nav>
    {{-- </div> --}}
</aside>

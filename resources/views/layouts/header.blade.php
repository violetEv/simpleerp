<header class="sticky top-0 z-30 flex w-full bg-white border-b border-gray-200">

    <div class="flex items-center justify-between w-full px-4 py-3 xl:px-6">

        {{-- LEFT SECTION --}}
        <div class="flex items-center gap-3">

            {{-- Desktop Toggle --}}
            <button type="button" @click="$store.sidebar.toggleExpanded()"
                class="hidden xl:flex items-center justify-center w-10 h-10 
           text-gray-500 border border-gray-200 rounded-lg 
           hover:bg-gray-100 transition">

                {{-- Hamburger --}}
                <svg width="18" height="14" viewBox="0 0 16 12" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.5 1C0.5 0.58 0.83 0.25 1.25 0.25H14.75C15.17 0.25 15.5 0.58 15.5 1C15.5 1.41 15.17 1.75 14.75 1.75H1.25C0.83 1.75 0.5 1.41 0.5 1ZM0.5 6C0.5 5.58 0.83 5.25 1.25 5.25H10C10.41 5.25 10.75 5.58 10.75 6C10.75 6.41 10.41 6.75 10 6.75H1.25C0.83 6.75 0.5 6.41 0.5 6ZM0.5 11C0.5 10.58 0.83 10.25 1.25 10.25H14.75C15.17 10.25 15.5 10.58 15.5 11C15.5 11.41 15.17 11.75 14.75 11.75H1.25C0.83 11.75 0.5 11.41 0.5 11Z"
                        fill="currentColor" />
                </svg>
            </button>

            {{-- Mobile Toggle --}}
            <button
                class="flex xl:hidden items-center justify-center w-10 h-10 text-gray-500 rounded-lg hover:bg-gray-100 transition"
                :class="{ 'bg-gray-100': $store.sidebar.isMobileOpen }" @click="$store.sidebar.toggleMobileOpen()">

                <svg width="18" height="14" viewBox="0 0 16 12" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.5 1C0.5 0.58 0.83 0.25 1.25 0.25H14.75C15.17 0.25 15.5 0.58 15.5 1C15.5 1.41 15.17 1.75 14.75 1.75H1.25C0.83 1.75 0.5 1.41 0.5 1ZM0.5 6C0.5 5.58 0.83 5.25 1.25 5.25H10C10.41 5.25 10.75 5.58 10.75 6C10.75 6.41 10.41 6.75 10 6.75H1.25C0.83 6.75 0.5 6.41 0.5 6ZM0.5 11C0.5 10.58 0.83 10.25 1.25 10.25H14.75C15.17 10.25 15.5 10.58 15.5 11C15.5 11.41 15.17 11.75 14.75 11.75H1.25C0.83 11.75 0.5 11.41 0.5 11Z"
                        fill="currentColor" />
                </svg>
            </button>

            <h1 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                {{ auth()->user()->department_id ? auth()->user()->department->name : 'No Department' }}
            </h1>
        </div>

        {{-- RIGHT --}}
        <div x-data="{ open: false }" class="relative">

            <button @click="open=!open" class="flex items-center gap-2 focus:outline-none">

                <div class="w-9 h-9 bg-gray-300 rounded-full"></div>

                <span class="hidden md:block text-sm font-medium text-gray-700">
                    {{ auth()->user()->name }}
                </span>

                <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="open" x-transition @click.away="open=false"
                class="absolute right-0 mt-2 w-44 bg-white border rounded-lg shadow-lg">

                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>

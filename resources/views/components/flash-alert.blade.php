@if (session('success') || session('error'))
    @php
        $isSuccess = session()->has('success');
        $message = $isSuccess ? session('success') : session('error');
    @endphp

    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition:enter="transform ease-out duration-300"
        x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transform ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="translate-x-full opacity-0" class="fixed top-16 right-6 z-[9999]">

        <div
            class="flex items-center gap-3 px-4 py-2 rounded-xl shadow-lg min-w-[300px]
            {{ $isSuccess ? 'bg-[#136566] text-white' : 'bg-red-500 text-white' }}">

            {{-- Icon --}}
            @if ($isSuccess)
                <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M9 12l2 2l4-4"></path>
                    <circle cx="12" cy="12" r="10"></circle>
                </svg>
            @else
                <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M8 8l8 8"></path>
                    <path d="M16 8l-8 8"></path>
                </svg>
            @endif

            <span class="font-medium">
                {{ $message }}
            </span>

            {{-- Close --}}
            <button @click="show = false" class="ml-auto text-white/70 hover:text-white text-xl leading-none">
                &times;
            </button>

        </div>
    </div>
@endif

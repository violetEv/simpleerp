<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta http-equiv="refresh" content="30">  --}}
    <title>SimpleERP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />


</head>

<body x-data class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- BACKDROP MOBILE --}}
        @include('layouts.backdrop')
        {{-- RIGHT SIDE --}}
        <div class="flex flex-col flex-1 transition-all duration-300"
            :class="$store.sidebar.isExpanded ? 'xl:ml-64' : 'xl:ml-20'">

            @include('layouts.header')

            <main class="flex-1 overflow-y-auto p-6">
                {{-- @yield('content') --}}
                {{ $slot }}
            </main>

        </div>

    </div>
    {{-- script preline --}}
    <script src="https://cdn.jsdelivr.net/npm/preline@1.8.0/dist/preline.min.js"></script>
    <script>
        window.addEventListener('load', () => {
            if (window.HSStaticMethods) {
                window.HSStaticMethods.autoInit();
            }
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DAW_24_25</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="font-sans antialiased">
    <div class="bg-gray-50 text-black/50 max-width">
        <div class="relative min-h-screen flex flex-col">
            <div class="relative w-full ">
                <header class="absolute top-0 right-0 p-4">
                    @if (Route::has('login'))
                        {{-- Aquí es dónde tengo que poner la condición de que si es el administrador, que carge adminlte y si no que carge el menu normal --}}
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="text-xl rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Manú principal
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-xl rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="text-xl rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="flex flex-col justify-center items-center min-h-screen">
                    <div>
                        <img src="{{ asset('img/logoSANGUT.png') }}" alt="logo" class="max-w-full h-auto">
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>

</html>

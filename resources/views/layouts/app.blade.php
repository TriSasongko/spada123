<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-100">

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex h-screen bg-gray-200 font-roboto">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300">

            <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-indigo-600 shadow-sm">
                <div class="flex items-center">

                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-500 focus:outline-none hover:text-indigo-600 transition">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <div class="ml-4 font-semibold text-xl text-gray-800">
                        @if (isset($header))
                            {{ $header }}
                        @endif
                    </div>
                </div>

                <div class="flex items-center">
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = ! dropdownOpen"
                            class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none hover:ring-2 hover:ring-indigo-500 transition">
                            @if (Auth::user()->avatar)
                                <img class="h-full w-full object-cover"
                                    src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
                            @else
                                <div
                                    class="h-full w-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </button>

                        <div x-show="dropdownOpen" @click="dropdownOpen = false"
                            class="fixed inset-0 h-full w-full z-10" style="display: none;"></div>

                        <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-20"
                            style="display: none;">

                            <div class="px-4 py-2 bg-indigo-600 text-white">
                                <p class="text-xs opacity-75">Login sebagai:</p>
                                <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                            </div>

                            @if (Auth::user()->role === 'guru')
                                <a href="{{ route('guru.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Dashboard Guru</a>
                            @elseif(Auth::user()->role === 'siswa')
                                <a href="{{ route('siswa.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Dashboard Siswa</a>
                            @endif

                            <a href="{{ route('my.profile') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Profil Saya</a>

                            <div class="border-t border-gray-100"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                {{ $slot }}
            </main>

        </div>
    </div>
</body>

</html>

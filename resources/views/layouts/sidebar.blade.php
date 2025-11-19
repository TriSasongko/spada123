<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden">
</div>

<div :class="sidebarOpen ? 'translate-x-0 lg:w-64' : '-translate-x-full lg:w-0'"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 transition-all duration-300 ease-in-out lg:static lg:inset-auto lg:translate-x-0 overflow-hidden">
    <div class="w-64">

        <div class="flex items-center justify-center mt-8 border-b border-gray-800 pb-6">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
                <span class="text-2xl font-bold text-white">SPADA</span>
            </div>
        </div>

        <nav class="mt-6 space-y-2 px-4 pb-20">

            @if (Auth::user()->role === 'guru')
                <a href="{{ route('guru.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-200 transition-colors {{ request()->routeIs('guru.dashboard') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-gray-800' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="mx-3 font-medium">Dashboard</span>
                </a>

                <p class="px-4 mt-6 text-xs font-bold text-gray-500 uppercase">Akademik</p>

                <a href="{{ route('guru.materi.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-200 transition-colors {{ request()->routeIs('guru.materi.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-gray-800' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <span class="mx-3 font-medium">Materi</span>
                </a>

                <a href="{{ route('guru.tugas.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-200 transition-colors {{ request()->routeIs('guru.tugas.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-gray-800' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <span class="mx-3 font-medium">Tugas</span>
                </a>

                <a href="{{ route('guru.ujian.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-200 transition-colors {{ request()->routeIs('guru.ujian.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-gray-800' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span class="mx-3 font-medium">Ujian</span>
                </a>

                <p class="px-4 mt-6 text-xs font-bold text-gray-500 uppercase">Laporan</p>

                <a href="{{ route('guru.absensi.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-200 transition-colors {{ request()->routeIs('guru.absensi.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-gray-800' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="mx-3 font-medium">Absensi</span>
                </a>

                <a href="{{ route('guru.rekap.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-200 transition-colors {{ request()->routeIs('guru.rekap.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-gray-800' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span class="mx-3 font-medium">Rekap Nilai</span>
                </a>
            @elseif(Auth::user()->role === 'siswa')
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-200 transition-colors {{ request()->routeIs('siswa.dashboard') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-gray-800' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="mx-3 font-medium">Dashboard</span>
                </a>

                <a href="{{ route('my.profile') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-200 transition-colors {{ request()->routeIs('my.profile') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-gray-800' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="mx-3 font-medium">Profil Saya</span>
                </a>
            @endif

        </nav>
    </div>
</div>

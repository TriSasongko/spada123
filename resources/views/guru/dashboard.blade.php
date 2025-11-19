<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard Guru') }}
    </x-slot>

    @if(isset($pengumumans) && $pengumumans->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-bold mb-4 text-gray-700 flex items-center">
                📢 Informasi Sekolah
            </h3>
            <div class="grid gap-4">
                @foreach($pengumumans as $info)
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r shadow-sm flex items-start hover:bg-blue-100 transition">
                        <div class="mr-4 text-blue-500 mt-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-blue-900 text-lg">{{ $info->judul }}</h4>
                            <p class="text-sm text-blue-700 mt-1 whitespace-pre-line">{{ $info->isi }}</p>
                            <div class="flex justify-between items-center mt-2 border-t border-blue-200 pt-2">
                                <span class="text-xs text-blue-400 italic">
                                    Diposting: {{ $info->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <h3 class="text-gray-700 text-3xl font-medium mb-4">Statistik Mengajar</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:shadow-md transition">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Total Materi</p>
                <p class="text-lg font-semibold text-gray-700">{{ $total_mapel ?? 0 }}</p>
            </div>
        </div>

        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:shadow-md transition">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Tugas Dibuat</p>
                <p class="text-lg font-semibold text-gray-700">{{ $total_tugas ?? 0 }}</p>
            </div>
        </div>

        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:shadow-md transition">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Ujian Aktif</p>
                <p class="text-lg font-semibold text-gray-700">{{ $total_ujian ?? 0 }}</p>
            </div>
        </div>

        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:shadow-md transition">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Kelas Diajar</p>
                <p class="text-lg font-semibold text-gray-700">{{ $total_kelas ?? 0 }}</p>
            </div>
        </div>

    </div>

    <div class="mt-8">
        </div>

</x-app-layout>

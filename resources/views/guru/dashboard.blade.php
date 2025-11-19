<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    @if (isset($pengumumans) && $pengumumans->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-bold mb-4 text-gray-700 flex items-center">
                                📢 Informasi Sekolah
                            </h3>
                            <div class="grid gap-4">
                                @foreach ($pengumumans as $info)
                                    <div
                                        class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r shadow-sm flex items-start">
                                        <div class="mr-4 text-blue-500 mt-1">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-blue-900 text-lg">{{ $info->judul }}</h4>
                                            <p class="text-sm text-blue-700 mt-1 whitespace-pre-line">
                                                {{ $info->isi }}</p>
                                            <div class="flex justify-between items-center mt-2">
                                                <span
                                                    class="text-xs text-blue-400">{{ $info->created_at->diffForHumans() }}</span>
                                                <span
                                                    class="text-xs bg-blue-200 text-blue-800 px-2 py-0.5 rounded font-bold">
                                                    Untuk: {{ ucfirst($info->target) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <a href="{{ route('guru.materi.index') }}"
                            class="block p-6 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-blue-900">📂 Materi Pelajaran</h5>
                            <p class="font-normal text-blue-700">Upload dan kelola materi untuk kelas yang Anda ajar.
                            </p>
                        </a>

                        <a href="{{ route('guru.tugas.index') }}"
                            class="block p-6 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-purple-900">📝 Tugas Siswa</h5>
                            <p class="font-normal text-purple-700">Buat tugas baru dan nilai pekerjaan siswa.</p>
                        </a>

                        <a href="{{ route('guru.ujian.index') }}"
                            class="block p-6 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-red-900">📝 Ujian Online</h5>
                            <p class="font-normal text-red-700">Buat soal pilihan ganda dan ujian CBT.</p>
                        </a>

                        <a href="{{ route('guru.rekap.index') }}"
                            class="block p-6 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-green-900">📊 Rekap Nilai</h5>
                            <p class="font-normal text-green-700">Lihat dan download nilai siswa ke Excel.</p>
                        </a>

                        <!-- MENU ABSENSI (BARU) -->
                        <a href="{{ route('guru.absensi.index') }}"
                            class="block p-6 bg-teal-50 border border-teal-200 rounded-lg hover:bg-teal-100 transition">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-teal-900">📅 Absensi Siswa</h5>
                            <p class="font-normal text-teal-700">Catat kehadiran siswa per pertemuan.</p>
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

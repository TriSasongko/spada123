<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Siswa - Kelas {{ Auth::user()->kelas->nama_kelas ?? 'Belum Ada Kelas' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (isset($pengumumans) && $pengumumans->count() > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-bold mb-4 text-gray-700 flex items-center">
                        📢 Informasi Sekolah
                    </h3>
                    <div class="grid gap-4">
                        @foreach ($pengumumans as $info)
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r shadow-sm flex items-start">
                                <div class="mr-4 text-blue-500 mt-1">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-blue-900 text-lg">{{ $info->judul }}</h4>
                                    <p class="text-sm text-blue-700 mt-1 whitespace-pre-line">{{ $info->isi }}</p>
                                    <p class="text-xs text-blue-400 mt-2">{{ $info->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (isset($ujians) && $ujians->count() > 0)

                @php
                    $ujian_aktif_count = 0;
                    $list_ujian_valid = [];

                    foreach ($ujians as $ujian) {
                        // 1. Cek status pengerjaan
                        $riwayat = \App\Models\UjianSiswa::where('ujian_id', $ujian->id)
                            ->where('user_id', Auth::id())
                            ->first();
                        $is_selesai = $riwayat && $riwayat->status == 1;

                        // 2. Cek waktu habis
                        $waktu_habis = now() > $ujian->waktu_mulai->copy()->addMinutes($ujian->durasi_menit);

                        // 3. Filter: Hanya tampilkan jika BELUM selesai DAN BELUM habis waktu
                        if (!$is_selesai && !$waktu_habis) {
                            $list_ujian_valid[] = $ujian;
                            $ujian_aktif_count++;
                        }
                    }
                @endphp

                @if ($ujian_aktif_count > 0)
                    <h3 class="text-lg font-bold mb-4 text-red-700 flex items-center animate-pulse">
                        ⚠️ Ujian Segera / Sedang Berlangsung
                    </h3>

                    <div class="grid grid-cols-1 gap-4 mb-8">
                        @foreach ($list_ujian_valid as $ujian)
                            <div
                                class="bg-white border-l-4 border-red-500 rounded-lg p-6 shadow-sm flex justify-between items-center hover:shadow-md transition">
                                <div>

                                    <div class="mb-2">
                                        @if ($ujian->tipe_ujian == 'uas')
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-200 inline-block">
                                                UAS (Ujian Akhir Semester)
                                            </span>
                                        @elseif ($ujian->tipe_ujian == 'uts')
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded border border-yellow-200 inline-block">
                                                UTS (Ujian Tengah Semester)
                                            </span>
                                        @else
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded border border-blue-200 inline-block">
                                                UH (Ulangan Harian)
                                            </span>
                                        @endif
                                    </div>

                                    <h4 class="font-bold text-xl text-gray-800">{{ $ujian->judul }}</h4>
                                    <p class="text-gray-600 font-semibold">{{ $ujian->mapel->nama_mapel }}</p>

                                    <div class="text-sm mt-2 space-x-4 text-gray-500 flex items-center">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ $ujian->waktu_mulai->translatedFormat('l, d F Y - H:i') }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $ujian->durasi_menit }} Menit
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    @if (now() >= $ujian->waktu_mulai)
                                        <a href="{{ route('siswa.ujian.start', $ujian->id) }}"
                                            class="bg-red-600 text-white px-6 py-3 rounded font-bold hover:bg-red-700 shadow-lg animate-pulse transition flex flex-col items-center">
                                            <span>▶ KERJAKAN</span>
                                        </a>
                                    @else
                                        <button disabled
                                            class="bg-gray-200 text-gray-500 px-6 py-3 rounded font-bold cursor-not-allowed border border-gray-300 flex flex-col items-center">
                                            <span>🔒 Belum Dibuka</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr class="mb-8 border-gray-300">
                @endif
            @endif


            <h3 class="text-lg font-bold mb-4 text-gray-700">Mata Pelajaran Saya</h3>

            @if ($mapels->isEmpty())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                    <p>Belum ada mata pelajaran yang dijadwalkan untuk kelas ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($mapels as $mapel)
                        <a href="{{ route('siswa.materi.show', $mapel->id) }}"
                            class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-blue-50 transition transform hover:-translate-y-1 group">

                            <div class="mb-2">
                                <svg class="w-10 h-10 text-blue-500 mb-2 group-hover:scale-110 transition"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>

                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 group-hover:text-blue-700">
                                {{ $mapel->nama_mapel }}
                            </h5>
                            <p class="font-normal text-gray-500 text-sm">
                                {{ $mapel->kode_mapel }}
                            </p>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

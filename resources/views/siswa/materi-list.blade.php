<x-app-layout>
    <x-slot name="header">
        {{-- Container utama yang mengatur alignment --}}
        <div class="flex justify-between items-center max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Judul Mata Pelajaran --}}
            {{-- Penambahan 'mr-4' (margin-right: 1rem) untuk memberi jarak eksplisit dari tombol di sebelah kanan. --}}
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-4">
                Mapel: {{ $mapel->nama_mapel }}
            </h2>

            {{-- Tombol Kembali ke Dashboard --}}
            {{-- Styling yang sedikit ditingkatkan agar tombol lebih menonjol --}}
            <a href="{{ route('siswa.dashboard') }}"
                class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-150 px-3 py-1.5 rounded-md shadow-sm flex-shrink-0">
                &larr; Kembali ke Materi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Inisialisasi Alpine.js untuk tab --}}
            <div x-data="{ activeTab: 'ujian' }">

                {{-- Tab Header --}}
                <div class="flex border-b border-gray-200 mb-6">

                    <button @click="activeTab = 'materi'"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'materi', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'materi' }"
                        class="px-4 py-2 text-sm font-medium border-b-2 transition duration-300">
                        📚 Bahan Ajar / Materi ({{ $materis->count() }})
                    </button>
                    <button @click="activeTab = 'tugas'"
                        :class="{ 'border-purple-500 text-purple-600': activeTab === 'tugas', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'tugas' }"
                        class="px-4 py-2 text-sm font-medium border-b-2 transition duration-300">
                        📝 Tugas / Latihan ({{ $tugas->count() }})
                    </button>
                    <button @click="activeTab = 'ujian'"
                        :class="{ 'border-red-500 text-red-600': activeTab === 'ujian', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'ujian' }"
                        class="px-4 py-2 text-sm font-medium border-b-2 transition duration-300">
                        ⏰ Ujian / Ulangan ({{ isset($ujians) ? $ujians->count() : 0 }})
                    </button>
                </div>

                {{-- Tab Content - UJIAN --}}
                <div x-show="activeTab === 'ujian'" x-transition:enter.duration.500ms>
                    @if (isset($ujians) && $ujians->count() > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border-l-4 border-red-500">
                            <div class="p-6 text-gray-900">
                                <h3 class="text-lg font-bold mb-4 text-red-700 flex items-center">
                                    ⏰ Daftar Ujian Aktif
                                </h3>

                                @foreach ($ujians as $ujian)
                                    @php
                                        // Cek riwayat pengerjaan
                                        $riwayat = \App\Models\UjianSiswa::where('ujian_id', $ujian->id)
                                            ->where('user_id', Auth::id())
                                            ->first();
                                        $is_selesai = $riwayat && $riwayat->status == 1;

                                        // Cek waktu
                                        $waktu_habis =
                                            now() > $ujian->waktu_mulai->copy()->addMinutes($ujian->durasi_menit);
                                        $belum_mulai = now() < $ujian->waktu_mulai;
                                    @endphp

                                    <div
                                        class="border border-red-100 bg-red-50 p-4 mb-3 rounded-lg flex justify-between items-center transition hover:shadow-md">
                                        <div>
                                            <h4 class="font-bold text-gray-800 text-lg">{{ $ujian->judul }}</h4>
                                            <div class="text-sm text-gray-600 mt-1 space-y-1">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    {{ $ujian->waktu_mulai->translatedFormat('l, d F Y - H:i') }} WIB
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Durasi: {{ $ujian->durasi_menit }} Menit
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            @if ($is_selesai)
                                                <div
                                                    class="text-center bg-green-100 px-4 py-2 rounded border border-green-300">
                                                    <span class="block text-xs text-green-800 font-bold">NILAI
                                                        ANDA</span>
                                                    <span
                                                        class="text-2xl font-bold text-green-700">{{ $riwayat->nilai }}</span>
                                                </div>
                                            @elseif($belum_mulai)
                                                <span
                                                    class="bg-gray-200 text-gray-500 px-4 py-2 rounded font-bold text-sm border border-gray-300 cursor-not-allowed">
                                                    Belum Dibuka
                                                </span>
                                            @elseif($waktu_habis)
                                                <span
                                                    class="bg-red-200 text-red-600 px-4 py-2 rounded font-bold text-sm border border-red-300 cursor-not-allowed">
                                                    Waktu Habis
                                                </span>
                                            @else
                                                <a href="{{ route('siswa.ujian.start', $ujian->id) }}"
                                                    class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white font-bold rounded shadow hover:bg-red-700 animate-pulse transition">
                                                    ▶ KERJAKAN
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 text-center py-6">
                                <p class="text-gray-500 italic">Tidak ada Ujian / Ulangan aktif saat ini.</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Tab Content - MATERI --}}
                <div x-show="activeTab === 'materi'" x-transition:enter.duration.500ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold mb-4 text-blue-700 flex items-center">
                                📚 Daftar Bahan Ajar / Materi
                            </h3>

                            @forelse($materis as $materi)
                                <div class="border-b border-gray-200 py-4 last:border-0 group">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4
                                                class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition">
                                                {{ $materi->judul }}</h4>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Oleh: <span class="font-semibold">{{ $materi->guru->name }}</span>
                                                &bull; {{ $materi->created_at->format('d M Y, H:i') }}
                                            </p>
                                            @if ($materi->deskripsi)
                                                <p
                                                    class="text-gray-600 mt-2 text-sm bg-gray-50 p-2 rounded border border-gray-100">
                                                    {{ $materi->deskripsi }}</p>
                                            @endif
                                        </div>

                                        <div>
                                            <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank"
                                                class="inline-flex items-center px-4 py-2 bg-white border border-blue-500 text-blue-600 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-blue-50 transition">
                                                ⬇ Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6">
                                    <p class="text-gray-500 italic">Belum ada materi yang diupload guru.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Tab Content - TUGAS --}}
                <div x-show="activeTab === 'tugas'" x-transition:enter.duration.500ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold mb-4 text-purple-700 flex items-center">
                                📝 Daftar Tugas / Latihan
                            </h3>

                            @forelse($tugas as $t)
                                @php
                                    $sudah_kumpul = $t->pengumpulans->where('user_id', Auth::id())->first();
                                @endphp

                                <div
                                    class="border border-l-4 border-l-purple-500 bg-purple-50 p-4 mb-4 rounded shadow-sm hover:bg-purple-100 transition">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="text-md font-bold text-gray-800">{{ $t->judul }}</h4>
                                            <div class="text-sm text-gray-600 mt-1">
                                                Batas Waktu:
                                                <span
                                                    class="{{ $t->deadline->isPast() ? 'text-red-600 font-bold' : 'text-green-600 font-semibold' }}">
                                                    {{ $t->deadline->translatedFormat('l, d F Y H:i') }}
                                                </span>
                                            </div>

                                            <div class="mt-2">
                                                @if ($sudah_kumpul)
                                                    <span
                                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-200 inline-flex items-center">
                                                        ✅ Sudah Dikumpulkan
                                                    </span>
                                                    @if ($sudah_kumpul->nilai !== null)
                                                        <span
                                                            class="ml-2 bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded border border-blue-200">
                                                            Nilai: {{ $sudah_kumpul->nilai }}
                                                        </span>
                                                    @else
                                                        <span class="ml-2 text-gray-500 text-xs italic">(Menunggu
                                                            Penilaian)</span>
                                                    @endif
                                                @else
                                                    @if ($t->deadline->isPast())
                                                        <span
                                                            class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-200">
                                                            ⛔ Terlewat
                                                        </span>
                                                    @else
                                                        <span
                                                            class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-200">
                                                            ⏳ Belum Dikerjakan
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <a href="{{ route('siswa.tugas.show', $t->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none transition ease-in-out duration-150">
                                                Buka Tugas &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6">
                                    <p class="text-gray-500 italic">Tidak ada tugas aktif saat ini.</p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>

            </div>
            {{-- End of Alpine.js Tab Container --}}


        </div>
    </div>
</x-app-layout>

{{-- KODE KEDUA (DETAIL TUGAS) TIDAK PERLU DIUBAH KARENA ITU ADALAH HALAMAN TERPISAH --}}

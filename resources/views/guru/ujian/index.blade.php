<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Ujian (CBT)') }}
            </h2>
            <a href="{{ route('guru.dashboard') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-end">
                <a href="{{ route('guru.ujian.create') }}"
                    class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded shadow">
                    + Buat Ujian Baru
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-3 text-left">Judul & Tipe Ujian</th>
                                <th class="border p-3 text-left">Target Kelas</th>
                                <th class="border p-3 text-left">Waktu & Durasi</th>
                                <th class="border p-3 text-center">Soal</th>
                                <th class="border p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ujians as $ujian)
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-3">
                                        <div class="mb-2">
                                            @if ($ujian->tipe_ujian == 'uas')
                                                <span
                                                    class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm tracking-wide">
                                                    UAS (Ujian Akhir Semester)
                                                </span>
                                            @elseif($ujian->tipe_ujian == 'uts')
                                                <span
                                                    class="bg-yellow-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm tracking-wide">
                                                    UTS (Ujian Tengah Semester)
                                                </span>
                                            @else
                                                <span
                                                    class="bg-blue-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm tracking-wide">
                                                    UH (Ulangan Harian)
                                                </span>
                                            @endif
                                        </div>

                                        <span class="font-bold block text-lg text-gray-800">{{ $ujian->judul }}</span>

                                        <div class="flex gap-4 mt-2 text-sm">
                                            <a href="{{ route('guru.ujian.show', $ujian->id) }}"
                                                class="text-blue-600 hover:underline font-semibold flex items-center">
                                                ⚙️ Kelola Soal
                                            </a>
                                            <a href="{{ route('guru.ujian.hasil', $ujian->id) }}"
                                                class="text-green-600 hover:underline font-semibold flex items-center">
                                                📊 Lihat Hasil
                                            </a>
                                        </div>
                                    </td>

                                    <td class="border p-3">
                                        <span class="font-semibold block">{{ $ujian->kelas->nama_kelas }}</span>
                                        <span class="text-sm text-gray-500">{{ $ujian->mapel->nama_mapel }}</span>
                                    </td>

                                    <td class="border p-3">
                                        <div class="text-sm">
                                            <div class="mb-1 flex items-center text-gray-600">
                                                📅 {{ $ujian->waktu_mulai->translatedFormat('d M Y, H:i') }}
                                            </div>
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">
                                                ⏱ {{ $ujian->durasi_menit }} Menit
                                            </span>
                                        </div>
                                    </td>

                                    <td class="border p-3 text-center">
                                        <span
                                            class="font-bold text-xl text-gray-700">{{ $ujian->soals->count() }}</span>
                                        <span class="block text-xs text-gray-500">Butir</span>
                                    </td>

                                    <td class="border p-3 text-center">
                                        <form action="{{ route('guru.ujian.destroy', $ujian->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus ujian ini? Data nilai siswa juga akan hilang!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1 rounded text-sm font-bold transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border p-8 text-center text-gray-500 italic bg-gray-50">
                                        <p class="mb-2">Belum ada ujian yang dibuat.</p>
                                        <p class="text-xs">Klik tombol "+ Buat Ujian Baru" di pojok kanan atas.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

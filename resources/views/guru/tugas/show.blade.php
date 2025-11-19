<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Tugas & Penilaian
            </h2>
            <a href="{{ route('guru.tugas.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow-sm mb-6 border-l-4 border-purple-500">
                <h1 class="text-2xl font-bold mb-1">{{ $tugas->judul }}</h1>
                <p class="text-gray-600 mb-4">{{ $tugas->kelas->nama_kelas }} - {{ $tugas->mapel->nama_mapel }}</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-gray-50 p-3 rounded">
                        <span class="block text-gray-500">Total Pengumpulan</span>
                        <span class="font-bold text-lg">{{ $tugas->pengumpulans->count() }} Siswa</span>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <span class="block text-gray-500">Deadline</span>
                        <span class="font-bold text-lg {{ $tugas->deadline->isPast() ? 'text-red-600' : 'text-green-600' }}">
                            {{ $tugas->deadline->format('d M Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Daftar Jawaban Siswa</h3>

                    <table class="min-w-full border-collapse border border-gray-200 text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-3 text-left">Nama Siswa</th>
                                <th class="border p-3 text-left">Waktu Kirim</th>
                                <th class="border p-3 text-left">File Jawaban</th>
                                <th class="border p-3 text-left" width="35%">Nilai & Komentar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas->pengumpulans as $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-3 font-medium">
                                        {{ $p->siswa->name }}

                                        @if($p->nilai !== null)
                                            <span class="ml-2 text-green-600 text-xs font-bold">✅ ({{ $p->nilai }})</span>
                                        @endif
                                    </td>
                                    <td class="border p-3">
                                        {{ $p->created_at->format('d/m/Y H:i') }}
                                        @if ($p->created_at > $tugas->deadline)
                                            <span class="text-red-500 text-xs font-bold block">(Terlambat)</span>
                                        @endif
                                    </td>
                                    <td class="border p-3">
                                        <a href="{{ asset('storage/' . $p->file_siswa) }}" target="_blank"
                                            class="text-blue-600 hover:underline flex items-center">
                                            📄 Download File
                                        </a>
                                        @if ($p->catatan_siswa)
                                            <p class="text-xs text-gray-500 mt-1 italic">"{{ $p->catatan_siswa }}"</p>
                                        @endif
                                    </td>
                                    <td class="border p-3">
                                        <form action="{{ route('guru.tugas.nilai', $p->id) }}" method="POST"
                                            class="flex flex-col gap-2">
                                            @csrf
                                            <div class="flex gap-2">
                                                <input type="number" name="nilai" value="{{ $p->nilai }}"
                                                    placeholder="0-100" class="w-20 border-gray-300 rounded text-sm"
                                                    min="0" max="100" required>

                                                <button type="submit"
                                                    class="text-white px-3 py-1 rounded text-xs transition
                                                    {{ $p->nilai !== null ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }}">
                                                    {{ $p->nilai !== null ? 'Update' : 'Simpan' }}
                                                </button>
                                            </div>
                                            <textarea name="komentar_guru" rows="1" placeholder="Komentar (Opsional)"
                                                class="w-full border-gray-300 rounded text-xs">{{ $p->komentar_guru }}</textarea>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border p-6 text-center text-gray-500 italic">
                                        Belum ada siswa yang mengumpulkan tugas ini.
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

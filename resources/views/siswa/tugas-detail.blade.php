<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-2">{{ $tugas->judul }}</h1>
                    <p class="text-sm text-gray-500 mb-4">Deadline:
                        {{ $tugas->deadline->translatedFormat('l, d F Y H:i') }}</p>

                    <div class="bg-gray-50 p-4 rounded border border-gray-200 mb-4">
                        <h4 class="font-bold text-gray-700 mb-1">Instruksi:</h4>
                        <p class="whitespace-pre-wrap">{{ $tugas->deskripsi }}</p>
                    </div>

                    @if ($tugas->file_tugas)
                        <a href="{{ asset('storage/' . $tugas->file_tugas) }}" target="_blank"
                            class="text-blue-600 underline text-sm">
                            Download Lampiran Soal
                        </a>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Jawaban Anda</h3>

                    @if ($pengumpulan)
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
                            <h3 class="text-green-700 font-bold text-lg">✅ Tugas Telah Dikirim</h3>
                            <p class="text-sm text-green-600 mt-1">
                                Anda telah mengirimkan tugas ini pada:
                                <span class="font-bold">
                                    {{ $pengumpulan->created_at->translatedFormat('l, d F Y H:i') }}
                                </span>
                            </p>

                            <div class="mt-4 border-t pt-3">
                                <p class="font-semibold text-gray-700">File Jawaban Anda:</p>
                                <a href="{{ asset('storage/' . $pengumpulan->file_siswa) }}" target="_blank"
                                    class="text-blue-600 underline text-sm block">
                                    Lihat/Download File Jawaban
                                </a>

                                {{-- Tampilkan Nilai Jika Ada --}}
                                @if ($pengumpulan->nilai !== null)
                                    <p class="mt-4 font-semibold text-gray-700">Nilai:</p>
                                    <span class="text-3xl font-extrabold text-blue-700">{{ $pengumpulan->nilai }}</span>/100
                                    @if ($pengumpulan->komentar_guru)
                                        <p class="mt-2 text-sm text-gray-600">Komentar Guru: {{ $pengumpulan->komentar_guru }}</p>
                                    @endif
                                @else
                                    <p class="mt-2 text-yellow-700 font-semibold text-sm">Menunggu Penilaian dari Guru.</p>
                                @endif
                            </div>
                        </div>
                    @else
                        {{-- Logika Jika Belum Mengumpulkan --}}
                        @if (now() < $tugas->waktu_mulai)
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            <span class="font-bold">Tugas Belum Dibuka.</span><br>
                                            Anda baru bisa mengerjakan tugas ini pada: <br>
                                            <span
                                                class="font-bold">{{ $tugas->waktu_mulai->translatedFormat('l, d F Y H:i') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif(now() > $tugas->deadline)
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 text-center">
                                <h3 class="text-red-700 font-bold text-lg">⛔ Batas Waktu Berakhir</h3>
                                <p class="text-red-600 mt-1">Form pengumpulan jawaban sudah ditutup otomatis.</p>

                                <div class="mt-4 p-3 bg-white rounded border border-red-200 inline-block">
                                    <p class="text-sm text-gray-600">Ingin mengajukan perpanjangan waktu?</p>
                                    <p class="text-sm font-bold text-gray-800">Hubungi Guru: {{ $tugas->guru->name }}
                                    </p>
                                </div>
                            </div>
                        @else
                            {{-- FORM PENGUMPULAN --}}
                            <form action="{{ route('siswa.tugas.store', $tugas->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Upload File
                                        Jawaban</label>
                                    <input type="file" name="file_siswa"
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700"
                                        required>
                                    @error('file_siswa')
                                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                {{-- Tambahkan kolom catatan siswa jika diperlukan --}}
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Catatan Tambahan (Opsional)</label>
                                    <textarea name="catatan_siswa" rows="2" class="shadow border rounded w-full py-2 px-3 text-gray-700">{{ old('catatan_siswa') }}</textarea>
                                </div>

                                <button type="submit"
                                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                                    Kirim Jawaban
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

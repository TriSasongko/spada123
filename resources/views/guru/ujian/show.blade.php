<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Soal: {{ $ujian->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- NOTIFIKASI SUKSES (Opsional, biar user tahu soal tersimpan) -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- BAGIAN 1: DAFTAR SOAL YANG SUDAH DIINPUT -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="font-bold text-lg mb-4">Daftar Soal ({{ $ujian->soals->count() }})</h3>

                @forelse($ujian->soals as $index => $soal)
                    <div class="mb-4 border-b pb-4 last:border-0">
                        <div class="flex justify-between">
                            <div class="w-full mr-4">
                                <p class="font-bold text-gray-800">{{ $index + 1 }}. {{ $soal->pertanyaan }}</p>
                            </div>
                            <form action="{{ route('guru.ujian.soal.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm font-bold">Hapus</button>
                            </form>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm mt-2">
                            <span class="{{ $soal->kunci_jawaban == 'a' ? 'text-green-600 font-bold bg-green-50 px-2 rounded' : 'text-gray-600' }}">A. {{ $soal->opsi_a }}</span>
                            <span class="{{ $soal->kunci_jawaban == 'b' ? 'text-green-600 font-bold bg-green-50 px-2 rounded' : 'text-gray-600' }}">B. {{ $soal->opsi_b }}</span>
                            <span class="{{ $soal->kunci_jawaban == 'c' ? 'text-green-600 font-bold bg-green-50 px-2 rounded' : 'text-gray-600' }}">C. {{ $soal->opsi_c }}</span>
                            <span class="{{ $soal->kunci_jawaban == 'd' ? 'text-green-600 font-bold bg-green-50 px-2 rounded' : 'text-gray-600' }}">D. {{ $soal->opsi_d }}</span>
                            <span class="{{ $soal->kunci_jawaban == 'e' ? 'text-green-600 font-bold bg-green-50 px-2 rounded' : 'text-gray-600' }}">E. {{ $soal->opsi_e }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 italic text-center py-4">Belum ada soal. Silakan input soal di bawah.</p>
                @endforelse
            </div>

            <!-- BAGIAN 2: FORM TAMBAH SOAL BARU -->
            <div class="bg-white p-6 rounded shadow border-t-4 border-blue-500">
                <h3 class="font-bold text-lg mb-4 text-blue-800">+ Tambah Soal Baru</h3>

                <form action="{{ route('guru.ujian.soal.store', $ujian->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-bold text-sm text-gray-700 mb-2">Pertanyaan</label>
                        <textarea name="pertanyaan" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" rows="3" required placeholder="Tulis pertanyaan di sini..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <input type="text" name="opsi_a" placeholder="Pilihan A" class="w-full border-gray-300 rounded-md shadow-sm mb-2" required>
                            <input type="text" name="opsi_b" placeholder="Pilihan B" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <input type="text" name="opsi_c" placeholder="Pilihan C" class="w-full border-gray-300 rounded-md shadow-sm mb-2" required>
                            <input type="text" name="opsi_d" placeholder="Pilihan D" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="text" name="opsi_e" placeholder="Pilihan E" class="w-full border-gray-300 rounded-md shadow-sm" required>

                        <select name="kunci_jawaban" class="w-full border-gray-300 rounded-md shadow-sm bg-yellow-50 text-yellow-800 font-bold" required>
                            <option value="">-- Pilih Kunci Jawaban Benar --</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                            <option value="e">E</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full md:w-auto bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition duration-150">
                        + Simpan Soal
                    </button>
                </form>
            </div>

            <!-- BAGIAN 3: TOMBOL SELESAI & KEMBALI -->
            <div class="mt-8 flex flex-col md:flex-row justify-between items-center bg-gray-100 p-4 rounded-lg border border-gray-200">
                <div class="text-gray-600 text-sm mb-4 md:mb-0">
                    <p class="font-bold">Status: Tersimpan Otomatis.</p>
                    <p>Setiap kali Anda menekan tombol "Simpan Soal", data langsung masuk ke database.</p>
                </div>

                <a href="{{ route('guru.ujian.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-6 rounded shadow flex items-center transition duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Selesai & Kembali ke Daftar
                </a>
            </div>

        </div>
    </div>
</x-app-layout>

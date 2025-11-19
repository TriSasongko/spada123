<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Tugas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('guru.tugas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Target Kelas & Mapel</label>
                            <select name="pengampu_id" class="shadow border rounded w-full py-2 px-3 text-gray-700"
                                required>
                                <option value="">-- Pilih Target --</option>
                                @foreach ($opsi_target as $opsi)
                                    <option value="{{ $opsi['value'] }}">{{ $opsi['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kapan Tugas Dibuka?</label>

                            <div class="flex gap-2 mb-2">
                                <button type="button" onclick="setWaktu('sekarang')"
                                    class="px-3 py-1 bg-gray-200 rounded text-sm hover:bg-gray-300">Langsung
                                    Dibuka</button>
                                <button type="button" onclick="setWaktu('siang')"
                                    class="px-3 py-1 bg-gray-200 rounded text-sm hover:bg-gray-300">Nanti Siang
                                    (12:00)</button>
                                <button type="button" onclick="setWaktu('besok')"
                                    class="px-3 py-1 bg-gray-200 rounded text-sm hover:bg-gray-300">Besok Pagi
                                    (07:00)</button>
                            </div>

                            <input type="datetime-local" id="waktu_mulai" name="waktu_mulai"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Batas Waktu (Deadline)</label>
                            <input type="datetime-local" name="deadline"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="judul">Judul Tugas</label>
                            <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('judul') border-red-500 @enderror"
                                required>
                            @error('judul')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="deskripsi">Deskripsi
                                Tugas</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('deskripsi') border-red-500 @enderror" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="file_tugas">File Tugas
                                (Opsional)</label>
                            <input type="file" id="file_tugas" name="file_tugas"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('file_tugas') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Maks 5MB (PDF, DOC, DOCX, JPG, PNG)</p>
                            @error('file_tugas')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <script>
                            function setWaktu(opsi) {
                                const input = document.getElementById('waktu_mulai');
                                const now = new Date();

                                // Helper format date to YYYY-MM-DDTHH:MM (format input datetime-local)
                                const format = (date) => {
                                    // Menggeser waktu ke timezone lokal (WIB) manual sederhana
                                    date.setMinutes(date.getMinutes() - date.getTimezoneOffset());
                                    return date.toISOString().slice(0, 16);
                                };

                                if (opsi === 'sekarang') {
                                    input.value = format(now);
                                } else if (opsi === 'siang') {
                                    now.setHours(12, 0, 0, 0);
                                    if (new Date() > now) { // Jika sudah lewat jam 12, set besok jam 12
                                        now.setDate(now.getDate() + 1);
                                    }
                                    input.value = format(now);
                                } else if (opsi === 'besok') {
                                    now.setDate(now.getDate() + 1);
                                    now.setHours(7, 0, 0, 0);
                                    input.value = format(now);
                                }
                            }

                            // Set default ke 'sekarang' saat halaman load
                            window.onload = function() {
                                setWaktu('sekarang');
                            };
                        </script>
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="bg-green-600 text-white font-bold py-2 px-4 rounded hover:bg-green-700 transition">
                                Simpan dan Terbitkan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

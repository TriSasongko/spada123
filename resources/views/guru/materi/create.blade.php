<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Materi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Target Kelas & Mapel</label>
                            <select name="pengampu_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="">-- Pilih Kelas & Mapel --</option>

                                @forelse($opsi_target as $opsi)
                                    <option value="{{ $opsi['value'] }}">
                                        {{ $opsi['label'] }}
                                    </option>
                                @empty
                                    <option value="" disabled>Anda belum ditugaskan mengajar (Hubungi Admin)</option>
                                @endforelse

                            </select>
                            @error('pengampu_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Judul Materi</label>
                            <input type="text" name="judul" class="shadow border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: Bab 1 - Algoritma Dasar" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" class="shadow border rounded w-full py-2 px-3 text-gray-700" rows="3"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">File Materi (PDF/DOCX/PPT)</label>
                            <input type="file" name="file_materi" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            <p class="text-xs text-gray-500 mt-1">Maksimal 10MB.</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('guru.materi.index') }}" class="text-gray-600 underline mr-4">Batal</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Upload Materi
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

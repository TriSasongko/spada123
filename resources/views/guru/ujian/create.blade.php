<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Buat Ujian Baru</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">
            <form action="{{ route('guru.ujian.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block font-bold mb-2">Target Kelas & Mapel</label>
                    <select name="pengampu_id" class="w-full border rounded p-2" required>
                        @foreach ($opsi_target as $o)
                            <option value="{{ $o['value'] }}">{{ $o['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul Ujian</label>
                        <input type="text" name="judul"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700" required
                            placeholder="Contoh: Bab 1 - Algoritma">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tipe Ujian</label>
                        <select name="tipe_ujian" class="shadow border rounded w-full py-2 px-3 text-gray-700 bg-white"
                            required>
                            <option value="uh">Ulangan Harian (UH)</option>
                            <option value="uts">Ujian Tengah Semester (UTS)</option>
                            <option value="uas">Ujian Akhir Semester (UAS)</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-bold mb-2">Waktu Mulai</label>
                        <input type="datetime-local" name="waktu_mulai" class="w-full border rounded p-2" required>
                    </div>
                    <div>
                        <label class="block font-bold mb-2">Durasi (Menit)</label>
                        <input type="number" name="durasi_menit" class="w-full border rounded p-2" required
                            min="10" value="60">
                    </div>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan & Lanjut Buat
                    Soal</button>
            </form>
        </div>
    </div>
</x-app-layout>

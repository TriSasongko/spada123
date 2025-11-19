<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Input Absensi: {{ $kelas->nama_kelas }}
            </h2>
            <a href="{{ route('guru.absensi.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('guru.absensi.store', [$kelas->id, $mapel->id]) }}" method="POST">
                    @csrf

                    <!-- Info & Tanggal -->
                    <div class="flex flex-col md:flex-row justify-between mb-6 items-end">
                        <div>
                            <p class="text-gray-600">Mata Pelajaran: <span class="font-bold">{{ $mapel->nama_mapel }}</span></p>
                            <p class="text-gray-600">Jumlah Siswa: <span class="font-bold">{{ $siswas->count() }}</span></p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Pertemuan</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        </div>
                    </div>

                    <!-- Tabel Absensi -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 text-left border-b w-10">No</th>
                                    <th class="p-3 text-left border-b">Nama Siswa</th>
                                    <th class="p-3 text-center border-b w-1/3">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($siswas as $index => $siswa)
                                    @php
                                        // Cek apakah siswa ini sudah diabsen hari ini (untuk set default checked)
                                        $status_lama = $absensi_hari_ini[$siswa->id]->status ?? 'H'; // Default Hadir
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3 text-center">{{ $index + 1 }}</td>
                                        <td class="p-3 font-medium text-gray-700">{{ $siswa->name }}</td>
                                        <td class="p-3">
                                            <div class="flex justify-center gap-4">
                                                <!-- Hadir -->
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="radio" name="status[{{ $siswa->id }}]" value="H" class="text-green-600 focus:ring-green-500" {{ $status_lama == 'H' ? 'checked' : '' }}>
                                                    <span class="ml-1 text-sm font-bold text-green-700">H</span>
                                                </label>
                                                <!-- Izin -->
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="radio" name="status[{{ $siswa->id }}]" value="I" class="text-yellow-600 focus:ring-yellow-500" {{ $status_lama == 'I' ? 'checked' : '' }}>
                                                    <span class="ml-1 text-sm font-bold text-yellow-700">I</span>
                                                </label>
                                                <!-- Sakit -->
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="radio" name="status[{{ $siswa->id }}]" value="S" class="text-blue-600 focus:ring-blue-500" {{ $status_lama == 'S' ? 'checked' : '' }}>
                                                    <span class="ml-1 text-sm font-bold text-blue-700">S</span>
                                                </label>
                                                <!-- Alpha -->
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="radio" name="status[{{ $siswa->id }}]" value="A" class="text-red-600 focus:ring-red-500" {{ $status_lama == 'A' ? 'checked' : '' }}>
                                                    <span class="ml-1 text-sm font-bold text-red-700">A</span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Absensi
                        </button>
                    </div>

                </form>
            </div>

            <p class="text-gray-500 text-sm mt-4 text-center">* Default status adalah <b>Hadir (H)</b>. Ubah jika siswa berhalangan.</p>

        </div>
    </div>
</x-app-layout>

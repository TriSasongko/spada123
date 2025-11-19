<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hasil Ujian: {{ $ujian->judul }}
            </h2>
            <a href="{{ route('guru.ujian.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-4 rounded shadow mb-4 flex gap-4 text-sm">
                <div class="bg-blue-50 px-4 py-2 rounded">
                    <span class="text-gray-500 block">Kelas</span>
                    <span class="font-bold">{{ $ujian->kelas->nama_kelas }}</span>
                </div>
                <div class="bg-blue-50 px-4 py-2 rounded">
                    <span class="text-gray-500 block">Mapel</span>
                    <span class="font-bold">{{ $ujian->mapel->nama_mapel }}</span>
                </div>
                <div class="bg-green-50 px-4 py-2 rounded">
                    <span class="text-gray-500 block">Yang Mengerjakan</span>
                    <span class="font-bold">{{ $ujian->ujianSiswas->count() }} Siswa</span>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full border-collapse border border-gray-200 text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-3 text-left">No</th>
                                <th class="border p-3 text-left">Nama Siswa</th>
                                <th class="border p-3 text-left">Waktu Mulai</th>
                                <th class="border p-3 text-left">Waktu Selesai</th>
                                <th class="border p-3 text-center">Nilai</th>
                                <th class="border p-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ujian->ujianSiswas as $index => $hasil)
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-3">{{ $index + 1 }}</td>
                                    <td class="border p-3 font-bold">{{ $hasil->user->name }}</td>
                                    <td class="border p-3">{{ $hasil->waktu_mulai->format('H:i:s') }}</td>
                                    <td class="border p-3">
                                        {{ $hasil->waktu_selesai ? $hasil->waktu_selesai->format('H:i:s') : '-' }}
                                    </td>
                                    <td class="border p-3 text-center text-lg font-bold">
                                        {{ $hasil->nilai ?? 0 }}
                                    </td>
                                    <td class="border p-3 text-center">
                                        @if($hasil->status == 1)
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Selesai</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded animate-pulse">Mengerjakan...</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border p-6 text-center text-gray-500 italic">
                                        Belum ada siswa yang mengerjakan ujian ini.
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

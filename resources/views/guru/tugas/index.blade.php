<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Tugas') }}
            </h2>
            <a href="{{ route('guru.dashboard') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-end">
                <a href="{{ route('guru.tugas.create') }}"
                    class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                    + Buat Tugas Baru
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
                                <th class="border p-2 text-left">Judul Tugas</th>
                                <th class="border p-2 text-left">Kelas & Mapel</th>
                                <th class="border p-2 text-left">Waktu & Deadline</th>
                                <th class="border p-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas as $t)
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-2">
                                        <span class="font-bold block">{{ $t->judul }}</span>

                                        <div class="text-xs mt-1 space-x-2">
                                            <a href="{{ route('guru.tugas.show', $t->id) }}"
                                                class="text-blue-600 font-bold hover:underline">
                                                👉 Lihat Pengumpulan ({{ $t->pengumpulans->count() }})
                                            </a>

                                            <a href="{{ route('guru.tugas.edit', $t->id) }}"
                                               class="text-yellow-600 font-bold hover:text-yellow-800 hover:underline">
                                                ✏️ Edit/Perpanjang
                                            </a>
                                        </div>
                                    </td>
                                    <td class="border p-2">
                                        {{ $t->kelas->nama_kelas }} <br>
                                        <span class="text-xs text-gray-500">{{ $t->mapel->nama_mapel }}</span>
                                    </td>
                                    <td class="border p-2 text-sm">
                                        <div class="text-gray-500">
                                            Mulai: {{ $t->waktu_mulai ? $t->waktu_mulai->format('d M H:i') : '-' }}
                                        </div>
                                        <div class="{{ $t->deadline->isPast() ? 'text-red-600 font-bold' : 'text-green-600 font-bold' }}">
                                            Selesai: {{ $t->deadline->format('d M H:i') }}
                                            {{ $t->deadline->isPast() ? '(Tutup)' : '' }}
                                        </div>
                                    </td>
                                    <td class="border p-2">
                                        <form action="{{ route('guru.tugas.destroy', $t->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus tugas ini? Data pengumpulan siswa juga akan terhapus!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 text-sm font-bold">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border p-4 text-center text-gray-500">Belum ada tugas yang dibuat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

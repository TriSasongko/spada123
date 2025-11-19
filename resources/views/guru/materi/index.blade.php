<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Materi') }}
            </h2>
            <a href="{{ route('guru.dashboard') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-end">
                <a href="{{ route('guru.materi.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Upload Materi Baru
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
                                <th class="border p-2 text-left">Judul</th>
                                <th class="border p-2 text-left">Mapel</th>
                                <th class="border p-2 text-left">Kelas</th>
                                <th class="border p-2 text-left">File</th>
                                <th class="border p-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materis as $materi)
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-2">{{ $materi->judul }}</td>
                                    <td class="border p-2">{{ $materi->mapel->nama_mapel }}</td>
                                    <td class="border p-2">
                                        <span class="bg-yellow-200 text-yellow-800 py-1 px-2 rounded text-sm">
                                            {{ $materi->kelas->nama_kelas }}
                                        </span>
                                    </td>
                                    <td class="border p-2">
                                        <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank"
                                            class="text-blue-600 underline">Download</a>
                                    </td>
                                    <td class="border p-2">
                                        <form action="{{ route('guru.materi.destroy', $materi->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border p-4 text-center text-gray-500">Belum ada materi
                                        yang diupload.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

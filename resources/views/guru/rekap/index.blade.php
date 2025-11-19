<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Rekap Nilai</h2>
            <a href="{{ route('guru.dashboard') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold mb-4">Pilih Kelas & Mata Pelajaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($data_ajar as $data)
                        <a href="{{ route('guru.rekap.show', [$data['kelas_id'], $data['mapel_id']]) }}"
                            class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-green-50 transition">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">{{ $data['kelas_nama'] }}
                            </h5>
                            <p class="font-normal text-gray-700">{{ $data['mapel_nama'] }}</p>
                            <span class="text-green-600 text-sm mt-2 inline-block">👉 Buka Rekap</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

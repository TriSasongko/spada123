<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Absensi Siswa') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold mb-4 text-gray-700">Pilih Kelas untuk Absensi</h3>

                @if(empty($data_ajar))
                     <p class="text-gray-500 italic">Anda belum memiliki jadwal mengajar.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($data_ajar as $data)
                            <div class="block p-6 bg-white border-l-4 border-teal-500 rounded-lg shadow hover:shadow-md transition hover:bg-teal-50">

                                <div class="mb-4">
                                    <h5 class="mb-1 text-xl font-bold tracking-tight text-gray-900">{{ $data['kelas_nama'] }}</h5>
                                    <p class="font-normal text-gray-600">{{ $data['mapel_nama'] }}</p>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('guru.absensi.create', [$data['kelas_id'], $data['mapel_id']]) }}"
                                       class="flex-1 bg-teal-600 text-white text-center text-xs px-3 py-2 rounded hover:bg-teal-700 transition font-bold">
                                       📝 Input
                                    </a>

                                    <a href="{{ route('guru.absensi.rekap', [$data['kelas_id'], $data['mapel_id']]) }}"
                                       class="flex-1 bg-gray-600 text-white text-center text-xs px-3 py-2 rounded hover:bg-gray-700 transition font-bold">
                                       📊 Rekap
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

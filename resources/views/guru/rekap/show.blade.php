<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Rekap: {{ $kelas->nama_kelas }} - {{ $mapel->nama_mapel }}
            </h2>
            <div>
                <a href="{{ route('guru.rekap.index') }}" class="mr-3 text-gray-600 underline">Kembali</a>
                <a href="{{ route('guru.rekap.export', [$kelas->id, $mapel->id]) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    📥 Download Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 overflow-x-auto">

                <table class="min-w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 sticky left-0 bg-gray-100">Nama Siswa</th>

                            @foreach ($tugasList as $t)
                                <th class="border border-gray-300 p-2 w-24 text-center bg-purple-50"
                                    title="{{ $t->judul }}">
                                    Tgs {{ $loop->iteration }}
                                </th>
                            @endforeach

                            @foreach ($ujianList as $u)
                                <th class="border border-gray-300 p-2 w-24 text-center bg-blue-50"
                                    title="{{ $u->judul }}">
                                    {{ strtoupper($u->tipe_ujian) }} <br> <span
                                        class="text-[10px] font-normal">{{ Str::limit($u->judul, 8) }}</span>
                                </th>
                            @endforeach

                            <th class="border border-gray-300 p-2 bg-yellow-50 font-bold">Rata-rata</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($students as $siswa)
                            @php
                                $total_nilai = 0;
                                $jumlah_item = 0;
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 p-2 font-medium sticky left-0 bg-white">
                                    {{ $siswa->name }}</td>

                                @foreach ($tugasList as $t)
                                    @php
                                        $nilai = $t->pengumpulans->where('user_id', $siswa->id)->first()->nilai ?? null;
                                        if ($nilai !== null) {
                                            $total_nilai += $nilai;
                                            $jumlah_item++;
                                        }
                                    @endphp
                                    <td
                                        class="border border-gray-300 p-2 text-center {{ $nilai === null ? 'bg-red-50 text-red-300' : '' }}">
                                        {{ $nilai ?? '-' }}
                                    </td>
                                @endforeach

                                @foreach ($ujianList as $u)
                                    @php
                                        $nilaiUjian =
                                            $u->ujianSiswas->where('user_id', $siswa->id)->first()->nilai ?? null;
                                        if ($nilaiUjian !== null) {
                                            $total_nilai += $nilaiUjian;
                                            $jumlah_item++;
                                        }
                                    @endphp
                                    <td
                                        class="border border-gray-300 p-2 text-center font-semibold {{ $nilaiUjian === null ? 'bg-red-50 text-red-300' : 'text-blue-700' }}">
                                        {{ $nilaiUjian ?? '-' }}
                                    </td>
                                @endforeach

                                <td class="border border-gray-300 p-2 text-center font-bold bg-yellow-50">
                                    {{ $jumlah_item > 0 ? round($total_nilai / $jumlah_item, 1) : 0 }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rekap Absensi: {{ $kelas->nama_kelas }} - {{ $mapel->nama_mapel }}
            </h2>
            <a href="{{ route('guru.absensi.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8"> <!-- Pakai Full Width -->

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- FILTER BULAN -->
                <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end justify-between">

                    <div class="flex gap-4 items-end">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Bulan</label>
                            <select name="bulan" class="border rounded p-2 text-sm">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tahun</label>
                            <select name="tahun" class="border rounded p-2 text-sm">
                                @for ($y = date('Y'); $y >= date('Y') - 2; $y--)
                                    <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                            Tampilkan
                        </button>
                    </div>

                    <div>
                        <a href="{{ route('guru.absensi.export', ['kelas' => $kelas->id, 'mapel' => $mapel->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}"
                            class="bg-green-600 text-white px-4 py-2 rounded text-sm font-bold hover:bg-green-700 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download Excel
                        </a>
                    </div>

                </form>

                <!-- TABEL REKAP -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-300 text-xs">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2 sticky left-0 bg-gray-100 z-10">Nama Siswa</th>
                                <!-- Loop Tanggal 1-31 -->
                                @for ($d = 1; $d <= 31; $d++)
                                    <th class="border p-1 text-center w-8">{{ $d }}</th>
                                @endfor
                                <th class="border p-2 bg-green-50">H</th>
                                <th class="border p-2 bg-yellow-50">I</th>
                                <th class="border p-2 bg-blue-50">S</th>
                                <th class="border p-2 bg-red-50">A</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $siswa)
                                @php
                                    $h = 0;
                                    $i = 0;
                                    $s = 0;
                                    $a = 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-2 font-medium sticky left-0 bg-white z-10">{{ $siswa->name }}
                                    </td>

                                    @for ($d = 1; $d <= 31; $d++)
                                        @php
                                            // Format tanggal saat ini dalam loop: YYYY-MM-DD
                                            $tgl_cek = sprintf('%s-%02d-%02d', $tahun, $bulan, $d);

                                            // Cari data absensi tanggal ini
                                            $cek = $absensis
                                                ->where('user_id', $siswa->id)
                                                ->where('tanggal', $tgl_cek)
                                                ->first();
                                            $status = $cek ? $cek->status : '-';

                                            // Hitung total
                                            if ($status == 'H') {
                                                $h++;
                                            } elseif ($status == 'I') {
                                                $i++;
                                            } elseif ($status == 'S') {
                                                $s++;
                                            } elseif ($status == 'A') {
                                                $a++;
                                            }

                                            // Warna Cell
                                            $bg = '';
                                            if ($status == 'H') {
                                                $bg = 'bg-green-100 text-green-800';
                                            }
                                            if ($status == 'I') {
                                                $bg = 'bg-yellow-100 text-yellow-800';
                                            }
                                            if ($status == 'S') {
                                                $bg = 'bg-blue-100 text-blue-800';
                                            }
                                            if ($status == 'A') {
                                                $bg = 'bg-red-100 text-red-800 font-bold';
                                            }
                                        @endphp

                                        <td class="border p-1 text-center {{ $bg }}">
                                            {{ $status != '-' ? $status : '' }}
                                        </td>
                                    @endfor

                                    <!-- Total -->
                                    <td class="border p-2 text-center font-bold bg-green-50">{{ $h }}</td>
                                    <td class="border p-2 text-center font-bold bg-yellow-50">{{ $i }}</td>
                                    <td class="border p-2 text-center font-bold bg-blue-50">{{ $s }}</td>
                                    <td class="border p-2 text-center font-bold bg-red-50">{{ $a }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-xs text-gray-500">
                    <span class="mr-3"><span class="font-bold text-green-600">H</span> = Hadir</span>
                    <span class="mr-3"><span class="font-bold text-yellow-600">I</span> = Izin</span>
                    <span class="mr-3"><span class="font-bold text-blue-600">S</span> = Sakit</span>
                    <span class="mr-3"><span class="font-bold text-red-600">A</span> = Alpha</span>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<table>
    <thead>
        <tr>
            {{-- Judul Besar --}}
            <th colspan="37" style="text-align: center; font-weight: bold; font-size: 14pt;">
                REKAP ABSENSI BULAN {{ strtoupper(date('F', mktime(0, 0, 0, $bulan, 10))) }} {{ $tahun }}
            </th>
        </tr>
        <tr>
            <th colspan="37" style="text-align: center; font-weight: bold;">
                KELAS: {{ strtoupper($kelas->nama_kelas) }} - MAPEL: {{ strtoupper($mapel->nama_mapel) }}
            </th>
        </tr>
        <tr>
            {{-- Header --}}
            <th style="border: 1px solid black; font-weight: bold; width: 5px;">NO</th>
            <th style="border: 1px solid black; font-weight: bold; width: 30px;">NAMA SISWA</th>

            {{-- Tanggal 1-31 --}}
            @for($d=1; $d<=31; $d++)
                <th style="border: 1px solid black; font-weight: bold; text-align: center; width: 4px;">{{ $d }}</th>
            @endfor

            {{-- Rekap Total --}}
            <th style="border: 1px solid black; font-weight: bold; background-color: #ccffcc; text-align: center;">H</th>
            <th style="border: 1px solid black; font-weight: bold; background-color: #ffffcc; text-align: center;">I</th>
            <th style="border: 1px solid black; font-weight: bold; background-color: #cce5ff; text-align: center;">S</th>
            <th style="border: 1px solid black; font-weight: bold; background-color: #ffcccc; text-align: center;">A</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $index => $siswa)
            @php
                $h = 0; $i = 0; $s = 0; $a = 0;
            @endphp
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $index + 1 }}</td>
                <td style="border: 1px solid black;">{{ $siswa->name }}</td>

                {{-- Loop Tanggal --}}
                @for($d=1; $d<=31; $d++)
                    @php
                        $tgl_cek = sprintf('%s-%02d-%02d', $tahun, $bulan, $d);
                        $cek = $absensis->where('user_id', $siswa->id)->where('tanggal', $tgl_cek)->first();
                        $status = $cek ? $cek->status : '';

                        // Hitung Total
                        if($status == 'H') $h++;
                        elseif($status == 'I') $i++;
                        elseif($status == 'S') $s++;
                        elseif($status == 'A') $a++;
                    @endphp
                    <td style="border: 1px solid black; text-align: center;">
                        {{ $status }}
                    </td>
                @endfor

                {{-- Kolom Total --}}
                <td style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #ccffcc;">{{ $h }}</td>
                <td style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #ffffcc;">{{ $i }}</td>
                <td style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #cce5ff;">{{ $s }}</td>
                <td style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #ffcccc;">{{ $a }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

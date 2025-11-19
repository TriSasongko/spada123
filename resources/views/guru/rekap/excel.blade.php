<table>
    <table>
        <thead>
            <tr>
                <th colspan="{{ $tugasList->count() + $ujianList->count() + 2 }}"
                    style="text-align: center; font-weight: bold;">
                    REKAP NILAI LENGKAP (TUGAS & UJIAN)
                </th>
            </tr>
            <tr>
                <th style="border: 1px solid black; font-weight: bold;">Nama Siswa</th>

                @foreach ($tugasList as $t)
                    <th style="border: 1px solid black; background-color: #E6E6FA; font-weight: bold;">Tgs:
                        {{ $t->judul }}</th>
                @endforeach

                @foreach ($ujianList as $u)
                    <th style="border: 1px solid black; background-color: #ADD8E6; font-weight: bold;">
                        {{ strtoupper($u->tipe_ujian) }}: {{ $u->judul }}</th>
                @endforeach

                <th style="border: 1px solid black; background-color: #FFFFE0; font-weight: bold;">Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $siswa)
                @php
                    $total = 0;
                    $count = 0;
                @endphp
                <tr>
                    <td style="border: 1px solid black;">{{ $siswa->name }}</td>

                    @foreach ($tugasList as $t)
                        @php
                            $val = $t->pengumpulans->where('user_id', $siswa->id)->first()->nilai ?? null;
                            if ($val !== null) {
                                $total += $val;
                                $count++;
                            }
                        @endphp
                        <td style="border: 1px solid black; text-align: center;">{{ $val ?? 0 }}</td>
                    @endforeach

                    @foreach ($ujianList as $u)
                        @php
                            $valUjian = $u->ujianSiswas->where('user_id', $siswa->id)->first()->nilai ?? null;
                            if ($valUjian !== null) {
                                $total += $valUjian;
                                $count++;
                            }
                        @endphp
                        <td style="border: 1px solid black; text-align: center; color: blue;">{{ $valUjian ?? 0 }}</td>
                    @endforeach

                    <td
                        style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #FFFFE0;">
                        {{ $count > 0 ? round($total / $count, 1) : 0 }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</table>

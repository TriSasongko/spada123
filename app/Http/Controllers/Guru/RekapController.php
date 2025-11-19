<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pengampu;
use App\Models\MataPelajaran;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel; // Import Excel
use App\Exports\RekapNilaiExport;    // Import Class Export tadi

class RekapController extends Controller
{
    // 1. Halaman Pilih Kelas & Mapel
    public function index()
    {
        $user_id = Auth::id();
        // Ambil jadwal mengajar guru
        $pengampu_list = Pengampu::with(['kelas'])->where('user_id', $user_id)->get();

        $data_ajar = [];
        foreach ($pengampu_list as $p) {
            if (!empty($p->mata_pelajaran_ids)) {
                $mapels = MataPelajaran::whereIn('id', $p->mata_pelajaran_ids)->get();
                foreach ($mapels as $mapel) {
                    $data_ajar[] = [
                        'kelas_id' => $p->kelas_id,
                        'kelas_nama' => $p->kelas->nama_kelas,
                        'mapel_id' => $mapel->id,
                        'mapel_nama' => $mapel->nama_mapel,
                    ];
                }
            }
        }

        return view('guru.rekap.index', compact('data_ajar'));
    }

    // 2. Halaman Tampil Nilai (Preview)
    public function show($kelas_id, $mapel_id)
    {
        $students = User::where('role', 'siswa')
            ->where('kelas_id', $kelas_id)
            ->orderBy('name')
            ->get();

        // Ambil Tugas
        $tugasList = Tugas::where('kelas_id', $kelas_id)
            ->where('mata_pelajaran_id', $mapel_id)
            ->with('pengumpulans')
            ->get();

        // [BARU] Ambil Ujian (UH, UTS, UAS)
        $ujianList = Ujian::where('kelas_id', $kelas_id)
            ->where('mata_pelajaran_id', $mapel_id)
            ->with('ujianSiswas') // Eager load nilai
            ->get();

        $kelas = \App\Models\Kelas::find($kelas_id);
        $mapel = MataPelajaran::find($mapel_id);

        // Kirim $ujianList ke View
        return view('guru.rekap.show', compact('students', 'tugasList', 'ujianList', 'kelas', 'mapel'));
    }

    // 3. Proses Download Excel
    public function export($kelas_id, $mapel_id)
    {
        $students = User::where('role', 'siswa')->where('kelas_id', $kelas_id)->orderBy('name')->get();

        $tugasList = Tugas::where('kelas_id', $kelas_id)
            ->where('mata_pelajaran_id', $mapel_id)
            ->with('pengumpulans')->get();

        // [BARU] Ambil Ujian
        $ujianList = Ujian::where('kelas_id', $kelas_id)
            ->where('mata_pelajaran_id', $mapel_id)
            ->with('ujianSiswas')->get();

        $kelas = \App\Models\Kelas::find($kelas_id);
        $mapel = MataPelajaran::find($mapel_id);

        $nama_file = 'Rekap_Nilai_' . $kelas->nama_kelas . '_' . $mapel->nama_mapel . '.xlsx';

        // Kirim $ujianList ke Export Class
        return Excel::download(new RekapNilaiExport($students, $tugasList, $ujianList, $kelas, $mapel), $nama_file);
    }
}

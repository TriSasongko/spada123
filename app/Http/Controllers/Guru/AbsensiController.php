<?php

namespace App\Http\Controllers\Guru;

use App\Exports\RekapAbsensiExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Pengampu;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiController extends Controller
{
    // 1. Halaman Pilih Kelas & Mapel (Mirip menu Tugas)
    public function index()
    {
        $user_id = Auth::id();
        $pengampu_list = Pengampu::with('kelas')->where('user_id', $user_id)->get();

        // Kita perlu memecah JSON mapel agar bisa dipilih satu per satu
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

        return view('guru.absensi.index', compact('data_ajar'));
    }

    // 2. Halaman Form Input Absensi
    public function create($kelas_id, $mapel_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $mapel = MataPelajaran::findOrFail($mapel_id);

        // Ambil siswa di kelas tersebut, urutkan abjad
        $siswas = User::where('role', 'siswa')
                    ->where('kelas_id', $kelas_id)
                    ->orderBy('name')
                    ->get();

        // Cek apakah hari ini sudah absen? (Untuk menampilkan data lama jika ada)
        $absensi_hari_ini = Absensi::where('kelas_id', $kelas_id)
                            ->where('mata_pelajaran_id', $mapel_id)
                            ->where('tanggal', date('Y-m-d'))
                            ->get()
                            ->keyBy('user_id'); // Biar mudah diakses di view by ID

        return view('guru.absensi.create', compact('kelas', 'mapel', 'siswas', 'absensi_hari_ini'));
    }

    // 3. Proses Simpan Absensi
    public function store(Request $request, $kelas_id, $mapel_id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|array', // Array status per siswa
        ]);

        $guru_id = Auth::id();
        $tanggal = $request->tanggal;

        // Loop setiap siswa yang diabsen
        foreach ($request->status as $user_id => $status) {
            // Gunakan updateOrCreate agar jika diedit di hari yang sama, datanya tertimpa (bukan dobel)
            Absensi::updateOrCreate(
                [
                    'guru_id' => $guru_id,
                    'kelas_id' => $kelas_id,
                    'mata_pelajaran_id' => $mapel_id,
                    'user_id' => $user_id,
                    'tanggal' => $tanggal
                ],
                [
                    'status' => $status
                ]
            );
        }

        return redirect()->route('guru.absensi.index')->with('success', 'Absensi berhasil disimpan!');
    }
    // ... method store yang sudah ada ...

    // 4. Halaman Rekap Absensi Bulanan
    public function rekap(Request $request, $kelas_id, $mapel_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $mapel = MataPelajaran::findOrFail($mapel_id);

        // Ambil Bulan & Tahun dari Request (atau default bulan ini)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Ambil Siswa
        $students = User::where('role', 'siswa')
                        ->where('kelas_id', $kelas_id)
                        ->orderBy('name')
                        ->get();

        // Ambil Data Absensi pada bulan & tahun tersebut
        $absensis = Absensi::where('kelas_id', $kelas_id)
                        ->where('mata_pelajaran_id', $mapel_id)
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal', $tahun)
                        ->get();

        return view('guru.absensi.rekap', compact('kelas', 'mapel', 'students', 'absensis', 'bulan', 'tahun'));
    }
    public function export(Request $request, $kelas_id, $mapel_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $mapel = MataPelajaran::findOrFail($mapel_id);

        // Ambil parameter filter (jika tidak ada, default bulan ini)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Ambil data (sama seperti method rekap)
        $students = User::where('role', 'siswa')->where('kelas_id', $kelas_id)->orderBy('name')->get();
        $absensis = Absensi::where('kelas_id', $kelas_id)
                        ->where('mata_pelajaran_id', $mapel_id)
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal', $tahun)
                        ->get();

        // Nama File
        $nama_bulan = date('F', mktime(0, 0, 0, $bulan, 10));
        $nama_file = "Absensi_{$kelas->nama_kelas}_{$nama_bulan}_{$tahun}.xlsx";

        return Excel::download(new RekapAbsensiExport($students, $absensis, $kelas, $mapel, $bulan, $tahun), $nama_file);
    }
}

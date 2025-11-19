<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengampu;
use App\Models\MataPelajaran;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\Pengumuman; // <--- JANGAN LUPA IMPORT MODEL INI
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        // --- KODE LAMA ANDA (Statistik / Data Ajar) ---
        $jadwal = Pengampu::with('kelas')->where('user_id', $user_id)->get();
        $total_kelas = $jadwal->count();

        $total_mapel = 0;
        foreach($jadwal as $j) {
            if(!empty($j->mata_pelajaran_ids)) {
                $total_mapel += count($j->mata_pelajaran_ids);
            }
        }

        $total_tugas = Tugas::where('user_id', $user_id)->count();
        $total_ujian = Ujian::where('user_id', $user_id)->count();
        // ----------------------------------------------

        // --- [BARU] AMBIL PENGUMUMAN UNTUK GURU ---
        $pengumumans = Pengumuman::whereIn('target', ['semua', 'guru']) // Filter khusus Guru
                        ->latest()
                        ->take(3)
                        ->get();

        // Kirim variabel $pengumumans ke view
        return view('guru.dashboard', compact('total_kelas', 'total_mapel', 'total_tugas', 'total_ujian', 'pengumumans'));
    }
}

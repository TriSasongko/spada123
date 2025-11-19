<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\Pengampu;
use App\Models\Tugas;
use App\Models\Pengumpulan;
use App\Models\Ujian;
use App\Models\UjianSiswa;
use App\Models\Pengumuman; // [BARU] Import Model Pengumuman
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // 1. Dashboard Utama (Daftar Mapel & Pengumuman)
    public function index()
    {
        $user = Auth::user();

        // Cek jika siswa belum punya kelas
        if (!$user->kelas_id) {
            return view('siswa.no-class');
        }

        // --- [BARU] AMBIL PENGUMUMAN ---
        // Ambil pengumuman yang targetnya 'semua' ATAU 'siswa'
        $pengumumans = Pengumuman::whereIn('target', ['semua', 'siswa'])
                        ->latest()
                        ->take(3) // Ambil 3 terbaru saja agar tidak penuh
                        ->get();
        // -------------------------------

        // Ambil guru-guru yang mengajar di kelas siswa ini
        $pengampus = Pengampu::where('kelas_id', $user->kelas_id)->get();

        // Kumpulkan ID Mapel dari JSON
        $mapel_ids = [];
        foreach ($pengampus as $p) {
            if (!empty($p->mata_pelajaran_ids) && is_array($p->mata_pelajaran_ids)) {
                $mapel_ids = array_merge($mapel_ids, $p->mata_pelajaran_ids);
            }
        }

        // Ambil data Mapel unik berdasarkan ID yang dikumpulkan
        $mapels = MataPelajaran::whereIn('id', array_unique($mapel_ids))->get();

        // Ambil Ujian Aktif untuk kelas ini
        $ujians = Ujian::where('kelas_id', $user->kelas_id)
            ->where('is_active', true)
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        // Kirim variabel mapels, ujians, dan pengumumans ke view
        return view('siswa.dashboard', compact('mapels', 'ujians', 'pengumumans'));
    }

    // 2. Halaman List Materi & Tugas per Mapel
    public function showMateri($mapel_id)
    {
        $user = Auth::user();
        $mapel = MataPelajaran::findOrFail($mapel_id);

        // 1. Ambil Materi
        $materis = Materi::with('guru')
            ->where('mata_pelajaran_id', $mapel_id)
            ->where('kelas_id', $user->kelas_id)
            ->latest()
            ->get();

        // 2. Ambil Tugas
        $tugas = Tugas::with('pengumpulans')
            ->where('mata_pelajaran_id', $mapel_id)
            ->where('kelas_id', $user->kelas_id)
            ->latest()
            ->get();

        // 3. Ambil Ujian khusus mapel ini (Riwayat)
        $ujians = Ujian::where('mata_pelajaran_id', $mapel_id)
            ->where('kelas_id', $user->kelas_id)
            ->latest()
            ->get();

        return view('siswa.materi-list', compact('mapel', 'materis', 'tugas', 'ujians'));
    }

    // 3. Halaman Detail Tugas (Upload Jawaban)
    public function showTugas($id)
    {
        $user = Auth::user();
        $tugas = Tugas::with('guru')->findOrFail($id);

        // Cek apakah siswa sudah pernah mengumpulkan?
        $pengumpulan = Pengumpulan::where('tugas_id', $id)
            ->where('user_id', $user->id)
            ->first();

        return view('siswa.tugas-detail', compact('tugas', 'pengumpulan'));
    }

    // 4. Proses Upload Jawaban
    public function storePengumpulan(Request $request, $id)
    {
        $request->validate([
            'file_siswa' => 'required|file|mimes:pdf,doc,docx,jpg,png,zip|max:5120',
            'catatan_siswa' => 'nullable|string',
        ]);

        $path = $request->file('file_siswa')->store('tugas_siswa', 'public');

        Pengumpulan::create([
            'tugas_id' => $id,
            'user_id' => Auth::id(),
            'file_siswa' => $path,
            'catatan_siswa' => $request->catatan_siswa,
        ]);

        // Mengembalikan flash message success
        return redirect()->back()->with('success', 'Jawaban berhasil dikirim! Anda dapat melihat status pengiriman di bawah.');
    }

    // 5. Persiapan Ujian (Cek Status)
    public function startUjian($id)
    {
        $ujian = Ujian::findOrFail($id);
        $user_id = Auth::id();

        // Cek apakah sudah pernah mengerjakan?
        $existing = UjianSiswa::where('ujian_id', $id)->where('user_id', $user_id)->first();

        // Jika sudah selesai, tidak boleh masuk lagi
        if ($existing && $existing->status == 1) {
            return redirect()->back()->with('error', 'Anda sudah mengerjakan ujian ini. Nilai Anda: ' . $existing->nilai);
        }

        // Jika belum ada data, buat data baru (Mulai Mengerjakan)
        if (!$existing) {
            UjianSiswa::create([
                'ujian_id' => $id,
                'user_id' => $user_id,
                'waktu_mulai' => now(),
                'status' => 0 // 0 = Sedang Mengerjakan
            ]);
        }

        // Ambil soal (Acak urutan)
        $soals = $ujian->soals()->inRandomOrder()->get();

        return view('siswa.ujian.play', compact('ujian', 'soals'));
    }

    // 6. Submit Jawaban Ujian & Auto-Grading
    public function submitUjian(Request $request, $id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);
        $jawaban = $request->jawaban; // Array [soal_id => 'a', soal_id => 'c']

        $benar = 0;
        $total_soal = $ujian->soals->count();

        if ($total_soal > 0) {
            foreach ($ujian->soals as $soal) {
                // Cek apakah jawaban siswa ada dan sesuai kunci
                if (isset($jawaban[$soal->id]) && $jawaban[$soal->id] == $soal->kunci_jawaban) {
                    $benar++;
                }
            }
            // Hitung nilai (skala 100)
            $nilai_akhir = round(($benar / $total_soal) * 100);
        } else {
            $nilai_akhir = 0;
        }

        // Update Database UjianSiswa
        UjianSiswa::where('ujian_id', $id)->where('user_id', Auth::id())->update([
            'waktu_selesai' => now(),
            'nilai' => $nilai_akhir,
            'status' => 1 // 1 = Selesai
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Ujian selesai! Nilai Anda: ' . $nilai_akhir);
    }
}

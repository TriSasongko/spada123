<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pengampu;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller
{
    // 1. List Ujian
    public function index()
    {
        $ujians = Ujian::where('user_id', Auth::id())->with(['kelas', 'mapel'])->latest()->get();
        return view('guru.ujian.index', compact('ujians'));
    }

    // 2. Form Buat Header Ujian
    public function create()
    {
        $user_id = Auth::id();
        // Logic ambil pengampu (sama seperti tugas/materi)
        $pengampu_list = Pengampu::with('kelas')->where('user_id', $user_id)->get();
        $opsi_target = [];
        foreach ($pengampu_list as $p) {
            if (!empty($p->mata_pelajaran_ids)) {
                $mapels = MataPelajaran::whereIn('id', $p->mata_pelajaran_ids)->get();
                foreach ($mapels as $mapel) {
                    $opsi_target[] = ['value' => $p->kelas_id . '-' . $mapel->id, 'label' => $p->kelas->nama_kelas . ' - ' . $mapel->nama_mapel];
                }
            }
        }
        return view('guru.ujian.create', compact('opsi_target'));
    }

    // 3. Simpan Header Ujian
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'pengampu_id' => 'required',
            'tipe_ujian' => 'required|in:uh,uts,uas',
            'waktu_mulai' => 'required|date',
            'durasi_menit' => 'required|integer|min:1',
        ]);

        $ids = explode('-', $request->pengampu_id);

        $ujian = Ujian::create([
            'user_id' => Auth::id(),
            'kelas_id' => $ids[0],
            'mata_pelajaran_id' => $ids[1],
            'judul' => $request->judul,
            'tipe_ujian' => $request->tipe_ujian,
            'waktu_mulai' => $request->waktu_mulai,
            'durasi_menit' => $request->durasi_menit,
        ]);

        return redirect()->route('guru.ujian.show', $ujian->id)->with('success', 'Ujian dibuat. Silakan tambah soal.');
    }

    // 4. Halaman Detail Ujian (Tempat Tambah Soal)
    public function show($id)
    {
        $ujian = Ujian::with('soals')->where('user_id', Auth::id())->findOrFail($id);
        return view('guru.ujian.show', compact('ujian'));
    }

    // 5. Simpan Soal Baru
    public function storeSoal(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'opsi_a' => 'required',
            'opsi_b' => 'required',
            'opsi_c' => 'required',
            'opsi_d' => 'required',
            'opsi_e' => 'required',
            'kunci_jawaban' => 'required|in:a,b,c,d,e',
        ]);

        Soal::create([
            'ujian_id' => $id,
            'pertanyaan' => $request->pertanyaan,
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'opsi_e' => $request->opsi_e,
            'kunci_jawaban' => $request->kunci_jawaban,
        ]);

        return back()->with('success', 'Soal berhasil ditambahkan.');
    }

    // 6. Hapus Soal
    public function destroySoal($id)
    {
        Soal::findOrFail($id)->delete();
        return back()->with('success', 'Soal dihapus.');
    }

    // 7. Hapus Ujian
    public function destroy($id)
    {
        Ujian::where('user_id', Auth::id())->findOrFail($id)->delete();
        return back()->with('success', 'Ujian dihapus.');
    }

    // 8. Halaman Lihat Hasil Ujian Siswa
    public function hasil($id)
    {
        $ujian = Ujian::with(['ujianSiswas.user', 'kelas', 'mapel'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('guru.ujian.hasil', compact('ujian'));
    }
}

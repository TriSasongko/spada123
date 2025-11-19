<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\Pengampu;
use App\Models\MataPelajaran;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    // Menampilkan Daftar Tugas Guru Ini
    public function index()
    {
        $tugas = Tugas::with(['kelas', 'mapel'])
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();
        return view('guru.tugas.index', compact('tugas'));
    }

    // Form Buat Tugas
    public function create()
    {
        $user_id = Auth::id();
        $pengampu_list = Pengampu::with('kelas')->where('user_id', $user_id)->get();

        $opsi_target = [];
        foreach ($pengampu_list as $p) {
            if (!empty($p->mata_pelajaran_ids) && is_array($p->mata_pelajaran_ids)) {
                $mapels = MataPelajaran::whereIn('id', $p->mata_pelajaran_ids)->get();
                foreach ($mapels as $mapel) {
                    $value = $p->kelas_id . '-' . $mapel->id;
                    $label = "Kelas " . $p->kelas->nama_kelas . " - " . $mapel->nama_mapel;
                    $opsi_target[] = ['value' => $value, 'label' => $label];
                }
            }
        }
        return view('guru.tugas.create', compact('opsi_target'));
    }

    // Simpan Tugas
    public function store(Request $request)
    {
        $request->validate([
            'pengampu_id' => 'required',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'waktu_mulai' => 'required|date',
            'deadline' => 'required|date|after:waktu_mulai',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        $ids = explode('-', $request->pengampu_id);

        $path = null;
        if ($request->hasFile('file_tugas')) {
            $path = $request->file('file_tugas')->store('tugas_files', 'public');
        }

        Tugas::create([
            'user_id' => Auth::id(),
            'kelas_id' => $ids[0],
            'mata_pelajaran_id' => $ids[1],
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'waktu_mulai' => $request->waktu_mulai,
            'deadline' => $request->deadline,
            'file_tugas' => $path,
        ]);

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil dibuat!');
    }

    public function edit($id)
    {
        $tugas = Tugas::where('user_id', Auth::id())->findOrFail($id);
        return view('guru.tugas.edit', compact('tugas'));
    }

    public function update(Request $request, $id)
    {
        $tugas = Tugas::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'waktu_mulai' => 'required|date',
            'deadline' => 'required|date|after:waktu_mulai',
        ]);

        // Logic update file jika ada file baru (opsional, bisa skip jika hanya ganti tanggal)
        if ($request->hasFile('file_tugas')) {
             // Hapus file lama jika mau, lalu upload baru...
        }

        $tugas->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'waktu_mulai' => $request->waktu_mulai,
            'deadline' => $request->deadline, // Inilah inti perpanjangan waktu
        ]);

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil diperbarui (Waktu diperpanjang).');
    }

    // Hapus Tugas
    public function destroy($id)
    {
        $tugas = Tugas::where('user_id', Auth::id())->findOrFail($id);
        $tugas->delete();
        return redirect()->back()->with('success', 'Tugas dihapus.');
    }

    // 1. Halaman Detail Tugas & List Pengumpulan Siswa
    public function show($id)
    {
        $tugas = Tugas::with(['pengumpulans.siswa', 'kelas', 'mapel'])
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        return view('guru.tugas.show', compact('tugas'));
    }

    // 2. Proses Simpan Nilai
    public function berikanNilai(Request $request, $pengumpulan_id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'komentar_guru' => 'nullable|string',
        ]);

        $pengumpulan = Pengumpulan::findOrFail($pengumpulan_id);

        $pengumpulan->update([
            'nilai' => $request->nilai,
            'komentar_guru' => $request->komentar_guru,
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }
}

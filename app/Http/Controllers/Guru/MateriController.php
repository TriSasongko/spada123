<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Pengampu;
use App\Models\MataPelajaran; // Pastikan import ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        // Note: Di sini kita load 'mapel' milik Materi, BUKAN milik Pengampu.
        // Jadi pastikan model Materi punya relasi 'mapel' (belongsTo MataPelajaran)
        $materis = Materi::with(['kelas', 'mapel'])
                    ->where('user_id', $user_id)
                    ->latest()
                    ->get();

        return view('guru.materi.index', compact('materis'));
    }

    public function create()
    {
        $user_id = Auth::id();

        // PERBAIKAN DISINI:
        // Hapus 'mataPelajaran' dari with(), karena relasi itu sudah dihapus di Model Pengampu.
        // Kita hanya butuh load 'kelas'.
        $pengampu_list = Pengampu::with('kelas')
                        ->where('user_id', $user_id)
                        ->get();

        $opsi_target = [];

        // Kita looping manual untuk memecah JSON array mapel
        foreach ($pengampu_list as $p) {
            // Pastikan ada isi dan berbentuk array (karena casts di model)
            if (!empty($p->mata_pelajaran_ids) && is_array($p->mata_pelajaran_ids)) {

                // Ambil Data Nama Mapel berdasarkan ID yang ada di JSON
                $mapels = MataPelajaran::whereIn('id', $p->mata_pelajaran_ids)->get();

                foreach ($mapels as $mapel) {
                    // Format Value: ID_KELAS - ID_MAPEL
                    $value = $p->kelas_id . '-' . $mapel->id;
                    // Label: Kelas X - Mapel Matematika
                    $label = "Kelas " . $p->kelas->nama_kelas . " - " . $mapel->nama_mapel;

                    $opsi_target[] = [
                        'value' => $value,
                        'label' => $label
                    ];
                }
            }
        }

        return view('guru.materi.create', compact('opsi_target'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengampu_id' => 'required',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_materi' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ]);

        // Pecah ID Kelas dan ID Mapel
        $ids = explode('-', $request->pengampu_id);
        $kelas_id = $ids[0];
        $mapel_id = $ids[1];

        $path = null;
        if ($request->hasFile('file_materi')) {
            $path = $request->file('file_materi')->store('materi_uploads', 'public');
        }

        Materi::create([
            'user_id' => Auth::id(),
            'kelas_id' => $kelas_id,
            'mata_pelajaran_id' => $mapel_id, // ID Mapel disimpan tunggal di tabel materi
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $path,
        ]);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diupload!');
    }

    public function destroy($id)
    {
        $materi = Materi::where('user_id', Auth::id())->findOrFail($id);
        if($materi->file_path) {
            Storage::disk('public')->delete($materi->file_path);
        }
        $materi->delete();
        return redirect()->back()->with('success', 'Materi dihapus.');
    }
}

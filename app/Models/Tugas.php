<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tugas extends Model
{
    protected $guarded = [];

    // Agar kolom deadline otomatis jadi objek Carbon (bisa diformat tanggalnya)
    protected $casts = [
        'deadline' => 'datetime',
        'waktu_mulai' => 'datetime',
    ];

    public function guru(): BelongsTo { return $this->belongsTo(User::class, 'user_id'); }
    public function mapel(): BelongsTo { return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id'); }
    public function kelas(): BelongsTo { return $this->belongsTo(Kelas::class, 'kelas_id'); }

    // 1 Tugas punya banyak Pengumpulan (Jawaban Siswa)
    public function pengumpulans(): HasMany { return $this->hasMany(Pengumpulan::class); }
}

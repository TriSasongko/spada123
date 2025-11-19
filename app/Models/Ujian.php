<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $guarded = [];
    protected $casts = ['waktu_mulai' => 'datetime'];

    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function soals()
    {
        return $this->hasMany(Soal::class);
    }
    public function ujianSiswas()
    {
        return $this->hasMany(UjianSiswa::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UjianSiswa extends Model
{
    protected $guarded = [];
    protected $casts = ['waktu_mulai' => 'datetime', 'waktu_selesai' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}

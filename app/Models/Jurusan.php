<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    // Izinkan semua kolom diisi
    protected $guarded = [];

    // 1 Jurusan punya banyak Kelas
    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class);
    }
}

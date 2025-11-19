<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelas extends Model
{
    protected $guarded = [];

    // Nama tabel explisit (kadang laravel bingung baca plural 'kelas')
    protected $table = 'kelas';

    // 1 Kelas milik 1 Jurusan
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
}

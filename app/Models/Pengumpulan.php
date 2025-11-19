<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumpulan extends Model
{
    protected $guarded = [];

    public function tugas(): BelongsTo { return $this->belongsTo(Tugas::class); }
    public function siswa(): BelongsTo { return $this->belongsTo(User::class, 'user_id'); }
}

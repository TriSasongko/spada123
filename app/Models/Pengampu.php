<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengampu extends Model
{
    protected $guarded = [];

    // --- TAMBAHKAN BAGIAN INI ---
    protected $casts = [
        'mata_pelajaran_ids' => 'array',
    ];
    // ----------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
}

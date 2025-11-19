<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable implements FilamentUser
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'kelas_id',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Logika: Hanya role 'admin' yang bisa akses Filament Panel
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    // Helper untuk mengecek role di blade nanti
    public function isGuru()
    {
        return $this->role === 'guru';
    }
    public function isSiswa()
    {
        return $this->role === 'siswa';
    }
}

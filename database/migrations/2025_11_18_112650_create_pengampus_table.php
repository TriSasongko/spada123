<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengampus', function (Blueprint $table) {
            $table->id();

            // Relasi ke Guru
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->label('Guru');

            // Relasi ke Kelas
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();

            // GANTI INI: Bukan lagi ForeignId tunggal, tapi JSON untuk banyak mapel
            $table->json('mata_pelajaran_ids');

            $table->timestamps();

            // Mencegah duplikasi: 1 Guru hanya boleh punya 1 baris data per Kelas
            $table->unique(['user_id', 'kelas_id'], 'unique_guru_kelas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengampus');
    }
};

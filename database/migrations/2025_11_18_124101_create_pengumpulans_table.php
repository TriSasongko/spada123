<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengumpulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained('tugas')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Siswa

            $table->string('file_siswa')->nullable(); // File jawaban
            $table->text('catatan_siswa')->nullable(); // Teks tambahan dari siswa

            // Kolom Penilaian Guru (Diisi nanti)
            $table->integer('nilai')->nullable(); // 0-100
            $table->text('komentar_guru')->nullable();

            $table->timestamps(); // created_at = Waktu pengumpulan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulans');
    }
};

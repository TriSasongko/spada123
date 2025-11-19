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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            // Relasi ke Guru, Mapel, Kelas
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Guru
            $table->foreignId('mata_pelajaran_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();

            $table->string('judul');
            $table->text('deskripsi')->nullable(); // Soal/Instruksi
            $table->string('file_tugas')->nullable(); // Opsional: Jika soalnya berupa PDF
            $table->dateTime('deadline'); // Batas waktu pengumpulan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};

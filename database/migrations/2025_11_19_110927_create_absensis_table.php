<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        // Siapa yang mengabsen (Guru)
        $table->foreignId('guru_id')->constrained('users');

        // Siapa yang diabsen (Siswa)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

        // Konteks Pelajaran
        $table->foreignId('kelas_id')->constrained('kelas');
        $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans');

        $table->date('tanggal');
        $table->enum('status', ['H', 'I', 'S', 'A'])->default('H'); // H=Hadir, I=Izin, S=Sakit, A=Alpha
        $table->text('catatan')->nullable(); // Keterangan tambahan jika perlu

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};

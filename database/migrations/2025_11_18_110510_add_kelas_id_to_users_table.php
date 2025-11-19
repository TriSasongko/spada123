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
        Schema::table('users', function (Blueprint $table) {
            // Nullable karena Guru/Admin tidak punya kelas
            // nullOnDelete: Jika kelas dihapus, user tidak ikut terhapus (hanya jadi tanpa kelas)
            $table->foreignId('kelas_id')
                ->nullable()
                ->after('role')
                ->constrained('kelas')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kelas_id');
        });
    }
};

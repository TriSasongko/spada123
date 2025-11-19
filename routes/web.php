<?php

use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\ProfileController; // <--- PASTIKAN INI ADA
use App\Http\Controllers\Guru\RekapController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    /** @var User $user */
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect('/admin');
    } elseif ($user->role === 'guru') {
        return redirect()->route('guru.dashboard');
    } else {
        return redirect()->route('siswa.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Group Guru
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');

    // Routes Materi Guru
    Route::get('/materi', [\App\Http\Controllers\Guru\MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/create', [\App\Http\Controllers\Guru\MateriController::class, 'create'])->name('materi.create');
    Route::post('/materi', [\App\Http\Controllers\Guru\MateriController::class, 'store'])->name('materi.store');
    Route::delete('/materi/{id}', [\App\Http\Controllers\Guru\MateriController::class, 'destroy'])->name('materi.destroy');

    // --- TAMBAHKAN INI (ROUTE TUGAS) ---
    Route::get('/tugas', [\App\Http\Controllers\Guru\TugasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/create', [\App\Http\Controllers\Guru\TugasController::class, 'create'])->name('tugas.create');
    Route::post('/tugas', [\App\Http\Controllers\Guru\TugasController::class, 'store'])->name('tugas.store');
    Route::delete('/tugas/{id}', [\App\Http\Controllers\Guru\TugasController::class, 'destroy'])->name('tugas.destroy');

    // Route Detail Tugas (Lihat Pengumpulan)
    Route::get('/tugas/{id}', [\App\Http\Controllers\Guru\TugasController::class, 'show'])->name('tugas.show');

    // Route Simpan Nilai (Post ke ID Pengumpulan)
    Route::post('/pengumpulan/{id}/nilai', [\App\Http\Controllers\Guru\TugasController::class, 'berikanNilai'])->name('tugas.nilai');

    Route::get('/tugas/{id}/edit', [\App\Http\Controllers\Guru\TugasController::class, 'edit'])->name('tugas.edit');
    Route::put('/tugas/{id}', [\App\Http\Controllers\Guru\TugasController::class, 'update'])->name('tugas.update');

    // Route Rekap
    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap.index');
    Route::get('/rekap/{kelas}/{mapel}', [RekapController::class, 'show'])->name('rekap.show');
    Route::get('/rekap/{kelas}/{mapel}/export', [RekapController::class, 'export'])->name('rekap.export');

    Route::get('/ujian', [\App\Http\Controllers\Guru\UjianController::class, 'index'])->name('ujian.index');
    Route::get('/ujian/create', [\App\Http\Controllers\Guru\UjianController::class, 'create'])->name('ujian.create');
    Route::post('/ujian', [\App\Http\Controllers\Guru\UjianController::class, 'store'])->name('ujian.store');
    Route::get('/ujian/{id}', [\App\Http\Controllers\Guru\UjianController::class, 'show'])->name('ujian.show');
    Route::delete('/ujian/{id}', [\App\Http\Controllers\Guru\UjianController::class, 'destroy'])->name('ujian.destroy');

    // Route khusus tambah/hapus soal
    Route::post('/ujian/{id}/soal', [\App\Http\Controllers\Guru\UjianController::class, 'storeSoal'])->name('ujian.soal.store');
    Route::delete('/soal/{id}', [\App\Http\Controllers\Guru\UjianController::class, 'destroySoal'])->name('ujian.soal.destroy');

    // Route Lihat Hasil Ujian
    Route::get('/ujian/{id}/hasil', [\App\Http\Controllers\Guru\UjianController::class, 'hasil'])->name('ujian.hasil');

    Route::get('/absensi', [\App\Http\Controllers\Guru\AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/{kelas}/{mapel}', [\App\Http\Controllers\Guru\AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi/{kelas}/{mapel}', [\App\Http\Controllers\Guru\AbsensiController::class, 'store'])->name('absensi.store');

    // --- TAMBAHAN: Route Rekap ---
    Route::get('/absensi/{kelas}/{mapel}/rekap', [\App\Http\Controllers\Guru\AbsensiController::class, 'rekap'])->name('absensi.rekap');

    // Route Export Absensi
    Route::get('/absensi/{kelas}/{mapel}/export', [\App\Http\Controllers\Guru\AbsensiController::class, 'export'])->name('absensi.export');
});

// Group Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    // Dashboard Utama (List Mapel)
    Route::get('/dashboard', [\App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');

    // Halaman Lihat Materi per Mapel
    Route::get('/materi/{id}', [\App\Http\Controllers\Siswa\DashboardController::class, 'showMateri'])->name('materi.show');

    Route::get('/tugas/{id}', [\App\Http\Controllers\Siswa\DashboardController::class, 'showTugas'])->name('tugas.show');
    Route::post('/tugas/{id}', [\App\Http\Controllers\Siswa\DashboardController::class, 'storePengumpulan'])->name('tugas.store');

    Route::get('/ujian/{id}/start', [\App\Http\Controllers\Siswa\DashboardController::class, 'startUjian'])->name('ujian.start');
    Route::post('/ujian/{id}/submit', [\App\Http\Controllers\Siswa\DashboardController::class, 'submitUjian'])->name('ujian.submit');

});

// --- TAMBAHKAN BAGIAN INI ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', [App\Http\Controllers\UserProfileController::class, 'edit'])->name('my.profile');
    Route::patch('/my-profile', [App\Http\Controllers\UserProfileController::class, 'update'])->name('my.profile.update');
    Route::put('/my-profile/password', [App\Http\Controllers\UserProfileController::class, 'updatePassword'])->name('my.profile.password');
});
// ----------------------------

require __DIR__ . '/auth.php';

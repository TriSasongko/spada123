<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@smk.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Guru
        User::create([
            'name' => 'Budi Guru',
            'email' => 'guru@smk.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // 3. Buat Akun Siswa
        User::create([
            'name' => 'Ani Siswa',
            'email' => 'siswa@smk.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);
    }
}

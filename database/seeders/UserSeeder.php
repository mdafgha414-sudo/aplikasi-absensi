<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Menggunakan updateOrCreate agar jika email sudah ada, datanya diupdate. 
        // Jika belum ada, baru dibuat.
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Kunci pencarian
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'kode_kartu' => 'SISWA-001', 
            ]
        );

        User::updateOrCreate(
            ['email' => 'nadea@gmail.com'],
            [
                'name' => 'Nadea Noervita',
                'password' => Hash::make('123456'),
                'role' => 'user',
            ]
        );
    }
}
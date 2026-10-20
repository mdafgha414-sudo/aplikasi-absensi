<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- Tambahkan ini
use App\Models\User;                 // <-- Tambahkan ini

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
          User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
          ]);

           User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'user', // <-- Pastikan ini ada
        ]);
        User::create([
            'name' => 'Nadea Noervita',
            'email' => 'nadea@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'user', // <-- Pastikan ini ada
        ]);
    }
}

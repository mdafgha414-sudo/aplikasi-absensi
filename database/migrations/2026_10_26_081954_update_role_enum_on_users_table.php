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
// Mengubah tipe data kolom role agar menerima nilai baru
    DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user', 'guru', 'pembimbing') DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user', 'guru') DEFAULT 'user'");
    }
};

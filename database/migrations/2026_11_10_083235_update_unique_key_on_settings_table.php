<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // 1. Hapus aturan unique lama pada kolom 'key'
            $table->dropUnique(['key']); 
            
            // 2. Buat aturan unique baru (gabungan key + perusahaan_id)
            // Artinya: 1 Key hanya boleh ada 1 kali PER PERUSAHAAN
            $table->unique(['key', 'perusahaan_id']);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Untuk rollback jika diperlukan
            $table->dropUnique(['key', 'perusahaan_id']);
            $table->unique(['key']);
        });
    }
};
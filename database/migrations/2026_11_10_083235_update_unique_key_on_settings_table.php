<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // 1. Tambahkan kolom perusahaan_id (jika belum ada)
            if (!Schema::hasColumn('settings', 'perusahaan_id')) {
                $table->foreignId('perusahaan_id')->nullable()->after('value')->constrained('perusahaans')->onDelete('cascade');
            }

            // 2. Hapus aturan unique lama pada kolom 'key'
            // (Kita gunakan try-catch untuk berjaga-jaga jika index lama sudah tidak ada)
            try {
                $table->dropUnique(['key']);
            } catch (\Exception $e) {
                // Abaikan jika index 'key' sudah tidak ada
            }
            
            // 3. Buat aturan unique baru (gabungan key + perusahaan_id)
            // Cek dulu apakah index ini sudah ada agar tidak error saat deploy ulang
            $indexName = 'settings_key_perusahaan_id_unique';
            $existingIndexes = \DB::select("SHOW INDEX FROM settings WHERE Key_name = '{$indexName}'");
            
            if (empty($existingIndexes)) {
                $table->unique(['key', 'perusahaan_id'], $indexName);
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Hapus index gabungan
            $table->dropUnique('settings_key_perusahaan_id_unique');
            
            // Kembalikan unique ke kolom 'key' saja
            $table->unique(['key']);
            
            // Hapus kolom perusahaan_id
            if (Schema::hasColumn('settings', 'perusahaan_id')) {
                $table->dropForeign(['perusahaan_id']);
                $table->dropColumn('perusahaan_id');
            }
        });
    }
};
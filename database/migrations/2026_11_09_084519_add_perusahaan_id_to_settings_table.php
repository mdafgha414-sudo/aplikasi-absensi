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
        Schema::table('settings', function (Blueprint $table) {
         // Tambahkan perusahaan_id, nullable agar data lama (global) tidak error
        $table->foreignId('perusahaan_id')->nullable()->constrained('perusahaans')->onDelete('cascade')->after('key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
              $table->dropForeign(['perusahaan_id']);
        $table->dropColumn('perusahaan_id');
        });
    }
};

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
        Schema::table('users', function (Blueprint $table) {
              // Hapus kolom string lama, ganti dengan foreign key
        $table->dropColumn('sekolah');
        $table->foreignId('sekolah_id')->nullable()->constrained('sekolahs')->onDelete('set null')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropForeign(['sekolah_id']);
        $table->dropColumn('sekolah_id');
        $table->string('sekolah')->nullable(); // Balikkan ke string jika di-rollback
        });
    }
};

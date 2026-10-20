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
        Schema::create('jurnals', function (Blueprint $table) {
             $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke siswa
        $table->date('tanggal');
        $table->text('kegiatan');
        $table->text('kendala')->nullable();
        
        // Kolom penilaian (gabungkan di sini agar tidak perlu migrasi terpisah)
        $table->integer('nilai')->nullable();
        $table->text('catatan_guru')->nullable();
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};

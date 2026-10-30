<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alasan_keterlambatans', function (Blueprint $table) {

            $table->enum('status', ['Menunggu', 'Diterima', 'Ditolak'])
                ->default('Menunggu');

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();

            $table->text('catatan_pembimbing')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('alasan_keterlambatans', function (Blueprint $table) {

            $table->dropForeign(['reviewed_by']);

            $table->dropColumn([
                'status',
                'reviewed_by',
                'reviewed_at',
                'catatan_pembimbing'
            ]);
        });
    }
};
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlasanKeterlambatan extends Model
{
    use HasFactory;

    protected $table = 'alasan_keterlambatan'; // Sesuaikan nama tabel Anda

    protected $fillable = [
        'user_id',
        'tanggal',
        'alasan',
        'is_approved',
    ];

    // Relasi ke User (Siswa yang mengisi alasan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
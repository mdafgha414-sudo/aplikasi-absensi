<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
      use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
    ];

    // Relasi: 1 data absensi milik 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

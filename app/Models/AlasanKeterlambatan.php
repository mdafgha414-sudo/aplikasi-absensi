<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlasanKeterlambatan extends Model
{
    use HasFactory;

    protected $table = 'alasan_keterlambatans'; // Sesuaikan jika nama tabel di database berbeda

    protected $fillable = [
        'user_id',
        'tanggal',
        'alasan',
        'is_approved',
        'status',
        'reviewed_by',
        'reviewed_at',
        'catatan_pembimbing',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'reviewed_at' => 'datetime',
    ];

    // Relasi ke User (Siswa yang mengisi alasan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi dengan pembimbing yang memeriksa
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
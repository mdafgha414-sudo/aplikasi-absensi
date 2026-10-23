<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'izins';

    protected $fillable = [
        'user_id',
        'jenis_izin',
        'tanggal_izin',
        'alasan',
        'lampiran',
        'status',
        'catatan_guru', // Pastikan kolom ini ada di database
    ];

    // TAMBAHKAN RELASI INI
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
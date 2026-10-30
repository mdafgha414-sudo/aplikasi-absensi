<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlasanKeterlambatan extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'alasan',
        'status',
        'reviewed_by',
        'reviewed_at',
        'catatan_pembimbing',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    // Relasi dengan siswa
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan pembimbing yang memeriksa
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
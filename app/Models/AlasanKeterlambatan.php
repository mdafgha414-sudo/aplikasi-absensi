<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlasanKeterlambatan extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'alasan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }
}
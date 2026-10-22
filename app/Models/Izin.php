<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $table = 'izins';

    protected $fillable = [
        'user_id',
        'jenis_izin',
        'tanggal_izin',
        'alasan',
        'lampiran',
        'status',
        'catatan_guru',
    ];
}
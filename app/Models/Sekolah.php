<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    // Tambahkan user_id di sini
    protected $fillable = ['user_id', 'nama_sekolah'];

    /**
     * Relasi ke User (Pembimbing yang membuat sekolah ini)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
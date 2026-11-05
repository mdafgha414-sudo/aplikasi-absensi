<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Kolom-kolom yang boleh diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sekolah_id', // <-- DIUBAH DARI 'sekolah' MENJADI 'sekolah_id'
        'role',
        'kode_kartu',
        'perusahaan_id', // <-- TAMBAHAN UNTUK RELASI DENGAN PERUSAHAAN
        'foto_profil',
    ];

    /**
     * Kolom-kolom yang disembunyikan saat data diubah menjadi JSON/Array.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe data yang di-casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==========================================
    // RELASI
    // ==========================================

    /**
     * Relasi ke tabel Sekolah.
     * User (Siswa) memiliki satu Sekolah.
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function perusahaan()
{
    return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
}
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $fillable = ['nama_perusahaan', 'alamat', 'latitude', 'longitude', 'radius'];

public function users()
{
    return $this->hasMany(User::class);
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    protected $fillable = ['token', 'created_by', 'expires_at', 'is_active'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
     // Kolom yang boleh diisi melalui create() atau update()
    protected $fillable = [
        'key',
        'value',
    ];
}

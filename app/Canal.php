<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    protected $table = 'canal';

    protected $fillable = [
        'id', 'canal', 'descripcion'
    ];
}

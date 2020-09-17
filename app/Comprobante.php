<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    protected $table = 'comprobante_test';

    protected $fillable = [
        'id', 'rnc_cedula', 'razon_social', 'estado',
    ];
}

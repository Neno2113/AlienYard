<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    protected $table = 'categoriaproducto';

    protected $fillable = [
        'id', 'nombre'
    ];

}

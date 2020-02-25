<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaIngrediente extends Model
{
    protected $table = 'categoriaingrediente';


    protected $fillable = [
        'id', 'nombre'
    ];
}

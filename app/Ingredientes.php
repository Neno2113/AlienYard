<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredientes extends Model
{
    protected $table = 'ingrediente';
    
    protected $fillable = [
        'id', 'id_categoria', 'nombre'
    ];

    public function categoria()
    {
        return $this->belongsTo('App\CategoriaIngrediente', 'id_categoria');
    }

    // public function inventario()
    // {
    //     return $this->hasMany('App\Inventario', '');
    // }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recetas extends Model
{
    protected $table = 'recetas';

    protected $fillable = [
        'id', 'id_producto', 'id_ingrediente'
    ];


    public function producto()
    {
        return $this->belongsTo('App\Producto', 'id_producto');
    }

    public function ingrediente()
    {
        return $this->belongsTo('App\Ingredientes', 'id_ingrediente');
    }

}

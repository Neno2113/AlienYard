<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';

    protected $fillable = [
    'id', 'id_ingrediente', 'disponible', 'costo', 'fecha_ingreso'  
    ];

    public function ingrediente()
    {
        return $this->belongsTo('App\ingrediente', 'id_ingrediente');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = "comentarios";

    protected $fillable = [
        'id', 'plato', 'comentario'
    ];

    public function plato()
    {
        return $this->belongsTo('App\DetallePedido', 'plato');
    }
}

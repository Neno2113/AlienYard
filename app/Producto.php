<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';

    protected $fillable = [
        'id', 'id_categoria', 'precio', 'nombre', 'imagen', 'descripcion'
    ];

    public function categoria()
    {
        return $this->belongsTo('App\CategoriaProducto', 'id_categoria');
    }
}

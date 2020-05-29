<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $table = 'factura_detalle';

    protected $fillable = [
        'id', 'factura', 'producto', 'costo'
    ];


    public function factura()
    {
        return $this->belongsTo('App\Factura', 'factura');
    }

    public function plato()
    {
        return $this->belongsTo('App\Producto', 'producto');
    }
}

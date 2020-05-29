<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detallepedido';

    protected $fillable = [
        'id', 'id_maestroPedido', 'producto_id', 'costo'
    ];

    public function producto()
    {
        return $this->belongsTo('App\Producto', 'producto_id');
    }

    public function pedido()
    {
        return $this->belongsTo('App\MaestroPedido', 'id_maestroPedido');
    }
}

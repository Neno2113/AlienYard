<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'factura';

    protected $fillable = [
        'id', 'pedido', 'user_id', 'no_factura', 'fecha', 'tipo_factura', 'descuento', 'itbis', 'total'
    ];

    public function orden()
    {
        return $this->belongsTo('App\MaestroPedido', 'pedido');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaestroPedido extends Model
{
    protected $table = 'maestro_pedido';

    protected $fillable = [
        'id', 'user_id', 'total', 'fecha_creacion', 'hora_despachado', 'estado_id', 'creado_por',
        'canal_id', 'estado_pago', 'procesado_por', 'metodo_pago', 'hora_pago'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function canal()
    {
        return $this->belongsTo('App\Canal', 'canal_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo('App\MetodoPago', 'metodo_pago');
    }

    public function estado()
    {
        return $this->belongsTo('App\Estado', 'estado_id');
    }
}

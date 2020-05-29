<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermisoUsuario extends Model
{
    protected $table = 'permiso_usuario';


    protected $fillable = [
        'id', 'user_id', 'permiso'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

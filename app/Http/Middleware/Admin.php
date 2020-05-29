<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\PermisoUsuario;

class Admin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permiso)
    {
        $id = $this->auth->user()->id;
        $permiso = PermisoUsuario::where('user_id', $id)
            ->where('permiso', $permiso)->get()->first();

        if ($this->auth->user()->role !== 1 && empty($permiso)) {
            return redirect('home');
        }
        return $next($request);
    }
}

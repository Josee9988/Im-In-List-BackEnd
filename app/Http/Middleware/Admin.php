<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * handle
     * Summary: Middleware admin, quien acceda a las rutas 
     * especificas del admin sin serlo, sera redireccionado a un error 
     *
     * @param  mixed $request - Usuario para saber si es un usuario y su rol
     * @param  mixed $next    - Lo ejecutara si es correcto
     *
     * @return void
     */
    public function handle($request, Closure $next)
    {

        if (!$request->user()) {
            abort(403, "Error opciones bloqueadas");
        }
        
        if ($request->user()->role != 0) {
            abort(403, "Error opciones bloqueadas");
        }
        return $next($request);
    }
}

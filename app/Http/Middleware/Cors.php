<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{

    /**
     * handle
     *  - NO funciona, mediante componente
     * Summary: Permite que se realicen consultas desde fuera
     *
     * @param  mixed $request
     * @param  mixed $next
     *
     * @return void
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Credentials', 'true')
            ->header('Access-Control-Allow-Headers', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            
    }
}

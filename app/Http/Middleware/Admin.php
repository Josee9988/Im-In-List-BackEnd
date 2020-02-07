<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
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

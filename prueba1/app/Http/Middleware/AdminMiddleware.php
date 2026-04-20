<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // 1 = admin
        if (!Auth::check() || Auth::user()->tipo_usuario_id != 1) {
            abort(403, 'No tienes permiso para acceder a esta página');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auxiliar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y tiene el rol de 'auxiliar'
        if (auth()->check() && auth()->user()->rol === 'auxiliar') {
            return $next($request);
        }

        // Si no es auxiliar, muestra un mensaje de error y retorna un código 403
        abort(403, 'No tienes permiso para acceder a esta página.');
    }
}

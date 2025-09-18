<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Si el rol del usuario está en la lista de roles permitidos para la ruta
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Si no tiene el rol, lo redirigimos al dashboard con un error
        return redirect('dashboard')->with('error', 'No tienes permiso para acceder a esta sección.');
    }
}
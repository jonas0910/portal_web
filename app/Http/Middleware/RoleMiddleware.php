<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Verificar si el usuario tiene el rol especificado usando el método personalizado
        if (!$this->userHasRole($user, $role)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }

    /**
     * Verificar si el usuario tiene el rol especificado
     */
    private function userHasRole($user, $role)
    {
        // Método simple basado en email para evitar dependencias de Spatie
        switch ($role) {
            case 'admin':
                return $user->email === 'admin@notarios.org.pe';
            case 'notario':
                return str_contains($user->email, '@notarios.org.pe') && $user->email !== 'admin@notarios.org.pe';
            case 'cliente':
                return !str_contains($user->email, '@notarios.org.pe');
            default:
                return false;
        }
    }
}

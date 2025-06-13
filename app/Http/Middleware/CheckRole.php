<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user() || !$request->user()->hasAnyRole($roles)) {
            if ($request->user()) {
                // Redirigir según el rol del usuario
                if ($request->user()->hasRole('Administrador')) {
                    return redirect()->route('users.index');
                } elseif ($request->user()->hasRole('Contador')) {
                    return redirect()->route('transactions.index');
                } elseif ($request->user()->hasRole('Auditor')) {
                    return redirect()->route('audit.index');
                }
            }
            
            // Si no tiene rol o no está autenticado, redirigir al dashboard
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
} 
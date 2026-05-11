<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! auth()->check()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Non authentifié.'], 401);
            }

            return redirect()->route('login');
        }

        $userRole = auth()->user()->role?->nom;

        if (! $userRole || ! in_array($userRole, $roles, true)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Accès refusé.'], 403);
            }

            abort(403, 'Accès refusé. Vous n\'avez pas les autorisations nécessaires.');
        }

        return $next($request);
    }
}

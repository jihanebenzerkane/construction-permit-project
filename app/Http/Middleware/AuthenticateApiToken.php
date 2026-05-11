<?php

namespace App\Http\Middleware;

use App\Models\UserApiToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $plain = $request->bearerToken();
        if (! $plain) {
            return response()->json(['message' => 'Jeton d\'API manquant.'], 401);
        }

        $hash = hash('sha256', $plain);
        $token = UserApiToken::query()->where('token_hash', $hash)->first();
        if (! $token) {
            return response()->json(['message' => 'Jeton invalide.'], 401);
        }

        $token->forceFill(['last_used_at' => now()])->save();

        Auth::login($token->user);

        return $next($request);
    }
}

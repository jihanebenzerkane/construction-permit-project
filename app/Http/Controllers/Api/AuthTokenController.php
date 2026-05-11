<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserApiToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthTokenController extends Controller
{
    /**
     * Issue a new API token (email + password).
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'name' => 'nullable|string|max:100',
        ]);

        $user = User::query()->where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Identifiants incorrects.'], 422);
        }

        $plain = Str::random(48);
        UserApiToken::query()->create([
            'user_id' => $user->id,
            'name' => $request->input('name', 'api'),
            'token_hash' => hash('sha256', $plain),
        ]);

        return response()->json([
            'token' => $plain,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'role' => $user->role?->nom,
            ],
        ], 201);
    }

    /**
     * Revoke the current bearer token.
     */
    public function destroy(Request $request): JsonResponse
    {
        $plain = $request->bearerToken();
        if (! $plain) {
            return response()->json(['message' => 'Aucun jeton.'], 400);
        }

        $hash = hash('sha256', $plain);
        $deleted = UserApiToken::query()->where('token_hash', $hash)->delete();

        Auth::logout();

        return response()->json([
            'message' => $deleted ? 'Jeton révoqué.' : 'Jeton introuvable.',
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('role', 'district');

        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'role' => $user->role?->nom,
            'district_id' => $user->district_id,
        ]);
    }
}

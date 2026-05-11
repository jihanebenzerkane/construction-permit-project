<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permit;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermitApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user()->load('role');
        $role = $user->role?->nom;

        $query = Permit::query()->with(['status', 'permitType', 'district', 'citizen']);

        match ($role) {
            'citoyen' => $query->where('citizen_id', $user->id),
            'architecte' => $query->where('architect_id', $user->id),
            'agent_urbanisme' => $query->when(
                $request->query('status'),
                fn ($q) => $q->whereHas('status', fn ($s) => $s->where('nom', $request->query('status')))
            ),
            'service_technique' => $query->where('technical_review_required', true),
            'administrateur' => $query,
            default => $query->whereRaw('0 = 1'),
        };

        $permits = $query->latest()->paginate((int) $request->query('per_page', 15));

        return response()->json($permits);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $permit = Permit::query()
            ->with(['documents', 'histories.changedBy', 'status', 'permitType', 'citizen', 'technicalReviews'])
            ->findOrFail($id);

        if (! $this->canView($request->user(), $permit)) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        return response()->json($permit);
    }

    private function canView(User $user, Permit $permit): bool
    {
        $role = $user->role?->nom;

        return match ($role) {
            'administrateur', 'agent_urbanisme' => true,
            'service_technique' => (bool) $permit->technical_review_required,
            'citoyen' => $permit->citizen_id === $user->id,
            'architecte' => $permit->architect_id === $user->id,
            default => false,
        };
    }
}

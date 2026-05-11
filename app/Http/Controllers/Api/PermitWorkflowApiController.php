<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permit;
use App\Models\Status;
use App\Services\NotificationService;
use App\Services\WorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermitWorkflowApiController extends Controller
{
    public function validatePermit(Request $request, int $id): JsonResponse
    {
        if ($response = $this->ensureAgent($request)) {
            return $response;
        }

        $permit = Permit::query()->findOrFail($id);
        $status = Status::query()->where('nom', 'Validé administrativement')->firstOrFail();

        WorkflowService::changeStatus($permit, $status->id, Auth::id(), 'Validé administrativement (API).');
        NotificationService::notify(
            $permit->citizen_id,
            $permit->id,
            'Félicitations',
            "Votre dossier #{$permit->reference_number} a été validé administrativement."
        );

        return response()->json(['message' => 'Permis validé.', 'permit' => $permit->fresh(['status'])]);
    }

    public function reject(Request $request, int $id): JsonResponse
    {
        if ($response = $this->ensureAgent($request)) {
            return $response;
        }

        $request->validate([
            'commentaire' => 'nullable|string|max:2000',
        ]);

        $permit = Permit::query()->findOrFail($id);
        $status = Status::query()->where('nom', 'Refusé')->firstOrFail();

        WorkflowService::changeStatus(
            $permit,
            $status->id,
            Auth::id(),
            $request->input('commentaire', 'Refusé par agent (API).')
        );
        NotificationService::notify(
            $permit->citizen_id,
            $permit->id,
            'Dossier Refusé',
            "Votre dossier #{$permit->reference_number} a été refusé."
        );

        return response()->json(['message' => 'Dossier refusé.', 'permit' => $permit->fresh(['status'])]);
    }

    public function requestDocs(Request $request, int $id): JsonResponse
    {
        if ($response = $this->ensureAgent($request)) {
            return $response;
        }

        $request->validate([
            'commentaire' => 'required|string|max:2000',
        ]);

        $permit = Permit::query()->findOrFail($id);
        $status = Status::query()->where('nom', 'Documents complémentaires demandés')->firstOrFail();

        WorkflowService::changeStatus($permit, $status->id, Auth::id(), $request->commentaire);
        NotificationService::notify(
            $permit->citizen_id,
            $permit->id,
            'Documents Complémentaires',
            "Veuillez ajouter les documents demandés pour le dossier #{$permit->reference_number}."
        );

        return response()->json(['message' => 'Demande envoyée.', 'permit' => $permit->fresh(['status'])]);
    }

    private function ensureAgent(Request $request): ?JsonResponse
    {
        $user = $request->user();
        if (! $user || $user->role?->nom !== 'agent_urbanisme') {
            return response()->json(['message' => 'Rôle agent_urbanisme requis.'], 403);
        }

        return null;
    }
}

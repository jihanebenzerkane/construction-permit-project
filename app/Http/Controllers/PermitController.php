<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Document;
use App\Models\Permit;
use App\Models\PermitType;
use App\Models\Status;
use App\Models\User;
use App\Services\AIService;
use App\Services\NotificationService;
use App\Services\WorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermitController extends Controller
{
    public function citizenIndex()
    {
        $permits = Permit::where('citizen_id', Auth::id())
            ->with('status', 'permitType')
            ->latest()->paginate(10);

        return view('permits.index', compact('permits'));
    }

    public function architectIndex()
    {
        $permits = Permit::where('architect_id', Auth::id())
            ->with('status', 'citizen', 'permitType')
            ->latest()->paginate(10);

        return view('permits.index', compact('permits'));
    }

    public function agentIndex(Request $request)
    {
        $query = Permit::with('status', 'citizen', 'permitType', 'district');
        if ($request->status) {
            $query->whereHas('status', fn ($q) => $q->where('nom', $request->status));
        }
        $permits = $query->latest()->paginate(15);
        $statuses = Status::all();

        return view('permits.index', compact('permits', 'statuses'));
    }

    public function technicalIndex()
    {
        $permits = Permit::where('technical_review_required', true)
            ->with('status', 'citizen')
            ->latest()->paginate(10);

        return view('permits.index', compact('permits'));
    }

    public function create()
    {
        $permitTypes = PermitType::all();
        $districts = District::all();

        return view('permits.create', compact('permitTypes', 'districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'permit_type_id' => 'required|exists:permit_types,id',
            'district_id' => 'required|exists:districts,id',
            'project_title' => 'required|string|max:255',
            'project_address' => 'required|string',
            'surface' => 'required|numeric|min:1',
            'documents.*' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
        ]);

        $status = Status::where('nom', 'Soumis')->firstOrFail();

        $permit = Permit::create([
            'permit_type_id' => $request->permit_type_id,
            'citizen_id' => Auth::id(),
            'status_id' => $status->id,
            'district_id' => $request->district_id,
            'reference_number' => 'PC-'.date('Y').'-'.rand(10000, 99999),
            'project_title' => $request->project_title,
            'project_address' => $request->project_address,
            'surface' => $request->surface,
            'submitted_at' => now(),
        ]);

        // Upload Documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store("documents/{$permit->id}", 'public');
                Document::create([
                    'permit_id' => $permit->id,
                    'document_type_id' => null,
                    'uploaded_by' => Auth::id(),
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        $permit->load('documents', 'permitType');
        AIService::analyze($permit);

        WorkflowService::changeStatus($permit, $status->id, Auth::id(), 'Dossier soumis avec succès.');

        // Notify Agents
        $agents = User::whereHas('role', fn ($q) => $q->where('nom', 'agent_urbanisme'))->get();
        foreach ($agents as $agent) {
            NotificationService::notify($agent->id, $permit->id, 'Nouveau Dossier',
                "Un nouveau permis #{$permit->reference_number} a été soumis.");
        }

        return redirect()->route('citizen.permits')
            ->with('success', 'Dossier soumis avec succès !');
    }

    public function show($id)
    {
        $permit = Permit::query()
            ->with([
                'documents',
                'histories.changedBy',
                'status',
                'permitType',
                'citizen',
                'district',
                'technicalReviews.reviewer',
            ])
            ->findOrFail($id);

        if (! $this->userCanViewPermit(Auth::user(), $permit)) {
            abort(403, 'Accès refusé à ce dossier.');
        }

        return view('permits.show', compact('permit'));
    }

    private function userCanViewPermit(?User $user, Permit $permit): bool
    {
        if (! $user) {
            return false;
        }

        return match ($user->role?->nom) {
            'administrateur', 'agent_urbanisme' => true,
            'service_technique' => (bool) $permit->technical_review_required,
            'citoyen' => $permit->citizen_id === $user->id,
            'architecte' => $permit->architect_id === $user->id,
            default => false,
        };
    }

    public function validatePermit($id)
    {
        $permit = Permit::findOrFail($id);
        $status = Status::where('nom', 'Validé administrativement')->firstOrFail();

        WorkflowService::changeStatus($permit, $status->id, Auth::id(), 'Validé administrativement.');
        NotificationService::notify($permit->citizen_id, $permit->id, 'Félicitations',
            "Votre dossier #{$permit->reference_number} a été validé administrativement.");

        return back()->with('success', 'Permis validé avec succès.');
    }

    public function rejectPermit(Request $request, $id)
    {
        $permit = Permit::findOrFail($id);
        $status = Status::where('nom', 'Refusé')->firstOrFail();

        WorkflowService::changeStatus($permit, $status->id, Auth::id(), $request->commentaire ?? 'Refusé par agent.');
        NotificationService::notify($permit->citizen_id, $permit->id, 'Dossier Refusé',
            "Votre dossier #{$permit->reference_number} a été refusé.");

        return back()->with('success', 'Dossier refusé.');
    }

    public function requestDocs(Request $request, $id)
    {
        $permit = Permit::findOrFail($id);
        $status = Status::where('nom', 'Documents complémentaires demandés')->firstOrFail();

        WorkflowService::changeStatus($permit, $status->id, Auth::id(), $request->commentaire);
        NotificationService::notify($permit->citizen_id, $permit->id, 'Documents Complémentaires',
            "Veuillez ajouter les documents demandés pour le dossier #{$permit->reference_number}.");

        return back()->with('success', 'Demande envoyée au citoyen.');
    }
}

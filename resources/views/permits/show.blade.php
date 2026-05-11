@extends('layouts.app')

@section('title', 'Dossier '.$permit->reference_number)

@section('content')
    @php
        $role = auth()->user()->role?->nom;
    @endphp

    <div class="mb-6">
        <a href="{{ match ($role) {
            'citoyen' => route('citizen.permits'),
            'architecte' => route('architect.permits'),
            'agent_urbanisme' => route('agent.permits'),
            'service_technique' => route('technical.permits'),
            'administrateur' => route('admin.dashboard'),
            default => route('dashboard'),
        } }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">← Retour à la liste</a>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 pb-6">
            <div>
                <p class="text-sm font-medium text-slate-500">Référence</p>
                <h1 class="mt-1 font-mono text-2xl font-bold text-slate-900">{{ $permit->reference_number }}</h1>
                <p class="mt-2 text-lg text-slate-800">{{ $permit->project_title }}</p>
            </div>
            <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-800">{{ $permit->status?->nom }}</span>
        </div>

        <dl class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Type de permis</dt>
                <dd class="mt-1 text-slate-900">{{ $permit->permitType?->nom ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Surface</dt>
                <dd class="mt-1 text-slate-900">{{ $permit->surface }} m²</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">District</dt>
                <dd class="mt-1 text-slate-900">{{ $permit->district?->nom ?? '—' }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Adresse du projet</dt>
                <dd class="mt-1 text-slate-900">{{ $permit->project_address }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Demandeur</dt>
                <dd class="mt-1 text-slate-900">{{ $permit->citizen?->prenom }} {{ $permit->citizen?->nom }}</dd>
            </div>
            @if ($permit->risk_level)
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Niveau de risque (IA)</dt>
                    <dd class="mt-1 font-medium text-slate-900">{{ $permit->risk_level }}</dd>
                </div>
            @endif
        </dl>
    </div>

    @if ($role === 'agent_urbanisme')
        <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Actions agent</h2>
            <div class="mt-4 flex flex-wrap gap-3">
                <form action="{{ url('/agent/permits/'.$permit->id.'/validate') }}" method="post" class="inline" onsubmit="return confirm('Valider ce dossier administrativement ?');">
                    @csrf
                    <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Valider</button>
                </form>
                <form action="{{ url('/agent/permits/'.$permit->id.'/reject') }}" method="post" class="inline flex flex-wrap items-end gap-2">
                    @csrf
                    <input type="text" name="commentaire" placeholder="Motif (optionnel)" class="min-w-[12rem] rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Refuser</button>
                </form>
                <form action="{{ url('/agent/permits/'.$permit->id.'/request-docs') }}" method="post" class="inline flex flex-wrap items-end gap-2">
                    @csrf
                    <input type="text" name="commentaire" placeholder="Précisez les pièces demandées" required class="min-w-[14rem] rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <button type="submit" class="rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700">Demander des pièces</button>
                </form>
            </div>
        </div>
    @endif

    @if ($role === 'service_technique' && $permit->technical_review_required)
        <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Révision technique</h2>
            <form action="{{ url('/technical/permits/'.$permit->id.'/review') }}" method="post" class="mt-4 space-y-4 max-w-lg">
                @csrf
                <fieldset>
                    <legend class="text-sm font-medium text-slate-700">Conformité</legend>
                    <label class="mt-2 flex items-center gap-2 text-sm">
                        <input type="radio" name="conformite" value="1" required> Conforme — valider et archiver
                    </label>
                    <label class="mt-1 flex items-center gap-2 text-sm">
                        <input type="radio" name="conformite" value="0" required> Non conforme — refus
                    </label>
                </fieldset>
                <div>
                    <label for="remarque" class="block text-sm font-medium text-slate-700">Remarques</label>
                    <textarea name="remarque" id="remarque" rows="3" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm"></textarea>
                </div>
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Enregistrer la révision</button>
            </form>
        </div>
    @endif

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">Documents</h2>
        <ul class="mt-4 divide-y divide-slate-100">
            @forelse ($permit->documents as $doc)
                <li class="flex flex-wrap items-center justify-between gap-2 py-3 text-sm">
                    <span class="text-slate-800">{{ $doc->file_name }}</span>
                    <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" rel="noopener" class="font-medium text-slate-900 underline">Télécharger</a>
                </li>
            @empty
                <li class="py-4 text-slate-500">Aucun document.</li>
            @endforelse
        </ul>

        @if (in_array($role, ['citoyen', 'administrateur'], true))
            <form action="{{ url('/permits/'.$permit->id.'/documents') }}" method="post" enctype="multipart/form-data" class="mt-6 border-t border-slate-100 pt-6">
                @csrf
                <label class="block text-sm font-medium text-slate-700">Ajouter un document</label>
                <div class="mt-2 flex flex-wrap items-center gap-3">
                    <input type="file" name="document" required accept=".pdf,.jpg,.jpeg,.png" class="text-sm text-slate-600">
                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Envoyer</button>
                </div>
                <p class="mt-2 text-xs text-slate-500">PDF ou image, 10 Mo max.</p>
            </form>
        @endif
    </div>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">Historique des statuts</h2>
        <ul class="mt-4 space-y-3 text-sm">
            @forelse ($permit->histories->sortByDesc('changed_at') as $h)
                <li class="rounded-lg border border-slate-100 bg-slate-50/80 px-4 py-3">
                    <p class="font-medium text-slate-900">{{ $h->newStatus?->nom ?? '—' }}</p>
                    <p class="mt-1 text-slate-600">{{ $h->commentaire ?? '—' }}</p>
                    <p class="mt-1 text-xs text-slate-500">
                        {{ $h->changed_at?->format('d/m/Y H:i') }}
                        @if ($h->changedBy)
                            — {{ $h->changedBy->prenom }} {{ $h->changedBy->nom }}
                        @endif
                    </p>
                </li>
            @empty
                <li class="text-slate-500">Pas encore d’historique.</li>
            @endforelse
        </ul>
    </div>

    @if ($permit->technicalReviews->isNotEmpty())
        <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Révisions techniques enregistrées</h2>
            <ul class="mt-4 space-y-3 text-sm">
                @foreach ($permit->technicalReviews as $tr)
                    <li class="rounded-lg border border-slate-100 px-4 py-3">
                        <p class="font-medium {{ $tr->conformite ? 'text-emerald-700' : 'text-red-700' }}">
                            {{ $tr->conformite ? 'Conforme' : 'Non conforme' }}
                        </p>
                        <p class="mt-1 text-slate-600">{{ $tr->remarque ?: '—' }}</p>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $tr->reviewed_at?->format('d/m/Y H:i') }}
                            @if ($tr->reviewer)
                                — {{ $tr->reviewer->prenom }} {{ $tr->reviewer->nom }}
                            @endif
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

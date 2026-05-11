@extends('layouts.app')

@section('title', 'Dossiers permis')

@section('content')
    @php
        $role = auth()->user()->role?->nom;
        $listTitle = match ($role) {
            'citoyen' => 'Mes demandes de permis',
            'architecte' => 'Dossiers architecte',
            'agent_urbanisme' => 'Tous les dossiers',
            'service_technique' => 'Dossiers — révision technique',
            default => 'Dossiers',
        };
    @endphp

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $listTitle }}</h1>
            <p class="mt-1 text-sm text-slate-600">Référence, statut et actions.</p>
        </div>
        @if ($role === 'citoyen')
            <a href="{{ route('citizen.permits.create') }}" class="inline-flex justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                Nouveau dossier
            </a>
        @endif
    </div>

    @isset($statuses)
        <form method="get" action="{{ route('agent.permits') }}" class="mt-6 flex flex-wrap items-end gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div>
                <label for="status" class="block text-xs font-medium text-slate-500">Filtrer par statut</label>
                <select name="status" id="status" onchange="this.form.submit()"
                    class="mt-1 rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm">
                    <option value="">Tous</option>
                    @foreach ($statuses as $s)
                        <option value="{{ $s->nom }}" @selected(request('status') === $s->nom)>{{ $s->nom }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    @endisset

    <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Référence</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Projet</th>
                        @if (in_array($role, ['architecte', 'agent_urbanisme', 'service_technique'], true))
                            <th class="px-4 py-3 text-left font-medium text-slate-700">Demandeur</th>
                        @endif
                        @if ($role === 'agent_urbanisme')
                            <th class="px-4 py-3 text-left font-medium text-slate-700">District</th>
                        @endif
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Statut</th>
                        <th class="px-4 py-3 text-right font-medium text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($permits as $p)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 font-mono text-slate-800">{{ $p->reference_number }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ Str::limit($p->project_title, 42) }}</td>
                            @if (in_array($role, ['architecte', 'agent_urbanisme', 'service_technique'], true))
                                <td class="px-4 py-3 text-slate-700">{{ $p->citizen?->prenom }} {{ $p->citizen?->nom }}</td>
                            @endif
                            @if ($role === 'agent_urbanisme')
                                <td class="px-4 py-3 text-slate-600">{{ $p->district?->nom ?? '—' }}</td>
                            @endif
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">{{ $p->status?->nom }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('permits.show', $p->id) }}" class="font-medium text-slate-900 underline">Détails</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-12 text-center text-slate-500">Aucun dossier à afficher.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-4 py-3">
            {{ $permits->links() }}
        </div>
    </div>
@endsection

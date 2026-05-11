@extends('layouts.app')

@section('title', 'Espace citoyen')

@section('content')
    <h1 class="text-2xl font-bold text-slate-900">Tableau de bord — Citoyen</h1>
    <p class="mt-1 text-slate-600">Suivez vos demandes de permis de construire.</p>

    <div class="mt-8 grid gap-6 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Dossiers</p>
            <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalPermits }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">En attente</p>
            <p class="mt-2 text-3xl font-semibold text-amber-600">{{ $pending }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <a href="{{ route('citizen.permits.create') }}" class="inline-flex w-full items-center justify-center rounded-lg bg-slate-900 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                Nouveau dossier
            </a>
        </div>
    </div>

    <div class="mt-10">
        <h2 class="text-lg font-semibold text-slate-900">Derniers dossiers</h2>
        <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Référence</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Projet</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Statut</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentPermits as $p)
                        <tr>
                            <td class="px-4 py-3 font-mono text-slate-800">{{ $p->reference_number }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ Str::limit($p->project_title, 40) }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-800">{{ $p->status?->nom }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('permits.show', $p->id) }}" class="font-medium text-slate-900 underline">Détails</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500">Aucun dossier pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

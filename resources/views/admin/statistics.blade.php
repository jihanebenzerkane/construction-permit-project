@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')
    @include('partials.admin-nav')

    <h1 class="text-2xl font-bold text-slate-900">Statistiques</h1>
    <p class="mt-1 text-slate-600">Vue agrégée de l’activité sur la plateforme.</p>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Utilisateurs</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalUsers }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Dossiers total</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalPermits }}</p>
        </div>
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
            <p class="text-sm font-medium text-amber-800">Risque élevé</p>
            <p class="mt-2 text-3xl font-bold text-amber-900">{{ $highRisk }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">En attente (statut Soumis)</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $pending }}</p>
        </div>
    </div>

    <div class="mt-10">
        <h2 class="text-lg font-semibold text-slate-900">Dossiers par statut</h2>
        <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Statut</th>
                        <th class="px-4 py-3 text-right font-medium text-slate-700">Nombre</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($byStatus as $s)
                        <tr>
                            <td class="px-4 py-3">{{ $s->nom }}</td>
                            <td class="px-4 py-3 text-right font-mono text-slate-800">{{ $s->permits_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

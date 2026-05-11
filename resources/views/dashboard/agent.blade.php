@extends('layouts.app')

@section('title', 'Espace agent d’urbanisme')

@section('content')
    <h1 class="text-2xl font-bold text-slate-900">Tableau de bord — Agent</h1>
    <p class="mt-1 text-slate-600">Vue d’ensemble des dossiers à traiter.</p>

    <div class="mt-8 grid gap-6 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Dossiers à étudier / soumis</p>
            <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $pending }}</p>
        </div>
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
            <p class="text-sm font-medium text-amber-800">Risque élevé (IA)</p>
            <p class="mt-2 text-3xl font-semibold text-amber-900">{{ $highRisk }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <a href="{{ route('agent.permits') }}" class="inline-flex w-full items-center justify-center rounded-lg bg-slate-900 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                Liste des dossiers
            </a>
        </div>
    </div>

    <div class="mt-10">
        <h2 class="text-lg font-semibold text-slate-900">Activité récente</h2>
        <ul class="mt-4 space-y-3">
            @forelse ($recent as $p)
                <li class="flex flex-wrap items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm">
                    <span class="font-mono text-slate-800">{{ $p->reference_number }}</span>
                    <span class="text-slate-600">{{ Str::limit($p->project_title, 50) }}</span>
                    <a href="{{ route('permits.show', $p->id) }}" class="font-medium text-slate-900 underline">Ouvrir</a>
                </li>
            @empty
                <li class="text-slate-500">Aucun dossier récent.</li>
            @endforelse
        </ul>
    </div>
@endsection

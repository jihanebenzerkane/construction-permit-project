@extends('layouts.app')

@section('title', 'Service technique')

@section('content')
    <h1 class="text-2xl font-bold text-slate-900">Tableau de bord — Service technique</h1>
    <p class="mt-1 text-slate-600">Dossiers nécessitant une révision technique.</p>

    <div class="mt-8 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-slate-700">Référence</th>
                    <th class="px-4 py-3 text-left font-medium text-slate-700">Projet</th>
                    <th class="px-4 py-3 text-left font-medium text-slate-700">Demandeur</th>
                    <th class="px-4 py-3 text-left font-medium text-slate-700">Statut</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($permits as $p)
                    <tr>
                        <td class="px-4 py-3 font-mono">{{ $p->reference_number }}</td>
                        <td class="px-4 py-3">{{ Str::limit($p->project_title, 40) }}</td>
                        <td class="px-4 py-3">{{ $p->citizen?->prenom }} {{ $p->citizen?->nom }}</td>
                        <td class="px-4 py-3"><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs">{{ $p->status?->nom }}</span></td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('permits.show', $p->id) }}" class="font-medium text-slate-900 underline">Réviser</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-500">Aucune révision en attente.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

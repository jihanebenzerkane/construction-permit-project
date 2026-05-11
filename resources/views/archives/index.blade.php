@extends('layouts.app')

@section('title', 'Archives')

@section('content')
    @include('partials.admin-nav')

    <h1 class="text-2xl font-bold text-slate-900">Archives des dossiers</h1>
    <p class="mt-1 text-slate-600">Dossiers archivés avec date et motif.</p>

    <div class="mt-8 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Référence</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Projet</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Demandeur</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Date d’archivage</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Motif</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Par</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($archives as $a)
                        <tr>
                            <td class="px-4 py-3 font-mono">{{ $a->permit?->reference_number ?? '—' }}</td>
                            <td class="px-4 py-3">{{ Str::limit($a->permit?->project_title ?? '—', 36) }}</td>
                            <td class="px-4 py-3">
                                {{ $a->permit?->citizen?->prenom }} {{ $a->permit?->citizen?->nom }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $a->archive_date?->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ Str::limit($a->archive_reason ?? '—', 40) }}</td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $a->archivedBy?->prenom }} {{ $a->archivedBy?->nom }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if ($a->permit_id)
                                    <a href="{{ route('permits.show', $a->permit_id) }}" class="font-medium text-slate-900 underline">Voir</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-slate-500">Aucune archive.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-4 py-3">{{ $archives->links() }}</div>
    </div>
@endsection

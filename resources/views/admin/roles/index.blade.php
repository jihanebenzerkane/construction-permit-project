@extends('layouts.app')

@section('title', 'Rôles')

@section('content')
    @include('partials.admin-nav')

    <h1 class="text-2xl font-bold text-slate-900">Rôles</h1>
    <p class="mt-4">
        <a href="{{ route('admin.roles.create') }}" class="inline-flex rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Nouveau rôle</a>
    </p>
    <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-slate-700">Nom</th>
                    <th class="px-4 py-3 text-left font-medium text-slate-700">Permissions</th>
                    <th class="px-4 py-3 text-right font-medium text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($roles as $role)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $role->nom }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $role->permissions->pluck('nom')->join(', ') ?: '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="font-medium text-slate-900 underline">Modifier</a>
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="post" class="mt-2 inline" onsubmit="return confirm('Supprimer ce rôle ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-800 hover:bg-red-100">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

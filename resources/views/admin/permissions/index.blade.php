@extends('layouts.app')

@section('title', 'Permissions')

@section('content')
    @include('partials.admin-nav')

    <h1 class="text-2xl font-bold text-slate-900">Permissions</h1>
    <p class="mt-4">
        <a href="{{ route('admin.permissions.create') }}" class="inline-flex rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Nouvelle permission</a>
    </p>
    <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-slate-700">Nom</th>
                    <th class="px-4 py-3 text-left font-medium text-slate-700">Description</th>
                    <th class="px-4 py-3 text-left font-medium text-slate-700">Rôles</th>
                    <th class="px-4 py-3 text-right font-medium text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($permissions as $permission)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $permission->nom }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $permission->description ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $permission->roles->pluck('nom')->join(', ') ?: '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.permissions.edit', $permission) }}" class="font-medium text-slate-900 underline">Modifier</a>
                            <form action="{{ route('admin.permissions.destroy', $permission) }}" method="post" class="mt-2 inline" onsubmit="return confirm('Supprimer cette permission ?');">
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

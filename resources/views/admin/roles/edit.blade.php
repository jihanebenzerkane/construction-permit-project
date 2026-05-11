@extends('layouts.app')

@section('title', 'Modifier le rôle')

@section('content')
    @include('partials.admin-nav')

    <h1 class="text-2xl font-bold text-slate-900">Rôle : {{ $role->nom }}</h1>

    <h2 class="mt-8 text-lg font-semibold text-slate-900">Identifiant</h2>
    <form action="{{ route('admin.roles.update', $role) }}" method="post" class="mt-4 max-w-md space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="nom" class="block text-sm font-medium text-slate-700">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $role->nom) }}" required maxlength="100"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm">
        </div>
        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Enregistrer</button>
    </form>

    <h2 class="mt-10 text-lg font-semibold text-slate-900">Permissions associées</h2>
    <form action="{{ route('admin.roles.permissions.sync', $role) }}" method="post" class="mt-4 max-w-2xl space-y-2">
        @csrf
        @foreach ($permissions as $permission)
            <label class="flex items-start gap-3 rounded-lg border border-slate-100 bg-slate-50/80 px-4 py-3 text-sm">
                <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}" class="mt-1"
                    @checked($role->permissions->contains($permission->id))>
                <span>
                    <span class="font-medium text-slate-900">{{ $permission->nom }}</span>
                    @if ($permission->description)
                        <span class="mt-0.5 block text-slate-600">{{ $permission->description }}</span>
                    @endif
                </span>
            </label>
        @endforeach
        <button type="submit" class="mt-4 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Mettre à jour les permissions</button>
    </form>

    <p class="mt-8"><a href="{{ route('admin.roles.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">← Retour à la liste</a></p>
@endsection

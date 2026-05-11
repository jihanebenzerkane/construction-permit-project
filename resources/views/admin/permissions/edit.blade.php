@extends('layouts.app')

@section('title', 'Modifier la permission')

@section('content')
    @include('partials.admin-nav')

    <h1 class="text-2xl font-bold text-slate-900">Modifier la permission</h1>
    <form action="{{ route('admin.permissions.update', $permission) }}" method="post" class="mt-6 max-w-lg space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="nom" class="block text-sm font-medium text-slate-700">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $permission->nom) }}" required maxlength="150"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-slate-700">Description</label>
            <textarea name="description" id="description" rows="3" maxlength="2000"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm">{{ old('description', $permission->description) }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Enregistrer</button>
            <a href="{{ route('admin.permissions.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Annuler</a>
        </div>
    </form>
@endsection

@extends('layouts.app')

@section('title', 'Nouveau rôle')

@section('content')
    @include('partials.admin-nav')

    <h1 class="text-2xl font-bold text-slate-900">Nouveau rôle</h1>
    <form action="{{ route('admin.roles.store') }}" method="post" class="mt-6 max-w-md space-y-4">
        @csrf
        <div>
            <label for="nom" class="block text-sm font-medium text-slate-700">Identifiant du rôle (unique)</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required maxlength="100"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Créer</button>
            <a href="{{ route('admin.roles.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Annuler</a>
        </div>
    </form>
@endsection

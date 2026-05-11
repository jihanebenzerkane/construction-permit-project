@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="mx-auto max-w-lg rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-semibold text-slate-900">Créer un compte</h1>
        <p class="mt-1 text-sm text-slate-600">Renseignez vos informations</p>

        <form method="post" action="{{ route('register') }}" class="mt-8 space-y-4">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="nom" class="block text-sm font-medium text-slate-700">Nom</label>
                    <input id="nom" name="nom" type="text" value="{{ old('nom') }}" required maxlength="100"
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                </div>
                <div>
                    <label for="prenom" class="block text-sm font-medium text-slate-700">Prénom</label>
                    <input id="prenom" name="prenom" type="text" value="{{ old('prenom') }}" required maxlength="100"
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                </div>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
            </div>
            <div>
                <label for="cin" class="block text-sm font-medium text-slate-700">CIN</label>
                <input id="cin" name="cin" type="text" value="{{ old('cin') }}" required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                <input id="password" name="password" type="password" required minlength="6"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirmation</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
            </div>
            <div>
                <label for="role_id" class="block text-sm font-medium text-slate-700">Rôle</label>
                <select id="role_id" name="role_id" required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                    <option value="">— Choisir —</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="district_id" class="block text-sm font-medium text-slate-700">District</label>
                <select id="district_id" name="district_id" required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                    <option value="">— Choisir —</option>
                    @foreach ($districts as $d)
                        <option value="{{ $d->id }}" @selected(old('district_id') == $d->id)>{{ $d->nom ?? 'District #'.$d->id }}</option>
                    @endforeach
                </select>
            </div>

            @if ($errors->any())
                <ul class="list-inside list-disc text-sm text-red-600">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            @endif

            <button type="submit" class="w-full rounded-lg bg-slate-900 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                S’inscrire
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            Déjà inscrit ?
            <a href="{{ route('login') }}" class="font-medium text-slate-900 underline">Connexion</a>
        </p>
    </div>
@endsection

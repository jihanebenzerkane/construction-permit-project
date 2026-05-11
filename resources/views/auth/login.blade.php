@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="mx-auto max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-semibold text-slate-900">Connexion</h1>
        <p class="mt-1 text-sm text-slate-600">Plateforme permis de construire</p>

        <form method="post" action="{{ route('login') }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
            </div>
            @error('email')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full rounded-lg bg-slate-900 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                Se connecter
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            Pas de compte ?
            <a href="{{ route('register') }}" class="font-medium text-slate-900 underline">S’inscrire</a>
        </p>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Nouveau rôle')

@section('content')
    <h1>Nouveau rôle</h1>
    <form action="{{ route('admin.roles.store') }}" method="post">
        @csrf
        <label for="nom">Identifiant du rôle (unique)</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required maxlength="100">
        <p style="margin-top:1rem;">
            <button type="submit" class="btn">Créer</button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Annuler</a>
        </p>
    </form>
@endsection

@extends('layouts.admin')

@section('title', 'Nouvelle permission')

@section('content')
    <h1>Nouvelle permission</h1>
    <form action="{{ route('admin.permissions.store') }}" method="post">
        @csrf
        <label for="nom">Nom (unique)</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required maxlength="150">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="3" maxlength="2000">{{ old('description') }}</textarea>
        <p style="margin-top:1rem;">
            <button type="submit" class="btn">Créer</button>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Annuler</a>
        </p>
    </form>
@endsection

@extends('layouts.admin')

@section('title', 'Modifier la permission')

@section('content')
    <h1>Modifier la permission</h1>
    <form action="{{ route('admin.permissions.update', $permission) }}" method="post">
        @csrf
        @method('PUT')
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $permission->nom) }}" required maxlength="150">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="3" maxlength="2000">{{ old('description', $permission->description) }}</textarea>
        <p style="margin-top:1rem;">
            <button type="submit" class="btn">Enregistrer</button>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Annuler</a>
        </p>
    </form>
@endsection

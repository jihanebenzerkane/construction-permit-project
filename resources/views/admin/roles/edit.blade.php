@extends('layouts.admin')

@section('title', 'Modifier le rôle')

@section('content')
    <h1>Rôle : {{ $role->nom }}</h1>

    <h2>Identifiant</h2>
    <form action="{{ route('admin.roles.update', $role) }}" method="post">
        @csrf
        @method('PUT')
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $role->nom) }}" required maxlength="100">
        <p style="margin-top:1rem;">
            <button type="submit" class="btn">Enregistrer</button>
        </p>
    </form>

    <h2 style="margin-top:2rem;">Permissions associées</h2>
    <form action="{{ route('admin.roles.permissions.sync', $role) }}" method="post">
        @csrf
        @foreach ($permissions as $permission)
            <label style="font-weight:normal;">
                <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}"
                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                {{ $permission->nom }}
                @if ($permission->description)
                    <small>— {{ $permission->description }}</small>
                @endif
            </label>
        @endforeach
        <p style="margin-top:1rem;">
            <button type="submit" class="btn">Mettre à jour les permissions</button>
        </p>
    </form>

    <p style="margin-top:2rem;"><a href="{{ route('admin.roles.index') }}">← Retour à la liste</a></p>
@endsection

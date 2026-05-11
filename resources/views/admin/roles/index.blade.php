@extends('layouts.admin')

@section('title', 'Rôles')

@section('content')
    <h1>Rôles</h1>
    <p><a href="{{ route('admin.roles.create') }}" class="btn">Nouveau rôle</a></p>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Permissions</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->nom }}</td>
                    <td>{{ $role->permissions->pluck('nom')->join(', ') ?: '—' }}</td>
                    <td>
                        <a href="{{ route('admin.roles.edit', $role) }}">Modifier</a>
                        <form action="{{ route('admin.roles.destroy', $role) }}" method="post" style="display:inline;" onsubmit="return confirm('Supprimer ce rôle ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

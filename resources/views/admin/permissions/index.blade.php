@extends('layouts.admin')

@section('title', 'Permissions')

@section('content')
    <h1>Permissions</h1>
    <p><a href="{{ route('admin.permissions.create') }}" class="btn">Nouvelle permission</a></p>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Rôles</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->nom }}</td>
                    <td>{{ $permission->description ?? '—' }}</td>
                    <td>{{ $permission->roles->pluck('nom')->join(', ') ?: '—' }}</td>
                    <td>
                        <a href="{{ route('admin.permissions.edit', $permission) }}">Modifier</a>
                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="post" style="display:inline;" onsubmit="return confirm('Supprimer cette permission ?');">
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

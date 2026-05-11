@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('content')
    @include('partials.admin-nav')

    <h1 class="text-2xl font-bold text-slate-900">Gestion des utilisateurs</h1>
    <p class="mt-1 text-slate-600">Attribuez un rôle à chaque compte.</p>

    <div class="mt-8 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Nom</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">E-mail</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">CIN</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">District</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Rôle</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $u)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $u->prenom }} {{ $u->nom }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $u->email }}</td>
                            <td class="px-4 py-3 font-mono text-slate-600">{{ $u->cin }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $u->district?->nom ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <form action="{{ url('/admin/users/'.$u->id.'/role') }}" method="post" class="flex flex-wrap items-center gap-2">
                                    @csrf
                                    <select name="role_id" class="rounded-lg border border-slate-300 px-2 py-1.5 text-sm" onchange="this.form.submit()">
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->id }}" @selected($u->role_id === $r->id)>{{ $r->nom }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-4 py-3">{{ $users->links() }}</div>
    </div>
@endsection

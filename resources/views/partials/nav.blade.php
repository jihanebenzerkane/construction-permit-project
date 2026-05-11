@php
    $role = auth()->user()->role?->nom;
@endphp

<header class="border-b border-slate-200 bg-white shadow-sm">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-slate-900">{{ config('app.name') }}</a>

        <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-slate-600">
            @if ($role === 'citoyen')
                <a href="{{ route('citizen.dashboard') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Tableau de bord</a>
                <a href="{{ route('citizen.permits') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Mes dossiers</a>
                <a href="{{ route('citizen.permits.create') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Nouveau dossier</a>
            @elseif ($role === 'architecte')
                <a href="{{ route('architect.dashboard') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Tableau de bord</a>
                <a href="{{ route('architect.permits') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Dossiers</a>
            @elseif ($role === 'agent_urbanisme')
                <a href="{{ route('agent.dashboard') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Tableau de bord</a>
                <a href="{{ route('agent.permits') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Dossiers</a>
            @elseif ($role === 'service_technique')
                <a href="{{ route('technical.dashboard') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Tableau de bord</a>
                <a href="{{ route('technical.permits') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Révisions</a>
            @elseif ($role === 'administrateur')
                <a href="{{ route('admin.dashboard') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Tableau de bord</a>
                <a href="{{ route('admin.users') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Utilisateurs</a>
                <a href="{{ route('admin.statistics') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Statistiques</a>
                <a href="{{ route('admin.archives') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Archives</a>
                <a href="{{ route('admin.roles.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Rôles</a>
                <a href="{{ route('admin.permissions.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Permissions</a>
            @endif

            <a href="{{ route('notifications.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-slate-900">Notifications</a>

            <span class="hidden text-slate-300 sm:inline">|</span>
            <span class="text-slate-500">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</span>

            <form action="{{ route('logout') }}" method="post" class="inline">
                @csrf
                <button type="submit" class="rounded-md bg-slate-900 px-3 py-2 text-white hover:bg-slate-800">Déconnexion</button>
            </form>
        </nav>
    </div>
</header>

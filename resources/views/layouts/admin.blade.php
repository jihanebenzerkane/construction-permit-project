<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Administration') — {{ config('app.name') }}</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 960px; margin: 2rem auto; padding: 0 1rem; line-height: 1.5; }
        nav { margin-bottom: 1.5rem; }
        nav a { margin-right: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #ccc; padding: 0.5rem 0.75rem; text-align: left; }
        th { background: #f5f5f5; }
        .btn { display: inline-block; padding: 0.35rem 0.75rem; background: #333; color: #fff; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; font-size: 0.9rem; }
        .btn-secondary { background: #666; }
        label { display: block; margin-top: 0.75rem; }
        input[type="text"], textarea { width: 100%; max-width: 32rem; padding: 0.4rem; }
        .error { color: #b00020; }
        .success { color: #0a6; }
        ul.errors { color: #b00020; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.users') }}">Utilisateurs</a>
        <a href="{{ route('admin.roles.index') }}">Rôles</a>
        <a href="{{ route('admin.permissions.index') }}">Permissions</a>
        <a href="{{ route('admin.statistics') }}">Statistiques</a>
    </nav>
    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <ul class="errors">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif
    @yield('content')
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'] } } } }</script>
    @endif
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    @auth
        @include('partials.nav')
    @endauth

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>

@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <h1 class="text-2xl font-bold text-slate-900">Notifications</h1>
    <p class="mt-1 text-slate-600">Messages liés à vos dossiers.</p>

    <ul class="mt-8 space-y-3">
        @forelse ($notifications as $n)
            <li class="rounded-xl border {{ $n->is_read ? 'border-slate-200 bg-white' : 'border-slate-900/20 bg-slate-50' }} p-4 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="font-semibold text-slate-900">{{ $n->titre }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $n->message }}</p>
                        @if ($n->permit)
                            <p class="mt-2 text-xs text-slate-500">
                                Dossier :
                                <a href="{{ route('permits.show', $n->permit_id) }}" class="font-medium text-slate-900 underline">{{ $n->permit->reference_number }}</a>
                            </p>
                        @endif
                        <p class="mt-2 text-xs text-slate-400">{{ $n->created_at?->format('d/m/Y H:i') }}</p>
                    </div>
                    @if (! $n->is_read)
                        <form action="{{ url('/notifications/'.$n->id.'/read') }}" method="post">
                            @csrf
                            <button type="submit" class="rounded-lg bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-800">Marquer lu</button>
                        </form>
                    @endif
                </div>
            </li>
        @empty
            <li class="rounded-xl border border-dashed border-slate-200 py-12 text-center text-slate-500">Aucune notification.</li>
        @endforelse
    </ul>

    <div class="mt-8">
        {{ $notifications->links() }}
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Nouveau dossier')

@section('content')
    <h1 class="text-2xl font-bold text-slate-900">Nouvelle demande de permis</h1>
    <p class="mt-1 text-slate-600">Renseignez les informations du projet et joignez les pièces (PDF ou images, max 10 Mo chacune).</p>

    <form action="{{ route('citizen.permits.store') }}" method="post" enctype="multipart/form-data" class="mt-8 max-w-2xl space-y-6">
        @csrf
        <div>
            <label for="permit_type_id" class="block text-sm font-medium text-slate-700">Type de permis</label>
            <select name="permit_type_id" id="permit_type_id" required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                <option value="">— Choisir —</option>
                @foreach ($permitTypes as $t)
                    <option value="{{ $t->id }}" @selected(old('permit_type_id') == $t->id)>{{ $t->nom ?? 'Type #'.$t->id }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="district_id" class="block text-sm font-medium text-slate-700">District</label>
            <select name="district_id" id="district_id" required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                <option value="">— Choisir —</option>
                @foreach ($districts as $d)
                    <option value="{{ $d->id }}" @selected(old('district_id') == $d->id)>{{ $d->nom }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="project_title" class="block text-sm font-medium text-slate-700">Intitulé du projet</label>
            <input type="text" name="project_title" id="project_title" value="{{ old('project_title') }}" required maxlength="255"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
        </div>
        <div>
            <label for="project_address" class="block text-sm font-medium text-slate-700">Adresse du chantier</label>
            <textarea name="project_address" id="project_address" rows="3" required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">{{ old('project_address') }}</textarea>
        </div>
        <div>
            <label for="surface" class="block text-sm font-medium text-slate-700">Surface (m²)</label>
            <input type="number" name="surface" id="surface" value="{{ old('surface') }}" required min="1" step="0.01"
                class="mt-1 w-full max-w-xs rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
        </div>
        <div>
            <label for="documents" class="block text-sm font-medium text-slate-700">Documents (optionnel, plusieurs fichiers)</label>
            <input type="file" name="documents[]" id="documents" multiple accept=".pdf,.jpg,.jpeg,.png"
                class="mt-1 block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-800 hover:file:bg-slate-200">
        </div>

        @if ($errors->any())
            <ul class="list-inside list-disc text-sm text-red-600">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        @endif

        <div class="flex gap-3">
            <button type="submit" class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                Soumettre le dossier
            </button>
            <a href="{{ route('citizen.permits') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">Annuler</a>
        </div>
    </form>
@endsection

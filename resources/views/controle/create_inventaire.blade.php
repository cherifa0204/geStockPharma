@extends('layouts.base')
@section('content')

{{-- Page Header --}}
<div class="mb-8">
    <div class="flex items-center space-x-3 mb-2">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Inventaire de la Pharmacie</h1>
            <p class="text-sm text-slate-500">Sélectionnez une période pour générer votre rapport d'inventaire</p>
        </div>
    </div>
</div>

{{-- Form Card --}}
<div class="max-w-2xl">
    <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm">

        {{-- Info banner --}}
        <div class="mb-6 flex items-start space-x-3 rounded-xl bg-teal-50 border border-teal-100 p-4">
            <svg class="h-5 w-5 text-teal-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm text-teal-700">
                L'inventaire affichera les <strong>mouvements de stock</strong> (entrées, sorties, solde) pour tous les produits sur la période choisie.
            </p>
        </div>

        <form action="{{ route('inventaire') }}" method="get" class="space-y-6">
            @csrf

            {{-- Date de début --}}
            <div>
                <label for="date_debut" class="block text-sm font-semibold text-slate-700 mb-2">
                    <span class="flex items-center space-x-2">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Date de début</span>
                    </span>
                </label>
                <input
                    type="date"
                    id="date_debut"
                    name="date_debut"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 transition focus:border-teal-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20"
                >
            </div>

            {{-- Date de fin --}}
            <div>
                <label for="date_fin" class="block text-sm font-semibold text-slate-700 mb-2">
                    <span class="flex items-center space-x-2">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Date de fin</span>
                    </span>
                </label>
                <input
                    type="date"
                    id="date_fin"
                    name="date_fin"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 transition focus:border-teal-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20"
                >
            </div>

            {{-- Actions --}}
            <div class="flex items-center space-x-3 pt-2">
                <button
                    type="submit"
                    class="inline-flex items-center space-x-2 rounded-xl bg-teal-600 px-6 py-3 text-sm font-semibold text-white shadow-sm shadow-teal-500/20 transition hover:bg-teal-700 hover:shadow-md hover:shadow-teal-500/30 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Générer l'inventaire</span>
                </button>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

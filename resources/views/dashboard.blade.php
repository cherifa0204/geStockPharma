@extends('layouts.base')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Tableau de bord</h1>
            <p class="text-sm text-slate-500 mt-1">Bonjour, <span class="font-semibold text-teal-600">{{ Auth::user()->name }}</span> ! Voici l'état actuel de votre pharmacie aujourd'hui.</p>
        </div>

    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        
        <!-- Today's Sales -->
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm flex items-center space-x-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Ventes du jour</span>
                <span class="block text-2xl font-bold text-slate-900 mt-0.5">
                    {{ number_format(\App\Models\Vente::whereDate('date_vente', today()->toDateString())->sum('montant_total'), 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>

        <!-- Today's Purchases -->
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm flex items-center space-x-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Achats du jour</span>
                <span class="block text-2xl font-bold text-slate-900 mt-0.5">
                    {{ number_format(\App\Models\Achat::whereDate('date_achat', today()->toDateString())->sum('montant_total_achat'), 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>

        <!-- Total Medicines -->
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm flex items-center space-x-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Médicaments</span>
                <span class="block text-2xl font-bold text-slate-900 mt-0.5">
                    {{ \App\Models\Produit::count() }} Références
                </span>
            </div>
        </div>

        <!-- Low Stock Alerts -->
        @php
            $lowStockCount = \App\Models\Produit::where('quantite_stock', '<=', 5)->count();
        @endphp
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm flex items-center space-x-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $lowStockCount > 0 ? 'bg-amber-50 text-amber-600' : 'bg-slate-50 text-slate-400' }}">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Stocks faibles</span>
                <span class="block text-2xl font-bold mt-0.5 {{ $lowStockCount > 0 ? 'text-amber-600' : 'text-slate-900' }}">
                    {{ $lowStockCount }} @if($lowStockCount > 1) Produits @else Produit @endif
                </span>
            </div>
        </div>

    </div>

    <!-- Secondary Dashboard Content (Tables and Lists) -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        
        <!-- Low Stock Warnings -->
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm lg:col-span-1">
            <div class="flex items-center justify-between border-b border-slate-50 pb-4 mb-4">
                <h3 class="font-bold text-slate-900">Alertes de Stock Faible</h3>
                <span class="rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700">Alerte</span>
            </div>
            <div class="space-y-4">
                @forelse (\App\Models\Produit::where('quantite_stock', '<=', 5)->take(6)->get() as $prod)
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <span class="block text-sm font-semibold text-slate-800 truncate">{{ $prod->nom_produit }}</span>
                        <span class="block text-xs text-slate-400 mt-0.5">Prix de vente: {{ number_format($prod->prix_unitaire_vente, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <span class="inline-flex items-center rounded-lg px-2 py-1 text-xs font-semibold {{ $prod->quantite_stock == 0 ? 'bg-red-50 text-red-700 border border-red-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                        {{ $prod->quantite_stock }} en stock
                    </span>
                </div>
                @empty
                <div class="text-center py-6">
                    <svg class="mx-auto h-9 w-9 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="block text-xs font-semibold text-slate-400 mt-2">Tous les stocks sont normaux.</span>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Sales -->
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between border-b border-slate-50 pb-4 mb-4">
                <h3 class="font-bold text-slate-900">Ventes Récentes</h3>
                <a href="{{ route('ventes.index') }}" class="text-xs font-semibold text-teal-600 hover:text-teal-700 transition-colors">Voir tout &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 rounded-lg">
                        <tr>
                            <th scope="col" class="px-4 py-3 rounded-l-lg">ID</th>
                            <th scope="col" class="px-4 py-3">Date</th>
                            <th scope="col" class="px-4 py-3">Caissier / Pharmacien</th>
                            <th scope="col" class="px-4 py-3 text-right rounded-r-lg">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse (\App\Models\Vente::latest()->take(5)->get() as $vente)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-3 font-semibold text-slate-800">#{{ $vente->id }}</td>
                            <td class="px-4 py-3 text-slate-400">{{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $vente->user->name ?? 'Inconnu' }}</td>
                            <td class="px-4 py-3 font-semibold text-slate-900 text-right">{{ number_format($vente->montant_total, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-xs text-slate-400">Aucune vente enregistrée récemment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
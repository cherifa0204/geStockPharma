@extends('layouts.base')
@section('content')

<script src="{{ asset('DataTables/jquery.js') }}"></script>
<script src="{{ asset('DataTables/moncss.js') }}"></script>

{{-- Page Header --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="flex items-center space-x-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Détail de la vente</h1>
            <p class="text-sm text-slate-500">
                Vente <span class="font-semibold text-emerald-600">#{{ $vente->id }}</span>
                &nbsp;·&nbsp;
                {{ \Carbon\Carbon::parse($vente->created_at ?? $vente->updated_at)->format('d/m/Y') }}
                &nbsp;·&nbsp;
                {{ $vente->ligneventes?->count() ?? 0 }} ligne(s)
            </p>
        </div>
    </div>

    <div class="flex items-center space-x-3">
        <a href="{{ route('ventes.index') }}"
            class="inline-flex items-center space-x-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
            <span>Retour</span>
        </a>
        <a href="{{ route('ventes.recu', $vente) }}"
            class="inline-flex items-center space-x-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-500/20 transition hover:bg-emerald-700">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            <span>Générer un reçu</span>
        </a>
    </div>
</div>

{{-- Table Card --}}
<div class="rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">

    <div class="px-6 py-4 border-b border-slate-100">
        <h2 class="text-sm font-semibold text-slate-700">Produits vendus</h2>
    </div>

    <div class="overflow-x-auto">
        <table id="tble1" class="w-full text-sm text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">#</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">Désignation</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Prix unitaire (FCFA)</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Quantité</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Montant (FCFA)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @php $totalVente = 0; @endphp
                @forelse ($vente->ligneventes ?? [] as $ligne)
                    @php 
                        $montantLigne = $ligne->montant ?? (($ligne->produit->prix_unitaire_vente ?? 0) * $ligne->quantite_vente);
                        $totalVente += $montantLigne;
                    @endphp
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 text-slate-400 font-mono text-xs">{{ $loop->index + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            @if ($ligne->produit)
                                {{ $ligne->produit->nom_produit }}
                            @else
                                <span class="inline-flex items-center rounded-lg bg-red-50 px-2.5 py-1 text-xs font-medium text-red-500 border border-red-100">
                                    Produit supprimé
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-slate-600 font-medium">
                            {{ $ligne->produit ? number_format($ligne->produit->prix_unitaire_vente, 0, ',', ' ') : '—' }}
                        </td>
                        <td class="px-6 py-4 text-right text-slate-700 font-semibold">
                            {{ $ligne->quantite_vente }}
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-emerald-700">
                            {{ number_format($montantLigne, 0, ',', ' ') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">
                                    <svg class="h-7 w-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Aucune ligne de vente</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-emerald-50 border-t-2 border-emerald-200">
                    <td colspan="4" class="px-6 py-4 text-sm font-bold text-emerald-800 text-right">TOTAL VENTE</td>
                    <td class="px-6 py-4 text-right text-base font-extrabold text-emerald-700">
                        {{ number_format($totalVente, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    new DataTable('#tble1', {
        info: false,
        paging: false,
        searching: false,
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
    });
</script>

@endsection


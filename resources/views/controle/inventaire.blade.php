@extends('layouts.base')
@section('content')

@php use Carbon\Carbon; @endphp

{{-- Page Header --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="flex items-center space-x-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Inventaire du {{ Carbon::parse($date_debut)->format('d/m/Y') }} au {{ Carbon::parse($date_fin)->format('d/m/Y') }}
            </h1>
            <p class="text-sm text-slate-500">{{ $produits->count() ?? 0 }} produit(s) trouvé(s) sur cette période</p>
        </div>
    </div>

    <div class="flex items-center space-x-3">
        <a href="{{ route('create_inventaire') }}" class="inline-flex items-center space-x-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
            <span>Nouvelle période</span>
        </a>
        <a href="{{ route('ventes.exporter_inv', [$date_debut, $date_fin]) }}"
            class="inline-flex items-center space-x-2 rounded-xl bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-teal-500/20 transition hover:bg-teal-700">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            <span>Exporter PDF</span>
        </a>
    </div>
</div>

{{-- Scripts DataTables --}}
<script src="{{ asset('DataTables/jquery.js') }}"></script>
<script src="{{ asset('DataTables/moncss.js') }}"></script>

{{-- Summary Cards --}}
@php
    $total = 0;
    $totalQteInitiale = 0;
    $totalQteEntree = 0;
    $totalQteSortie = 0;
    foreach (($produits ?? []) as $prd) {
        $inv = $prd->inventaire_prd($date_debut, $date_fin);
        $total += $inv['total_vente'];
        $totalQteInitiale += $inv['quantite_initiale'];
        $totalQteEntree += $inv['quantite_entre'];
        $totalQteSortie += $inv['quantite_sortie'];
    }
@endphp

<div class="mb-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Qté Initiale</p>
        <p class="mt-2 text-2xl font-bold text-slate-800">{{ number_format($totalQteInitiale, 0, ',', ' ') }}</p>
    </div>
    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Entrées</p>
        <p class="mt-2 text-2xl font-bold text-emerald-600">+{{ number_format($totalQteEntree, 0, ',', ' ') }}</p>
    </div>
    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sorties (ventes)</p>
        <p class="mt-2 text-2xl font-bold text-red-500">-{{ number_format($totalQteSortie, 0, ',', ' ') }}</p>
    </div>
    <div class="rounded-2xl border border-teal-100 bg-teal-50 p-5 shadow-sm">
        <p class="text-xs font-semibold uppercase tracking-wider text-teal-500">Total Ventes</p>
        <p class="mt-2 text-2xl font-bold text-teal-700">{{ number_format($total, 0, ',', ' ') }} <span class="text-sm font-semibold">FCFA</span></p>
    </div>
</div>

{{-- Table --}}
<div class="rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">

    {{-- Table Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
        <h2 class="text-sm font-semibold text-slate-700">Détail par produit</h2>
        <div id="search-container"></div>
    </div>

    <div class="overflow-x-auto">
        <table id="tble" class="w-full text-sm text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">Désignation</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Qté Initiale</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Qté Ajoutée</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Qté Vendue</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Stock Actuel</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Montant Vente (FCFA)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($produits ?? [] as $prd)
                    @php $inv = $prd->inventaire_prd($date_debut, $date_fin); @endphp
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $inv['nom_produit'] }}
                        </td>
                        <td class="px-6 py-4 text-right text-slate-600 font-medium">
                            {{ number_format($inv['quantite_initiale'], 0, ',', ' ') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                +{{ number_format($inv['quantite_entre'], 0, ',', ' ') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center rounded-lg bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-600">
                                -{{ number_format($inv['quantite_sortie'], 0, ',', ' ') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-slate-800">
                            {{ number_format($prd->quantite_stock, 0, ',', ' ') }}
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-teal-700">
                            {{ number_format($inv['total_vente'], 0, ',', ' ') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">
                                    <svg class="h-7 w-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Aucun produit trouvé pour cette période</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-teal-50 border-t-2 border-teal-200">
                    <td colspan="5" class="px-6 py-4 text-sm font-bold text-teal-800 text-right">TOTAL VENTES</td>
                    <td class="px-6 py-4 text-right text-base font-extrabold text-teal-700">
                        {{ number_format($total, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<style>
    #search-container input[type="search"] {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 7px 14px;
        font-size: 0.875rem;
        color: #475569;
        background-color: #f8fafc;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        width: 260px;
    }
    #search-container input[type="search"]:focus {
        border-color: #14b8a6;
        box-shadow: 0 0 0 3px rgba(20,184,166,0.12);
        background-color: #fff;
    }
    .dataTables_empty { text-align: center; }
</style>

<script>
    new DataTable('#tble', {
        lengthChange: false,
        info: false,
        dom: '<"#search-container"f>t',
        paging: false,
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
            "search": "",
            "searchPlaceholder": "🔍  Rechercher un produit..."
        }
    });
</script>

@endsection

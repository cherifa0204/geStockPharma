@extends('layouts.base')
@section('content')

<script src="{{ asset('DataTables/jquery.js') }}"></script>
<script src="{{ asset('DataTables/moncss.js') }}"></script>

{{-- Page Header --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="flex items-center space-x-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Détail de l'achat</h1>
            <p class="text-sm text-slate-500">
                Bon de commande <span class="font-semibold text-teal-600">#{{ $achat->id }}</span>
                &nbsp;·&nbsp;
                {{ $achat->ligneachats?->count() ?? 0 }} ligne(s)
            </p>
        </div>
    </div>

    <div class="flex items-center space-x-3">
        <a href="{{ route('achats.index') }}"
            class="inline-flex items-center space-x-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
            <span>Retour</span>
        </a>
        <a href="{{ route('achats.fiche', ['achat' => $achat]) }}"
            class="inline-flex items-center space-x-2 rounded-xl bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-teal-500/20 transition hover:bg-teal-700">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            <span>Exporter PDF</span>
        </a>
    </div>
</div>

{{-- Table Card --}}
<div class="rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">

    <div class="px-6 py-4 border-b border-slate-100">
        <h2 class="text-sm font-semibold text-slate-700">Produits achetés</h2>
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
                @php $totalAchat = 0; @endphp
                @forelse ($achat->ligneachats ?? [] as $ligne)
                    @php $totalAchat += $ligne->montant_achat; @endphp
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
                            {{ $ligne->produit ? number_format($ligne->produit->prix_unitaire_achat, 0, ',', ' ') : '—' }}
                        </td>
                        <td class="px-6 py-4 text-right text-slate-700 font-semibold">
                            {{ $ligne->quantite_achat }}
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-teal-700">
                            {{ number_format($ligne->montant_achat, 0, ',', ' ') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">
                                    <svg class="h-7 w-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Aucune ligne d'achat</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-teal-50 border-t-2 border-teal-200">
                    <td colspan="4" class="px-6 py-4 text-sm font-bold text-teal-800 text-right">TOTAL ACHAT</td>
                    <td class="px-6 py-4 text-right text-base font-extrabold text-teal-700">
                        {{ number_format($totalAchat, 0, ',', ' ') }} FCFA
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

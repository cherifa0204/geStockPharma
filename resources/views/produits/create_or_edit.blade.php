@extends("layouts.base")

@section("content")
@php 
    $name = ($produit ?? null) != null ? "update" : "store";
    $title = ($produit ?? null) != null ? "Edition d'un" : "Enregistrement d'un nouveau";
@endphp

<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header Section -->
    <div>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ $title }} produit</h1>
        <p class="text-sm text-slate-500 mt-1">Saisissez les détails du médicament pour le rajouter ou le mettre à jour dans la base de données.</p>
    </div>

    <!-- Form Container -->
    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
        <form action="{{ route('produits.'.$name, $produit ?? '') }}" method="post" class="space-y-6">
            @if ($produit ?? null)
                @method("PUT")
            @endif
            @csrf

            <!-- Nom du Produit -->
            <div class="space-y-2">
                <label for="id_prod" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Nom du Produit</label>
                <input id="id_prod" type="text" name="nom_produit" value="{{ $produit->nom_produit ?? ''}}" class="@error('nom_produit') border-red-300 bg-red-50/50 @enderror block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none transition-all focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-500/20" placeholder="Ex: Paracétamol 500mg" autofocus>
                @error('nom_produit')
                    <p id="msg_prod" class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Prix Achat -->
                <div class="space-y-2">
                    <label for="prix_achat" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Prix Unitaire d'achat (FCFA)</label>
                    <input id="prix_achat" type="number" name="prix_unitaire_achat" value="{{ $produit->prix_unitaire_achat ?? ''}}" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none transition-all focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-500/20" placeholder="Ex: 500">
                    @error('prix_unitaire_achat')
                        <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prix Vente -->
                <div class="space-y-2">
                    <label for="prix_vente" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Prix Unitaire de vente (FCFA)</label>
                    <input id="prix_vente" type="number" name="prix_unitaire_vente" value="{{ $produit->prix_unitaire_vente ?? ''}}" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none transition-all focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-500/20" placeholder="Ex: 750">
                    @error('prix_unitaire_vente')
                        <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-50">
                <a href="{{ route('produits.index') }}" class="inline-flex items-center rounded-xl bg-white border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition-all">
                    Annuler
                </a>
                <button type="submit" class="inline-flex items-center space-x-2 rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-slate-700 transition-all">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    <span>Enregistrer</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
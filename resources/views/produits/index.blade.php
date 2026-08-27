@extends('layouts.base')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Produits</h1>
            <p class="text-sm text-slate-500 mt-1">Gérez le catalogue de médicaments, mettez à jour les prix et suivez l'état du stock physique.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            @can('add produit')
            <a href="{{ route('produits.create') }}" class="inline-flex items-center space-x-2 rounded-xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-teal-500/25 hover:bg-teal-600 hover:shadow-teal-500/35 transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Ajouter un Produit</span>
            </a>
            @endcan

            <a href="{{ route('produits.export_excel') }}" class="inline-flex items-center space-x-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-500/20 hover:bg-emerald-700 transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Exporter Excel (.xlsx)</span>
            </a>
        </div>
    </div>


    <!-- Mass Import Option (Collapsible or subtle card) -->
    @can('add produit')
    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center space-x-2">
            <svg class="h-4 w-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Importation de produits en masse</span>
        </h3>
        <form action="{{ route('produits.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            @csrf
            <div class="flex-1">
                <input type="file" name="file" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-all" />
            </div>
            <button type="submit" class="rounded-xl bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700 transition-colors">
                Importer (.xlsx)
            </button>
        </form>
    </div>
    @endcan

    <!-- Products Table Card -->
    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-bold text-slate-800 text-lg">Catalogue de médicaments</h2>
            <div id="custom-search-container" class="relative max-w-md w-full"></div>
        </div>

        <div class="overflow-x-auto">
            <table id="tble" class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th scope="col" class="px-6 py-4">Désignation</th>
                        @can('view price achat')
                        <th scope="col" class="px-6 py-4">Prix Achat (FCFA)</th>
                        @endcan
                        <th scope="col" class="px-6 py-4">Prix Vente (FCFA)</th>
                        <th scope="col" class="px-6 py-4">Quantité en Stock</th>
                        <th scope="col" class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($produits ?? [] as $produit)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <!-- Designation -->
                        <td class="px-6 py-4 font-semibold text-slate-800 capitalize">{{ $produit->nom_produit }}</td>
                        
                        <!-- PU Achat -->
                        @can('view price achat')
                        <td class="px-6 py-4 font-medium text-slate-600">
                            {{ number_format($produit->prix_unitaire_achat, 0, ',', ' ') }}
                        </td>
                        @endcan
                        
                        <!-- PU Vente -->
                        <td class="px-6 py-4 font-medium text-slate-700">
                            {{ number_format($produit->prix_unitaire_vente, 0, ',', ' ') }}
                        </td>
                        
                        <!-- Stock status badge -->
                        <td class="px-6 py-4 font-medium">
                            @if($produit->quantite_stock == 0)
                            <span class="inline-flex items-center rounded-lg bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 border border-red-100">
                                Rupture de stock
                            </span>
                            @elseif($produit->quantite_stock <= 5)
                            <span class="inline-flex items-center rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 border border-amber-100">
                                Stock critique ({{ $produit->quantite_stock }})
                            </span>
                            @else
                            <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 border border-emerald-100">
                                En stock ({{ $produit->quantite_stock }})
                            </span>
                            @endif
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                @can('edit produit')
                                <a href="{{ route('produits.edit', $produit) }}" class="inline-flex items-center rounded-xl bg-teal-50 px-3 py-1.5 text-xs font-semibold text-teal-700 hover:bg-teal-100 transition-colors">
                                    Modifier
                                </a>
                                @endcan
                                
                                @can('delete produit')
                                <form action="{{ route('produits.destroy', $produit) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center rounded-xl bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100 transition-colors">
                                        Supprimer
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-sm text-slate-400">Aucun produit disponible dans le catalogue.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Load scripts -->
<script src="{{ asset('DataTables/jquery.js') }}"></script>
<script src="{{ asset('DataTables/moncss.js') }}"></script>

<style>
    /* Styling search input to fit modern tailwind theme */
    .custom-search input[type="search"] {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 8px 12px 8px 36px;
        outline: none;
        font-size: 14px;
        transition: all 0.2s;
    }
    .custom-search input[type="search"]:focus {
        border-color: #14b8a6;
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15);
    }
    .custom-search {
        position: relative;
        width: 100%;
    }
    /* Add search icon */
    .custom-search::before {
        content: '';
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-size: contain;
        pointer-events: none;
    }
    .dataTables_empty {
        text-align: center;
        padding: 40px !important;
        color: #94a3b8;
    }
</style>

<script>
    $(document).ready(function() {
        var table = $('#tble').DataTable({
            lengthChange: false,
            info: false,
            paging: false,
            dom: '<"custom-search"f>t',
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
                "search": "",
                "searchPlaceholder": "Rechercher un médicament..."
            }
        });
        
        // Move the search bar to our custom header container
        $('.custom-search').appendTo('#custom-search-container');
    });
</script>
@endsection

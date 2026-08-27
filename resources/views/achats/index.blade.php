@extends('layouts.base')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Achats & Stock</h1>
            <p class="text-sm text-slate-500 mt-1">Suivez les réapprovisionnements de stock auprès des fournisseurs et gérez les fiches d'achat.</p>
        </div>
        
        <div class="flex items-center space-x-3">
            @can('create achat')
            <a href="{{ route('achats.create') }}" class="inline-flex items-center space-x-2 rounded-xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-teal-500/25 hover:bg-teal-600 hover:shadow-teal-500/35 transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Ajouter un Achat</span>
            </a>
            @endcan
        </div>
    </div>

    <!-- Purchases Table Card -->
    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-bold text-slate-800 text-lg">Historique des achats</h2>
            <div id="custom-search-container" class="relative max-w-md w-full"></div>
        </div>

        <div class="overflow-x-auto">
            <table id="tble" class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th scope="col" class="px-6 py-4">Numéro d'achat</th>
                        <th scope="col" class="px-6 py-4">Date d'achat</th>
                        <th scope="col" class="px-6 py-4">Montant Total (FCFA)</th>
                        <th scope="col" class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($achats ?? [] as $achat)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <!-- Numéro -->
                        <td class="px-6 py-4 font-bold text-slate-800">#{{ $achat->id }}</td>
                        
                        <!-- Date -->
                        <td class="px-6 py-4 font-medium text-slate-500">
                            {{ \Carbon\Carbon::parse($achat->date_achat)->format('d/m/Y') }}
                        </td>
                        
                        <!-- Montant -->
                        <td class="px-6 py-4 font-semibold text-slate-700">
                            {{ number_format($achat->montant_total_achat, 0, ',', ' ') }}
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('achats.show', $achat) }}" class="inline-flex items-center rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200 transition-colors">
                                    Détails
                                </a>
                                
                                <a href="{{ route('achats.edit', $achat) }}" class="inline-flex items-center rounded-xl bg-teal-50 px-3 py-1.5 text-xs font-semibold text-teal-700 hover:bg-teal-100 transition-colors">
                                    Modifier
                                </a>
                                
                                <form action="{{ route('achats.destroy', $achat) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet achat ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center rounded-xl bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100 transition-colors">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-12 text-sm text-slate-400">Aucun achat enregistré.</td>
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
                "searchPlaceholder": "Rechercher un achat..."
            }
        });
        
        // Move the search bar to our custom header container
        $('.custom-search').appendTo('#custom-search-container');
    });
</script>
@endsection

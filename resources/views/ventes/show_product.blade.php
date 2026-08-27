@extends('layouts.base')
@section('content')

<script  src="{{asset('DataTables/jquery.js')}}"></script>
<script src="{{asset('DataTables/moncss.js')}}"></script>



<div class="flex justify-between">
<div>

</div>


</div> 


<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="tbl" class="w-full my-10 text-sm text-left text-gray-500 dark:text-gray-400 bg-green-600 ">
        <thead class="text-xs text-white uppercase dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nom du Produit
                </th>
                <th scope="col" class="px-6 py-3">
                   Prix Unitaire de Vente (en FCFA)
                </th>
                <th scope="col" class="px-6 py-3">
                    Quantité Actuelle
                </th>
               
            </tr>
        </thead>
        <tbody>
        @forelse ($produits as $produit)
            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $produit->nom_produit }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{number_format($produit->prix_unitaire_vente,thousands_separator:' ')  }} 
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ number_format($produit->quantite_stock,thousands_separator:' ') }}
                </td>
                
                 
            </tr>
        @empty
                <tr>Aucun produit</tr>
        @endforelse
        </tbody>
        <tfoot></tfoot>
    </table>
</div>


<script type="text/javascript">
    //rechercher produit
   new DataTable('#tbl',{
        info:false,
        paging:false,
        language: {
                 "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
             }
    });

   

  
   
</script>


@endSection

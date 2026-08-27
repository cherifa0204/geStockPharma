@extends('layouts.base')
@section('content')

<script  src="{{asset('DataTables/jquery.js')}}"></script>
<script src="{{asset('DataTables/moncss.js')}}"></script>
<!-- modal add -->
<div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modal-id">
  <div class="relative w-auto my-6 mx-auto max-w-3xl">
    <!--content-->
    <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
      <!--header-->
     
      <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
        <h3 class="text-3xl font-semibold">
        Enregistrement d'un nouveau produit
        </h3>
        <button class="p-1 ml-auto  leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('modal-id')">
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
        </button>
      </div>
      <!--body-->
      <div class="relative p-6 flex-auto">
        <section class="bg-white dark:bg-gray-900">
         <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">

          <!-- <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">  Ajouter un  nouveau Produit</h2> -->
          <form action="{{route('produits.store')}}" method="post">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                      <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Nom du Produit</label>
                      <input type="text" name="nom_produit"  class="@error('nom_produit') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Entrez le nom du produit ">
                      @error('nom_produit')
                      <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                     @enderror
                </div>
                <div class="w-full">
                    <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix Unitaire d'achat</label>
                    <input type="number" name="prix_unitaire_achat"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1000">
                    @error('prix_unitaire_achat')
                      <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full">
                      <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix Unitaire de vente</label>
                      <input type="number" name="prix_unitaire_vente"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1200">
                      @error('prix_unitaire_vente')
                      <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                     @enderror
                </div>
                  
                <div class="w-full">
                  <button type="submit" class=" bg-green-600 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                    Enregitrer
                  </button>
                </div>
                  
              </div>
                
            </form>
        </div>
    </section>    
    </div>
      <!--footer-->
    <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
        <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id')">
          Annuler
        </button>
        <!-- <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="submit" onclick="toggleModal('modal-id')">
          Enregitrer
        </button> -->
    </div>
</div>
</div>
</div>
<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>



<div class="flex justify-between">
<div>

</div>
@can('add produit')
<button class="bg-green-600 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id')">
  <a href="#">Ajouter un Produit</a> 
</button>
@endcan
</div> 


<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="tble" class="w-full my-10 text-sm text-left text-gray-500 dark:text-gray-400 bg-green-600 ">
        <caption class="text-3xl font-semibold">Liste des produits</caption>
        <thead class="text-xs text-white uppercase dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                Désignation
                </th>
                @can('view price achat')
                <th scope="col" class="px-6 py-3">
                    Prix Unitaire D'achat(FCFA)
                </th>
                @endcan
                <th scope="col" class="px-6 py-3">
                   Prix Unitaire de Vente (FCFA)
                </th>
                <th scope="col" class="px-6 py-3">
                    Quantité Actuelle
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
        @forelse ($produits ?? [] as $produit)
            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 capitalize  whitespace-nowrap dark:text-white">
                {{ $produit->nom_produit }}
                </td>
                @can('view price achat')
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{number_format($produit->prix_unitaire_achat,thousands_separator:' ')  }} 
                </td>
                @endcan
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{number_format($produit->prix_unitaire_vente,thousands_separator:' ')  }} 
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{number_format($produit->quantite_stock,thousands_separator:' ') }}
                </td>
                <td class="px-6 py-4 flex justify-between font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  <form  action="{{route('produits.edit',$produit)}}" method="get">
                    @csrf
                    @can('edit produit')
                    <button id="btn_edit" class="bg-green-600 text-white font-medium whitespace-nowrap dark:text-white"  type="submit">
                        Editer
                    </button>
                    @endcan
                  </form>
                  <form action="{{route('produits.destroy',$produit )}}" method="post">
                          @csrf
                          @method("DELETE")
                          @can('delete produit')
                          <button id="btn_suppr"  class="bg-red-600  font-medium whitespace-nowrap dark:text-white text-white" type="submit">
                          Supprimer</button> 
                          @endcan
                    </form>          
                 </td>
                 
            </tr>
        @empty
          
                <p>Aucun produit</p>
        @endforelse
        </tbody>
        <tfoot></tfoot>
    </table>
</div>


<style>
        .custom-search input[type="search"] {
            /* background-color: gray; */
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
            margin: 25px;
            width:500px;
        }

        .dataTables_empty {
            text-align: center;
        }
  </style>
  <script>
        //rechercher produit
        new DataTable('#tble', {
            // Options de configuration de DataTables
            lengthChange: false, // Désactiver la sélection du nombre de lignes
            info: false,
            dom: '<"custom-search"f>t',
            paging: false,
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
                "search": "",
                "searchPlaceholder": "Rechercher un produit"
            }
        });
    </script>


<script type="text/javascript">

    // ouverture et fermeture du cadre
  function toggleModal(modalID){
    document.getElementById(modalID).classList.toggle("hidden");
    document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
    document.getElementById(modalID).classList.toggle("flex");
    document.getElementById(modalID + "-backdrop").classList.toggle("flex");
  

  }
   
</script>


@endSection

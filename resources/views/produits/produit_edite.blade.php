

<!-- modal edite-->
<div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modalEdit">
  <div class="relative w-auto my-6 mx-auto max-w-3xl">
    <!--content-->
    <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
      <!--header-->
     
      <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
        <h3 class="text-3xl font-semibold">
          Modification d'un produit
        </h3>
        <button class="p-1 ml-auto  leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('modalEdit')">
        X
        </button>
      </div>
      <!--body-->
      <div class="relative p-6 flex-auto">
        <section class="bg-white dark:bg-gray-900">
         <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
         <form action="{{route('produits.update', $produit)}}" method="post" id="modalEdite">
           @csrf
            @method("PUT")
          
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Nom du Produit</label>
                    <input type="text" name="nom_produit" value="{{$produit->nom_produit}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Entrez le nom du produit ">
                </div>
                <div class="w-full">
                    <label for="prix_unitaire_achat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix Unitaire d'achat</label>
                    <input id="prix_unitaire_achat" type="number" name="prix_unitaire_achat" value="{{ $produit->prix_unitaire_achat}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1000">
                </div>
                <div class="w-full">
                    <label for="prix_unitaire_vente" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix Unitaire de vente</label>
                    <input id="prix_unitaire_vente" type="number" name="prix_unitaire_vente" value="{{ $produit->prix_unitaire_vente }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1200">
                </div>
                    
                <div>
                    <button type="submit" class=" bg-green-600 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                    Modifier
                    </button>
                </div>  
            </div>
         </form>
        </div>
    </section>    
    </div>
      <!--footer-->
    <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
        <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modalEdit')">
          Fermer
        </button>
        <!-- <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="submit" onclick="toggleModal('modal-id')">
          Enregitrer
        </button> -->
    </div>
   </div>
  </div>
</div>
<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modalEdit-backdrop"></div>
      
</form>






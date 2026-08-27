@extends('layouts.base')

@section('content')
@php
    $name = ($vente ?? null) != null ? "update" : "store";
    $title = ($vente ?? null) != null ? "Modification d'une" : "Enregistrement d'une";
@endphp

<div class="space-y-6">
    <!-- Header Section -->
    <div>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ $title }} vente</h1>
        <p class="text-sm text-slate-500 mt-1">Enregistrez les médicaments vendus à un patient et mettez à jour le stock en temps réel.</p>
    </div>

    <!-- Main Form -->
    <form id="id_form" action="{{ route('ventes.'.$name, $vente ?? '') }}" method="post" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @if ($vente ?? null)
            @method("PUT")
        @endif
        @csrf

        <!-- Saisie Médicament & Quantité (Left Column) -->
        <div class="lg:col-span-1 space-y-6">
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm space-y-4">
                <h2 class="font-bold text-slate-800 text-base">Ajouter un produit</h2>
                
                <!-- Product Search input -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Nom du Produit</label>
                    <div class="relative">
                        <input type="search" id="searchInput" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none transition-all focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-500/20" autofocus placeholder="Rechercher un produit...">
                        
                        <!-- Floating Autocomplete Card -->
                        <div class="absolute z-30 left-0 right-0 mt-1 bg-white rounded-xl border border-slate-100 shadow-xl max-h-48 overflow-y-auto" style="display:none;" id="products_container">
                            <ul id="products" class="divide-y divide-slate-50">
                                <!-- Loaded dynamically via JS -->
                            </ul>
                        </div>
                    </div>
                    <div id="error_prod" class="text-xs font-semibold text-red-500 mt-1"></div>
                    <input id="id_prd" type="number" hidden>
                </div>

                <!-- Quantity input -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Quantité vendue</label>
                    <input type="number" id="id_quantite" min="1" placeholder="Entrez la quantité" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none transition-all focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-500/20" value="" />
                    <div id="id_alerte" class="text-xs font-semibold text-red-500 mt-1"></div>
                </div>

                <!-- Add Button -->
                <button type="button" id="btn_ajouter" class="w-full inline-flex items-center justify-center space-x-2 rounded-xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-teal-500/25 hover:bg-teal-600 hover:shadow-teal-500/35 transition-all">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Ajouter à la liste</span>
                </button>
            </div>
            
            <!-- Submit Form Button -->
            <button id="btn" type="submit" onclick="enableInput()" class="w-full inline-flex items-center justify-center space-x-2 rounded-xl bg-slate-800 px-4 py-3 text-sm font-semibold text-white shadow-md hover:bg-slate-700 transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                <span>Enregistrer la vente</span>
            </button>
        </div>

        <!-- Table of Sales Lines (Right Columns) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h2 class="font-bold text-slate-800 text-lg">Liste des lignes de vente</h2>
                </div>

                <div class="overflow-x-auto">
                    <table id="lignes_vente" class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4">ID</th>
                                <th scope="col" class="px-6 py-4">Nom Produit</th>
                                <th scope="col" class="px-6 py-4 w-32">Quantité</th>
                                <th scope="col" class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="id_tbody" class="divide-y divide-slate-100">
                            @foreach ($vente->ligneventes ?? [] as $ligne)
                            <tr id="{{ $loop->index+1 }}" class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $loop->index+1 }}</td>
                                <td class="px-6 py-4 font-medium text-slate-700">
                                    <input type="text" name="ligne_vente_id[]" value="{{ $ligne->id }}" hidden >
                                    <input type="text" name="produit[]" value="{{ $ligne->produit->id }}" hidden >
                                    <span>{{ $ligne->produit->nom_produit }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <input class="w-20 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-center text-sm font-semibold text-slate-700 outline-none transition-all focus:border-teal-500 focus:bg-white" type="number" name="quantite[]" value="{{ $ligne->quantite_vente }}">
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <input type="button" value="Editer" class="inline-flex items-center rounded-xl bg-teal-50 px-3 py-1.5 text-xs font-semibold text-teal-700 hover:bg-teal-100 cursor-pointer transition-colors" onclick="editer_ligne('{{ $loop->index+1 }}')">
                                        <input type="button" value="Supprimer" class="inline-flex items-center rounded-xl bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100 cursor-pointer transition-colors" onclick="supprimer_ligne('{{ $loop->index+1 }}')">
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <input type="text" name="ligne_suppr" id="ligne_suppr" hidden>
            </div>
        </div>
    </form>
</div>

<!-- Autocomplete logic and operations -->
<script type="text/javascript">
    const produits = JSON.parse('{!! $produits !!}');
    let searchInput = document.getElementById('searchInput');
    let produits_ul = document.getElementById('products');
    let productsContainer = document.getElementById('products_container');
    let input_id = document.getElementById('id_prd');
    let quantite_input = document.getElementById('id_quantite');
    let add_btn = document.getElementById('btn_ajouter');
    let tableau = document.getElementById('lignes_vente');
    let input_suppr = document.getElementById('ligne_suppr');
    let edit_id = "";
    let num = tableau.children[1].children.length + 1;
    let msg = document.querySelector("#id_alerte");
    let msg_prd = document.querySelector("#error_prod");
    let mon_tbody = document.getElementById("id_tbody");
    
    let liste_id = [];
    
    // Load existing items into tracking array
    @foreach ($vente->ligneventes ?? [] as $ligne)
        liste_id.push({{ $ligne->produit->id }});
    @endforeach

    function load_select_data(produits) {
        produits_ul.innerHTML = "";
        if (produits.length === 0) {
            produits_ul.innerHTML = "<li class='px-4 py-3 text-xs text-slate-400 text-center'>Aucun médicament trouvé</li>";
            return;
        }
        produits.map((prd) => {
            produits_ul.innerHTML += `<li class='px-4 py-2.5 cursor-pointer hover:bg-teal-50 text-slate-700 hover:text-teal-700 text-sm font-medium transition-colors border-b border-slate-50 last:border-b-0' id='pro_${prd.id}'>${prd.nom_produit}</li>`;
        });
    }
   
    searchInput.addEventListener('input', function() {
        let list = [];
        msg_prd.innerText = "";
        let mot = searchInput.value.toLowerCase();
        
        if (mot !== "") {
            produits.map((produit) => {
                if (produit.nom_produit.toLowerCase().startsWith(mot.toLowerCase())) {
                    list.push(produit);
                } 
            });
            productsContainer.style.display = "block";
            load_select_data(list);
        } else {
            productsContainer.style.display = "none";
        }
    });

    quantite_input.addEventListener('input', function() {
        msg.innerText = "";
    });

    function recuperer_id(chaine) {
        let number = 0;
        let partieNumerique = chaine.match(/\d+/);
        if (partieNumerique) {
             number = parseInt(partieNumerique[0]);
             return number;
        }
    }

    // Hide suggestions dropdown on click outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !productsContainer.contains(event.target)) {
            productsContainer.style.display = 'none';
        }
    });

    produits_ul.addEventListener('click', function(event) {
        if (event.target.tagName === 'LI' && event.target.id) {
            const selectedProduct = event.target.textContent;
            searchInput.value = selectedProduct;
            input_id.value = recuperer_id(event.target.id);
            productsContainer.style.display = 'none';
            clear_msg_prd();
        }
    });

    function ligne_html(num_ligne, id_ligne_vente, id_produit, nom_produit, quantite) {
        return `<tr class='hover:bg-slate-50/50 transition-colors' id='${num_ligne}'>` +
            `<td class='px-6 py-4 font-bold text-slate-800'>${num_ligne}</td>` +
            `<td class='px-6 py-4 font-medium text-slate-700'>` +
            `<input type='text' name='ligne_vente_id[]' value='${id_ligne_vente}' hidden>` +
            `<input id='id_${id_produit}' type='text' name='produit[]' value='${id_produit}' hidden>` +
            `<span>${nom_produit}</span>` +
            `</td>` +
            `<td class='px-6 py-4'>` +
            `<input class='w-20 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-center text-sm font-semibold text-slate-700 outline-none transition-all focus:border-teal-500 focus:bg-white' type='number' name='quantite[]' value='${quantite}'>` +
            `</td>` +
            `<td class='px-6 py-4 text-right'>` +
            `<div class='flex items-center justify-end space-x-2'>` +
            `<input type='button' value='Editer' onclick='editer_ligne(${num_ligne})' class='inline-flex items-center rounded-xl bg-teal-50 px-3 py-1.5 text-xs font-semibold text-teal-700 hover:bg-teal-100 cursor-pointer transition-colors'>` +
            `<input type='button' value='Supprimer' onclick='supprimer_ligne(${num_ligne})' class='inline-flex items-center rounded-xl bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100 cursor-pointer transition-colors'>` +
            `</div>` +
            `</td>` +
            `</tr>`;
    }

    function clean_input() {
        searchInput.value = "";
        quantite_input.value = "";
        msg.innerText = "";
    } 
    
    function clear_msg_prd() {
        msg_prd.innerText = "";
    }
    
    function update_qte(produit_id, quantite) {
        let liste_lignes = Array.from(mon_tbody.getElementsByTagName('tr'));
        let tab_verite = [];
        for (let index = 0; index < liste_lignes.length; index++) {
            let product = parseInt(liste_lignes[index].children[1].children[1].value);
            let qte = parseInt(liste_lignes[index].children[2].children[0].value);
            if (product === produit_id) {
                let somme = parseInt(quantite) + qte;
                liste_lignes[index].children[2].children[0].value = somme;
                tab_verite.push(product);
            }
        }
        return tab_verite;
    }

    function updateSubmitButtonState() {
        const btnSubmit = document.getElementById('btn');
        if (!btnSubmit || !mon_tbody) return;
        const count = mon_tbody.querySelectorAll('tr').length;
        if (count === 0) {
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
            btnSubmit.classList.remove('hover:bg-slate-700');
        } else {
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
            btnSubmit.classList.add('hover:bg-slate-700');
        }
    }

    function ajouter_ligne(produit_id, nom_produit, quantite) {
        let tab_body = mon_tbody;
        
        if (edit_id !== "") {
            produits.map((prd) => {
                if (prd.nom_produit == nom_produit) {
                    if (prd.quantite_stock >= quantite) {
                        let ligne = document.getElementById(edit_id);
                        ligne.children[1].children[1].value = produit_id;
                        ligne.children[1].children[2].innerText = nom_produit;
                        ligne.children[2].children[0].value = quantite;
                        clean_input();
                    } else {
                        msg.innerText = `Quantité stock insuffisante, il ne reste que ${prd.quantite_stock}`;
                    }
                }
            });
        } else {
            produits.map((prd) => {
                if (prd.nom_produit == nom_produit) {
                    if (prd.quantite_stock == 0) {
                        msg.innerText = `${prd.nom_produit} est en rupture de stock.`;
                        return;
                    }
                    if (prd.quantite_stock < quantite) {
                        msg.innerText = `Quantité stock insuffisante, il ne reste que ${prd.quantite_stock}.`;
                        return;
                    }
                    
                    let tab = update_qte(produit_id, quantite);
                    if (!liste_id.includes(produit_id) && tab.length == 0) {
                        tab_body.innerHTML += ligne_html(num, -1, produit_id, prd.nom_produit, quantite);
                        liste_id.push(produit_id);
                        clean_input();
                    }
                }
            });
        }
        num += 1;
        edit_id = "";
        updateSubmitButtonState();
    }

    add_btn.addEventListener('click', function(e) {
        if (searchInput.value == "") {
            msg_prd.innerText = "Veuillez sélectionner un produit";
            return;
        }
        
        let liste_prod = [];
        produits.map((produit) => {
            liste_prod.push(produit.nom_produit);
        });
        
        if (!liste_prod.includes(searchInput.value)) {
            msg_prd.innerText = "Le produit '" + searchInput.value + "' n'existe pas ou n'est pas en stock.";
            return;
        }
        clear_msg_prd();
        
        let nom_produit = searchInput.value;
        let quantite = parseInt(quantite_input.value);
        let produit_id = parseInt(input_id.value);
        
        if (isNaN(quantite) || quantite <= 0) {
            msg.innerText = "La quantité doit être supérieure à 0";
            return;
        } 
        
        ajouter_ligne(produit_id, nom_produit, quantite);
    });

    function editer_ligne(id_ligne) {
        let ligne = document.getElementById(id_ligne);
        input_id.value = ligne.children[1].children[1].value;
        searchInput.value = ligne.children[1].children[2].innerText;
        quantite_input.value = ligne.children[2].children[0].value; 
        edit_id = id_ligne;
    }

    function supprimer_ligne(id_ligne) {
        let ligne = document.getElementById(id_ligne);
        let ligne_id_db = ligne.children[1].children[0].value;
        if (ligne_id_db !== "-1") {
            input_suppr.value += ligne_id_db + ",";
        }
        
        let id_sup = parseInt(ligne.children[1].children[1].value);
        liste_id = liste_id.filter(item => item !== id_sup);
        ligne.remove();
        updateSubmitButtonState();
    }
    
    function enableInput() {
        // Ready to submit
    }

    // Initial state check on page load
    updateSubmitButtonState();
</script>
@endsection
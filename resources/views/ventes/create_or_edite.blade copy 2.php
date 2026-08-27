@extends('layouts.base')
@section('content')
@php
$name= ($vente ?? null) != null ? "update" : "store";
$title=($produit ?? null) != null ? "Edition d'un " : "Enregistrement d'une ";

@endphp
<form id="id_form" action="{{route('ventes.'.$name, $vente  ?? '' )}}" method="post">
    @if ($vente ?? null)
    @method("PUT")
    @endif
    @csrf

    <div>
        <h1 class="text-3xl font-semibold">{{$title}} vente</h1>
        <div>
            <label>Nom du Produit:</label>
            <div class="w-64">
                <input type="search" name="" id="searchInput" class="" autofocus >
                <!-- <div id="id_alert"></div> -->
                <div class="bg-white max-h-24 overflow-y-auto">
                    <ul class="m-3" id="products" hidden >
                    </ul>
                    <input id='id_prd' type="number" hidden>
                </div>
            </div>

            <label for="">Quantitée Vente:</label>
            <input type="number" name='' id="id_quantite" min="1" class="@error('quantite') is-invalided @enderror" />
            <button type="button" id="btn_ajouter" class="bg-green-600 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">+</button>

        </div>
        <button id="btn" type="submit" onclick="enableInput()" class="bg-green-600 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Enregistrer</button>
        @if(session('alerte'))
        <div class="alert alert-warning">
            {{ session('alerte') }}
        </div>
        @endif
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table id="lignes_vente" class="w-full my-10 text-sm text-left dark:text-gray-400 bg-green-600">
            <caption class="text-3xl font-semibold">Liste des Lignes de ventes</caption>
            <thead class="text-xs text-white uppercase dark:bggray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Nom Produit</th>
                    <th scope="col" class="px-6 py-3">Quantité vendue</th>
                    <th scope="col" class="px-6 py-3">Actions</th>

                </tr>
            </thead>
            <tbody id="id_body">
                @foreach ($vente->ligneventes ?? [] as $ligne)
                <tr id="{{ $loop->index+1 }}" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 capitalize whitespace-nowrap dark:text-white">{{ $loop->index+1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <input  type="text" name="ligne_vente_id[]" value="{{ $ligne->id }}" hidden>
                        <input  type="text" name="produit[]" value="{{ $ligne->produit->id }}" hidden>
                        <span>{{$ligne->produit->nom_produit}}</span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <input class="border-none border-inherit backdrop-opacity-10" type="text" name="quantite[]" value="{{ $ligne->quantite_vente }}">
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white justify-between">
                        <input type="button" value="Editer" class="bg-blue-600 cursor-pointer  text-white font-medium whitespace-nowrap dark:text-white" onclick="editer_ligne('{{ $loop->index+1 }}')">
                        <input type="button" class="bg-red-600 text-white cursor-pointer  font-medium whitespace-nowrap dark:text-white" value="Supprimer" onclick="supprimer_ligne('{{ $loop->index+1 }}')">
                    </td>

                </tr>

                @endforeach

            </tbody>
            <input type="text" name="ligne_suppr" id="ligne_suppr" hidden>

        </table>
</form>

<script type="text/javascript">
    //selection dans une barre de recherche

    //liste des produits obtenu par injection d'une liste d'objet produit en php dans une variable produits de js
    const produits = JSON.parse('{!! $produits !!}');
   // console.log(produits);
    const searchInput = document.getElementById('searchInput');
    const produits_ul = document.getElementById('products');
    //tableau de li
    const liElements = Array.from(produits_ul.getElementsByTagName('li'));
    let input_id= document.getElementById('id_prd');
   // console.log(input_id.value);
    let quantite_input = document.getElementById('id_quantite');
    // recuperation du bouton ajouter
    let add_btn = document.getElementById('btn_ajouter');
    let tableau = document.getElementById('lignes_vente');
    let input_suppr = document.getElementById('ligne_suppr');
    let edit_id = "";
    //numero des lignes du tableau
    let num = tableau.children[2].children.length + 1;


     ///////////////////////
    //validation
    

    //charger les produits
    function load_select_data(produits) {
        //initialiser 
        
        produits_ul.innerHTML = "";
        // map() sert à parcourir les objets
        produits.map((prd) => {
            produits_ul.innerHTML += `<li class='w-300 cursor-pointer hover:bg-gray-200' id='${'pro_'+''+prd.id}'>${prd.nom_produit}</li>`;
            //let tag_li=document.getElementById('${prd.id}'); onclick='recuperer_prod('${prd.id}')'
        });
    }

   

    // searchInput.addEventListener('change',function(e){
    //     let masque=/^[0-9]+$/
    //     let valeur=searchInput.value;
    //     console.log(valeur);
        
    //     if (masque.test(valeur)) {
    //         //paragraphe.textContent +="Le nom du produit recherché est invalide.Veuillez saisir une chaine de caractéres";
    //         alert('Le nom du produit recherché est invalide.Veuillez saisir une chaine de caractéres');
    //         searchInput.value="";
    //     }
        
    // });
    //let paragraphe=document.getElementById("id_alert");
    searchInput.addEventListener('input', function() {
        list = [];
    
        const mot = searchInput.value.toLowerCase();
        produits.map((produit) => {
            //includes() sert à verifier si le mot est contenu dans la liste des noms des produits.
            //toLowerCase() retourne une chaine de caractères en minuscules
            if (produit.nom_produit.toLowerCase().includes(mot.toLowerCase())) {
                // Afficher la liste des produits
                produits_ul.style.display="block";
                //ajouter(push) le nom du produit dans la liste
                list.push(produit);
                //console.log(produit);
            }
           
        });
        //chargement des produits
        load_select_data(list);
    });

    //fonction qui recupere l'id du produit
    function recuperer_id(chaine) {
        let number =0;
        let partieNumerique = chaine.match(/\d+/);
        if (partieNumerique) {
             number=parseInt(partieNumerique[0]);
             return number;
        }
    }
    //verification de l'element li cliqué
    produits_ul.addEventListener('click', function(event) {
        if (event.target.tagName === 'LI') {
            const selectedProduct = event.target.textContent;
            searchInput.value = selectedProduct;
            console.log('id input '+''+event.target.id);
            //id du produit recherché
            input_id.value=recuperer_id(event.target.id)  ;
            console.log( input_id.value);
            // console.log(input_id);
            // Cacher la liste des produits une fois le produit sélectionné
            produits_ul.style.display = 'none';
        }
    });

     ///////////////////fonction qui retourne une ligne à creer
    function ligne_html(num_ligne, id_ligne_vente, id_produit, nom_produit, quantite) {
        return "<tr class='bg-white border-b dark:bg-gray-900 dark:border-gray-700' id='" + num_ligne + "'>" +
            "<td scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" + num_ligne + "</td>" +
            "<td scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" +
            "<input type='text' name='ligne_vente_id[]' value='" + id_ligne_vente + "' hidden>" +
            "<input id='' type='text' name='produit[]' value='" + id_produit + "' hidden>" +
            "<span>" + nom_produit + "</span>" +
            "</td>" +
            "<td scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" +
            "<input class='border-none border-inherit backdrop-opacity-10' type='text' name='quantite[]' value='" + quantite + "' style='' classe='qte'>" +
            "</td>" +

            "<td scope='row' class='px-6 py-4 flex justify-between font-medium text-gray-900 whitespace-nowrap dark:text-white'>" +
            "<input type='button' value='Editer' onclick='editer_ligne(" + num_ligne + ")'>" +
            " <input type='button' value='Supprimer' onclick='supprimer_ligne(" + num_ligne + ")'>" +
            "</td>" +
            "</tr>";
    }
    //fonction qui nettoie un champs de text
    function clean_input() {
        searchInput.value="";
        quantite_input.value =1;
        //console.log(search_input.value);

    } 
    
   
    
    function ajouter_ligne() {
        const id_tab_body=document.getElementById('id_body')
        const liste_tr=Array.from(id_tab_body.getElementsByTagName('tr'));
       // console.log(liste_tr);
        //recuperons
        //let string_pro=input_id.value;
        //prendre la partie numerique de la chaine
        //let produit_id=recuperer_id(string_pro);
        //console.log(produit_id); 

        let tab_body = tableau.children[2];
        console.log("tab body");
        console.log(tab_body);

        let produit_id = input_id.value;
        //verification 
        if (quantite_input.value < 0) {
            return alert("La quantité de vente ne peut pas être negative ");
        
        } 
        if (quantite_input.value == 0){
            return alert("La quantité de vente ne peut pas être 0 ");
        }  

        let quantite = quantite_input.value;
        let nom_produit = searchInput.value;
        // let nom_prd_li = document.getElementById(input_id.value);
        // let nom_produit = nom_prd_li.textContent;
        //console.log(nom_prd_li.id);
        console.log(nom_produit);
        if (edit_id !== "") {
            let ligne = document.getElementById(edit_id);
            ligne.children[1].children[1].value = produit_id;
            ligne.children[1].children[2].innerText = nom_produit;
            ligne.children[2].children[0].value = quantite;
        } else {
            tab_body.innerHTML += ligne_html(num, -1, produit_id, nom_produit, quantite);
            // tab_body.innerHTML += ligne_html(num, produit_id,nom_produit , quantite);

        }
        num += 1;
        clean_input();
        edit_id = "";
    }

    //Ajout des ligne dans le tableau
    add_btn.addEventListener('click', function(e) {
        ajouter_ligne();
    });

//fonction permettant d'editer une ligne de vente dans la table

    function editer_ligne(id_ligne) {
        //console.log(id_ligne);
        let ligne = document.getElementById(id_ligne);
        //console.log(l);
        searchInput.value =ligne.children[1].children[2].innerText;
        
        //console.log(ligne.children[2].children[0].value);
        quantite_input.value = ligne.children[2].children[0].value; 
        edit_id = id_ligne;
    }

    function supprimer_ligne(id_ligne) {
        let ligne = document.getElementById(id_ligne);
        let ligne_id_db = ligne.children[1].children[0].value;
       // console.log(ligne_id_db);
        if (ligne_id_db !== "-1") {
            input_suppr.value += ligne_id_db + ",";
        }
        ligne.remove();

    }
    //clean_input();










    /*let produit_select = document.getElementById('id_produit');
    let quantite_input = document.getElementById('id_quantite');  
    let ajouter_balise = document.getElementById('btn_ajouter');
    let tableau = document.getElementById('lignes_vente');
    let input_suppr = document.getElementById('ligne_suppr');
    let edit_id = "";
    let num = tableau.children[2].children.length + 1;
    console.log(num);

    
    ajouter_balise.addEventListener('click', function(e) {
         //
     if (quantite_input.value < 0) {
        return alert("La quantité de vente ne peut pas être negative ");
        
     } 
     if (quantite_input.value == 0){
        return alert("La quantité de vente ne peut pas être 0 ");
     }  
     
     ajouter_ligne();
       
    });

    function ligne_html(num_ligne, id_ligne_vente, id_produit, nom_produit, quantite) {
        return "<tr class='bg-white border-b dark:bg-gray-900 dark:border-gray-700' id='" + num_ligne + "'>" +
            "<td scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" + num_ligne + "</td>" +
            "<td scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" +
            "<input type='text' name='ligne_vente_id[]' value='" + id_ligne_vente + "' hidden>" +
            "<input type='text' name='produit[]' value='" + id_produit + "' hidden>" +
            "<span>" + nom_produit + "</span>" +
            "</td>" +
            "<td scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" +
            "<input class='border-none border-inherit backdrop-opacity-10' type='text' name='quantite[]' value='" + quantite + "' style='' classe='qte'>" +
            "</td>" +

            "<td scope='row' class='px-6 py-4 flex justify-between font-medium text-gray-900 whitespace-nowrap dark:text-white'>" +
            "<input type='button' value='Editer' onclick='editer_ligne(" + num_ligne + ")'>" +
            " <input type='button' value='Supprimer' onclick='supprimer_ligne(" + num_ligne + ")'>" +
            "</td>" +
            "</tr>";
    }

    function enableInput() {
        // qtes_input = document.getElementsByClassName('qte');
        // console.log(qtes_input);
        //qtes_input.forEach((element) => element.disabled = false);
        // event.stopPropagation();
        // event.preventDefault();
    }

    function ajouter_ligne() {
        let tab_body = tableau.children[2];
        let produit_id = produit_select.value;
        let quantite = quantite_input.value;
        let selected_index = produit_select.selectedIndex;
        let nom_produit = produit_select.options[selected_index].text;
        if (edit_id !== "") {
            let ligne = document.getElementById(edit_id);
            ligne.children[1].children[1].value = produit_id;
            ligne.children[1].children[2].innerText = nom_produit;
            ligne.children[2].children[0].value = quantite;
        } else {
            tab_body.innerHTML += ligne_html(num, -1, produit_id, nom_produit, quantite);
            // tab_body.innerHTML += ligne_html(num, produit_id,nom_produit , quantite);

        }
        num += 1;
        clean_input();
        edit_id = "";
    }

    function editer_ligne(id_ligne) {
        let ligne = document.getElementById(id_ligne);
        quantite_input.value = ligne.children[2].children[0].value;
        console.log(ligne.children[1].children[1].value);
        produit_select.value = ligne.children[1].children[1].value;
        edit_id = id_ligne;
    }

    function supprimer_ligne(id_ligne) {
        let ligne = document.getElementById(id_ligne);
        let ligne_id_db = ligne.children[1].children[0].value;
        console.log(ligne_id_db);
        if (ligne_id_db !== "-1") {
            input_suppr.value += ligne_id_db + ",";
        }
        ligne.remove();

    }

    function clean_input() {
        console.log(produit_select.value);
        produit_select.value = "-";
        quantite_input.value = 0;
        console.log(produit_select.value);

    }

    clean_input();

*/


    //liste des produits obtenu par injection d'une liste d'objet produit en php dans une variable produits de js
    /*let produits = JSON.parse('{!! $produits !!}');
    console.log(produits);
    //recuperons  l'id de balise
    let produits_ul = document.getElementById('produits');
    let input_id= document.getElementById('id_prd');
    let quantite_input = document.getElementById('id_quantite');
    // recuperation du bouton ajouter
    let add_btn = document.getElementById('btn_ajouter');
    let tableau = document.getElementById('lignes_vente');
    let input_suppr = document.getElementById('ligne_suppr');
    let edit_id = "";
    //numero des lignes du tableau
    let num = tableau.children[2].children.length + 1;
    //console.log(num);
    //let liElements = document.querySelectorAll("li"); // Sélectionne tous les éléments <li>

    //////////////////////////////////////////////////
    //chargement des produits
    load_select_data(produits);
    //recuperer le champs de recherche 
    let search_input = document.getElementById('search_input');
    //Appel au gestionnaire d'événements (addEventListener) pour l'événement keyup qui se déclenche dès qu'une touche est relâchée
    search_input.addEventListener('keyup', function(e) {
        list = [];
       
        //recuper 
        mot = search_input.value;
        console.log(mot);
        produits_ul.removeAttribute('hidden');
        
        produits.map((produit) => {
            //includes() sert à verifier si le mot est contenu dans la liste des noms des produits.
            //toLowerCase() retourne une chaine de caractères en minuscules
            if (produit.nom_produit.toLowerCase().includes(mot.toLowerCase())) {
                //ajouter(push) le nom du produit dans la liste
                list.push(produit);
                console.log(produit);
            }
        });
        //chargement des produits
        load_select_data(list);

    });
    //charger les produits
    function load_select_data(produits) {
        //initialiser 
        produits_ul.innerHTML = "";
        produits.map((prd) => {
            produits_ul.innerHTML += `<li class='w-300 cursor-pointer hover:bg-gray-200' id='${prd.id}' onclick='recuperer_prod('${prd.id}')'>${prd.nom_produit}</li>`;
            //let tag_li=document.getElementById('${prd.id}');
        });
    };
   function recuperer_prod(id_prod) {
        let liElements = document.querySelectorAll("li"); // Sélectionne tous les éléments <li>

        //parcourir les li
        liElements.forEach(function(elt) {
            console.log(elt);
            // if (elt.id==id_prod) {
            //     console.log(li.id);
            // }




            // li.addEventListener("click", function(e) {
            //     let liElement=e.target
            //     console.log(liElement);
            //     let id_prd= liElement.id; // Récupère l'identifiant de l'élément <li> cliqué
            //     input_id.value=id_prd;
                
            //     search_input.value =liElement.textContent });   
                //console.log( search_input.value);
        });
    
    }*/


    ///////////////////fonction qui retourne une ligne à creer
    /*function ligne_html(num_ligne, id_ligne_vente, id_produit, nom_produit, quantite) {
        return "<tr class='bg-white border-b dark:bg-gray-900 dark:border-gray-700' id='" + num_ligne + "'>" +
            "<td scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" + num_ligne + "</td>" +
            "<td scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" +
            "<input type='text' name='ligne_vente_id[]' value='" + id_ligne_vente + "' hidden>" +
            "<input type='text' name='produit[]' value='" + id_produit + "' hidden>" +
            "<span>" + nom_produit + "</span>" +
            "</td>" +
            "<td scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" +
            "<input class='border-none border-inherit backdrop-opacity-10' type='text' name='quantite[]' value='" + quantite + "' style='' classe='qte'>" +
            "</td>" +

            "<td scope='row' class='px-6 py-4 flex justify-between font-medium text-gray-900 whitespace-nowrap dark:text-white'>" +
            "<input type='button' value='Editer' onclick='editer_ligne(" + num_ligne + ")'>" +
            " <input type='button' value='Supprimer' onclick='supprimer_ligne(" + num_ligne + ")'>" +
            "</td>" +
            "</tr>";
    }
    //fonction qui nettoie un champs de text
    function clean_input() {
        search_input.value="";
        quantite_input.value = 0;
        //console.log(search_input.value);

    }

    function ajouter_ligne() {
        let tab_body = tableau.children[2];
        let produit_id = input_id.value;
        let quantite = quantite_input.value;
        let nom_prd_li = document.getElementById(input_id.value);
        let nom_produit = nom_prd_li.textContent;
        console.log(nom_produit);
        if (edit_id !== "") {
            let ligne = document.getElementById(edit_id);
            ligne.children[1].children[1].value = produit_id;
            ligne.children[1].children[2].innerText = nom_produit;
            ligne.children[2].children[0].value = quantite;
        } else {
            tab_body.innerHTML += ligne_html(num, -1, produit_id, nom_produit, quantite);
            // tab_body.innerHTML += ligne_html(num, produit_id,nom_produit , quantite);

        }
        num += 1;
        clean_input();
        edit_id = "";
    }

    //Ajout des ligne dans le tableau
    add_btn.addEventListener('click', function(e) {
        ajouter_ligne();
    });


    function editer_ligne(id_ligne) {
        let ligne = document.getElementById(id_ligne);
        quantite_input.value = ligne.children[2].children[0].value;

        // liElements.forEach(function(li) {
        //     li.addEventListener("click", function(e) {
        //         let liElement=e.target
        //         let id_prd= liElement.id; // Récupère l'identifiant de l'élément <li> cliqué
        //         input_id.value=id_prd;
        //         //console.log(input_id.value);
        //         search_input.value =liElement.textContent });   

        //     });
        //console.log(ligne.children[1].children[1].value);
        search_input.value = ligne.children[1].children[1].value;
        console.log(search_input.value);
        edit_id = id_ligne;
    }

    function supprimer_ligne(id_ligne) {
        let ligne = document.getElementById(id_ligne);
        let ligne_id_db = ligne.children[1].children[0].value;
       // console.log(ligne_id_db);
        if (ligne_id_db !== "-1") {
            input_suppr.value += ligne_id_db + ",";
        }
        ligne.remove();

    }
    //clean_input();

    */
</script>
@endsection
@extends('layouts.base')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@php
    $name= ($achat ?? null) != null ? "update" : "store";
    $title=($achat ?? null) != null ? "Edition d'un " : "Enregistrement d'un nouveau";
@endphp
<form action="{{route('achats.'.$name, $achat  ?? '' )}}" method="post">
    @if ($achat ?? null)
        @method("PUT")
    @endif
    @csrf
    <div>

        <h2>{{$title}} achat</h2>
        <div>
            <label for="">Nom du produit :</label>
            <select name="" id="id_produit" class="produits">
                <option value="-">Sélectionner</option>
                @foreach ($produits as $produit)
                    <option value="{{ $produit->id }}">{{ $produit->nom_produit }}</option>
                @endforeach
            </select>
            <label for="">Quantité achetée</label>
            <input type="number" name="" id="id_quantite">
            <button type="button" id="btn_ajouter" class=" bg-green-600 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">+ Ajouter</button>
        </div>
        <button id="btn" type="submit" onclick="enableInput()" class="bg-green-600 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Enregistrer</button>
    </div>
    <table border="3" id="lignes_achat">
        <caption>Liste des achats</caption>
        <thead>
            <tr>
                <th>ID </th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($achat->ligneachats ?? [] as $ligne)
            <tr id="{{ $loop->index+1 }}">
                <td>{{ $loop->index+1 }}</td>
                <td>
                    <input type="text" name="ligne_achat_id[]" value="{{$ligne->id}}" hidden>
                    <input type="text" name="produit[]" value="{{$ligne->produit->id}}" hidden>
                    <span>{{$ligne->produit->nom_produit}}</span>
                </td>
                <td>
                    <input type="number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white border: none" name="quantite[]" value="{{$ligne->quantite_achat}}" >
                    <!---span>{{$ligne->quantite_achat}}</span--->
                </td>
                <td>
                    <input type="button" value="Editer" onclick="editer_ligne('{{ $loop->index+1 }}')">
                    <input type="button" value="Supprimer" onclick="supprimer_ligne('{{ $loop->index+1 }}')">
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <input type="text" name="ligne_suppr" id="ligne_suppr" hidden>
</form>

<script type="text/javascript">
    //selection dans une barre de recherche 
    // $(document).ready(function() {
    //   $(".produits").select2();
    // });

//

let produit_select=document.getElementById('id_produit');
let quantite_input=document.getElementById('id_quantite');
let ajouter_balise=document.getElementById('btn_ajouter');
let tableau=document.getElementById('lignes_achat');
let input_suppr=document.getElementById('ligne_suppr');
let edit_id = "";
let num = tableau.children[2].children.length+1;
console.log(num);

ajouter_balise.addEventListener('click', function(e){
    ajouter_ligne();
});

function ligne_html(num_ligne, id_ligne_achat, id_produit, nom_produit, quantite_achat){
    return "<tr id='"+num_ligne+"'>"+
                "<td>"+num_ligne+"</td>"+
                "<td>"+
                    "<input type='text' name='ligne_achat_id[]' value='"+id_ligne_achat+"' hidden>"+
                    "<input type='text' name='produit[]' value='"+id_produit+"'hidden>"+
                    "<span>"+nom_produit+"</span>"+
                "</td>"+
                "<td>"+
                    "<input type='text' name='quantite[]' value='"+quantite_achat+"' style='' classe='qte'>"+
                "</td>"+
                "<td>"+
                    "<input type='button' value='Editer' onclick='editer_ligne("+num_ligne+")'>"+
                   " <input type='button' value='Supprimer' onclick='supprimer_ligne("+num_ligne+")'>"+
                "</td>"+
            "</tr>";  
}

function enableInput(){
    // qtes_input = document.getElementsByClassName('qte');
    // console.log(qtes_input);
    //qtes_input.forEach((element) => element.disabled = false);
    // event.stopPropagation();
    // event.preventDefault();
}
//fonction permettant d'ajouter une ligne d'achat dans la table
function ajouter_ligne(){
    
    let tab_body=tableau.children[2];
    //recuperation de l'id de produit dans la balise select
    let produit_id = produit_select.value;
    let quantite = quantite_input.value;
    // avec selectedIndex on selectionne l'indice du produit selectionné dans la balise select
    let selected_index=produit_select.selectedIndex;
    //recuperation du nom du produit 
    let nom_produit=produit_select.options[selected_index].text;
    //verifions que l'id de la ligne à editer 
    if (edit_id !== ""){
        let ligne= document.getElementById(edit_id);
        ligne.children[1].children[1].value = produit_id;
        ligne.children[1].children[2].innerText = nom_produit;
        ligne.children[2].children[0].value = quantite;
    } else {
        //ajout d'une ligne d'achat dans le tableau html
        tab_body.innerHTML += ligne_html(num, -1, produit_id,nom_produit , quantite);
    }
    num += 1 ;
    //nettoyer les champs
    clean_input();
    edit_id = "";
}

//fonction permettant d'editer une ligne d'achat dans la table

function editer_ligne(id_ligne) {
    let ligne= document.getElementById(id_ligne);
    quantite_input.value=ligne.children[2].children[0].value;
    console.log(ligne.children[1].children[1].value);
    produit_select.value=ligne.children[1].children[1].value; 
    edit_id = id_ligne;
}

//fonction permettant de supprimer une ligne d'achat dans la table

function supprimer_ligne(id_ligne) {
    let ligne= document.getElementById(id_ligne);
    //recuperer un id de la base
    let ligne_id_db=ligne.children[1].children[0].value;
    console.log(ligne_id_db);
    if (ligne_id_db !== "-1") {
        input_suppr.value+=ligne_id_db + ",";
    }
    ligne.remove();

}
//fonction permettant de nettoyer les champs apres validation dans la table

function clean_input() {
    console.log(produit_select.value);
    produit_select.value="-";
    quantite_input.value=0;
    console.log(produit_select.value);

}

clean_input();


</script>

@endsection

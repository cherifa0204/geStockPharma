
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@php
    $name= ($vente ?? null) != null ? "update" : "store";
    $title=($produit ?? null) != null ? "Edition d'un " : "Enregistrement d'un nouveau";

@endphp
<form action="{{route('ventes.'.$name, $vente  ?? '' )}}" method="post">
    @if ($vente ?? null)
        @method("PUT")
    @endif
    @csrf

    <div>
        <h2>{{$title}}  vente</h2>
            <label>Nom du Produit:</label>
            <select name="" id="id_produit" class="produits">
                <option value="-">sélectionner</option>
                @foreach ($produits as $produit)
                    <option value="{{ $produit->id }}" >{{ $produit->nom_produit }}</option>

                @endforeach
            </select>
            <label for="">quantitée:</label>
            <input type="number"   name=''  id="id_quantite" class="@error('quantite') is-invalided @enderror"/>

            <!----label>Prix Unitaire:</label--->
            <!---input  type="number" name=''--->
           
            <button type="button" id="btn_ajouter">+ Ajouter</button>

        </div>
        <button id="btn" type="submit" onclick="enableInput()">Enregistrer</button>

    </div>
    <table border="3" id="lignes_vente">
            <caption>Liste des ventes</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NomProduit</th>
                    <th>Quantité vendue</th>
                    <th>Actions</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($vente->ligneventes ?? [] as $ligne)
                <tr id="{{ $loop->index+1 }}">
                    <td>{{ $loop->index+1 }}</td>
                    <td>
                        <input type="text" name="ligne_vente_id[]" value="{{ $ligne->id }}" hidden>
                        <input type="text" name="produit[]" value="{{ $ligne->produit->id }}" hidden>
                        <span>{{$ligne->produit->nom_produit}}</span>
                    </td>
                    <td>
                        <input type="text"  name="quantite[]" value="{{ $ligne->quantite_vente }}" style="border: none;">
                    </td>
                    <td>
                        <input type="button" value="Editer" onclick="editer_ligne('{{ $loop->index+1 }}')">
                        <input type="button" value="Supprimer" onclick="supprimer_ligne('{{ $loop->index+1 }}')">
                    </td>

                </tr>

                @endforeach
            </tbody>
            <input type="text" name="ligne_suppr" id="ligne_suppr" hidden>

    </table>
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
let tableau=document.getElementById('lignes_vente');
let input_suppr=document.getElementById('ligne_suppr');
let edit_id = "";
let num = tableau.children[2].children.length+1;
console.log(num);

ajouter_balise.addEventListener('click', function(e){
    ajouter_ligne();
});

function ligne_html(num_ligne, id_ligne_vente, id_produit, nom_produit, quantite){
    return "<tr id='"+num_ligne+"'>"+
                "<td>"+num_ligne+"</td>"+
                "<td>"+
                    "<input type='text' name='ligne_vente_id[]' value='"+id_ligne_vente+"' hidden>"+
                    "<input type='text' name='produit[]' value='"+id_produit+"' hidden>"+
                    "<span>"+nom_produit+"</span>"+
                "</td>"+
                "<td>"+
                    "<input type='text' name='quantite[]' value='"+quantite+"' style='' classe='qte'>"+
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

function ajouter_ligne(){
    let tab_body=tableau.children[2];
    let produit_id = produit_select.value;
    let quantite = quantite_input.value;
    let selected_index=produit_select.selectedIndex;
    let nom_produit=produit_select.options[selected_index].text;
    if (edit_id !== ""){
        let ligne= document.getElementById(edit_id);
        ligne.children[1].children[1].value = produit_id;
        ligne.children[1].children[2].innerText = nom_produit;
        ligne.children[2].children[0].value = quantite;
    } else {
        tab_body.innerHTML += ligne_html(num, -1, produit_id,nom_produit , quantite);
       // tab_body.innerHTML += ligne_html(num, produit_id,nom_produit , quantite);

    }
    num += 1 ;
    clean_input();
    edit_id = "";
}

function editer_ligne(id_ligne) {
    let ligne= document.getElementById(id_ligne);
    quantite_input.value=ligne.children[2].children[0].value;
    console.log(ligne.children[1].children[1].value);
    produit_select.value=ligne.children[1].children[1].value;
    edit_id = id_ligne;
}

function supprimer_ligne(id_ligne) {
    let ligne= document.getElementById(id_ligne);
    let ligne_id_db=ligne.children[1].children[0].value;
    console.log(ligne_id_db);
    if (ligne_id_db !== "-1") {
        input_suppr.value+=ligne_id_db + ",";
    }
    ligne.remove();

}

function clean_input() {
    console.log(produit_select.value);
    produit_select.value="-";
    quantite_input.value=0;
    console.log(produit_select.value);

}

clean_input();


</script>



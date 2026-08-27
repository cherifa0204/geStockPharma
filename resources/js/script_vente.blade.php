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
    

    //charger les produits dans ul
    function load_select_data(produits) {
        //initialiser 
        
        produits_ul.innerHTML = "";
        // map() sert à parcourir les objets
        produits.map((prd) => {
            produits_ul.innerHTML += `<li class='w-300 cursor-pointer hover:bg-gray-200' id='${'pro_'+''+prd.id}'>${prd.nom_produit}</li>`;
            //let tag_li=document.getElementById('${prd.id}'); onclick='recuperer_prod('${prd.id}')'
        });
    }

    //lorsque la liste des produits 
    list = [];
    searchInput.addEventListener('input', function() {
     
    
        const mot = searchInput.value.toLowerCase();
        produits.map((produit) => {
            //includes() sert à verifier si le mot est contenu dans la liste des noms des produits.
            //toLowerCase() retourne une chaine de caractères en minuscules
            if (produit.nom_produit.toLowerCase().includes(mot.toLowerCase())) {
                // Afficher la liste des produits
                produits_ul.style.display="block";
                //ajouter(push) le nom du produit dans la liste
                list.push(produit);
                
            }
            //console.log("ce produit n'existe pas");
           
        });
        //chargement des produits
        load_select_data(list);
        //console.log(list);
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
           
            //id du produit recherché
            input_id.value=recuperer_id(event.target.id)  ;
    
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
            "<input id='id_"+id_produit +"' type='text' name='produit[]' value='" + id_produit + "' >" +
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
    
   
    //tableau de id
    let liste_id=[]
    //fonction qui permet d'ajouter une ligne
    function ajouter_ligne(produit_id,nom_produit,quantite) {
        let tab_body = tableau.children[2];

        if (edit_id !== "") {
            let ligne = document.getElementById(edit_id);

            ligne.children[1].children[1].value = produit_id;
            ligne.children[1].children[2].innerText = nom_produit;
            ligne.children[2].children[0].value = quantite;
        } else {

            if (nom_produit =="" ) {
                return alert("Le nom du produit est invalide");
            }
            //verifion si l'id du produit existe deja sinon on creer  la ligne
            if (!liste_id.includes(produit_id)) {
                tab_body.innerHTML += ligne_html(num, -1, produit_id, nom_produit, quantite);
                liste_id.push(produit_id);
               // console.log('ok');
            }
           
            
        }
        num += 1;
        clean_input();
        edit_id = "";
    }

    //je veux creer un tableau qui contier les id de produis puis je verifie lors de l'ajout si l'id est deja ds le tableau
    //recuperons le tbody



    const id_tab_body=document.getElementById('id_body')
    //Ajout des ligne dans le tableau
    add_btn.addEventListener('click', function(e) {

        produits_ul.style.display = 'none';
        liste_prod=[];
        //Ajout des nom de produits dans liste_prod 
        produits.map((produit) => {
            liste_prod.push(produit.nom_produit);
            
           
        });
       // verifier si la valeur du searchInput est contenu dans liste_prod
        let nom_produit = searchInput.value;
        if (!liste_prod.includes(nom_produit)) {
           return alert("Ce produit n'existe pas,veuillez cliquer sur un produit qui existe ou cliquez sur ajouter un produit ");
        }
        

       
        ///recuperons l'id de l'input id_prod
        let produit_id = input_id.value;
        //concatenons la chaine 'id_' à l'id du produit selectionné pour recuperer l'id du produit sur la ligne
        let input_ligne='id_'+ produit_id;
        //recuperons l'id du produit ajouté sur une ligne
        let id_prod_ligne=recuperer_id(input_ligne);
      
        //console.log(liste_ligne);
       //recuperons la quantite du produit
        let quantite = quantite_input.value;
        if (liste_id.includes(id_prod_ligne)) {
            //alert("Souhaitez vous modifier la quantité du produit " +nom_produit+" ? "+"si oui,cliquez sur Editer");
             //verification de la quantite
            
            if (quantite < 0 | quantite == 0) {
                return alert("La quantité de vente ne peut pas être negative ou 0 ");
            
            } 
           

            //ajouter_ligne(id_prod_ligne,nom_produit,quantite);
            //input_id.value=0;
        }
        //let quantite = quantite_input.value;
        if (quantite < 0 | quantite == 0) {
            return alert("La quantité de vente ne peut pas être negative ou 0");
        
        } 
       ajouter_ligne(id_prod_ligne,nom_produit,quantite);
       clean_input();


      
       
    });

//fonction permettant d'editer une ligne de vente dans la table en ramenant les anciennes valeurs

    function editer_ligne(id_ligne) {
        //console.log(id_ligne);
        let ligne = document.getElementById(id_ligne);
        //ajouter
        input_id.value=ligne.children[1].children[1].value;
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
        
        //retirer l'id de la ligene supprimer 
        let id_sup=ligne.children[1].children[1].value
        // liste_id=liste_id.filter(item => item !== id_sup);
        
        ligne.remove();
        liste_id.splice(id_ligne,id_sup);
        console.log(liste_id);
        
    }
    //clean_input();


</script>
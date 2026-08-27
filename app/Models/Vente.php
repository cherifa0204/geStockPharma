<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Vente extends Model
{
    use HasFactory;
    protected $fillable=[
        'montant_total','date_vente',"user_id"];
    
    function ligneventes()
    {
        return $this->hasMany(LigneVente::class);
    }

    function user() 
    {
        return $this->belongsTo(User::class,"user_id");
    }




    public function calculer_montant_total_vente()
        {
            $this->montant_total =$this->ligneventes->sum('montant');
           
            $this->save();

            return $this->montant_total;
        }


        

        //methode qui ajoute,edite et supprime les lignes de vente
        function add_ligne_vente( $lignes_vente,$ids_suppr="")
        {
            
            // for ($i=0; $i < count($lignes_vente); $i++) { 

            // }
            $vente=$this->id;
            foreach ($lignes_vente as $ligne_tab) {
                
                //dd( $ligne_tab["produit"]->id);
                if ($ligne_tab["id_ligne"]=="-1") {
                    $ligne=LigneVente::create([
                        'vente_id' => $vente,
                        'produit_id' => $ligne_tab["produit"]->id,
                        'quantite_vente' => $ligne_tab["quantite"]
                        ]);
                        //dd($ligne->produit);
                        $ligne->produit->diminuer_quantite_stock( $ligne->quantite_vente);
                }
               
                else {
                    $id=$ligne_tab["id_ligne"];
                    $ligne= LigneVente::find($id);
                     //Annuler l'ancienne quantite vente
                    $ligne->produit->augmenter_quantite_stock($ligne->quantite_vente);
                    $ligne->update([
                    'produit_id' =>$ligne_tab["produit"]->id,
                    'quantite_vente' => $ligne_tab["quantite"]]);
                    //mise a jour de quantite stock apres la modification de la vente
                    $ligne->produit->diminuer_quantite_stock( $ligne->quantite_vente);
                }

            }
            //Suppression d'une ligne de vente
            $tab=explode(",",$ids_suppr);
            $tab_ligne_a_supp=explode(",",$ids_suppr);
            if (count($tab_ligne_a_supp )!==0) {
                for($i=0; $i<count($tab_ligne_a_supp); $i++){
                    $id=$tab_ligne_a_supp[$i];
                    if ( $id !=="") {
                        $ligne= LigneVente::find(intval($id));
                        $prd=Produit::find($ligne->produit_id);
                            //Annuler l'ancienne quantite vente
                        $ligne->produit->augmenter_quantite_stock($ligne->quantite_vente);
                        //dd( $ligne->produit->quantite_stock);
                        $ligne->delete();
                    }
    
                }
            }


        }   
        //function add_ligne_vente($id_lignes,$produits,$quantites,$ids_suppr=""){
            //dd($produits);
        //     for ($i=0; $i < count($id_lignes); $i++) { 
        //         //Ajout des lignes
        //         $prod=Produit::find(intval($produits[$i]));

        //        if ($id_lignes[$i]=="-1" && ($prod !== null ) && intval($quantites[$i]) >0 ) {
        //             $vente=$this->id;
                    
                    
        //             if ($prod !== null | intval($quantites[$i]) >0) {
        //             $ligne=LigneVente::create([
        //                 'vente_id' => $vente,
        //                 'produit_id' => intval($produits[$i]),
        //                 'quantite_vente' => intval($quantites[$i])]);
        //                 $prd_ligne=Produit::find($ligne->produit_id);
        //             $quantite=intval($quantites[$i]);
        //             $prod->diminuer_quantite_stock($quantite);
               
        //             }
                   
                
        //        } 
        //        else {
        //           //editer la ligne de vente
        //             $id=$id_lignes[$i];
        //             $ligne= LigneVente::find($id);
        //              //recuperer le produit associé à la vente
        //             $prd=Produit::find($ligne->produit_id);
        //             //Annuler l'ancienne quantite vente
        //             $prd->augmenter_quantite_stock($ligne->quantite_vente);
        //             //mise ajour de la ligne
        //             $ligne->update([
        //                 'produit_id' => $produits[$i],
        //                 'quantite_vente' => $quantites[$i]]);
        //            //mise a jour de quantite stock apres la modification de la vente
                 
        //          $prd->diminuer_quantite_stock($ligne->quantite_vente);
                        
        //         }
                
        //     }   
            
           
        //    //Suppression d'une ligne de vente
        //     $tab=explode(",",$ids_suppr);
        //     $tab_ligne_a_supp=explode(",",$ids_suppr);
        //     //dd( $tab_ligne_a_supp);
        //     if (count($tab_ligne_a_supp )!==0) {
        //         for($i=0; $i<count($tab_ligne_a_supp); $i++){
        //             $id=$tab_ligne_a_supp[$i];
        //             if ( $id !=="") {
        //                 $ligne= LigneVente::find(intval($id));
        //                 $prd=Produit::find($ligne->produit_id);
        //                  //Annuler l'ancienne quantite vente
        //                  $prd->augmenter_quantite_stock($ligne->quantite_vente);
        //                 //dd( $ligne->produit->quantite_stock);
        //                 $ligne->delete();
        //             }
    
        //         }
        //    }
      
}

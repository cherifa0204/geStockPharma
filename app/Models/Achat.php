<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Achat extends Model
{
    use HasFactory;
    protected $fillable=["date_achat","montant_total_achat"];


    
//un achat concerne plusieurs lignes
    function ligneachats()
    {
        return $this->hasMany(LigneAchat::class);
    }

    function calculer_montant_total()
    {
        
        $this->montant_total_achat = $this->ligneachats()->sum('montant_achat');
        //$this->save();
        return $this->montant_total_achat;
    }

    //methode pour creer ou mettre à jour les lignes d'achat
    function add_ligne($id_lignes,$produits,$quantites,$ids_suppr="")
    {
        //dd($quantites);
        for ($i=0; $i < count($id_lignes); $i++) { 
            //dd($id_lignes[$i]=="-1");
           if ($id_lignes[$i]=="-1") {
                $achat=$this->id;
                $ligne=LigneAchat::create([
                'achat_id' => $achat,
                'produit_id' => intval($produits[$i]),
                'quantite_achat' => intval($quantites[$i])]);
                //mise a jour de quantite stock
                $prd=Produit::find($ligne->produit_id);
                $prd->augmenter_quantite_stock($ligne->quantite_achat);
              
            } 
           else {
              //Mise a jour d'une ligne 
                $id=$id_lignes[$i];
                $ligne= LigneAchat::find($id);
               //recuperer le produit associé à l'achat
                $prd=Produit::find($ligne->produit_id);
                 //retirer l'ancienne quantite d'achat
                $prd->diminuer_quantite_stock($ligne->quantite_achat);
                // dd($produits[$i]);
                $ligne->update([
                    'produit_id' => $produits[$i],
                    'quantite_achat' => $quantites[$i]]);
               
                 //mise a jour de quantite stock
                 
                 $prd->augmenter_quantite_stock($ligne->quantite_achat);
                    
            }
        }   
        //$this->calculer_montant_total();
       
       // dd($ids_suppr);
        $tab=explode(",",$ids_suppr);
        $tab_ligne_a_supp=explode(",",$ids_suppr);
        //dd( $tab_ligne_a_supp);
        if (count($tab_ligne_a_supp )!==0) {
            for($i=0; $i<count($tab_ligne_a_supp); $i++){
                $id=$tab_ligne_a_supp[$i];
                if ( $id !=="") {
                    $ligne= LigneAchat::find(intval($id));
                    //recuperer le produit associé à l'achat
                    $prd=Produit::find($ligne->produit_id);
                    //retirer l'ancienne quantite d'achat
                    $prd->diminuer_quantite_stock($ligne->quantite_achat);

                    $ligne->delete();
                }

            }
        }
       

    } 
    
}

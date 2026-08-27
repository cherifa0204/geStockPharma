<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Carbon\Carbon;

class Produit extends Model
{
    use HasFactory;
    //,'quantite_stock'
    protected $fillable=['nom_produit','prix_unitaire_achat','prix_unitaire_vente'];
    
    //

    function ligneAchats(){
        return $this->hasMany(LigneAchat::class);
    }

    function ligneVentes(){
        return $this->hasMany(LigneVente::class);
    }

    function augmenter_quantite_stock(int $quantite)
    {
        $this->quantite_stock +=$quantite;
        $this->save();
    }

    function diminuer_quantite_stock(int $quantite)
    {
        $this->quantite_stock -=$quantite;
        $this->save();
        //dump($this->quantite_stock);
        return $this->quantite_stock;
       

    }

    ///calcul qtes lors de l'inventaire
    function inventaire_prd($debut,$fin)
    {
        $date_debut = Carbon::parse()->format('Y-m-d',$debut); 
        $date_fin = Carbon::parse()->format('Y-m-d',$fin); 
    
        $tab=[];
        $quantite_entre=0;
        $quantite_sortie=0;
        $total_vente=0;
        $total_achat=0;

        foreach ($this->ligneAchats as $ligne) {
            $dateA=Carbon::parse($ligne->achat->date_achat);
            if ($dateA->gte($date_debut) and $dateA->lte($date_fin)) {
                //$ligne_trouve=$ligne->achat->whereBetween('date_achat',[$date_debut,$date_fin] )->get();
                $quantite_entre +=$ligne->quantite_achat;
                $total_achat += $ligne->montant_achat;
           
            } 
        }  

        //dump("qte_en ".$quantite_entre);
        foreach ($this->ligneVentes as $ligne) {
            $dateV=Carbon::parse($ligne->vente->date_vente);
            if ($dateV->gte($date_debut) and $dateV->lte($date_fin)) {
                //$ligne_trouve=$ligne->achat->whereBetween('date_achat',[$date_debut,$date_fin] )->get();
                $quantite_sortie +=$ligne->quantite_vente;
                $total_vente += $ligne->montant;
           
            } 
        }
      
        //dump("qte_sorti ".$quantite_sortie);
        $quantite_initiale= $this->quantite_stock - ($quantite_entre -$quantite_sortie);

        //dump("qte_i ".$quantite_initiale);
        $tab=["nom_produit"=>$this->nom_produit,
                "quantite_entre"=>$quantite_entre,
                "quantite_sortie"=>$quantite_sortie,
                "quantite_initiale"=>$quantite_initiale,
                "total_achat" =>$total_achat,
                "total_vente"=> $total_vente,
            ];
            //dump($tab["nom_produit"]);
        return $tab;


        //$quantite_sortie =$this->ligneVentes->sum('quantite_vente');
      
        // $quantite_entre=$this->ligneAchats->sum('quantite_achat')->where($this->ligneAchats->achat->date_achat,'=',$debut);
        // $quantite_intiale= $this->quantite_stock - ($quantite_entre -$quantite_sortie);
        // $tab=["quantite_sortie"=>$quantite_sortie,
        //     "quantite_entre"=>$quantite_entre,
        //     "quantite_initiale"=>$quantite_intiale,
        // ];
        // dump($tab);
        // return $tab;

    }
   


}

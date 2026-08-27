<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpDocumentor\Reflection\Types\Parent_;
use App\Events\LigneVenteUpdated;
class LigneVente extends Model
{
    use HasFactory;
    protected $fillable =['vente_id','produit_id','quantite_vente','montant'];
    

    // Définissons un événement de modèle pour la mise à jour
    protected $dispatchesEvents = [
        'VenteUpdated' => LigneVenteUpdated::class,
    ];
    
    function vente()
    {
        return $this->belongsTo(Vente::class);
    }

    function produit()
    {
        return $this->belongsTo(Produit::class);
    }
    //montant ligne update
    function save(array $options = [])
    {
        
        $this->montant=$this->produit->prix_unitaire_vente * $this->quantite_vente;
    
        Parent::save($options);
    }


    
}

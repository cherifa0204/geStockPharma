<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpDocumentor\Reflection\Types\Parent_;
use App\Events\LigneAchatUpdated;

class LigneAchat extends Model
{
    use HasFactory;
    protected $fillable =["achat_id","produit_id",'quantite_achat','montant_achat'];

    // Définissez un événement de modèle pour la mise à jour
    protected $dispatchesEvents = [
        'updated' => LigneAchatUpdated::class,
    ];
    
    function achat()
    {
        return $this->belongsTo(Achat::class);
    }

    function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    //redefinir
    function save(array $options = [])
    {
       // dd($this->id);
        $this->montant_achat=$this->produit->prix_unitaire_achat * $this->quantite_achat;
    
        Parent::save($options);
    }

 }

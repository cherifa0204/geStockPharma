<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\LigneVenteUpdated;
class UpdateMontantVente
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LigneVenteUpdated $event): void
    {
        //dd($event);
        //acceder a la vente associe à ligne vente
        $vente=$event->ligneVente->vente;
        
         // Recalculer le montant total de la vente en utilisant la méthode appropriée (par exemple, celle que nous avons définie précédemment)
         $nouveauMontant = $vente->calculer_montant_total_vente();
        
         // Mettre à jour le montant total
         $vente->montant_total= $nouveauMontant;
         $vente->save();
    }
}

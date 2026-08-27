<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\LigneAchatUpdated;
class RecalculerMontantTotalAchat
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
    public function handle(LigneAchatUpdated $event): void
    {
        //dd($event->ligneAchat->achat);
        // Accédez à l'achat associé à la ligne d'achat mise à jour
        $achat = $event->ligneAchat->achat;

        // Recalculer le montant total de l'achat en utilisant la méthode appropriée (par exemple, celle que nous avons définie précédemment)
        $nouveauMontantTotal = $achat->calculer_montant_total();

        // Mettre à jour le montant total de l'achat
        $achat->montant_total_achat = $nouveauMontantTotal;
       // dd($achat->montant_total_achat);
        $achat->save();
    }
}

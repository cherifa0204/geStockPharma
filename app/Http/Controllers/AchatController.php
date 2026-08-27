<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Produit;
use App\Models\LigneAchat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
        return view("achats.index")->with(["achats"=>Achat::all()]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //les prds
        $produits=Produit::all();
        return view("achats.create_or_edite",compact('produits'));
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->ligne_achat_id);
       if ($request->ligne_achat_id ==null ) {
            return redirect()->route("achats.create");
       }


       //enregistrement d'achat
        $achat=Achat::create(['date_achat'=>now()]);
        $achat->add_ligne($request->ligne_achat_id,$request->produit,$request->quantite);
        //calcul du montant total achat
        $achat->calculer_montant_total();
        $achat->save();

        return redirect()->route("achats.index")->with(['achats' =>Achat::all()]); 
    }

      

    /**
     * Display the specified resource.
     */
    public function show(Achat $achat)
    {
    
        return view('achats.show',compact('achat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achat $achat)
    {
        //dd($achat->ligneachats);
        $produits=Produit::all();
        return view("achats.create_or_edite",compact('achat','produits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Achat $achat)
    {
        $achat->add_ligne($request->ligne_achat_id,$request->produit,$request->quantite,$request->ligne_suppr);
        $achat->calculer_montant_total();
        $achat->save();
       return redirect()->route("achats.index");
  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achat $achat)
    {
        
        foreach ($achat->ligneachats as $ligne) {
            $ligne->delete();
           
        }
        $achat->delete();
        return redirect()->route("achats.index");
    }

  //Exporter en pdf
    public function exporter_achat(Achat $achat)
    {
        $achat->load(['ligneachats.produit']);
        $pdf = Pdf::loadView('achats.fiche_achat', [
            "achat" => $achat,
        ]);
        
        return $pdf->download('Fiche_Achat_#' . $achat->id . '.pdf');
    }

}


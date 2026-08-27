<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=Auth::user();
        $date_day=Carbon::parse(now());
        //dump($date_day);
        //$vente=Vente::where("date_vente",">=",$date_day);
        $vente=Vente::all();
       // dd($vente);
        return view("ventes.index")->with(["ventes"=>$vente]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits=Produit::all();
        //dd($produits);
        return view("ventes.create_or_edite")->with(["produits"=>$produits]);
    }

     /**
     *
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
        //dd($request->ligneventes);
       //dd($request->ligne_suppr);
        if ($request->quantite==null  ) {
            return redirect()->route("ventes.create");
        }
        
        $lignes_vente=[];
        $lignes_errors=[];
        for ($i=0; $i < count($request->produit) ; $i++) { 
            //recuperer la quantite stock du produit selectionné
            $prod=Produit::find(intval($request->produit[$i]));
            if ($prod &&  $request->quantite[$i] ) {
                $quantite_stock=$prod->quantite_stock;
                $quantite_vente=intval($request->quantite[$i]);
                if ($quantite_stock >= $quantite_vente) {
                    //dd($request->ligne_vente_id[$i]);
                  array_push($lignes_vente,["id_ligne"=>$request->ligne_vente_id[$i],"produit"=>$prod,"quantite"=>$quantite_vente]);
                  
                }
                else{
                    
                    array_push($lignes_errors,["produit"=>$prod->nom_produit,"message"=>"Quantiteé invalide"]);
                    
                }
            }else {
                return redirect()->route("ventes.create")->with(['alerte' =>"Attention! Il y 'a une ligne invalide."]); 

            }
                               
        }
   
       // dd($lignes_vente);
        ///
        if (count($lignes_errors)== 0) {
            $user=Auth::user();
            $vente=Vente::create([
                'date_vente'=>now(),
                'user_id'=>$user->id,
            ]);
            //dd($request-> ligne_suppr);
            $vente->add_ligne_vente($lignes_vente);
            $vente->calculer_montant_total_vente();  
        
        } else {
            return redirect()->route("ventes.create",compact('lignes_errors')); 
        }

      
    return redirect()->route("ventes.index")->with(['ventes' =>Vente::all(),"info"=>"La vente a été ajouotée avec sucèss!"]); 
}

    /**
     * Display the specified resource.
     */
    public function show(Vente $vente)
    {
        return view('ventes.show',compact('vente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vente $vente)
    {
        //
        $produits=Produit::all();
        return view("ventes.create_or_edite",compact('vente','produits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vente $vente)
    {
        //
        if ($request->quantite ==null ) {
            //prevoir une info 
            return redirect()->route("ventes.create");
        }
        $lignes_vente=[];
        $lignes_errors=[];
        for ($i=0; $i < count($request->produit) ; $i++) { 
            //recuperer la quantite stock du produit selectionné
            $prod=Produit::find(intval($request->produit[$i]));
            if ($prod &&  $request->quantite[$i] ) {
                $quantite_stock=$prod->quantite_stock;
                $quantite_vente=intval($request->quantite[$i]);
                if ($quantite_stock >= $quantite_vente) {
                    //dd($request->ligne_vente_id[$i]);
                  array_push($lignes_vente,["id_ligne"=>$request->ligne_vente_id[$i],"produit"=>$prod,"quantite"=>$quantite_vente]);
                  
                }
                else{
                    
                    array_push($lignes_errors,["produit"=>$prod->nom_produit,"message"=>"Quantiteé invalide"]);
                    
                }
            }else {
                return redirect()->route("ventes.create")->with(['alerte' =>"Attention! Il y 'a une ligne invalide."]); 

            }
                               
        }
   
       // dd($lignes_vente);
        ///
        if (count($lignes_errors)== 0) {
            //dd($request-> ligne_suppr);
            $vente->add_ligne_vente($lignes_vente,$request->ligne_suppr);
            $vente->calculer_montant_total_vente();  
        
        } else {
            return redirect()->route("ventes.create",compact('lignes_errors')); 
        }

       return redirect()->route("ventes.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vente $vente)
    {
        //
        foreach ($vente->ligneventes() as $ligne) {
            // $prod=Produit::find($ligne->produit_id);
            // $prod->augmenter_quantite_stock($ligne->quantite_vente);
            $ligne->delete();
           
        }
        $vente->delete();
        return redirect()->route("ventes.index");
    }
    // show_product affiche les produits  pour la vente
    public function show_product()
    {
        $produits=Produit::all();
        //dd($produits);
        return view('ventes.show_product',compact('produits'));
    }


    ///
    public function recu(Vente $vente)
    {
        $vente->load(['ligneventes.produit']);
        $pdf = Pdf::loadView('ventes.recu_vente', [
            "vente" => $vente,
        ]);
        
        return $pdf->download('Recu_Vente_#' . $vente->id . '.pdf');
    }


    public function create_inventaire() {
        //dd('ok');
        return view('controle.create_inventaire');
        
    }

//faire l'inventaire
    public function faire_inventaire(Request $request){
        //dd($request->date_debut > $request->date_fin);
        $validator = Validator::make($request->all(), ["date_debut" =>["required","date"],
        "date_fin" =>["required","date"]
        ],["date_debut.required"=>"Entrez la date du debut sous le format jj/mm/aaaa ,",
        "date_debut.required"=>"La date du debut est  obligatoire",
        "date_fin.date"=>"La date de fin est  obligatoire",
        "date_fin.required"=>"Entrez la date de fin sous le format jj/mm/aaaa , "
    
    
        ]);
        $validated = $validator->validated();

        if ($request->date_debut > $request->date_fin) {
            $message="Attention! la date du debut de l'inventaire ne doit pas dépassée la date de fin. ";
            return redirect()->route('create_inventaire')->with("message",$message);
            
        }
        $date_debut=$request->date_debut;
        $date_fin=$request->date_fin;
        $produits=Produit::all();
       
        return view('controle.inventaire',compact('produits','date_debut','date_fin'));
    }
    
    //exporter la'affiche d'inventaire

    function exporter_inventaire($date_debut,$date_fin) 
    {
        $produits = Produit::all();
        $pdf = Pdf::loadView('controle.export_inv', [
            "produits" => $produits,
            "date_debut" => $date_debut,
            "date_fin" => $date_fin
        ]);
        
        return $pdf->download('Inventaire_' . $date_debut . '_au_' . $date_fin . '.pdf');
    }
}

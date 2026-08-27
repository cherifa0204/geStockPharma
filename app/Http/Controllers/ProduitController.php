<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduitFormRequest;
use App\Models\Achat;
use App\Models\Commander;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProduitsImport;
use Barryvdh\DomPDF\Facade\Pdf;


class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        //return view('produits.index',["produits"=>Produit::orderBy('nom_produit','asc')]);
        return view('produits.index')->with(["produits"=>Produit::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("produits.create_or_edit")->with(["produits"=>Produit::all()]);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //valiadtion des données
        
        $validator = Validator::make($request->all(), [
            'nom_produit' => [
                'required',
                'regex:/^[^\d][A-Za-z-0-9\/\s]+$/',
                'unique:produits',
                'min:3',
            ],
            'prix_unitaire_achat' => [
                'required',
                'numeric',
                'min:1',
            ],
            'prix_unitaire_vente' => [
                'required',
                'numeric',
                'min:1',
            ],
        ], [
            'nom_produit.required' => 'Le nom du produit est obligatoire.',
            'nom_produit.min' => 'Le nom du produit ne doit pas être inférieur à 3 caractères.',
            'nom_produit.regex' => "Le nom du produit n'accepte qu'une chaine de caractères .",
            'prix_unitaire_achat.required' => 'Le prix unitaire achat est obligatoire.',
            'prix_unitaire_achat.numeric' => 'Le prix unitaire achat doit être un nombre.',
            'prix_unitaire_achat.min' => 'Le prix unitaire achat ne peut pas être inférieur à 1.',
            'prix_unitaire_vente.required' => 'Le prix unitaire de vente est obligatoire.',
            'prix_unitaire_vente.numeric' => 'Le prix unitaire de vente doit être un nombre.',
            'prix_unitaire_vente.min' => 'Le prix unitaire de vente ne peut pas être inférieur à 1.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $validated = $validator->validated();
        //dd(Produit::all()->where('nom_produit','=',$request->nom_produit));

       $prd=Produit::select("id")->where('nom_produit','=',$request->nom_produit);
       //dd($prd);
    //    if ($prd !== null) {
    //     return redirect()->route("produits.index")->with("info","Le produit existe déjà.");

           
    //    }
       
        Produit::create($request->all());
        return redirect()->route("produits.index")->with("info","Le produit a été enregistré avec succès!");
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        return view("produits.create_or_edit",compact("produit"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        $validator = Validator::make($request->all(), [
            'nom_produit' => [
                'required',
               // 'regex:/^[A-Za-z0-9\s\/]+|[A-Za-z\s\/]+$/',
               'regex:/^[^\d][A-Za-z-0-9\/\s]+$/',
                'min:3',
                // 'unique:produits'
            ],
            'prix_unitaire_achat' => [
                'required',
                'numeric',
                'min:1',
            ],
            'prix_unitaire_vente' => [
                'required',
                'numeric',
                'min:1',
            ],

            // 'quantite_stock' => [
            //     'required',
            //     'numeric',
            //     'min:1',
            // ],

        ], [
            'nom_produit.required' => 'Le nom du produit est obligatoire.',
            'nom_produit.unique' =>'Attention! ce produit existe deja ',
            'nom_produit.min' => 'Le nom du produit ne doit pas être inférieur à 3 caractères.',
            'nom_produit.regex' => "Le nom du produit n'accepte que les chaine de  caractères ou les alphanumériques.",
            'prix_unitaire_achat.required' => 'Le prix unitaire achat est obligatoire.',
            'prix_unitaire_achat.numeric' => 'Le prix unitaire achat doit être un nombre.',
            'prix_unitaire_achat.min' => 'Le prix unitaire achat ne peut pas être inférieur à 1.',
            'prix_unitaire_vente.required' => 'Le prix unitaire de vente est obligatoire.',
            'prix_unitaire_vente.numeric' => 'Le prix unitaire de vente doit être un nombre.',
            'prix_unitaire_vente.min' => 'Le prix unitaire de vente ne peut pas être inférieur à 1.',
        ]);
        $validated = $validator->validated();
        $prd = Produit::where("nom_produit","=",$request->nom_produit)->first();
        //dd($prd);
       if ($prd ==null) {
        $produit->update($request->all());
       } else {
        //return redirect()->route('produits.create')->with("echec","Le du nom produit a été déja utilisé!");

       }
       
        
       
        return redirect()->route('produits.index')->with("success","Le produit a été bien modifié avec succès!");
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with("success","Le produit a été bien supprimé!");
        
    }

    //importation
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ], [
            'file.required' => 'Veuillez sélectionner un fichier à importer.',
            'file.mimes' => 'Le fichier doit être au format Excel (.xlsx, .xls) ou CSV.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $import = new ProduitsImport();
            Excel::import($import, $request->file('file'));

            $message = "Importation réussie ! {$import->createdCount} nouveau(x) produit(s) inséré(s) et {$import->updatedCount} produit(s) mis à jour.";
            return redirect()->route('produits.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('produits.index')->with('echec', "Erreur lors de l'importation : " . $e->getMessage());
        }
    }
    //exportation

    public function exporter_produit()
    {
        //
        $pdf=Pdf::loadView('produits.export_pdf',[
            "produits" => Produit::all(),
    
         ]);
        
       return $pdf->download('produits');
    }

    
}

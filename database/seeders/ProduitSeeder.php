<?php

namespace Database\Seeders;

use App\Models\Achat;
use App\Models\Commander;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Produit;
class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prd1=Produit::create(["nom_produit"=>"Amoxiclav derik 1g B/12",
        'quantite_stock'=>0,'prix_unitaire_achat'=>5500,'prix_unitaire_vente'=>5700]);

        $prd2=Produit::create(["nom_produit"=>"Artrim sirop 1fl",
        'quantite_stock'=>0,'prix_unitaire_achat'=>2800,'prix_unitaire_vente'=>3000]);

        $prd3=Produit::create(["nom_produit"=>"Bimalarial comp 80/480 1bte",
        'quantite_stock'=>0,'prix_unitaire_achat'=>1850,'prix_unitaire_vente'=>2000]);

        $prd4=Produit::create(["nom_produit"=>"Cromsol collyre",
        'quantite_stock'=>0,'prix_unitaire_achat'=>900,'prix_unitaire_vente'=>1000]);

        $prd5=Produit::create(["nom_produit"=>"Micozal crème",
        'quantite_stock'=>0,'prix_unitaire_achat'=>1500,'prix_unitaire_vente'=>1600]);


     
 }
}

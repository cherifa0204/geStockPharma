<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=User::create([
            'name' => 'cherifa',
            'email' => 'ch@mail.com',
            'password' =>'12341234',
            'role' =>'pharmacien',
        ]);
        $user2=User::create([
            'name' => 'fridaouss',
            'email' => 'fri@mail.com',
            'password' =>'12345678',
            'role' =>'gerant',
        ]);
        //creer des roles
         $gerant=Role::create(['name'=>'gerant']);
         $pharmacien=Role::create(['name'=>'pharmacien']);
        
          //creer des permissions 
        $ProduitPermission=Permission::create(['name'=>'add produit']);
        $editProduitPermission=Permission::create(['name'=>'edit produit']);
        $deleteProduitPermission=Permission::create(['name'=>'delete produit']);
       
        $achatPermission=Permission::create(['name'=>'create achat']);
        $ventePermission=Permission::create(['name'=>'create vente']);
        $viewPermission=Permission::create(['name'=>'view price achat']);
        $viewUser=Permission::create(['name'=>'user view']);
        //Attribuer des permissions aux roles
        $gerant->givePermissionTo($ProduitPermission,$achatPermission,$ventePermission,$viewPermission,$editProduitPermission,$deleteProduitPermission,$viewUser);
        $pharmacien->givePermissionTo($ventePermission);
        
        //assignation des roles 
        $user->assignRole($pharmacien);
    
        $user2->assignRole($gerant);

        
        //$user->
        
    }
}

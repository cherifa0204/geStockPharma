<?php

use App\Exports\ProduitsExport;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\AchatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenteController;
use App\Models\Patient;
use App\Models\Produit;
use App\Models\Achat;
use App\Models\User;
use  Maatwebsite\Excel\Facades\Excel;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// App::setLocale(('fr'));
Route::get('/', function () {
    return view('accueil');
});

// Route::get('/accueil', function () {
//     return view('accueil');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');

});

require __DIR__.'/auth.php';

//admin 
//routes de produits
Route::middleware('auth')->prefix("produits")->name("produits.")->controller(ProduitController::class)->group(function (){
    Route::get('/','index')->name("index");
    Route::get('/creation','create')->name("create");
    Route::post('/store','store')->name("store");
    Route::get('/{produit}/edit','edit')->name("edit");
    Route::put('/{produit}/update','update')->name("update");
    Route::delete('/{produit}/destroy','destroy')->name("destroy");
    Route::get('/{produit}/show','show')->name("show");
    Route::post('/import-product','import')->name("import");
    Route::get('/products-export', function () {
        if (!function_exists('deflate_init')) {
            return Excel::download(new ProduitsExport, 'produits.csv', \Maatwebsite\Excel\Excel::CSV);
        }
        return Excel::download(new ProduitsExport, 'produits.xlsx');
    })->name('export_excel');


});

//Achats
Route::middleware(['auth','role:gerant'])->prefix("achats")->name("achats.")->controller(AchatController::class)->group(function (){
    Route::get('/',"index")->name("index");
    Route::get('/create',"create")->name("create");
    Route::post('/store',"store")->name("store");
    Route::get('/{achat}/edit',"edit")->name("edit");
    Route::put('/{achat}/update',"update")->name("update");
    Route::delete('/{achat}/destroy',"destroy")->name("destroy");
    Route::get('/{achat}/show',"show")->name("show");
    Route::get('/fiche_achat/{achat}',"exporter_achat")->name("fiche");

   
});

//users
Route::middleware('auth')->prefix("users")->name("users.")->controller(UserController::class)->group(function (){
    Route::get('/',"index")->name("index");
    Route::get('/attribuer_role',"assign")->name("assign_role");
    Route::post('/store',"store")->name("store");
    Route::get('/{user}/edit',"edit")->name("edit");
    Route::put('/{user}/update',"update")->name("update");
    Route::delete('/{user}/destroy',"destroy")->name("destroy");
    Route::get('/{user}/show',"show")->name("show");
   
   
});

//inventaire hebdo
Route::middleware('auth')->get('/inventaire', [VenteController::class,'faire_inventaire'])->name("inventaire");

Route::middleware('auth')->get('/create_inventaire', [VenteController::class,'create_inventaire'])->name("create_inventaire");

// Route::middleware(['auth','role:gerant'])->get('/users', [UserController::class,'index'])->name("users");

// vente
Route::middleware('auth')->prefix("ventes")->name("ventes.")->controller(VenteController::class)->group(function (){
    Route::get('/',"index")->name("index");
    Route::get('/create',"create")->name("create");
    Route::post('/store',"store")->name("store");
    Route::get('/{vente}/edit',"edit")->name("edit");
    Route::put('/{vente}/update',"update")->name("update");
    Route::delete('/{vente}/destroy',"destroy")->name("destroy");
    Route::get('/{vente}/show',"show")->name("show");
    Route::get('/show_product',"show_product")->name("show_product");
    Route::get('/recu-vente/{vente}', 'recu')->name('recu');
    Route::get('/export_inventaire/{date_debut}/{date_fin}', 'exporter_inventaire')->name('exporter_inv');


   //exporter_inventaire
});



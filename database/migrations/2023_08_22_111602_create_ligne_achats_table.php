<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ligne_achats', function (Blueprint $table) {
            $table->id();
            $table->integer('achat_id')->foreign("achat_id")->references("id")->on("achats")->onDelete('cascade')->onUpdate('cascade');
            $table->integer('produit_id')->foreign("produit_id")->references("id")->on("produits")->onDelete('cascade')->onUpdate('cascade');
            $table->integer('quantite_achat');
            $table->integer('montant_achat')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligne_achats');
    }
};

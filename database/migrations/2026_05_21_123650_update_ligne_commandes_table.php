<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ligne_commandes', function (Blueprint $table) {
            // Supprimer la colonne sous_total si elle existe
            if (Schema::hasColumn('ligne_commandes', 'sous_total')) {
                $table->dropColumn('sous_total');
            }
            
            // Ajouter les colonnes manquantes avec valeurs par défaut
            if (!Schema::hasColumn('ligne_commandes', 'quantite')) {
                $table->integer('quantite')->default(1);
            }
            
            if (!Schema::hasColumn('ligne_commandes', 'prix_unitaire')) {
                $table->decimal('prix_unitaire', 10, 2)->default(0);
            }
            
            // Ajouter la colonne statut si elle n'existe pas
            if (!Schema::hasColumn('ligne_commandes', 'statut')) {
                $table->string('statut')->default('en_attente');
            }
        });
    }

    public function down()
    {
        Schema::table('ligne_commandes', function (Blueprint $table) {
            // Revert changes if needed
        });
    }
};
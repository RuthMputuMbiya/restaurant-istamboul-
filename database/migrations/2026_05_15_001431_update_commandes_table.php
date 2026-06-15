<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (!Schema::hasColumn('commandes', 'type_commande')) {
                $table->string('type_commande')->default('sur_place')->after('notes');
            }
            if (!Schema::hasColumn('commandes', 'nom_client')) {
                $table->string('nom_client')->nullable()->after('client_id');
            }
        });

        // Modifier l'ENUM pour inclure 'panier'
        DB::statement("ALTER TABLE commandes MODIFY COLUMN statut ENUM('panier', 'en_attente', 'en_preparation', 'pret', 'livre', 'annulee') DEFAULT 'panier'");
    }

    public function down()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn(['type_commande', 'nom_client']);
        });
        DB::statement("ALTER TABLE commandes MODIFY COLUMN statut ENUM('en_attente', 'en_preparation', 'pret', 'livre', 'annulee') DEFAULT 'en_attente'");
    }
};
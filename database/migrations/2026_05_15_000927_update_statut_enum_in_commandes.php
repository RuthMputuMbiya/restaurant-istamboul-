<?php
// database/migrations/xxxx_xx_xx_xxxxxx_update_statut_enum_in_commandes.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Modifier l'ENUM pour ajouter 'panier'
        DB::statement("ALTER TABLE commandes MODIFY COLUMN statut ENUM('panier', 'en_attente', 'en_preparation', 'pret', 'livre', 'annulee') DEFAULT 'panier'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE commandes MODIFY COLUMN statut ENUM('en_attente', 'en_preparation', 'pret', 'livre', 'annulee') DEFAULT 'en_attente'");
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE commandes MODIFY COLUMN statut ENUM('panier', 'en_attente', 'validee', 'en_preparation', 'pret', 'servi', 'paye', 'annulee', 'recuperee') DEFAULT 'en_attente'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE commandes MODIFY COLUMN statut ENUM('panier', 'en_attente', 'validee', 'en_preparation', 'pret', 'servi', 'paye', 'annulee') DEFAULT 'en_attente'");
    }
};
// database/migrations/2024_01_01_000006_create_ligne_commandes_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ligne_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->integer('quantite')->default(1);
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('sous_total', 10, 2);
            $table->text('instructions')->nullable();
            $table->enum('statut', ['en_attente', 'en_preparation', 'pret', 'servi'])->default('en_attente');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('ligne_commandes');
    }
};
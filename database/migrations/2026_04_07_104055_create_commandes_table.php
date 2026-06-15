// database/migrations/2024_01_01_000005_create_commandes_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_commande')->unique();
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('table_id')->constrained('tables_resto')->onDelete('cascade');
            $table->foreignId('serveur_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('statut', [
                'en_attente', 
                'validee', 
                'en_preparation', 
                'pret', 
                'servi', 
                'paye', 
                'annulee'
            ])->default('en_attente');
            $table->decimal('montant_total', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('heure_commande')->useCurrent();
            $table->timestamp('heure_servi')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('commandes');
    }
};
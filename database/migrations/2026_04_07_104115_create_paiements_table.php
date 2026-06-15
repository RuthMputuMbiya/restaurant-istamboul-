<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('montant', 12, 2);
            $table->enum('mode_paiement', ['shwary', 'especes', 'mobile_money', 'carte'])->default('shwary');
            $table->string('reference')->unique();
            $table->string('transaction_id')->nullable();
            $table->string('devise')->default('CDF');
            $table->enum('statut', ['en_attente', 'valide', 'echoue', 'en_cours'])->default('en_attente');
            $table->foreignId('encaisse_par')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('date_paiement')->nullable();
            $table->text('response_data')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};
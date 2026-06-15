<?php

// database/migrations/2024_01_01_000003_create_menus_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2);
            $table->decimal('prix_usd', 10, 2)->nullable()->after('prix');  // ← AJOUT DE prix_usd
            $table->string('image')->nullable();
            $table->integer('temps_preparation')->default(15);
            $table->boolean('est_disponible')->default(true);
            $table->boolean('est_populaire')->default(false);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
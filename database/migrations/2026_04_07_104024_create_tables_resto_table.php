// database/migrations/2024_01_01_000001_create_tables_resto_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tables_resto', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->integer('capacite');
            $table->enum('zone', ['interieur', 'terrasse', 'salon'])->default('interieur');
            $table->enum('statut', ['libre', 'occupee', 'reservee'])->default('libre');
            $table->boolean('est_active')->default(true);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tables_resto');
    }
};
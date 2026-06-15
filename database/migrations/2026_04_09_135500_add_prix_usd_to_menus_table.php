<?php
// database/migrations/2024_04_09_000000_add_prix_usd_to_menus_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->decimal('prix_usd', 10, 2)->nullable()->after('prix');
        });
    }
    
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('prix_usd');
        });
    }
};
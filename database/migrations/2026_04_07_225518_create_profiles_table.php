<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informations personnelles
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('Cameroun');
            $table->string('postal_code')->nullable();
            $table->date('birth_date')->nullable();
            
            // Préférences alimentaires
            $table->json('preferences')->nullable();
            $table->json('dietary_restrictions')->nullable();
            $table->json('favorite_dishes')->nullable();
            $table->json('allergies')->nullable();
            
            // Notifications
            $table->boolean('newsletter_subscribed')->default(false);
            $table->json('notification_settings')->nullable();
            
            // Préférences de l'application
            $table->string('language')->default('fr');
            $table->string('currency')->default('XAF');
            
            $table->timestamps();
            
            // Index pour optimiser les recherches
            $table->index(['city', 'country']);
            $table->index('newsletter_subscribed');
            $table->index('language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
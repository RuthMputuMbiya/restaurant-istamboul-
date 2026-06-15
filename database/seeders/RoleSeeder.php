<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  // ← AJOUTER CETTE LIGNE

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            [
                'nom' => 'Client',
                'slug' => 'client',
                'description' => 'Client du restaurant qui peut réserver une table et consulter le menu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Serveur',
                'slug' => 'serveur',
                'description' => 'Serveur qui prend les commandes, sert les plats et encaisse les paiements',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Cuisinier',
                'slug' => 'cuisinier',
                'description' => 'Cuisinier qui prépare les plats et change le statut des commandes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Gérant',
                'slug' => 'gerant',
                'description' => 'Gérant qui gère le menu, les prix et consulte les statistiques',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Administrateur',
                'slug' => 'admin',
                'description' => 'Administrateur qui gère les utilisateurs et supervise le système',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['slug' => $role['slug']], // Vérifier si le slug existe déjà
                $role // Si existe, mettre à jour, sinon créer
            );
        }
    }
}
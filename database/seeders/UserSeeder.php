<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        
        // Seulement les 4 acteurs (pas les clients)
        $users = [
            // Serveurs (role_id = 2)
            [
                'name' => 'Regine Ngondo',
                'email' => 'serveur@gmail.com',
                'telephone' => '+243 997008474',
                'adresse' => 'Lubumbashi, Quartier Golf',
                'role_id' => 2,  // Serveur
                'password' => Hash::make('password123'),
                'est_actif' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ruth mputu',
                'email' => 'ruthmputu13@gmail.com',
                'telephone' => '+243 997185648',
                'adresse' => 'Lubumbashi, Quartier Bel-Air',
                'role_id' => 2,  // Serveur
                'password' => Hash::make('password123'),
                'est_actif' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Cuisiniers (role_id = 3)
            [
                'name' => 'Deborah Kanku',
                'email' => 'cuisinier@gmail.com',
                'telephone' => '+243 844567890',
                'adresse' => 'Lubumbashi, Quartier Kampemba',
                'role_id' => 3,  // Cuisinier
                'password' => Hash::make('password123'),
                'est_actif' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grace Mbuyi',
                'email' => 'grace.cuisinier@istamboul.com',
                'telephone' => '+243 855678901',
                'adresse' => 'Lubumbashi, Quartier Ruashi',
                'role_id' => 3,  // Cuisinier
                'password' => Hash::make('password123'),
                'est_actif' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David Ilunga',
                'email' => 'david.cuisinier@istamboul.com',
                'telephone' => '+243 866789012',
                'adresse' => 'Lubumbashi, Quartier Lubumbashi',
                'role_id' => 3,  // Cuisinier
                'password' => Hash::make('password123'),
                'est_actif' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Gérants (role_id = 4)
            [
                'name' => 'Pierre Kasongo',
                'email' => 'pierre.gerant@istamboul.com',
                'telephone' => '+243 877890123',
                'adresse' => 'Lubumbashi, Quartier Centre',
                'role_id' => 4,  // Gérant
                'password' => Hash::make('password123'),
                'est_actif' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alain Mutombo',
                'email' => 'Gerant@gmail.com',
                'telephone' => '+243 899012345',
                'adresse' => 'Lubumbashi, Quartier Golf',
                'role_id' => 4,  // Gérant
                'password' => Hash::make('password123'),
                'est_actif' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Admins (role_id = 5)
            [
                'name' => 'Eunice Ekeneshi',
                'email' => 'ekeneshie@gmail.com',
                'telephone' => '+243 814870950',
                'adresse' => 'Lubumbashi, Siège',
                'role_id' => 5,  // Admin
                'password' => Hash::make('password123'),
                'est_actif' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Technique',
                'email' => 'admin.tech@istamboul.com',
                'telephone' => '+243 912345678',
                'adresse' => 'Lubumbashi, Technique',
                'role_id' => 5,  // Admin
                'password' => Hash::make('password123'),
                'est_actif' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insérer les 4 acteurs (serveurs, cuisiniers, gérants, admins)
        foreach ($users as $user) {
            // Éviter les doublons
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],  // Vérifier si l'email existe
                $user  // Si oui, mettre à jour ; si non, insérer
            );
        }
        
        $this->command->info('✅ 4 acteurs créés avec succès !');
        $this->command->info('   - Serveurs : 2 (role_id = 2)');
        $this->command->info('   - Cuisiniers : 3 (role_id = 3)');
        $this->command->info('   - Gérants : 2 (role_id = 4)');
        $this->command->info('   - Admins : 2 (role_id = 5)');
        $this->command->info('');
        $this->command->info('📝 Les clients s\'inscriront eux-mêmes (role_id = 1 par défaut)');
    }
}
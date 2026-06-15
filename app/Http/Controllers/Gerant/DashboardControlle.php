<?php

// app/Http/Controllers/Gerant/DashboardController.php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\Menu;
use App\Models\User;
use App\Models\TableResto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Statistiques du jour
            $commandesAujourdhui = Commande::whereDate('created_at', today())->count();
            $chiffreAffaires = Paiement::whereDate('date_paiement', today())->where('statut', 'valide')->sum('montant') ?? 0;
            $totalClients = User::where('role_id', 1)->count();
            $totalTables = TableResto::count();
            $tablesLibres = TableResto::where('statut', 'libre')->count();
            $reservationsJour = Reservation::whereDate('date_reservation', today())->count();
            $commandesEnAttente = Commande::where('statut', 'validee')->count();
            $commandesEnPreparation = Commande::where('statut', 'en_preparation')->count();
            $commandesPretes = Commande::where('statut', 'pret')->count();
            
            // Dernières commandes
            $dernieresCommandes = Commande::with(['table'])
                ->latest()
                ->take(5)
                ->get();
            
            // Top plats
            $topPlats = DB::table('ligne_commandes')
                ->join('menus', 'ligne_commandes.menu_id', '=', 'menus.id')
                ->select('menus.nom', DB::raw('SUM(ligne_commandes.quantite) as total_ventes'))
                ->groupBy('menus.id', 'menus.nom')
                ->orderBy('total_ventes', 'desc')
                ->take(5)
                ->get();
            
            // Graphique CA 7 jours
            $joursSemaine = [];
            $ventesParJour = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $joursSemaine[] = $date->translatedFormat('D');
                $ventesParJour[] = Paiement::whereDate('date_paiement', $date)->where('statut', 'valide')->sum('montant') ?? 0;
            }
            
            // CA du mois
            $caMois = Paiement::whereMonth('date_paiement', now()->month)->where('statut', 'valide')->sum('montant') ?? 0;
            
            return view('gerant.dashboard', compact(
                'commandesAujourdhui',
                'chiffreAffaires',
                'totalClients',
                'totalTables',
                'tablesLibres',
                'reservationsJour',
                'commandesEnAttente',
                'commandesEnPreparation',
                'commandesPretes',
                'dernieresCommandes',
                'topPlats',
                'joursSemaine',
                'ventesParJour',
                'caMois'
            ));
            
        } catch (\Exception $e) {
            // En cas d'erreur, retourner la vue avec des valeurs par défaut
            return view('gerant.dashboard', [
                'commandesAujourdhui' => 0,
                'chiffreAffaires' => 0,
                'totalClients' => 0,
                'totalTables' => 0,
                'tablesLibres' => 0,
                'reservationsJour' => 0,
                'commandesEnAttente' => 0,
                'commandesEnPreparation' => 0,
                'commandesPretes' => 0,
                'dernieresCommandes' => collect([]),
                'topPlats' => collect([]),
                'joursSemaine' => ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                'ventesParJour' => [0, 0, 0, 0, 0, 0, 0],
                'caMois' => 0
            ]);
        }
    }
}
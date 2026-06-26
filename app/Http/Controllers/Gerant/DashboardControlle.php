<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\Menu;
use App\Models\User;
use App\Models\TableResto;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // STATISTIQUES AUTOMATIQUES
        // ==========================================

        // --- RÉSERVATIONS ---
        $reservationsJour = Reservation::whereDate('date_reservation', today())->count();
        $reservationsTotal = Reservation::count();

        // --- COMMANDES ---
        $commandesEnAttente = Commande::where('statut', 'validee')->count();
        $commandesEnPreparation = Commande::where('statut', 'en_preparation')->count();
        $commandesPretes = Commande::where('statut', 'pret')->count();
        $commandesAujourdhui = Commande::whereDate('created_at', today())->count();
        $totalCommandes = Commande::count();

        // --- CAISSES ---
        $chiffreAffaires = Paiement::where('statut', 'valide')
            ->orWhere('statut', 'paye')
            ->sum('montant') ?? 0;

        $caJour = Paiement::where(function ($query) {
            $query->where('statut', 'valide')
                ->orWhere('statut', 'paye');
        })
            ->whereDate('date_paiement', today())
            ->sum('montant') ?? 0;

        $caMois = Paiement::where(function ($query) {
            $query->where('statut', 'valide')
                ->orWhere('statut', 'paye');
        })
            ->whereMonth('date_paiement', now()->month)
            ->whereYear('date_paiement', now()->year)
            ->sum('montant') ?? 0;

        // --- CLIENTS ---
        $totalClients = User::where('role_id', 1)->count();

        // --- TABLES ---
        $totalTables = TableResto::count();
        $tablesLibres = TableResto::where('statut', 'libre')->count();
        $tablesOccupees = TableResto::where('statut', 'occupee')->count();

        // --- DERNIÈRES COMMANDES ---
        $dernieresCommandes = Commande::with(['table', 'user'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($commande) {
                if (!$commande->montant_total) {
                    $commande->montant_total = $commande->ligneCommandes->sum('prix_total') ?? 0;
                }
                return $commande;
            });

        // --- TOP 5 PLATS ---
        $topPlats = DB::table('ligne_commandes')
            ->join('menus', 'ligne_commandes.menu_id', '=', 'menus.id')
            ->select(
                'menus.id',
                'menus.nom',
                DB::raw('SUM(ligne_commandes.quantite) as total_ventes'),
                DB::raw('SUM(ligne_commandes.prix_total) as total_chiffre')
            )
            ->groupBy('menus.id', 'menus.nom')
            ->orderBy('total_ventes', 'desc')
            ->take(5)
            ->get();

        // --- GRAPHIQUE : CA 7 DERNIERS JOURS ---
        $joursSemaine = [];
        $ventesParJour = [];
        $commandesParJour = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $joursSemaine[] = Carbon::parse($date)->translatedFormat('D');

            $ventesParJour[] = Paiement::where(function ($query) {
                $query->where('statut', 'valide')
                    ->orWhere('statut', 'paye');
            })
                ->whereDate('date_paiement', $date)
                ->sum('montant') ?? 0;

            $commandesParJour[] = Commande::whereDate('created_at', $date)->count();
        }

        // --- RÉSERVATIONS À VENIR ---
        $reservationsAVenir = Reservation::where('date_reservation', '>=', today())
            ->where('statut', 'validee')
            ->orderBy('date_reservation', 'asc')
            ->take(5)
            ->get();

        // --- STATUTS DES COMMANDES ---
        $statsCommandes = [
            'en_attente' => Commande::where('statut', 'en_attente')->count(),
            'validee' => Commande::where('statut', 'validee')->count(),
            'en_preparation' => Commande::where('statut', 'en_preparation')->count(),
            'pret' => Commande::where('statut', 'pret')->count(),
            'servi' => Commande::where('statut', 'servi')->count(),
            'paye' => Commande::where('statut', 'paye')->count(),
        ];

        // --- TAUX DE RÉSERVATION ---
        $tauxOccupation = $totalTables > 0
            ? round(($tablesOccupees / $totalTables) * 100)
            : 0;

        return view('gerant.dashboard', compact(
            'reservationsJour',
            'reservationsTotal',
            'commandesEnAttente',
            'commandesEnPreparation',
            'commandesPretes',
            'commandesAujourdhui',
            'totalCommandes',
            'chiffreAffaires',
            'caJour',
            'caMois',
            'totalClients',
            'totalTables',
            'tablesLibres',
            'tablesOccupees',
            'dernieresCommandes',
            'topPlats',
            'joursSemaine',
            'ventesParJour',
            'commandesParJour',
            'reservationsAVenir',
            'statsCommandes',
            'tauxOccupation'
        ));
    }

    public function getStats(Request $request)
    {
        try {
            $periode = $request->get('periode', 'jour');

            switch ($periode) {
                case 'semaine':
                    $dateDebut = now()->startOfWeek();
                    $dateFin = now()->endOfWeek();
                    break;
                case 'mois':
                    $dateDebut = now()->startOfMonth();
                    $dateFin = now()->endOfMonth();
                    break;
                case 'annee':
                    $dateDebut = now()->startOfYear();
                    $dateFin = now()->endOfYear();
                    break;
                default:
                    $dateDebut = today();
                    $dateFin = today();
            }

            $ca = Paiement::where(function ($query) {
                $query->where('statut', 'valide')
                    ->orWhere('statut', 'paye');
            })
                ->whereBetween('date_paiement', [$dateDebut, $dateFin])
                ->sum('montant') ?? 0;

            $commandes = Commande::whereBetween('created_at', [$dateDebut, $dateFin])->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'ca' => $ca,
                    'commandes' => $commandes,
                    'periode' => $periode,
                    'date_debut' => $dateDebut->format('d/m/Y'),
                    'date_fin' => $dateFin->format('d/m/Y')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

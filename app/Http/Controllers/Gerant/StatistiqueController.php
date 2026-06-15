<?php
// app/Http/Controllers/Gerant/StatistiqueController.php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Chiffre d'affaires
        $caJour = Paiement::whereDate('date_paiement', today())->where('statut', 'valide')->sum('montant') ?? 0;
        $caMois = Paiement::whereMonth('date_paiement', now()->month)->where('statut', 'valide')->sum('montant') ?? 0;
        $caAnnee = Paiement::whereYear('date_paiement', now()->year)->where('statut', 'valide')->sum('montant') ?? 0;
        
        // Nombre de commandes
        $commandesJour = Commande::whereDate('created_at', today())->count();
        $commandesMois = Commande::whereMonth('created_at', now()->month)->count();
        $commandesAnnee = Commande::whereYear('created_at', now()->year)->count();
        
        // Réservations
        $reservationsMois = Reservation::whereMonth('date_reservation', now()->month)->count();
        
        // Panier moyen
        $panierMoyen = $commandesMois > 0 ? $caMois / $commandesMois : 0;
        
        // Top plats
        $topPlats = DB::table('ligne_commandes')
            ->join('menus', 'ligne_commandes.menu_id', '=', 'menus.id')
            ->select('menus.nom', DB::raw('SUM(ligne_commandes.quantite) as total_ventes'))
            ->groupBy('menus.id', 'menus.nom')
            ->orderBy('total_ventes', 'desc')
            ->take(10)
            ->get();
        
        // Graphique CA 7 jours
        $joursSemaine = [];
        $ventesParJour = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $joursSemaine[] = $date->translatedFormat('D');
            $ventesParJour[] = Paiement::whereDate('date_paiement', $date)->where('statut', 'valide')->sum('montant') ?? 0;
        }
        
        // Modes de paiement
        $modesPaiement = Paiement::where('statut', 'valide')
            ->select('mode_paiement', DB::raw('count(*) as total'))
            ->groupBy('mode_paiement')
            ->get();
        
        // Statuts des commandes
        $statutsCommandes = Commande::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->get();
        
        return view('gerant.statistiques.index', compact(
            'caJour', 'caMois', 'caAnnee',
            'commandesJour', 'commandesMois', 'commandesAnnee',
            'reservationsMois', 'panierMoyen', 'topPlats',
            'joursSemaine', 'ventesParJour', 'modesPaiement', 'statutsCommandes'
        ));
    }
    
    public function export(Request $request)
    {
        $periode = $request->get('periode', 'mois');
        
        // Définir les dates selon la période
        switch ($periode) {
            case 'jour':
                $debut = now()->startOfDay();
                $fin = now()->endOfDay();
                $titre = "Rapport du " . now()->format('d/m/Y');
                break;
            case 'semaine':
                $debut = now()->startOfWeek();
                $fin = now()->endOfWeek();
                $titre = "Rapport de la semaine du " . $debut->format('d/m/Y') . " au " . $fin->format('d/m/Y');
                break;
            case 'mois':
                $debut = now()->startOfMonth();
                $fin = now()->endOfMonth();
                $titre = "Rapport du mois de " . now()->translatedFormat('F Y');
                break;
            case 'annee':
                $debut = now()->startOfYear();
                $fin = now()->endOfYear();
                $titre = "Rapport de l'année " . now()->format('Y');
                break;
            default:
                $debut = now()->startOfMonth();
                $fin = now()->endOfMonth();
                $titre = "Rapport du mois de " . now()->translatedFormat('F Y');
        }
        
        // Récupérer les données
        $ca = Paiement::whereBetween('date_paiement', [$debut, $fin])->where('statut', 'valide')->sum('montant') ?? 0;
        $commandes = Commande::whereBetween('created_at', [$debut, $fin])->with(['ligneCommandes.menu', 'table'])->get();
        $nbCommandes = $commandes->count();
        $panierMoyen = $nbCommandes > 0 ? $ca / $nbCommandes : 0;
        
        // Top plats
        $topPlats = DB::table('ligne_commandes')
            ->join('menus', 'ligne_commandes.menu_id', '=', 'menus.id')
            ->join('commandes', 'ligne_commandes.commande_id', '=', 'commandes.id')
            ->whereBetween('commandes.created_at', [$debut, $fin])
            ->select('menus.nom', DB::raw('SUM(ligne_commandes.quantite) as total_ventes'))
            ->groupBy('menus.id', 'menus.nom')
            ->orderBy('total_ventes', 'desc')
            ->take(10)
            ->get();
        
        // Modes de paiement
        $modesPaiement = Paiement::whereBetween('date_paiement', [$debut, $fin])
            ->where('statut', 'valide')
            ->select('mode_paiement', DB::raw('count(*) as total'), DB::raw('SUM(montant) as montant'))
            ->groupBy('mode_paiement')
            ->get();
        
        // Générer le PDF
        $pdf = Pdf::loadView('gerant.statistiques.export', compact(
            'ca', 'commandes', 'nbCommandes', 'panierMoyen', 
            'topPlats', 'modesPaiement', 'titre', 'debut', 'fin'
        ));
        
        // Télécharger le PDF
        return $pdf->download('rapport_ventes_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
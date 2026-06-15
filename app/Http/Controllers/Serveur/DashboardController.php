<?php

namespace App\Http\Controllers\Serveur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\TableResto;
use App\Models\Reservation;
use App\Models\Paiement;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques
        $commandesJour = Commande::whereDate('created_at', today())->count();
        
        // CA aujourd'hui (tous modes de paiement)
        $caJour = Paiement::whereDate('date_paiement', today())
            ->where('statut', 'valide')
            ->sum('montant');
        
        // CA par mode de paiement aujourd'hui
        $caJourAirtel = Paiement::whereDate('date_paiement', today())
            ->where('statut', 'valide')
            ->where('mode_paiement', 'airtel_money')
            ->sum('montant');
        
        $caJourOrange = Paiement::whereDate('date_paiement', today())
            ->where('statut', 'valide')
            ->where('mode_paiement', 'orange_money')
            ->sum('montant');
        
        $caJourEspeces = Paiement::whereDate('date_paiement', today())
            ->where('statut', 'valide')
            ->where('mode_paiement', 'especes')
            ->sum('montant');
        
        $caJourCarte = Paiement::whereDate('date_paiement', today())
            ->where('statut', 'valide')
            ->where('mode_paiement', 'carte')
            ->sum('montant');
        
        $caJourShwary = Paiement::whereDate('date_paiement', today())
            ->where('statut', 'valide')
            ->where('mode_paiement', 'shwary')
            ->sum('montant');
        
        // Statistiques tables
        $tablesLibres = TableResto::where('statut', 'libre')->count();
        $tablesOccupees = TableResto::where('statut', 'occupee')->count();
        $tablesReservees = TableResto::where('statut', 'reservee')->count();
        
        // Commandes en cours
        $commandesEnCours = Commande::whereIn('statut', ['en_attente', 'validee', 'en_preparation', 'pret'])
            ->with(['table', 'client', 'paiement'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Commandes prêtes
        $commandesPretes = Commande::where('statut', 'pret')
            ->with(['table', 'client', 'paiement', 'ligneCommandes.menu'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Commandes payées en ligne en attente de confirmation
        $paiementsEnLigneAttente = Paiement::where('statut', 'valide')
            ->whereIn('mode_paiement', ['shwary', 'airtel_money', 'orange_money'])
            ->whereNull('encaisse_par')
            ->with(['commande.table', 'commande.client', 'commande.ligneCommandes.menu'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Commandes des clients (panier)
        $commandesClient = Commande::whereIn('statut', ['en_attente'])
            ->whereNotNull('client_id')
            ->with(['client', 'ligneCommandes.menu'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $commandesClientEnAttente = $commandesClient->count();
        
        // Paiements récents (CORRIGÉ - sans 'client')
        $paiementsRecents = Paiement::with(['commande.table', 'encaisseur'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Réservations du jour
        $reservationsAujourdhui = Reservation::whereDate('date_reservation', today())
            ->where('statut', 'confirmee')
            ->with('table')
            ->orderBy('heure_reservation', 'asc')
            ->get();
        
        // Tables
        $tables = TableResto::orderBy('numero')->get();
        
        return view('serveur.dashboard', compact(
            'commandesJour',
            'caJour',
            'caJourAirtel',
            'caJourOrange',
            'caJourEspeces',
            'caJourCarte',
            'caJourShwary',
            'tablesLibres',
            'tablesOccupees',
            'tablesReservees',
            'commandesEnCours',
            'commandesPretes',
            'paiementsEnLigneAttente',
            'commandesClient',
            'commandesClientEnAttente',
            'paiementsRecents',
            'reservationsAujourdhui',
            'tables'
        ));
    }
    
    // Récupérer les paniers clients en AJAX
    public function getPaniersClients()
    {
        $commandesClient = Commande::whereIn('statut', ['en_attente'])
            ->whereNotNull('client_id')
            ->with(['client', 'ligneCommandes.menu'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $commandesClientEnAttente = $commandesClient->count();
        
        return response()->json([
            'html' => view('serveur.partials.paniers-clients', compact('commandesClient'))->render(),
            'commandesClientEnAttente' => $commandesClientEnAttente
        ]);
    }
}
<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use App\Models\User;
use App\Models\TableResto;
use App\Models\Reservation;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];
        
        // Données communes
        $data['totalCommandes'] = Commande::count();
        $data['chiffreAffaires'] = Paiement::where('statut', 'valide')->sum('montant');
        $data['totalClients'] = User::where('role_id', 1)->count();
        $data['noteMoyenne'] = 4.8;
        
        // Données spécifiques selon le rôle
        if ($user->isClient()) {
            $data['mesCommandes'] = Commande::where('client_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }
        
        if ($user->isServeur()) {
            $data['tables'] = TableResto::all();
            $data['commandesActives'] = Commande::whereIn('statut', ['en_attente', 'validee', 'en_preparation', 'pret'])
                ->with(['table', 'ligneCommandes'])
                ->get();
        }
        
        if ($user->isCuisinier()) {
            $data['commandesCuisine'] = Commande::where('statut', 'validee')
                ->with(['table', 'ligneCommandes.menu'])
                ->orderBy('created_at', 'asc')
                ->get();
        }
        
        if ($user->isGerant()) {
            $data['topPlats'] = DB::table('ligne_commandes')
                ->join('menus', 'ligne_commandes.menu_id', '=', 'menus.id')
                ->select('menus.nom', DB::raw('SUM(ligne_commandes.quantite) as total_ventes'))
                ->groupBy('menus.id', 'menus.nom')
                ->orderBy('total_ventes', 'desc')
                ->take(5)
                ->get();
                
            $data['joursSemaine'] = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            $data['ventesParJour'] = [];
            for ($i = 6; $i >= 0; $i--) {
                $data['ventesParJour'][] = Paiement::whereDate('date_paiement', now()->subDays($i))->sum('montant');
            }
        }
        
        if ($user->isAdmin()) {
            $data['derniersUtilisateurs'] = User::with('role')->latest()->take(5)->get();
            
            $rolesDistribution = DB::table('users')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->select('roles.slug', DB::raw('count(*) as total'))
                ->groupBy('roles.slug')
                ->get();
                
            $data['rolesLabels'] = $rolesDistribution->pluck('slug')->map(function($slug) {
                return ucfirst($slug);
            });
            $data['rolesData'] = $rolesDistribution->pluck('total');
        }
        
        return view('dashboard', $data);
    }
}
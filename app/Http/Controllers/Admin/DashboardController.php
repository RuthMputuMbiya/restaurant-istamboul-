<?php

// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Commande;
use App\Models\Reservation;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques
        $totalUsers = User::count();
        $commandesJour = Commande::whereDate('created_at', today())->count();
        $revenusMois = Paiement::whereMonth('date_paiement', now()->month)->sum('montant') ?? 0;
        $noteMoyenne = 4.8;
        
        // Dernières commandes
        $dernieresCommandes = Commande::with(['client', 'table'])
            ->latest()
            ->take(5)
            ->get();
        
        // Derniers utilisateurs
        $recentUsers = User::with('role')->latest()->take(5)->get();
        
        // Distribution des rôles
        $rolesDistribution = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('roles.slug', DB::raw('count(*) as count'))
            ->groupBy('roles.slug')
            ->get();
        
        $rolesLabels = $rolesDistribution->pluck('slug');
        $rolesData = $rolesDistribution->pluck('count');
        
        // Graphique
        $joursSemaine = [];
        $commandesParJour = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $joursSemaine[] = $date->translatedFormat('D');
            $commandesParJour[] = Commande::whereDate('created_at', $date)->count();
        }
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'commandesJour',
            'revenusMois',
            'noteMoyenne',
            'dernieresCommandes',
            'recentUsers',
            'rolesDistribution',
            'rolesLabels',
            'rolesData',
            'joursSemaine',
            'commandesParJour'
        ));
    }
}
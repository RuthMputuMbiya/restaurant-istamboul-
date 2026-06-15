<?php

// app/Http/Controllers/Client/DashboardController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Plat;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
  public function index()
    {
        $user = Auth::user();
        $userId = $user->id;
        
        // Utiliser directement user_id sans passer par Client
        $reservationsRecentes = Reservation::where('client_id', $userId)
            ->with('table')
            ->latest()
            ->limit(5)
            ->get();
        
        $commandesRecentes = Commande::where('client_id', $userId)
            ->latest()
            ->limit(5)
            ->get();
        
        $prochaineReservation = Reservation::where('client_id', $userId)
            ->where('date_reservation', '>=', date('Y-m-d'))
            ->where('statut', 'confirmee')
            ->orderBy('date_reservation', 'asc')
            ->orderBy('heure_reservation', 'asc')
            ->first();
        
        $totalCommandes = Commande::where('client_id', $userId)->count();
        $totalReservations = Reservation::where('client_id', $userId)->count();
        $totalDepense = Commande::where('client_id', $userId)->sum('montant_total');
        
        return view('client.dashboard', compact(
            'reservationsRecentes',
            'commandesRecentes',
            'prochaineReservation',
            'totalCommandes',
            'totalReservations',
            'totalDepense'
        ));
    }
}
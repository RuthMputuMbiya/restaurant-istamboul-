<?php

namespace App\Http\Controllers\Cuisinier;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $commandesValidees = Commande::where('statut', 'validee')
            ->with(['table', 'ligneCommandes.menu'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        $commandesEnPreparation = Commande::where('statut', 'en_preparation')
            ->with(['table', 'ligneCommandes.menu'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        $commandesPretes = Commande::where('statut', 'pret')
            ->with(['table', 'ligneCommandes.menu'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('cuisinier.dashboard', compact('commandesValidees', 'commandesEnPreparation', 'commandesPretes'));
    }
}
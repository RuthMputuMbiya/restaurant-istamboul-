<?php

namespace App\Http\Controllers\Cuisinier;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function index(Request $request)
    {
        $statut = $request->get('statut', 'en_attente');
        
        $commandes = Commande::where('statut', $statut)
            ->with(['table', 'ligneCommandes.menu'])
            ->orderBy('created_at', 'asc')
            ->get();  // Utilisez get() au lieu de paginate()
        
        return view('cuisinier.commandes.index', compact('commandes', 'statut'));
    }
    
    public function demarrerPreparation(Commande $commande)
    {
        if ($commande->statut !== 'validee' && $commande->statut !== 'en_attente') {
            return redirect()->back()->with('error', 'Cette commande ne peut pas être démarrée.');
        }
        
        DB::beginTransaction();
        
        try {
            $commande->update(['statut' => 'en_preparation']);
            
            foreach ($commande->ligneCommandes as $ligne) {
                $ligne->update(['statut' => 'en_preparation']);
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Préparation commencée.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors du démarrage.');
        }
    }
    
    public function marquerPret(Commande $commande)
    {
        if ($commande->statut !== 'en_preparation') {
            return redirect()->back()->with('error', 'Cette commande n\'est pas en préparation.');
        }
        
        DB::beginTransaction();
        
        try {
            $commande->update(['statut' => 'pret']);
            
            foreach ($commande->ligneCommandes as $ligne) {
                $ligne->update(['statut' => 'pret']);
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Commande marquée comme prête.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors du marquage.');
        }
    }
    
    public function show(Commande $commande)
    {
        $commande->load(['ligneCommandes.menu', 'table', 'client']);
        
        return view('cuisinier.commandes.show', compact('commande'));
    }
}
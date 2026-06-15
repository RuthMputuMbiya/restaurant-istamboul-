<?php

namespace App\Http\Controllers\Serveur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{
    public function index()
    {
        $paiementsEnAttente = Paiement::where('statut', 'valide')
            ->whereIn('mode_paiement', ['shwary', 'airtel_money', 'orange_money'])
            ->with(['commande.table', 'commande.client', 'commande.ligneCommandes.menu'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $commandesNonPayees = Commande::whereIn('statut', ['pret', 'servi', 'en_attente', 'validee'])
            ->whereDoesntHave('paiement', function($q) {
                $q->where('statut', 'valide');
            })
            ->with(['table', 'ligneCommandes.menu', 'client'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        $paiementsRecents = Paiement::with(['commande.table', 'encaisseur', 'commande.client'])
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();
        
        return view('serveur.paiement.index', compact('paiementsEnAttente', 'commandesNonPayees', 'paiementsRecents'));
    }
    
    public function show(Commande $commande)
    {
        $commande->load(['ligneCommandes.menu', 'table', 'client', 'paiement']);
        
        return view('serveur.paiement.show', compact('commande'));
    }
    
    public function confirmerPaiementEnLigne(Paiement $paiement)
    {
        if ($paiement->statut !== 'valide') {
            return redirect()->back()->with('error', 'Ce paiement n\'est pas valide.');
        }
        
        DB::beginTransaction();
        
        try {
            $commande = $paiement->commande;
            
            $paiement->update([
                'encaisse_par' => Auth::id(),
                'date_paiement' => now()
            ]);
            
            $commande->update(['statut' => 'en_preparation']);
            
            if ($commande->table_id) {
                $commande->table->update(['statut' => 'libre']);
            }
            
            DB::commit();
            
            return redirect()->route('serveur.paiement.index')
                ->with('success', 'Paiement confirmé. Commande envoyée en cuisine.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la confirmation.');
        }
    }
    
    public function process(Request $request, Commande $commande)
    {
        $request->validate([
            'mode_paiement' => 'required|in:especes,airtel_money,orange_money,carte',
            'montant_recu' => 'required_if:mode_paiement,especes|nullable|numeric|min:0',
            'numero_telephone' => 'required_if:mode_paiement,airtel_money,orange_money|nullable|string|min:9|max:10'
        ]);
        
        if ($commande->paiement && $commande->paiement->statut === 'valide') {
            return redirect()->back()->with('error', 'Cette commande est déjà payée.');
        }
        
        DB::beginTransaction();
        
        try {
            $montantTotal = $commande->montant_total;
            $reference = $this->genererReference($request->mode_paiement);
            
            $paiement = Paiement::create([
                'commande_id' => $commande->id,
                'client_id' => $commande->client_id,
                'montant' => $montantTotal,
                'mode_paiement' => $request->mode_paiement,
                'numero_telephone' => $request->numero_telephone,
                'reference' => $reference,
                'statut' => 'valide',
                'encaisse_par' => Auth::id(),
                'date_paiement' => now()
            ]);
            
            $commande->update(['statut' => 'en_preparation']);
            
            if ($commande->table_id) {
                $commande->table->update(['statut' => 'libre']);
            }
            
            DB::commit();
            
            $monnaie = null;
            if ($request->mode_paiement === 'especes' && $request->montant_recu) {
                $monnaie = $request->montant_recu - $montantTotal;
            }
            
            return redirect()->route('serveur.paiement.recu', $commande)
                ->with('success', 'Paiement effectué avec succès.')
                ->with('monnaie', $monnaie);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors du paiement: ' . $e->getMessage());
        }
    }
    
    public function recu(Commande $commande)
    {
        // Charger toutes les relations, y compris le paiement avec numero_telephone
        $commande->load(['ligneCommandes.menu', 'table', 'client', 'serveur', 'paiement']);
        
        return view('serveur.paiement.recu', compact('commande'));
    }
    
    public function downloadRecu(Commande $commande)
    {
        $commande->load(['ligneCommandes.menu', 'table', 'paiement']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('serveur.paiement.pdf', compact('commande'));
        
        return $pdf->download('recu_commande_' . $commande->id . '.pdf');
    }
    
    private function genererReference($mode)
    {
        $prefix = [
            'especes' => 'ESP',
            'airtel_money' => 'AIR',
            'orange_money' => 'ORG',
            'carte' => 'CB'
        ][$mode] ?? 'PAY';
        
        return $prefix . '_' . date('YmdHis') . '_' . rand(1000, 9999);
    }
}
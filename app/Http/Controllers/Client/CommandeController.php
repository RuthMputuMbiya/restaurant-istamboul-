<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Menu;
use App\Models\TableResto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommandeController extends Controller
{
    // Afficher la liste des commandes du client
    public function index()
    {
        $commandes = Commande::where('client_id', Auth::id())
            ->whereIn('statut', ['en_attente', 'validee', 'en_preparation', 'pret', 'servi', 'paye', 'recuperee'])
            ->with(['table', 'ligneCommandes.menu'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('client.commandes.index', compact('commandes'));
    }
    
    // Afficher les détails d'une commande
    public function show(Commande $commande)
    {
        if ($commande->client_id != Auth::id()) {
            abort(403);
        }
        
        $commande->load(['ligneCommandes.menu', 'table', 'paiement']);
        
        return view('client.commandes.show', compact('commande'));
    }
    
    // Afficher le panier
    public function panier()
    {
        $commande = Commande::where('client_id', Auth::id())
            ->where('statut', 'panier')
            ->first();
        
        $plats = [];
        $total = 0;
        
        if ($commande) {
            $lignes = LigneCommande::where('commande_id', $commande->id)
                ->with('menu')
                ->get();
            
            foreach ($lignes as $ligne) {
                $sousTotal = $ligne->quantite * $ligne->prix_unitaire;
                $total += $sousTotal;
                $plats[] = [
                    'id' => $ligne->id,
                    'menu' => $ligne->menu,
                    'quantite' => $ligne->quantite,
                    'prix_unitaire' => $ligne->prix_unitaire,
                    'sous_total' => $sousTotal
                ];
            }
        }
        
        $tables = TableResto::where('statut', 'libre')->get();
        
        return view('client.panier', compact('plats', 'total', 'tables', 'commande'));
    }
    
    // Ajouter au panier
    public function ajouterAuPanier(Request $request)
    {
        Log::info('Ajout au panier - Données reçues:', $request->all());
        
        try {
            $request->validate([
                'menu_id' => 'required|exists:menus,id',
                'quantite' => 'required|integer|min:1'
            ]);
            
            $menu = Menu::findOrFail($request->menu_id);
            
            DB::beginTransaction();
            
            $commande = Commande::firstOrCreate(
                [
                    'client_id' => Auth::id(),
                    'statut' => 'panier'
                ],
                [
                    'montant_total' => 0,
                    'numero_commande' => 'PAN-' . date('Ymd') . '-' . Auth::id()
                ]
            );
            
            $ligne = LigneCommande::where('commande_id', $commande->id)
                ->where('menu_id', $request->menu_id)
                ->first();
            
            if ($ligne) {
                $ligne->increment('quantite', $request->quantite);
            } else {
                LigneCommande::create([
                    'commande_id' => $commande->id,
                    'menu_id' => $request->menu_id,
                    'quantite' => $request->quantite,
                    'prix_unitaire' => $menu->prix,
                    'statut' => 'en_attente'
                ]);
            }
            
            $total = LigneCommande::where('commande_id', $commande->id)
                ->sum(DB::raw('quantite * prix_unitaire'));
            $commande->update(['montant_total' => $total]);
            
            DB::commit();
            
            $cartCount = LigneCommande::where('commande_id', $commande->id)->count();
            
            return response()->json([
                'success' => true,
                'message' => $menu->nom . ' ajouté au panier',
                'cart_count' => $cartCount,
                'cart_total' => number_format($total, 0, ',', ' ') . ' FC'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur ajout panier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Mettre à jour la quantité
    public function updateQuantite(Request $request)
    {
        $request->validate([
            'ligne_id' => 'required|exists:ligne_commandes,id',
            'quantite' => 'required|integer|min:0'
        ]);
        
        $ligne = LigneCommande::findOrFail($request->ligne_id);
        
        if ($ligne->commande->client_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }
        
        DB::beginTransaction();
        
        try {
            if ($request->quantite == 0) {
                $ligne->delete();
            } else {
                $ligne->update(['quantite' => $request->quantite]);
            }
            
            $commande = $ligne->commande;
            $total = LigneCommande::where('commande_id', $commande->id)
                ->sum(DB::raw('quantite * prix_unitaire'));
            $commande->update(['montant_total' => $total]);
            
            DB::commit();
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Erreur'], 500);
        }
    }
    
    // Retirer du panier
    public function retirerDuPanier($id)
    {
        $ligne = LigneCommande::findOrFail($id);
        
        if ($ligne->commande->client_id != Auth::id()) {
            abort(403);
        }
        
        DB::beginTransaction();
        
        try {
            $ligne->delete();
            
            $commande = $ligne->commande;
            $total = LigneCommande::where('commande_id', $commande->id)
                ->sum(DB::raw('quantite * prix_unitaire'));
            $commande->update(['montant_total' => $total]);
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Produit retiré du panier');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la suppression');
        }
    }
    
    // Vider le panier
    public function viderPanier()
    {
        $commande = Commande::where('client_id', Auth::id())
            ->where('statut', 'panier')
            ->first();
        
        if ($commande) {
            DB::beginTransaction();
            try {
                LigneCommande::where('commande_id', $commande->id)->delete();
                $commande->update(['montant_total' => 0]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }
        
        return redirect()->back()->with('success', 'Panier vidé');
    }
    
    // Passer commande
    public function passerCommande(Request $request)
    {
        $commande = Commande::where('client_id', Auth::id())
            ->where('statut', 'panier')
            ->first();
        
        if (!$commande || $commande->ligneCommandes->count() == 0) {
            return redirect()->back()->with('error', 'Votre panier est vide');
        }
        
        DB::beginTransaction();
        
        try {
            $updateData = [
                'statut' => 'en_attente',
                'numero_commande' => 'CMD-' . date('Ymd') . '-' . $commande->id,
                'notes' => $request->notes
            ];
            
            if ($request->has('table_id') && $request->table_id) {
                $updateData['table_id'] = $request->table_id;
                $table = TableResto::find($request->table_id);
                if ($table && $table->statut == 'libre') {
                    $table->update(['statut' => 'occupee']);
                }
            }
            
            $commande->update($updateData);
            
            DB::commit();
            
            return redirect()->route('client.paiement.index')
                ->with('success', 'Commande créée! Veuillez procéder au paiement.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la création');
        }
    }
    
    // Annuler une commande
    public function annuler($id)
    {
        $commande = Commande::where('id', $id)->where('client_id', Auth::id())->first();
        
        if (!$commande) {
            return response()->json(['success' => false, 'message' => 'Commande non trouvée'], 404);
        }
        
        if (!in_array($commande->statut, ['en_attente', 'validee'])) {
            return response()->json(['success' => false, 'message' => 'Cette commande ne peut plus être annulée'], 400);
        }
        
        $commande->update(['statut' => 'annulee']);
        
        if ($commande->table_id) {
            $table = TableResto::find($commande->table_id);
            if ($table) {
                $table->update(['statut' => 'libre']);
            }
        }
        
        return response()->json(['success' => true]);
    }
    
    // Récupérer le nombre d'articles dans le panier
    public function getPanierCount()
    {
        $commande = Commande::where('client_id', Auth::id())
            ->where('statut', 'panier')
            ->first();
        
        $count = 0;
        if ($commande) {
            $count = LigneCommande::where('commande_id', $commande->id)->count();
        }
        
        return response()->json(['count' => $count]);
    }
    
    // NOUVELLE MÉTHODE : Confirmer la récupération d'une commande
    public function confirmerRecuperation($id)
    {
        $commande = Commande::where('id', $id)
            ->where('client_id', Auth::id())
            ->where('statut', 'pret')
            ->first();
        
        if (!$commande) {
            return response()->json(['success' => false, 'message' => 'Commande non trouvée'], 404);
        }
        
        DB::beginTransaction();
        
        try {
            // Marquer la commande comme récupérée
            $commande->update(['statut' => 'recuperee']);
            
            // Libérer la table
            if ($commande->table_id) {
                $table = TableResto::find($commande->table_id);
                if ($table) {
                    $table->update(['statut' => 'libre']);
                }
            }
            
            DB::commit();
            
            return response()->json(['success' => true, 'message' => 'Commande récupérée avec succès']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }
}
<?php

namespace App\Http\Controllers\Serveur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\TableResto;
use App\Models\Menu;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    // Afficher la liste des commandes
    public function index()
    {
        $commandes = Commande::with(['table', 'client', 'serveur'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('serveur.commandes.index', compact('commandes'));
    }
    
    // Formulaire de création de commande
    public function create(Request $request)
    {
        $table_id = $request->get('table_id');
        $tables = TableResto::orderBy('numero')->get();
        $menus = Menu::where('est_disponible', true)->get();
        $tableSelectionnee = $table_id ? TableResto::find($table_id) : null;
        
        return view('serveur.commandes.create', compact('tables', 'menus', 'tableSelectionnee'));
    }
    
    // Enregistrer une nouvelle commande
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables_resto,id',
            'plats' => 'required|array|min:1',
            'plats.*.menu_id' => 'required|exists:menus,id',
            'plats.*.quantite' => 'required|integer|min:1'
        ]);
        
        DB::beginTransaction();
        
        try {
            // Créer la commande
            $commande = Commande::create([
                'table_id' => $request->table_id,
                'serveur_id' => Auth::id(),
                'client_id' => null,
                'client_nom' => $request->client_nom,
                'type_commande' => $request->type_commande ?? 'sur_place',
                'statut' => 'en_attente',
                'montant_total' => 0,
                'numero_commande' => 'CMD-' . date('Ymd') . '-' . rand(1000, 9999),
                'notes' => $request->notes
            ]);
            
            // Ajouter les plats
            foreach ($request->plats as $plat) {
                $menu = Menu::find($plat['menu_id']);
                
                LigneCommande::create([
                    'commande_id' => $commande->id,
                    'menu_id' => $plat['menu_id'],
                    'quantite' => $plat['quantite'],
                    'prix_unitaire' => $menu->prix,
                    'instructions' => $plat['instructions'] ?? null,
                    'statut' => 'en_attente'
                ]);
            }
            
            // Recalculer le total
            $total = LigneCommande::where('commande_id', $commande->id)
                ->sum(DB::raw('quantite * prix_unitaire'));
            $commande->update(['montant_total' => $total]);
            
            // Mettre à jour le statut de la table
            $table = TableResto::find($request->table_id);
            if ($table && $table->statut == 'libre') {
                $table->update(['statut' => 'occupee']);
            }
            
            DB::commit();
            
            return redirect()->route('serveur.commandes.show', $commande->id)
                ->with('success', 'Commande créée avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la création: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    // Afficher les détails d'une commande
    public function show($id)
    {
        $commande = Commande::with(['table', 'client', 'serveur', 'ligneCommandes.menu'])
            ->findOrFail($id);
        
        return view('serveur.commandes.show', compact('commande'));
    }
    
    // Valider une commande
    public function valider(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        
        if ($commande->statut !== 'en_attente') {
            return redirect()->back()->with('error', 'Cette commande ne peut pas être validée.');
        }
        
        $commande->update(['statut' => 'validee']);
        
        return redirect()->back()->with('success', 'Commande validée avec succès.');
    }
    
    // Envoyer la commande en cuisine
    public function envoyerCuisine($id)
    {
        $commande = Commande::findOrFail($id);
        
        if ($commande->statut !== 'validee') {
            return redirect()->back()->with('error', 'Veuillez d\'abord valider la commande.');
        }
        
        DB::beginTransaction();
        
        try {
            $commande->update(['statut' => 'en_preparation']);
            
            foreach ($commande->ligneCommandes as $ligne) {
                $ligne->update(['statut' => 'en_preparation']);
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Commande envoyée en cuisine.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l\'envoi.');
        }
    }
    
    // Servir une commande
    public function servir(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        
        if ($commande->statut !== 'pret') {
            return redirect()->back()->with('error', 'Cette commande n\'est pas encore prête.');
        }
        
        DB::beginTransaction();
        
        try {
            $commande->update(['statut' => 'servi']);
            
            // Libérer la table
            if ($commande->table_id) {
                $table = TableResto::find($commande->table_id);
                if ($table) {
                    $table->update(['statut' => 'libre']);
                }
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Commande servie avec succès.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors du service.');
        }
    }
    
    // Afficher l'addition
    public function addition($id)
    {
        $commande = Commande::with(['ligneCommandes.menu', 'table', 'client'])
            ->findOrFail($id);
        
        return view('serveur.commandes.addition', compact('commande'));
    }
}
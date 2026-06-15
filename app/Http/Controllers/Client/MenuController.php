<?php
// app/Http/Controllers/Client/MenuController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Afficher la page du menu
     */
    public function index()
    {
        // Récupérer toutes les catégories
        $categories = Categorie::orderBy('ordre')->get();
        
        // Récupérer tous les plats disponibles
        $menus = Menu::where('est_disponible', true)
            ->with('categorie')
            ->orderBy('nom')
            ->paginate(12);
        
        // Récupérer les plats populaires
        $platsPopulaires = Menu::where('est_populaire', true)
            ->where('est_disponible', true)
            ->limit(6)
            ->get();
        
        return view('client.menu.index', compact('categories', 'menus', 'platsPopulaires'));
    }
    
    /**
     * Rechercher un plat
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        $menus = Menu::where('est_disponible', true)
            ->where('nom', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->with('categorie')
            ->paginate(12);
        
        $categories = Categorie::orderBy('ordre')->get();
        $platsPopulaires = Menu::where('est_populaire', true)
            ->where('est_disponible', true)
            ->limit(6)
            ->get();
        
        if ($request->ajax()) {
            return response()->json([
                'menus' => view('client.menu.partials.menu_list', compact('menus'))->render()
            ]);
        }
        
        return view('client.menu.index', compact('categories', 'menus', 'platsPopulaires'));
    }
    
    /**
     * Filtrer par catégorie
     */
    public function filtreParCategorie($slug)
    {
        $categorie = Categorie::where('slug', $slug)->firstOrFail();
        
        $menus = Menu::where('est_disponible', true)
            ->where('categorie_id', $categorie->id)
            ->with('categorie')
            ->paginate(12);
        
        $categories = Categorie::orderBy('ordre')->get();
        $platsPopulaires = Menu::where('est_populaire', true)
            ->where('est_disponible', true)
            ->limit(6)
            ->get();
        
        return view('client.menu.index', compact('categories', 'menus', 'platsPopulaires', 'categorie'));
    }
    
    /**
     * Afficher les détails d'un plat
     */
    public function show($slug)
    {
        $menu = Menu::where('slug', $slug)
            ->where('est_disponible', true)
            ->with('categorie')
            ->firstOrFail();
        
        // Plats similaires (même catégorie)
        $similaires = Menu::where('categorie_id', $menu->categorie_id)
            ->where('id', '!=', $menu->id)
            ->where('est_disponible', true)
            ->limit(4)
            ->get();
        
        return view('client.menu.show', compact('menu', 'similaires'));
    }
}
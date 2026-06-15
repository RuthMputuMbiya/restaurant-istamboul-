<?php
// app/Http/Controllers/Gerant/MenuController.php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Categorie::with('menus')->get();
        return view('gerant.menu.index', compact('categories'));
    }
    
    public function create()
    {
        $categories = Categorie::all();
        return view('gerant.menu.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Générer un slug unique
        $slug = Str::slug($request->nom);
        $originalSlug = $slug;
        $count = 1;
        
        while (Menu::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        $data = [
            'categorie_id' => $request->categorie_id,
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description,
            'prix' => $request->prix,
            'image' => $imagePath,
            'temps_preparation' => $request->temps_preparation ?? 15,
            'est_disponible' => $request->has('est_disponible'),
            'est_populaire' => $request->has('est_populaire'),
        ];
        
        // Ajouter prix_usd seulement si la colonne existe
        if (Schema::hasColumn('menus', 'prix_usd')) {
            $data['prix_usd'] = $request->prix_usd;
        }

        Menu::create($data);

        return redirect()->route('gerant.menu.index')
            ->with('success', 'Plat ajouté avec succès');
    }
    
    public function edit(Menu $menu)
    {
        $categories = Categorie::all();
        return view('gerant.menu.edit', compact('menu', 'categories'));
    }
    
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Gérer l'image
        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $imagePath = $request->file('image')->store('menus', 'public');
            $menu->image = $imagePath;
        }

        // Générer un nouveau slug unique si le nom a changé
        $slug = $menu->slug;
        if ($menu->nom !== $request->nom) {
            $slug = Str::slug($request->nom);
            $originalSlug = $slug;
            $count = 1;
            
            while (Menu::where('slug', $slug)->where('id', '!=', $menu->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $data = [
            'categorie_id' => $request->categorie_id,
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description,
            'prix' => $request->prix,
            'temps_preparation' => $request->temps_preparation ?? 15,
            'est_disponible' => $request->has('est_disponible'),
            'est_populaire' => $request->has('est_populaire'),
        ];
        
        // Ajouter prix_usd seulement si la colonne existe
        if (Schema::hasColumn('menus', 'prix_usd')) {
            $data['prix_usd'] = $request->prix_usd;
        }

        $menu->update($data);

        return redirect()->route('gerant.menu.index')
            ->with('success', 'Plat modifié avec succès');
    }
    
    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
        $menu->delete();
        return redirect()->route('gerant.menu.index')
            ->with('success', 'Plat supprimé avec succès');
    }
    
    public function toggleDisponible(Menu $menu)
    {
        $menu->update(['est_disponible' => !$menu->est_disponible]);
        $status = $menu->est_disponible ? 'disponible' : 'indisponible';
        return redirect()->back()->with('success', "Le plat est maintenant {$status}");
    }
}
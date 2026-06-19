<?php
// app/Http/Controllers/Gerant/CategorieController.php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('menus')->orderBy('ordre')->get();
        return view('gerant.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('gerant.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:categories,nom|max:255',
            'description' => 'nullable|string',
            'ordre' => 'nullable|integer'
        ]);

        Categorie::create([
            'nom' => $request->nom,
            'slug' => Str::slug($request->nom),
            'description' => $request->description,
            'ordre' => $request->ordre ?? 0,
        ]);

        return redirect()->route('gerant.categories.index')
            ->with('success', 'Catégorie créée avec succès');
    }

    // CORRIGÉ : Utiliser 'Categorie $category' pour correspondre à la route
    public function edit(Categorie $category)
    {
        return view('gerant.categories.edit', compact('category'));
    }

    // CORRIGÉ : Utiliser 'Categorie $category' pour correspondre à la route
    public function update(Request $request, Categorie $category)
    {
        $request->validate([
            'nom' => 'required|unique:categories,nom,' . $category->id . '|max:255',
            'description' => 'nullable|string',
            'ordre' => 'nullable|integer'
        ]);

        $category->update([
            'nom' => $request->nom,
            'slug' => Str::slug($request->nom),
            'description' => $request->description,
            'ordre' => $request->ordre ?? 0,
        ]);

        return redirect()->route('gerant.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès');
    }

    public function destroy(Categorie $category)
    {
        try {
            // Vérifier si la catégorie a des plats
            if ($category->menus()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer cette catégorie car elle contient ' . $category->menus()->count() . ' plat(s)'
                ], 400);
            }

            $category->delete();
            return response()->json(['success' => true, 'message' => 'Catégorie supprimée avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression: ' . $e->getMessage()], 500);
        }
    }
}

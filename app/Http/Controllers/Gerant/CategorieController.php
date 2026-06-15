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
        $categories = Categorie::withCount('menus')->get();
        return view('gerant.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('gerant.categories.create');
    }
    public function store(Request $request)
    {
        Categorie::create([
            'nom' => $request->nom,
            'slug' => Str::slug($request->nom),
            'description' => $request->description,
            'ordre' => $request->ordre ?? 0,
        ]);
        return redirect()->route('gerant.categories.index');
    }
    public function edit(Categorie $categorie)
    {
        return view('gerant.categories.edit', compact('categorie'));
    }
    public function update(Request $request, Categorie $categorie)
    {
        $categorie->update($request->all());
        return redirect()->route('gerant.categories.index');
    }
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();
        return redirect()->route('gerant.categories.index');
    }
}
<?php
// app/Http/Controllers/GerantController.php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Menu;
use App\Models\TableResto;
use App\Models\Reservation;
use Illuminate\Http\Request;

class GerantController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        return view('gerant.dashboard');
    }
    
    // Menu
    public function menuIndex()
    {
        $categories = Categorie::with('menus')->get();
        return view('gerant.menu.index', compact('categories'));
    }
    
    public function menuCreate()
    {
        $categories = Categorie::all();
        return view('gerant.menu.create', compact('categories'));
    }
    
    public function menuEdit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Categorie::all();
        return view('gerant.menu.edit', compact('menu', 'categories'));
    }
    
    // Catégories
    public function categoriesIndex()
    {
        $categories = Categorie::withCount('menus')->get();
        return view('gerant.categories.index', compact('categories'));
    }
    
    public function categoriesCreate()
    {
        return view('gerant.categories.create');
    }
    
    public function categoriesEdit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('gerant.categories.edit', compact('categorie'));
    }
    
    // Tables
    public function tablesIndex()
    {
        $tables = TableResto::all();
        return view('gerant.tables.index', compact('tables'));
    }
    
    public function tablesCreate()
    {
        return view('gerant.tables.create');
    }
    
    public function tablesEdit($id)
    {
        $table = TableResto::findOrFail($id);
        return view('gerant.tables.edit', compact('table'));
    }
    
    // Statistiques
    public function statistiques()
    {
        return view('gerant.statistiques.index');
    }
    
    public function export()
    {
        return view('gerant.statistiques.export');
    }
    
    // Réservations
    public function reservations()
    {
        $reservations = Reservation::with(['client', 'table'])->get();
        return view('gerant.reservations.index', compact('reservations'));
    }
}
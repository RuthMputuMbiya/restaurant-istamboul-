<?php
// app/Http/Controllers/Gerant/TableController.php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\TableResto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TableController extends Controller
{
     public function index()
    {
        $tables = TableResto::orderBy('numero')->get();
        return view('gerant.tables.index', compact('tables'));
    }
    
    public function create()
    {
        return view('gerant.tables.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:10|unique:tables_resto,numero',
            'capacite' => 'required|integer|min:1|max:20',
            'zone' => 'required|in:interieur,terrasse,salon',
        ]);

        TableResto::create([
            'numero' => $request->numero,
            'capacite' => $request->capacite,
            'zone' => $request->zone,
            'statut' => 'libre',
            'est_active' => true,
        ]);

        return redirect()->route('gerant.tables.index')
            ->with('success', 'Table ajoutée avec succès');
    }
    
    public function edit(TableResto $table)
    {
        return view('gerant.tables.edit', compact('table'));
    }
    
    public function update(Request $request, TableResto $table)
    {
        $request->validate([
            'numero' => 'required|string|max:10|unique:tables_resto,numero,' . $table->id,
            'capacite' => 'required|integer|min:1|max:20',
            'zone' => 'required|in:interieur,terrasse,salon',
        ]);

        $table->update([
            'numero' => $request->numero,
            'capacite' => $request->capacite,
            'zone' => $request->zone,
        ]);

        return redirect()->route('gerant.tables.index')
            ->with('success', 'Table modifiée avec succès');
    }
    
    public function destroy(TableResto $table)
    {
        $table->delete();
        return redirect()->route('gerant.tables.index')
            ->with('success', 'Table supprimée avec succès');
    }
    
    // MÉTHODE POUR ACTIVER/DÉSACTIVER
    public function toggleActive(TableResto $table)
    {
        $table->update(['est_active' => !$table->est_active]);
        $status = $table->est_active ? 'activée' : 'désactivée';
        
        return redirect()->back()->with('success', "Table {$status} avec succès");
    }
}
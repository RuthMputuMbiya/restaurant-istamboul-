<?php

namespace App\Http\Controllers\Serveur;

use App\Http\Controllers\Controller;
use App\Models\TableResto;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = TableResto::orderBy('numero')->get();
        return view('serveur.tables.index', compact('tables'));
    }
    
    public function changerStatut(Request $request, $id) {}
}
<?php
// app/Http/Controllers/Admin/CommandeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['table', 'client'])->latest()->paginate(20);
        return view('admin.commandes.index', compact('commandes'));
    }
    
    public function show(Commande $commande)
    {
        return view('admin.commandes.show', compact('commande'));
    }
}
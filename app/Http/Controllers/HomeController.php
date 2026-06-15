<?php
// app/Http/Controllers/Client/HomeController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Categorie::orderBy('ordre')->get();
        $products = Menu::where('est_disponible', true)->get();
        
        return view('client.home', compact('categories', 'products'));
    }
}
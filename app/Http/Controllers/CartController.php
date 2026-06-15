<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Ajouter un plat au panier
     */
    public function add(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantite' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart', []);
        $menuId = $request->menu_id;
        $quantite = $request->quantite;
        $instructions = $request->instructions;

        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantite'] += $quantite;
        } else {
            $menu = Menu::find($menuId);
            $cart[$menuId] = [
                'id' => $menu->id,
                'nom' => $menu->nom,
                'prix' => $menu->prix,
                'quantite' => $quantite,
                'image' => $menu->image,
                'instructions' => $instructions
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Plat ajouté au panier',
            'count' => $this->getTotalCount($cart)
        ]);
    }

    /**
     * Compter les articles dans le panier
     */
    public function count()
    {
        $cart = Session::get('cart', []);
        $count = $this->getTotalCount($cart);
        return response()->json(['count' => $count]);
    }

    /**
     * Récupérer tous les articles du panier
     */
    public function items()
    {
        $cart = Session::get('cart', []);
        $items = array_values($cart);
        return response()->json(['items' => $items, 'total' => $this->getTotalPrice($cart)]);
    }

    /**
     * Mettre à jour la quantité d'un article (utilise key ou menu_id)
     */
    public function update(Request $request)
    {
        $cart = Session::get('cart', []);
        
        // Support pour key (index) ou menu_id
        if ($request->has('key')) {
            $key = $request->key;
            $cartItems = array_values($cart);
            if (isset($cartItems[$key])) {
                $menuId = $cartItems[$key]['id'];
                $cart[$menuId]['quantite'] = $request->quantite;
                Session::put('cart', $cart);
                return response()->json(['success' => true]);
            }
        } 
        elseif ($request->has('menu_id')) {
            $request->validate([
                'menu_id' => 'required|exists:menus,id',
                'quantite' => 'required|integer|min:1'
            ]);
            $menuId = $request->menu_id;
            if (isset($cart[$menuId])) {
                $cart[$menuId]['quantite'] = $request->quantite;
                Session::put('cart', $cart);
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Article non trouvé'], 404);
    }

    /**
     * Supprimer un article du panier (utilise key ou menu_id)
     */
    public function remove(Request $request)
    {
        $cart = Session::get('cart', []);
        
        // Support pour key (index) ou menu_id
        if ($request->has('key')) {
            $key = $request->key;
            $cartItems = array_values($cart);
            if (isset($cartItems[$key])) {
                $menuId = $cartItems[$key]['id'];
                unset($cart[$menuId]);
                Session::put('cart', $cart);
                return response()->json(['success' => true]);
            }
        }
        elseif ($request->has('menu_id')) {
            $request->validate([
                'menu_id' => 'required|exists:menus,id'
            ]);
            $menuId = $request->menu_id;
            if (isset($cart[$menuId])) {
                unset($cart[$menuId]);
                Session::put('cart', $cart);
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Article non trouvé'], 404);
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        Session::forget('cart');
        return response()->json(['success' => true, 'message' => 'Panier vidé']);
    }

    /**
     * Calculer le nombre total d'articles
     */
    private function getTotalCount($cart)
    {
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantite'];
        }
        return $count;
    }

    /**
     * Calculer le prix total du panier
     */
    private function getTotalPrice($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        return $total;
    }
}
<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ClientProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('client.profil', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
        ]);
        
        $user->update($request->only('name', 'email', 'telephone'));
        
        return redirect()->route('client.profil')->with('success', 'Profil mis à jour');
    }
}
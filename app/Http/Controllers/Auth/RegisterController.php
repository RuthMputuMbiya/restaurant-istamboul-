<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        // Si déjà connecté, rediriger
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.register');
    }
    
    /**
     * Traiter l'inscription d'un nouveau client
     */
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        
        try {
            // Récupérer l'ID du rôle client
            $clientRoleId = Role::where('slug', 'client')->value('id');
            
            // Créer le nouvel utilisateur (client)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'role_id' => $clientRoleId,
                'est_actif' => true,
                'email_verified_at' => now()
            ]);
            
            DB::commit();
            
            // Connecter automatiquement l'utilisateur après inscription
            Auth::login($user);
            
            // Rediriger vers le dashboard client
            return redirect()->route('client.dashboard')
                ->with('success', 'Bienvenue chez ISTAMBOUL ! Votre compte a été créé avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.')
                ->withInput();
        }
    }
    
    /**
     * Vérifier si l'email existe déjà (AJAX)
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        
        $exists = User::where('email', $request->email)->exists();
        
        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Cet email est déjà utilisé.' : 'Email disponible.'
        ]);
    }
    
    /**
     * Vérifier si le téléphone existe déjà (AJAX)
     */
    public function checkTelephone(Request $request)
    {
        $request->validate([
            'telephone' => 'required|string|min:9'
        ]);
        
        $exists = User::where('telephone', $request->telephone)->exists();
        
        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Ce numéro est déjà utilisé.' : 'Numéro disponible.'
        ]);
    }
}
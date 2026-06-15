<?php

// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        // Si déjà connecté, rediriger vers le dashboard approprié
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        
        return view('auth.login');
    }
    
    /**
     * Traiter la tentative de connexion
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');
        
        // Vérifier les identifiants
        if (Auth::attempt($credentials, $remember)) {
            
            $user = Auth::user();
            
            // Vérifier si le compte est actif
            if (!$user->est_actif) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Votre compte a été désactivé. Veuillez contacter l\'administrateur.');
            }
            
            // Régénérer la session pour sécurité
            $request->session()->regenerate();
            
            // Enregistrer la dernière connexion
            $user->update(['last_login_at' => now()]);
            
            // Rediriger vers le dashboard selon le rôle
            return $this->redirectToDashboard();
        }
        
        // Échec de connexion
        return redirect()->route('login')
            ->with('error', 'Email ou mot de passe incorrect.')
            ->withInput($request->only('email'));
    }
    
    /**
     * Rediriger l'utilisateur vers son dashboard selon son rôle
     */
    protected function redirectToDashboard()
    {
        $user = Auth::user();
        
        if ($user->isClient()) {
            return redirect()->route('client.dashboard');
        }
        
        if ($user->isServeur()) {
            return redirect()->route('serveur.dashboard');
        }
        
        if ($user->isCuisinier()) {
            return redirect()->route('cuisinier.dashboard');
        }
        
        if ($user->isGerant()) {
            return redirect()->route('gerant.dashboard');
        }
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect('/');
    }
    
    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
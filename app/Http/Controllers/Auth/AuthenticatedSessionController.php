<?php

// app/Http/Controllers/Auth/AuthenticatedSessionController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{

    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email ou mot de passe incorrect.',
            ]);
        }

        $user = Auth::user();

        // Vérifier si le compte est actif
        if (!$user->est_actif) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
            ]);
        }

        $request->session()->regenerate();

        // Redirection SIMPLE selon le rôle - SANS VÉRIFICATION
        if ($user->isClient()) {
            return redirect('/client/dashboard');
        }
        
        if ($user->isServeur()) {
            return redirect('/serveur/dashboard');
        }
        
        if ($user->isCuisinier()) {
            return redirect('/cuisinier/dashboard');
        }
        
        if ($user->isGerant()) {
            return redirect('/gerant/dashboard');
        }
        
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard');
        }

        return redirect('/');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 🔒 Vérifier connexion
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 🔒 Vérifier si utilisateur actif
        if (!$user->est_actif) {
            Auth::logout();
            return redirect('/login')->with('error', 'Compte désactivé.');
        }

        // 🔥 Mapping des rôles
        $rolesMap = [
            'client' => 1,
            'serveur' => 2,
            'cuisinier' => 3,
            'gerant' => 4,
            'admin' => 5,
        ];

        // 🔍 Vérification
        foreach ($roles as $role) {
            if (isset($rolesMap[$role]) && $user->role_id === $rolesMap[$role]) {
                return $next($request);
            }
        }

        // ❌ Accès refusé
        abort(403, 'Accès non autorisé.');
    }
}
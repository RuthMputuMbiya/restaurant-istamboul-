<?php

// app/Http/Middleware/CheckUserRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Vérifier si le compte est actif
        if (!$user->est_actif) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Votre compte a été désactivé.');
        }

        $userRole = $user->role->slug ?? null;
        
        if (!in_array($userRole, $roles)) {
            abort(403, 'Accès non autorisé. Vous n\'avez pas les droits nécessaires.');
        }

        return $next($request);
    }
}
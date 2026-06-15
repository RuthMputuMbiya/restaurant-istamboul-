<?php

// app/Http/Controllers/Auth/RegisteredUserController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'min:9', 'max:20', 'unique:users'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Nettoyer le numéro de téléphone
        $telephone = $this->formatPhoneNumber($request->telephone);

        $clientRole = Role::where('slug', 'client')->first();
        
        if (!$clientRole) {
            $clientRole = Role::create([
                'nom' => 'Client',
                'slug' => 'client',
                'description' => 'Client du restaurant'
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $telephone,
            'adresse' => $request->adresse,
            'password' => Hash::make($request->password),
            'role_id' => $clientRole->id,
            'est_actif' => true,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('client.dashboard'));
    }

    /**
     * Formater le numéro de téléphone
     */
    private function formatPhoneNumber($phone)
    {
        // Enlever tous les espaces, tirets et caractères non numériques
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Si le numéro commence par 0 (ex: 0971041435)
        if (preg_match('/^0[0-9]{9}$/', $phone)) {
            $phone = '+243' . substr($phone, 1);
        }
        // Si le numéro commence par 243 (ex: 243971041435)
        elseif (preg_match('/^243[0-9]{9}$/', $phone)) {
            $phone = '+' . $phone;
        }
        // Si le numéro a 9 chiffres (ex: 971041435)
        elseif (preg_match('/^[0-9]{9}$/', $phone)) {
            $phone = '+243' . $phone;
        }
        // Si le numéro commence déjà par +243
        elseif (preg_match('/^\+243[0-9]{9}$/', $phone)) {
            // Déjà bon format
        }
        // Autre cas, garder tel quel
        
        return $phone;
    }
}
<?php

// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs
     */
    public function index()
    {
        $users = User::with('role')->orderBy('created_at', 'desc')->paginate(20);
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }
    
    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $roles = Role::where('slug', '!=', 'client')->get();
        return view('admin.users.create', compact('roles'));
    }
    
    /**
     * Enregistrer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|string|min:9|max:20|unique:users,telephone',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:6|confirmed'
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'est_actif' => true
        ]);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }
    
    /**
     * Afficher les détails d'un utilisateur
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Afficher le formulaire de modification
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }
    
    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'required|string|min:9|max:20|unique:users,telephone,' . $user->id,
            'role_id' => 'required|exists:roles,id'
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'role_id' => $request->role_id,
            'est_actif' => $request->est_actif ?? true
        ]);
        
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur modifié avec succès.');
    }
    
    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
    
    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleActif(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas modifier votre propre compte.');
        }
        
        $user->update(['est_actif' => !$user->est_actif]);
        
        $statut = $user->est_actif ? 'activé' : 'désactivé';
        
        return redirect()->back()->with('success', "L'utilisateur a été {$statut}.");
    }
}
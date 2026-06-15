<?php

// app/Http/Controllers/Admin/RoleController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        // Pas de système de permissions pour l'instant
        $allPermissions = []; // Tableau vide
        return view('admin.roles.create', compact('allPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:roles,nom',
            'description' => 'nullable|string|max:500'
        ]);

        Role::create([
            'nom' => $request->nom,
            'slug' => Str::slug($request->nom),
            'description' => $request->description
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle créé avec succès.');
    }

    public function edit(Role $role)
    {
        $allPermissions = []; // Tableau vide
        $rolePermissions = [];
        
        return view('admin.roles.edit', compact('role', 'allPermissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:roles,nom,' . $role->id,
            'description' => 'nullable|string|max:500'
        ]);

        $role->update([
            'nom' => $request->nom,
            'slug' => Str::slug($request->nom),
            'description' => $request->description
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle modifié avec succès.');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer ce rôle car il est attribué à des utilisateurs.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle supprimé avec succès.');
    }
}
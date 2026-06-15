<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'adresse',
        'role_id',
        'est_actif',
        // ❌ on enlève email_verified_at pour sécurité
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'est_actif' => 'boolean',
        ];
    }

    // 🔗 Relation avec le rôle
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // 🔥 MÉTHODE GÉNÉRIQUE (BONNE PRATIQUE)
    public function hasRoleId($roleId)
    {
        return $this->role_id === $roleId;
    }

    // ✅ TES MÉTHODES (inchangées mais propres)
    public function isClient()
    {
        return $this->hasRoleId(1);
    }

    public function isServeur()
    {
        return $this->hasRoleId(2);
    }

    public function isCuisinier()
    {
        return $this->hasRoleId(3);
    }

    public function isGerant()
    {
        return $this->hasRoleId(4);
    }

    public function isAdmin()
    {
        return $this->hasRoleId(5);
    }

    // 📦 Relations
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'client_id');
    }

    public function commandesServeur()
    {
        return $this->hasMany(Commande::class, 'serveur_id');
    }
}
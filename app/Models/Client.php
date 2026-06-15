<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';

    protected $fillable = [
        'numero_commande',
        'client_id',
        'table_id',
        'serveur_id',
        'statut',
        'montant_total',
        'notes',
        'type_commande',
        'heure_commande',
        'heure_servi',
        'nom_client'
    ];

    // Valeurs par défaut pour éviter les erreurs
    protected $attributes = [
        'table_id' => null,
        'serveur_id' => null,
        'statut' => 'panier',
        'montant_total' => 0,
        'type_commande' => 'sur_place'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($commande) {
            if (!$commande->numero_commande) {
                $commande->numero_commande = 'CMD-' . date('Ymd') . '-' . rand(1000, 9999);
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function table()
    {
        return $this->belongsTo(TableResto::class, 'table_id');
    }

    public function serveur()
    {
        return $this->belongsTo(User::class, 'serveur_id');
    }

    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class, 'commande_id');
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class, 'commande_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeItem extends Model
{
    use HasFactory;

    protected $table = 'commande_items';

    protected $fillable = [
        'commande_id',
        'plat_id',
        'quantite',
        'prix_unitaire',
        'sous_total'
    ];

    protected $casts = [
        'quantite' => 'integer',
        'prix_unitaire' => 'decimal:2',
        'sous_total' => 'decimal:2'
    ];

    // Relation avec la commande
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // Relation avec le plat
    public function plat()
    {
        return $this->belongsTo(Plat::class);
    }

    // Calcul automatique du sous-total
    public function getSousTotalAttribute()
    {
        return $this->quantite * $this->prix_unitaire;
    }
}
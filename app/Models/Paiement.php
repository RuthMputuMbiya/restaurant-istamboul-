<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'client_id',
        'montant',
        'mode_paiement',
        'numero_telephone',
        'reference',
        'transaction_id',
        'statut',
        'encaisse_par',
        'date_paiement',
        'response_data',
        'devise',
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'montant' => 'decimal:2'
    ];

    // Relation avec la commande
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // Relation avec le client
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relation avec l'utilisateur qui a encaissé
    public function encaisseur()
    {
        return $this->belongsTo(User::class, 'encaisse_par');
    }
}
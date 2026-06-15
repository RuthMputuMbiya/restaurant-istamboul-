<?php

// app/Models/Commande.php

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

    protected $casts = [
        'montant_total' => 'decimal:2',
        'heure_commande' => 'datetime',
        'heure_servi' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Générer automatiquement le numéro de commande
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($commande) {
            if (!$commande->numero_commande) {
                $commande->numero_commande = 'CMD-' . date('Ymd') . '-' . rand(1000, 9999);
            }
        });
    }

    /**
     * Relation avec le client
     * Une commande appartient à un client
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Relation avec la table
     * Une commande est associée à une table
     */
    public function table()
    {
        return $this->belongsTo(TableResto::class, 'table_id');
    }

    /**
     * Relation avec le serveur
     * Une commande est prise par un serveur
     */
    public function serveur()
    {
        return $this->belongsTo(User::class, 'serveur_id');
    }

    /**
     * Relation avec les lignes de commande
     * Une commande contient plusieurs lignes
     */
    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class, 'commande_id');
    }

    /**
     * Relation avec le paiement
     * Une commande a un seul paiement
     */
    public function paiement()
    {
        return $this->hasOne(Paiement::class, 'commande_id');
    }

    /**
     * Calculer le montant total de la commande
     */
    public function calculerTotal()
    {
        $total = $this->ligneCommandes()->sum('sous_total');
        $this->montant_total = $total;
        $this->saveQuietly();
        return $total;
    }

    /**
     * Changer le statut de la commande
     */
    public function changerStatut($nouveauStatut)
    {
        $this->statut = $nouveauStatut;

        if ($nouveauStatut === 'livre') {
            $this->heure_servi = now();
        }

        return $this->save();
    }

    /**
     * Vérifier si la commande peut être modifiée
     */
    public function peutEtreModifiee()
    {
        return in_array($this->statut, ['panier', 'en_attente']);
    }

    /**
     * Obtenir le nombre d'articles dans la commande
     */
    public function getNbArticlesAttribute()
    {
        return $this->ligneCommandes()->sum('quantite');
    }

    /**
     * Obtenir le libellé du statut en français
     */
    public function getStatutLibelleAttribute()
    {
        $statuts = [
            'panier' => 'En attente de validation',
            'en_attente' => 'En attente de traitement',
            'en_preparation' => 'En cours de préparation',
            'pret' => 'Prêt à être servi',
            'livre' => 'Livré',
            'annulee' => 'Annulé'
        ];
        return $statuts[$this->statut] ?? $this->statut;
    }

    /**
     * Obtenir la couleur du statut
     */
    public function getStatutCouleurAttribute()
    {
        $couleurs = [
            'panier' => 'warning',
            'en_attente' => 'warning',
            'en_preparation' => 'info',
            'pret' => 'success',
            'livre' => 'secondary',
            'annulee' => 'danger'
        ];
        return $couleurs[$this->statut] ?? 'secondary';
    }
}